<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use PDF;
use Session;

class ContrachequeController extends Controller
{
    public function verificaLogin()
    {
        $login = Session::get('login');
        if ($login) {
            return view('auth.painel');
        } else {
            return view('auth.login');
        }
    }

    public function login(Request $request)
    {
        // Verifica se tem fol2 pro database
        $database = DB::connection()->getDatabaseName();
        $fol2 = '%hsfol2_%';
        $verificaFol2 = DB::select('SELECT 1 FROM INFORMATION_SCHEMA.TABLES tbl WHERE tbl.`TABLE_NAME`
        LIKE ? AND `TABLE_SCHEMA` = ? LIMIT 1', [$fol2, $database]);

        if ($verificaFol2 == null) {
            Session::put('fol2', false);
        }

        // Recebe os dados do form/
        $cpf = $request->cpf;
        $senha = sha1($request->senha);

        // Busca os dados da autenticação
        $autenticacao = DB::select('SELECT * FROM `hscad_municipedoc` inner join `hscad_cadmunicipal`
        on hscad_cadmunicipal.inscricaomunicipal = hscad_municipedoc.idmunicipe
        where hscad_municipedoc.numero = ? and hscad_cadmunicipal.senhaweb = ?', [$cpf, $senha]);

        // Cria as sessões e redireciona
        if ($autenticacao != null) {
            Session::put('login', true);
            Session::put('tokenweb', $autenticacao[0]->tokenweb);
            return view('auth.painel');
        } else {
            return view('auth.login');
        }
    }

    public function sair()
    {
        Session::flush();
        return redirect()->route('verificaLogin');
    }

    public function consultaDemonstrativoMensal()
    {
        if (Session::get('login')) {
            $token = Session::get('tokenweb');

            if (Session::get('fol2') == true) {
                $contratos = DB::select('SELECT a.idcontrato AS id, a.matricula, c.descricao AS
                desc_funcao, func_fol2_contrato_admissao(a.idcontrato) AS dataadmissao, e.descricao AS
                desc_situacao FROM view_fol2_contratorelacaoatual AS a INNER JOIN hsfol2_contratofuncao b
                ON a.idcontratofuncao = b.id INNER JOIN hsfol2_funcao c ON c.id = b.idfuncao
                INNER JOIN hsfol2_contratoatividade d ON d.id = a.idcontratoatividade INNER JOIN hsfol2_situacaocontratual e
                ON e.id = d.idsituacaocontratual INNER JOIN hsfol2_servidor f ON a.idservidor = f.id INNER JOIN hscad_cadmunicipal g
                ON g.inscricaomunicipal = f.idmunicipe WHERE g.tokenweb = ?', [$token]);

                $tiposfolha = DB::select('select id, descricao from hsfol2_tipofolha');

            } else {
                $contratos = DB::select('select c.id, c.matricula, d.descricao as desc_funcao, e.dataadmissao, g.descricao
                as desc_situacao from hscad_cadmunicipal a, hsfol_servidor b, hsfol_contrato c, hsfol_funcao d,
                hsfol_contratoadmissao e, hsfol_contratoafastamento f, hsfol_situacao g where a.tokenweb = ? && a.inscricaomunicipal = b.idcadmunicipal
                && b.id = c.idservidor && c.idfuncao = d.id && c.id = e.idcontrato && c.id = f.idcontrato && f.idsituacao = g.id', [$token]);

                $tiposfolha = DB::select('select id, descricao from hsfol_tipofolha');

                $mesNumero = date('n');

                $meses = array(
                    '1' => 'Janeiro',
                    '2' => 'Fevereiro',
                    '3' => 'Março',
                    '4' => 'Abril',
                    '5' => 'Maio',
                    '6' => 'Junho',
                    '7' => 'Julho',
                    '8' => 'Agosto',
                    '9' => 'Setembro',
                    '10' => 'Outubro',
                    '11' => 'Novembro',
                    '12' => 'Dezembro',
                );
                foreach ($meses as $key => $mes) {
                    if ($mesNumero == $key) {
                        $mesAtual = $mes;
                    }
                }
            }

            return view('auth.consultaDemonstrativoMensal', compact('contratos', 'tiposfolha', 'mesNumero', 'mesAtual', 'meses'));
        }
        return redirect()->route('verificaLogin');
    }

    public function buscaContrachequeMensal(Request $request)
    {
        if (Session::get('login')) {
            $token = Session::get('tokenweb');

            $contrato = $request->contrato;
            $tipofolha = $request->tipofolha;
            $mes = $request->mes;
            $month = utf8_encode(strtoupper(strftime("%B", mktime(20, 0, 0, $mes, 01, 98))));
            $descricaomes = $this->traduzMes($month);
            $ano = $request->ano;

            $servidor = DB::select('select a.nome, c.matricula, d.descricao as desc_funcao,
            f.descricao as desc_lotacao, h.padrao, h.nivel, h.classe from hscad_cadmunicipal a,
            hsfol_servidor b, hsfol_contrato c, hsfol_funcao d, hsfol_contratolocal e, hsfol_lotacao f,
            hsfol_contratoadmissao g, hsfol_padraoclasse h where c.id = ? && a.inscricaomunicipal = b.idcadmunicipal
            && b.id = c.idservidor && c.idfuncao = d.id && c.id = e.idcontrato && e.idlotacao = f.id && c.id = g.idcontrato
            && g.idpadraoclasse = h.id', [$contrato]);

            $valores = DB::select('select a.valor, a.referencia, c.codigo, c.descricao as desc_evento, c.classificacao, d.descricao
            as desc_tipofolha from hsfol_calculo a, hsfol_referencia b, hsfol_evento c, hsfol_tipofolha d where a.idcontrato = ?
            && b.idtipofolha = ? && EXTRACT(MONTH FROM b.datafolha) = ? && EXTRACT(YEAR FROM b.datafolha) = ? &&
            a.idreferencia = b.id && a.idevento = c.id && b.idtipofolha = d.id && b.status = 0 && c.classificacao IN (1,2,4)
            order by c.codigo', [$contrato, $tipofolha, $mes, $ano]);

            $mensagem = "Contracheque não disponível.";
            $vencimentos = $this->buscaVencimentos($valores);
            $descontos = $this->buscaDescontos($valores);
            $bases = $this->buscaBases($valores);

            $totalVencimentos = $this->calculaTotalValores($vencimentos);
            $totalDescontos = $this->calculaTotalValores($descontos);
            $totalLiquido = $totalVencimentos - $totalDescontos;

            return view('auth.contrachequeMensal', compact('mensagem', 'contrato', 'tipofolha', 'mes',
                'descricaomes', 'ano', 'servidor', 'valores', 'vencimentos', 'descontos', 'bases', 'totalVencimentos',
                'totalDescontos', 'totalLiquido'));
        }
        return redirect()->route('verificaLogin');
    }

    public function geraPdfMensal(Request $request)
    {
        if (Session::get('login')) {
            $token = Session::get('tokenweb');

            $dadosOrgao = $this->buscaDadosOrgao();
            $contrato = $request->contrato;
            $tipofolha = $request->tipofolha;
            $mes = $request->mes;
            $month = utf8_encode(strtoupper(strftime("%B", mktime(20, 0, 0, $mes, 01, 98))));
            $descricaomes = $this->traduzMes($month);
            $ano = $request->ano;

            $servidor = DB::select('select a.nome, c.matricula, d.descricao as desc_funcao,
            f.descricao as desc_lotacao, h.padrao, h.nivel, h.classe from hscad_cadmunicipal a,
            hsfol_servidor b, hsfol_contrato c, hsfol_funcao d, hsfol_contratolocal e, hsfol_lotacao f,
            hsfol_contratoadmissao g, hsfol_padraoclasse h where c.id = ? && a.inscricaomunicipal = b.idcadmunicipal
            && b.id = c.idservidor && c.idfuncao = d.id && c.id = e.idcontrato && e.idlotacao = f.id && c.id = g.idcontrato
            && g.idpadraoclasse = h.id', [$contrato]);

            $valores = DB::select('select a.valor, a.referencia, c.codigo, c.descricao as desc_evento, c.classificacao, d.descricao
            as desc_tipofolha from hsfol_calculo a, hsfol_referencia b, hsfol_evento c, hsfol_tipofolha d where a.idcontrato = ?
            && b.idtipofolha = ? && EXTRACT(MONTH FROM b.datafolha) = ? && EXTRACT(YEAR FROM b.datafolha) = ? &&
            a.idreferencia = b.id && a.idevento = c.id && b.idtipofolha = d.id && b.status = 0 && c.classificacao IN (1,2,4)
            order by c.codigo', [$contrato, $tipofolha, $mes, $ano]);

            $vencimentos = $this->buscaVencimentos($valores);
            $descontos = $this->buscaDescontos($valores);
            $bases = $this->buscaBases($valores);

            $totalVencimentos = $this->calculaTotalValores($vencimentos);
            $totalDescontos = $this->calculaTotalValores($descontos);
            $totalLiquido = $totalVencimentos - $totalDescontos;

            $pdf = PDF::loadView('auth.pdfDemonstrativoMensal', compact('contrato', 'tipofolha', 'mes',
                'descricaomes', 'ano', 'servidor', 'valores', 'vencimentos', 'descontos', 'bases', 'totalVencimentos',
                'totalDescontos', 'totalLiquido', 'dadosOrgao'));

            return $pdf->setPaper('a4')->stream('contracheque.pdf');
        }
        return redirect()->route('verificaLogin');

    }

    public function geraPdfPeriodo(Request $request)
    {
        if (Session::get('login')) {
            $token = Session::get('tokenweb');
            $dadosorgao = $this->buscaDadosOrgao();
            $contrato = $request->contrato;
            $tipofolha = $request->tipofolha;
            $datainicial = $request->datainicial;
            $datafinal = $request->datafinal;

            if (Session::get('fol2') == true) {

                // CASO TENHA FOL 2 FAZ AS CONSULTAS ESPECÍFICAS

            } else {
                $controle = 1;
                $totalregistros = 0;
                if ($tipofolha == 'TODOS') {
                    $alcance = "1,2,3,4,5,6,7";

                    $anomes = DB::select('select EXTRACT(YEAR FROM b.datafolha) as ano, EXTRACT(MONTH FROM b.datafolha)
                    as mes from hsfol_calculo a, hsfol_referencia b, hsfol_evento c where a.idcontrato = ? && b.idtipofolha
                    IN(?) && a.idreferencia = b.id && a.idevento = c.id && b.status = 0 && c.classificacao IN (1,2,4) &&
                    b.datafolha BETWEEN ? and ? group by mes,ano order by ano, mes, c.codigo', [$contrato, $alcance, $datainicial, $datafinal]);

                } else {
                    $anomes = DB::select('select EXTRACT(YEAR FROM b.datafolha) as ano, EXTRACT(MONTH FROM b.datafolha) as mes
                    from hsfol_calculo a, hsfol_referencia b, hsfol_evento c where a.idcontrato = ?
                    && b.idtipofolha = ? && a.idreferencia = b.id && a.idevento = c.id && b.status = 0
                    && c.classificacao IN (1,2,4) && b.datafolha BETWEEN ? and ?
                    group by mes,ano order by mes, ano, c.codigo', [$contrato, $tipofolha, $datainicial, $datafinal]);

                }

                $servidor = $this->buscaServidor($token, $contrato);
                foreach ($anomes as $item) {
                    $anos[] = $item->ano;
                    $meses[] = $item->mes;
                }

                $nome = $servidor[0]->nome;
                $matricula = $servidor[0]->matricula;
                $funcao = $servidor[0]->desc_funcao;
                $lotacao = $servidor[0]->desc_lotacao;
                $padrao = $servidor[0]->padrao;
                $nivel = $servidor[0]->nivel;
                $classe = $servidor[0]->classe;

                for ($i = 0; $i < sizeof($meses); $i++) {
                    for ($j = 1; $j <= 7; $j++) {
                        if (Session::get('fol2') != true) {
                            $valores = DB::select('select a.valor, a.referencia, c.codigo, c.descricao as desc_evento,
                            c.classificacao, d.descricao as desc_tipofolha from hsfol_calculo a, hsfol_referencia b, hsfol_evento c,
                            hsfol_tipofolha d where a.idcontrato = ? && b.idtipofolha = ?
                            && EXTRACT(MONTH FROM b.datafolha) = ? && EXTRACT(YEAR FROM b.datafolha) = ?
                            && a.idreferencia = b.id && a.idevento = c.id && b.idtipofolha = d.id && b.status = 0
                            && c.classificacao IN (1,2,4) order by c.codigo', [$contrato, $j, $meses[$i], $anos[$i]]);
                        } else {
                            // FOL 2
                        }
                        
                    }    
                }

                //dd(sizeof($meses));

                for ($i = 0; $i < sizeof($meses); $i++) {
                    for ($j = 1; $j <= 7; $j++) {

                        $codigos = array();
                        $descricoes = array();
                        $referencias = array();
                        $classificacoes = array();
                        $valores = array();
                        $totalvencimentos = 0;
                        $totaldescontos = 0;
                        if (Session::get('fol2') != true) {
                            $valores = DB::select("select a.valor, a.referencia, c.codigo, c.descricao as desc_evento,
                            c.classificacao, d.descricao as desc_tipofolha from hsfol_calculo a, hsfol_referencia b, hsfol_evento c,
                            hsfol_tipofolha d where a.idcontrato = ? && b.idtipofolha = ?
                            && EXTRACT(MONTH FROM b.datafolha) = ? && EXTRACT(YEAR FROM b.datafolha) = ?
                            && a.idreferencia = b.id && a.idevento = c.id && b.idtipofolha = d.id && b.status = 0
                            && c.classificacao IN (1,2,4) order by c.codigo", [$contrato, $j, $meses[$i], $anos[$i]]);

                        } else {
                            // Query FOL2
                        }

                        if (sizeof($valores) > 0) {

                            $codigo;
                            for ($i = 0; $i < sizeof($valores); $i++) {
                                $codigos[$i] = $valores[$i]->codigo;
                                $descricoes[$i] = $valores[$i]->desc_evento;
                                $referencias[$i] = $valores[$i]->referencia;
                                $totalvalores[$i] = number_format($valores[$i]->valor, 2, ",", ".");

                                if ($valores[$i]->classificacao == 'P') {
                                    $classificacoes[$i] = 1;
                                } else if ($valores[$i]->classificacao == 'D') {
                                    $classificacoes[] = 2;
                                } else if ($valores[$i]->classificacao == 'B') {
                                    $classificacoes[$i] = 4;
                                } else {
                                    $classificacoes[$i] = $valores[$i]->classificacao;
                                }
                                if ($valores[$i]->classificacao == 1 || $valores[$i]->classificacao == 'P') {
                                    $totalvencimentos = $totalvencimentos + $valores[$i]->valor;
                                } else if ($valores[$i]->classificacao == 2 || $valores[$i]->classificacao == 'D') {
                                    $totaldescontos = $totaldescontos + $valores[$i]->valor;
                                }
                                $liquido = $totalvencimentos - $totaldescontos;
                                $descricaotipofolha = strtoupper($valores[$i]->desc_tipofolha);
                            }

                            $nomeempresa = $dadosorgao[0]->nome_empresa;
                            $numero = $dadosorgao[0]->numero;
                            $cnpj = $dadosorgao[0]->cnpj;
                            $logradouro = $dadosorgao[0]->nome;

                            for ($i = 0; $i < sizeof($meses); $i++) {
                                $month[$i] = utf8_encode(strtoupper(strftime("%B", mktime(20, 0, 0, $meses[$i], 01, 98))));
                                $descricaomes[$i] = $this->traduzMes($month[$i]);
                            }
                        }
                    }
                }

            }

            $pdf = PDF::loadView('auth.pdfDemonstrativoPeriodo', compact(
                'nomeempresa'
            ));

            return $pdf->setPaper('a4')->stream('contrachequePeriodo.pdf');
        }
        return redirect()->route('verificaLogin');

    }

    public function buscaServidor($token, $contrato)
    {
        $servidor = DB::select('select a.nome, c.matricula, d.descricao as desc_funcao, f.descricao as desc_lotacao, h.padrao,
                h.nivel, h.classe from hscad_cadmunicipal a, hsfol_servidor b, hsfol_contrato c, hsfol_funcao d, hsfol_contratolocal e,
                hsfol_lotacao f, hsfol_contratoadmissao g, hsfol_padraoclasse h where a.tokenweb = ? && c.id = ?
                && a.inscricaomunicipal = b.idcadmunicipal && b.id = c.idservidor && c.idfuncao = d.id &&
                c.id = e.idcontrato && e.idlotacao = f.id && c.id = g.idcontrato && g.idpadraoclasse = h.id', [$token, $contrato]);

        return $servidor;
    }

    public function consultaDemonstrativoPeriodo()
    {
        if (Session::get('login')) {
            $token = Session::get('tokenweb');

            if (Session::get('fol2') == true) {
                $contratos = DB::select('SELECT a.idcontrato AS id, a.matricula, c.descricao AS
                desc_funcao, func_fol2_contrato_admissao(a.idcontrato) AS dataadmissao, e.descricao AS
                desc_situacao FROM view_fol2_contratorelacaoatual AS a INNER JOIN hsfol2_contratofuncao b
                ON a.idcontratofuncao = b.id INNER JOIN hsfol2_funcao c ON c.id = b.idfuncao
                INNER JOIN hsfol2_contratoatividade d ON d.id = a.idcontratoatividade INNER JOIN hsfol2_situacaocontratual e
                ON e.id = d.idsituacaocontratual INNER JOIN hsfol2_servidor f ON a.idservidor = f.id INNER JOIN hscad_cadmunicipal g
                ON g.inscricaomunicipal = f.idmunicipe WHERE g.tokenweb = ?', [$token]);

                $tiposfolha = DB::select('select id, descricao from hsfol2_tipofolha');

            } else {
                $contratos = DB::select('select c.id, c.matricula, d.descricao as desc_funcao, e.dataadmissao, g.descricao
                as desc_situacao from hscad_cadmunicipal a, hsfol_servidor b, hsfol_contrato c, hsfol_funcao d,
                hsfol_contratoadmissao e, hsfol_contratoafastamento f, hsfol_situacao g where a.tokenweb = ? && a.inscricaomunicipal = b.idcadmunicipal
                && b.id = c.idservidor && c.idfuncao = d.id && c.id = e.idcontrato && c.id = f.idcontrato && f.idsituacao = g.id', [$token]);

                $tiposfolha = DB::select('select id, descricao from hsfol_tipofolha');

            }

            return view('auth.consultaDemonstrativoPeriodo', compact('contratos', 'tiposfolha'));
        }
        return redirect()->route('verificaLogin');
    }

    public function buscaDadosOrgao()
    {
        $dados = DB::select('select a.nome_empresa, a.numero, a.cnpj, b.nome from hscad_dadosempresa a, hscad_logradouros b
        where a.id = 1 and a.idlogradouro = b.id');

        return $dados;
    }

    public function calculaTotalValores($array)
    {
        $dados = 0;
        if (isset($array)) {
            foreach ($array as $item) {
                $aux = $item->valor;
                $dados = $dados + $aux;
            }
        }

        return $dados;
    }

    public function buscaVencimentos($valores)
    {
        foreach ($valores as $valor) {
            if ($valor->classificacao == '1') {
                $vencimentos[] = $valor;
            }
        }
        if (isset($vencimentos)) {
            return $vencimentos;
        } else {
            return null;
        }
    }

    public function buscaDescontos($valores)
    {
        foreach ($valores as $valor) {
            if ($valor->classificacao == '2') {
                $descontos[] = $valor;
            }
        }
        if (isset($descontos)) {
            return $descontos;
        } else {
            return null;
        }
    }

    public function buscaBases($valores)
    {
        foreach ($valores as $valor) {
            if ($valor->classificacao == '4') {
                $bases[] = $valor;
            }
        }
        if (isset($bases)) {
            return $bases;
        } else {
            return null;
        }
    }

    public function traduzMes($month)
    {
        switch ($month) {
            case "JANUARY":
                $mes = "JANEIRO";
                return $mes;
                break;
            case "FEBRUARY":
                $mes = "FEVEREIRO";
                return $mes;
                break;
            case "MARCH":
                $mes = "MARÇO";
                return $mes;
                break;
            case "APRIL":
                $mes = "ABRIL";
                return $mes;
                break;
            case "MAY":
                $mes = "MAIO";
                return $mes;
                break;
            case "JUNE":
                $mes = "JUNHO";
                return $mes;
                break;
            case "JULY":
                $mes = "JULHO";
                return $mes;
                break;
            case "AUGUST":
                $mes = "AGOSTO";
                return $mes;
                break;
            case "SEPTEMBER":
                $mes = "SETEMBRO";
                return $mes;
                break;
            case "OCTOBER":
                $mes = "OUTUBRO";
                return $mes;
                break;
            case "NOVEMBER":
                $mes = "NOVEMBRO";
                return $mes;
                break;
            case "DECEMBER":
                $mes = "DEZEMBRO";
                return $mes;
                break;
        }

    }

}
