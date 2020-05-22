<?php

namespace App\Http\Controllers;

use App\Mail\EnviaPin;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

        if ($verificaFol2 != null) {
            Session::put('fol2', true);
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

            $idcadmunicipal = $autenticacao[0]->idmunicipe;

            // Busca Dados pra mostrar no Painel
            $dadosPagamento = $this->buscaDadosPagamento($idcadmunicipal);

            // Armazena os dados disponíveis no Painel em sessões
            Session::put('inscricao', $dadosPagamento[0]->inscricao);
            Session::put('nome', $dadosPagamento[0]->nome);
            Session::put('documento', $dadosPagamento[0]->documento);
            Session::put('valor_provento', $dadosPagamento[0]->valor_provento);
            Session::put('valor_desconto', $dadosPagamento[0]->valor_desconto);
            Session::put('valor_liquido', $dadosPagamento[0]->valor_liquido);

            return view('auth.painel', compact('dadosPagamento', 'autenticacao'));
        } else {
            return redirect()->back()->with('error', 'Dados incorretos.');
        }
    }

    public function buscaDadosPagamento($idcadmunicipal)
    {
        $dadosPagamento = "";
        // MUDAR PARA TRUE QUANDO TIVER A CONSULTA FOL2
        if (Session::get('fol2') == true) {
            // CONSULTA FOL 2

        } else {
            $dadosPagamento = DB::select('SELECT `servidor`.`idcadmunicipal` AS `inscricao`,
        (SELECT `municipe`.`nome`
           FROM `hscad_cadmunicipal` `municipe`
          WHERE `servidor`.`idcadmunicipal` = `municipe`.`inscricaomunicipal`)
           AS `nome`,
        (SELECT `documento`.`numero`
           FROM `hscad_municipedoc` `documento`
          WHERE `documento`.`iddocumento` = 3
            AND `servidor`.`idcadmunicipal` = `documento`.`idmunicipe`)
           AS `documento`,
        SUM(if(`evento`.`classificacao` = 1, `calculo`.`valor`, 0.00))
           AS `valor_provento`,
        SUM(if(`evento`.`classificacao` = 2, `calculo`.`valor`, 0.00))
           AS `valor_desconto`,
        SUM(
           if(`evento`.`classificacao` = 1,
              `calculo`.`valor`,
              -`calculo`.`valor`))
           AS `valor_liquido`
        FROM `hsfol_calculo` `calculo`
        INNER JOIN `hsfol_contrato` `contrato`
           ON `contrato`.id = `calculo`.idcontrato
        INNER JOIN `hsfol_servidor` `servidor`
           ON `contrato`.`idservidor` = `servidor`.`id`
        INNER JOIN `hsfol_evento` `evento`
           ON `evento`.`id` = `calculo`.`idevento`
        INNER JOIN `hsfol_referencia` `referencia`
           ON `referencia`.`id` = `calculo`.`idreferencia`
        WHERE `servidor`.`idcadmunicipal` = ?
        AND `evento`.`classificacao` IN (1, 2)
        AND YEAR(`referencia`.`datafolha`) = 2019
        GROUP BY `servidor`.`idcadmunicipal`', [$idcadmunicipal]);

        }
        return $dadosPagamento;
    }

    public function painel()
    {
        if (Session::get('login')) {
            return view('auth.painel');
        } else {
            return view('auth.login');
        }
    }

    public function recuperarSenha()
    {
        return view('auth.resgateSenha');
    }

    public function salvarNovaSenha(Request $request)
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
        $senha = $request->senha;
        $confirmaSenha = $request->confirmasenha;
        $pin = $request->pin;
        $senhaCrip = sha1($request->senha);

        if ($senha != $confirmaSenha) {
            return redirect()->back()->with('error', 'Senhas diferentes.');
        }

        // Recupera a inscrição municipal
        $inscricaoMunicipal = DB::select('select a.inscricaomunicipal from hscad_cadmunicipal a, hscad_municipedoc b
            where b.numero = ? && a.pin = ? && a.inscricaomunicipal = b.idmunicipe', [$cpf, $pin]);

        if ($inscricaoMunicipal == null) {
            return redirect()->back()->with('error', 'Dados Incorretos.');
        }

        $atualizaSenha = DB::table('hscad_cadmunicipal')
            ->where('inscricaomunicipal', $inscricaoMunicipal[0]->inscricaomunicipal)
            ->update([
                'senhaweb' => $senhaCrip,
            ]);
        return redirect()->route('verificaLogin')->with('success', 'Senha alterada com sucesso!');
    }

    public function buscarPin()
    {
        return view('auth.pin');
    }

    public function enviarPin(Request $request)
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
        $email = $request->email;

        // Busca o PIN e envia o email
        $buscaPin = DB::select('select a.pin from hscad_cadmunicipal a, hscad_municipedoc b
        where b.numero = ? && a.email = ? && a.inscricaomunicipal = b.idmunicipe', [$cpf, $email]);
        if ($buscaPin != null) {
            $pin = $buscaPin[0]->pin;
            Mail::to($email)->send(new EnviaPin($cpf, $pin));
            return redirect()->back()->with('success', 'E-mail enviado com sucesso.');
        } else {
            return redirect()->back()->with('error', 'E-mail não cadastrado, entre em contato com a administração.');
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
            }
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

            if (Session::get('fol2') == true) {

                // CONSULTAS FOL2
                $servidor = DB::select('SELECT b.nome, a.matricula, e.descricao AS desc_funcao, g.descricao
                AS desc_lotacao, i.padrao, i.nivel, i.classe FROM view_fol2_contratorelacaoatual
                AS a INNER JOIN hscad_cadmunicipal b INNER JOIN hsfol2_servidor c ON a.idservidor = c.id
                AND c.idmunicipe = b.inscricaomunicipal INNER JOIN hsfol2_contratofuncao d ON a.idcontratofuncao = d.id
                INNER JOIN hsfol2_funcao e ON e.id = d.idfuncao INNER JOIN hsfol2_contratolotacao f
                ON a.idcontratolotacao = f.id INNER JOIN hsfol2_lotacao g ON g.id = f.idlotacao
                INNER JOIN hsfol2_contratopadrao h INNER JOIN hsfol2_padraonivelclasse i
                ON a.idcontratopadrao = h.id AND h.idpadraonivelclasse = i.id
                WHERE b.tokenweb = ? AND a.idcontrato = ?', [$token, $contrato]);

                $valores = DB::select("SELECT b.valor, b.referencia, d.codigo, d.descricao
                                    as desc_evento, d.classificacao, e.descricao as desc_tipofolha
                                    FROM hsfol2_calculo a, hsfol2_calculoevento b, hsfol2_referencia c,
                                    hsfol2_evento d, hsfol2_tipofolha e WHERE a.idcontrato = ?
                                    && c.idtipofolha = ? && EXTRACT(MONTH FROM c.datafolha) = ?
                                    && EXTRACT(YEAR FROM c.datafolha) = ? && a.idreferencia = c.id && b.idevento = d.id
                                    && b.idcalculo = a.id && c.idtipofolha = e.id && c.encerrada = 1 && d.classificacao
                                    IN ('P', 'D', 'B') ORDER BY d.codigo", [$contrato, $tipofolha, $mes, $ano]);

            } else if (Session::get('fol2') == false) {
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

            }

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

            if (Session::get('fol2') == true) {
                // CONSULTAS FOL2
                $servidor = DB::select('SELECT b.nome, a.matricula, e.descricao AS desc_funcao, g.descricao
                    AS desc_lotacao, i.padrao, i.nivel, i.classe FROM view_fol2_contratorelacaoatual
                    AS a INNER JOIN hscad_cadmunicipal b INNER JOIN hsfol2_servidor c ON a.idservidor = c.id
                    AND c.idmunicipe = b.inscricaomunicipal INNER JOIN hsfol2_contratofuncao d ON a.idcontratofuncao = d.id
                    INNER JOIN hsfol2_funcao e ON e.id = d.idfuncao INNER JOIN hsfol2_contratolotacao f
                    ON a.idcontratolotacao = f.id INNER JOIN hsfol2_lotacao g ON g.id = f.idlotacao
                    INNER JOIN hsfol2_contratopadrao h INNER JOIN hsfol2_padraonivelclasse i
                    ON a.idcontratopadrao = h.id AND h.idpadraonivelclasse = i.id
                    WHERE b.tokenweb = ? AND a.idcontrato = ?', [$token, $contrato]);

                $valores = DB::select("SELECT b.valor, b.referencia, d.codigo, d.descricao
                                        as desc_evento, d.classificacao, e.descricao as desc_tipofolha
                                        FROM hsfol2_calculo a, hsfol2_calculoevento b, hsfol2_referencia c,
                                        hsfol2_evento d, hsfol2_tipofolha e WHERE a.idcontrato = ?
                                        && c.idtipofolha = ? && EXTRACT(MONTH FROM c.datafolha) = ?
                                        && EXTRACT(YEAR FROM c.datafolha) = ? && a.idreferencia = c.id && b.idevento = d.id
                                        && b.idcalculo = a.id && c.idtipofolha = e.id && c.encerrada = 1 && d.classificacao
                                        IN ('P', 'D', 'B') ORDER BY d.codigo", [$contrato, $tipofolha, $mes, $ano]);
            } else {
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
            }

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

            // Dados do Servidor
            $servidor = $this->buscaServidor($token, $contrato);
            $nome = $servidor[0]->nome;
            $matricula = $servidor[0]->matricula;
            $funcao = $servidor[0]->desc_funcao;
            $lotacao = $servidor[0]->desc_lotacao;
            $padrao = $servidor[0]->padrao;
            $nivel = $servidor[0]->nivel;
            $classe = $servidor[0]->classe;

            if (Session::get('fol2') == true) {

                // Recupera os dados dos valores no período (1 select pra cada tipo de folha)
                if ($tipofolha == 'TODOS') {
                    $valoresTipoFolha1 = DB::select("SELECT
                                            b.valor AS valor_calculado,
                                            b.referencia AS valor_referencia,
                                            EXTRACT(MONTH FROM c.datafolha) AS mes,
                                            EXTRACT(YEAR FROM c.datafolha) AS ano,
                                            d.codigo AS cod_evento,
                                            d.descricao as desc_evento,
                                            d.classificacao,
                                            e.descricao as desc_tipofolha
                                        FROM
                                            hsfol2_calculo a,
                                            hsfol2_calculoevento b,
                                            hsfol2_referencia c,
                                            hsfol2_evento d,
                                            hsfol2_tipofolha e
                                        WHERE
                                            a.idcontrato = ?
                                            AND c.idtipofolha = 1
                                            AND c.datafolha BETWEEN ? AND ?
                                            AND a.idreferencia = c.id
                                            AND b.idevento = d.id
                                            AND b.idcalculo = a.id
                                            AND c.idtipofolha = e.id
                                            AND c.encerrada = 1
                                            AND d.classificacao IN ('P', 'D', 'B')
                                        ORDER BY
                                            d.codigo;", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha2 = DB::select("SELECT
                                            b.valor AS valor_calculado,
                                            b.referencia AS valor_referencia,
                                            EXTRACT(MONTH FROM c.datafolha) AS mes,
                                            EXTRACT(YEAR FROM c.datafolha) AS ano,
                                            d.codigo AS cod_evento,
                                            d.descricao as desc_evento,
                                            d.classificacao,
                                            e.descricao as desc_tipofolha
                                        FROM
                                            hsfol2_calculo a,
                                            hsfol2_calculoevento b,
                                            hsfol2_referencia c,
                                            hsfol2_evento d,
                                            hsfol2_tipofolha e
                                        WHERE
                                            a.idcontrato = ?
                                            AND c.idtipofolha = 2
                                            AND c.datafolha BETWEEN ? AND ?
                                            AND a.idreferencia = c.id
                                            AND b.idevento = d.id
                                            AND b.idcalculo = a.id
                                            AND c.idtipofolha = e.id
                                            AND c.encerrada = 1
                                            AND d.classificacao IN ('P', 'D', 'B')
                                        ORDER BY
                                            d.codigo;", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha3 = DB::select("SELECT
                                            b.valor AS valor_calculado,
                                            b.referencia AS valor_referencia,
                                            EXTRACT(MONTH FROM c.datafolha) AS mes,
                                            EXTRACT(YEAR FROM c.datafolha) AS ano,
                                            d.codigo AS cod_evento,
                                            d.descricao as desc_evento,
                                            d.classificacao,
                                            e.descricao as desc_tipofolha
                                        FROM
                                            hsfol2_calculo a,
                                            hsfol2_calculoevento b,
                                            hsfol2_referencia c,
                                            hsfol2_evento d,
                                            hsfol2_tipofolha e
                                        WHERE
                                            a.idcontrato = ?
                                            AND c.idtipofolha = 3
                                            AND c.datafolha BETWEEN ? AND ?
                                            AND a.idreferencia = c.id
                                            AND b.idevento = d.id
                                            AND b.idcalculo = a.id
                                            AND c.idtipofolha = e.id
                                            AND c.encerrada = 1
                                            AND d.classificacao IN ('P', 'D', 'B')
                                        ORDER BY
                                            d.codigo;", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha4 = DB::select("SELECT
                                            b.valor AS valor_calculado,
                                            b.referencia AS valor_referencia,
                                            EXTRACT(MONTH FROM c.datafolha) AS mes,
                                            EXTRACT(YEAR FROM c.datafolha) AS ano,
                                            d.codigo AS cod_evento,
                                            d.descricao as desc_evento,
                                            d.classificacao,
                                            e.descricao as desc_tipofolha
                                        FROM
                                            hsfol2_calculo a,
                                            hsfol2_calculoevento b,
                                            hsfol2_referencia c,
                                            hsfol2_evento d,
                                            hsfol2_tipofolha e
                                        WHERE
                                            a.idcontrato = ?
                                            AND c.idtipofolha = 4
                                            AND c.datafolha BETWEEN ? AND ?
                                            AND a.idreferencia = c.id
                                            AND b.idevento = d.id
                                            AND b.idcalculo = a.id
                                            AND c.idtipofolha = e.id
                                            AND c.encerrada = 1
                                            AND d.classificacao IN ('P', 'D', 'B')
                                        ORDER BY
                                            d.codigo;", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha5 = DB::select("SELECT
                                            b.valor AS valor_calculado,
                                            b.referencia AS valor_referencia,
                                            EXTRACT(MONTH FROM c.datafolha) AS mes,
                                            EXTRACT(YEAR FROM c.datafolha) AS ano,
                                            d.codigo AS cod_evento,
                                            d.descricao as desc_evento,
                                            d.classificacao,
                                            e.descricao as desc_tipofolha
                                        FROM
                                            hsfol2_calculo a,
                                            hsfol2_calculoevento b,
                                            hsfol2_referencia c,
                                            hsfol2_evento d,
                                            hsfol2_tipofolha e
                                        WHERE
                                            a.idcontrato = ?
                                            AND c.idtipofolha = 5
                                            AND c.datafolha BETWEEN ? AND ?
                                            AND a.idreferencia = c.id
                                            AND b.idevento = d.id
                                            AND b.idcalculo = a.id
                                            AND c.idtipofolha = e.id
                                            AND c.encerrada = 1
                                            AND d.classificacao IN ('P', 'D', 'B')
                                        ORDER BY
                                            d.codigo;", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha6 = DB::select("SELECT
                                            b.valor AS valor_calculado,
                                            b.referencia AS valor_referencia,
                                            EXTRACT(MONTH FROM c.datafolha) AS mes,
                                            EXTRACT(YEAR FROM c.datafolha) AS ano,
                                            d.codigo AS cod_evento,
                                            d.descricao as desc_evento,
                                            d.classificacao,
                                            e.descricao as desc_tipofolha
                                        FROM
                                            hsfol2_calculo a,
                                            hsfol2_calculoevento b,
                                            hsfol2_referencia c,
                                            hsfol2_evento d,
                                            hsfol2_tipofolha e
                                        WHERE
                                            a.idcontrato = ?
                                            AND c.idtipofolha = 6
                                            AND c.datafolha BETWEEN ? AND ?
                                            AND a.idreferencia = c.id
                                            AND b.idevento = d.id
                                            AND b.idcalculo = a.id
                                            AND c.idtipofolha = e.id
                                            AND c.encerrada = 1
                                            AND d.classificacao IN ('P', 'D', 'B')
                                        ORDER BY
                                            d.codigo;", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha7 = DB::select("SELECT
                                            b.valor AS valor_calculado,
                                            b.referencia AS valor_referencia,
                                            EXTRACT(MONTH FROM c.datafolha) AS mes,
                                            EXTRACT(YEAR FROM c.datafolha) AS ano,
                                            d.codigo AS cod_evento,
                                            d.descricao as desc_evento,
                                            d.classificacao,
                                            e.descricao as desc_tipofolha
                                        FROM
                                            hsfol2_calculo a,
                                            hsfol2_calculoevento b,
                                            hsfol2_referencia c,
                                            hsfol2_evento d,
                                            hsfol2_tipofolha e
                                        WHERE
                                            a.idcontrato = ?
                                            AND c.idtipofolha = 7
                                            AND c.datafolha BETWEEN ? AND ?
                                            AND a.idreferencia = c.id
                                            AND b.idevento = d.id
                                            AND b.idcalculo = a.id
                                            AND c.idtipofolha = e.id
                                            AND c.encerrada = 1
                                            AND d.classificacao IN ('P', 'D', 'B')
                                        ORDER BY
                                            d.codigo;", [$contrato, $datainicial, $datafinal]);

                    if ($valoresTipoFolha1 != null) {
                        $totalMensal1 = $this->buscaTotaisMensal($valoresTipoFolha1);
                    } else {
                        $totalMensal1 = null;
                    }
                    if ($valoresTipoFolha2 != null) {
                        $totalMensal2 = $this->buscaTotaisMensalAno($valoresTipoFolha2);
                    } else {
                        $totalMensal2 = null;
                    }
                    if ($valoresTipoFolha3 != null) {
                        $totalMensal3 = $this->buscaTotaisMensalAno($valoresTipoFolha3);
                    } else {
                        $totalMensal3 = null;
                    }
                    if ($valoresTipoFolha4 != null) {
                        $totalMensal4 = $this->buscaTotaisMensalAno($valoresTipoFolha4);
                    } else {
                        $totalMensal4 = null;
                    }
                    if ($valoresTipoFolha5 != null) {
                        $totalMensal5 = $this->buscaTotaisMensalAno($valoresTipoFolha5);
                    } else {
                        $totalMensal5 = null;
                    }
                    if ($valoresTipoFolha6 != null) {
                        $totalMensal6 = $this->buscaTotaisMensalAno($valoresTipoFolha6);
                    } else {
                        $totalMensal6 = null;
                    }
                    if ($valoresTipoFolha7 != null) {
                        $totalMensal7 = $this->buscaTotaisMensalAno($valoresTipoFolha7);
                    } else {
                        $totalMensal7 = null;
                    }

                    if (($valoresTipoFolha1 == null) && ($valoresTipoFolha2 == null) &&
                        ($valoresTipoFolha3 == null) && ($valoresTipoFolha4 == null) &&
                        ($valoresTipoFolha5 == null) && ($valoresTipoFolha6 == null) && ($valoresTipoFolha7 == null)) {
                        return redirect()->back()->with('error', 'Não existem lançamentos no período informado.');
                    } else {
                        $pdf = PDF::loadView('auth.pdfDemonstrativoPeriodo', compact(
                            'totalMensal1', 'totalMensal2', 'totalMensal3', 'totalMensal4', 'totalMensal5',
                            'totalMensal6', 'totalMensal7', 'servidor', 'dadosorgao', 'contrato', 'tipofolha',
                            'datainicial', 'datafinal', 'nome', 'matricula', 'funcao', 'lotacao', 'padrao',
                            'nivel', 'classe', 'valoresTipoFolha1', 'valoresTipoFolha2', 'valoresTipoFolha3',
                            'valoresTipoFolha4', 'valoresTipoFolha5', 'valoresTipoFolha6', 'valoresTipoFolha7'
                        ));

                        return $pdf->setPaper('a4')->stream('contrachequePeriodo.pdf');
                    }

                } else {
                    $valores = DB::select("SELECT
                                b.valor AS valor_calculado,
                                b.referencia AS valor_referencia,
                                EXTRACT(MONTH FROM c.datafolha) AS mes,
                                EXTRACT(YEAR FROM c.datafolha) AS ano,
                                d.codigo AS cod_evento,
                                d.descricao as desc_evento,
                                d.classificacao,
                                e.descricao as desc_tipofolha
                            FROM
                                hsfol2_calculo a,
                                hsfol2_calculoevento b,
                                hsfol2_referencia c,
                                hsfol2_evento d,
                                hsfol2_tipofolha e
                            WHERE
                                a.idcontrato = ?
                                AND c.idtipofolha = ?
                                AND c.datafolha BETWEEN ? AND ?
                                AND a.idreferencia = c.id
                                AND b.idevento = d.id
                                AND b.idcalculo = a.id
                                AND c.idtipofolha = e.id
                                AND c.encerrada = 1
                                AND d.classificacao IN ('P', 'D', 'B')
                            ORDER BY
                                d.codigo;", [$contrato, $tipofolha, $datainicial, $datafinal]);

                }

                // FOL2 == false
            } else {

                // Recupera os dados dos valores no período
                if ($tipofolha == 'TODOS') {
                    $eventos = DB::select("SELECT `calculo`.`idcontrato` AS `idcontrato`,
                                        `referencia`.`idtipofolha`,
                                        YEAR(`referencia`.`datafolha`) AS `ano`,
                                        MONTH(`referencia`.`datafolha`) AS `mes`,
                                        `evento`.`codigo` AS `cod_evento`,
                                        `evento`.`descricao` AS `desc_evento`,
                                        `evento`.`classificacao` AS `classificacao`,
                                        (SELECT `tipofolha`.`descricao`
                                            FROM `hsfol_tipofolha` `tipofolha`
                                            WHERE `referencia`.`idtipofolha` = `tipofolha`.`id`)
                                            AS `desc_tipofolha`,
                                        `calculo`.`referencia` AS `valor_referencia`,
                                        `calculo`.`valor` AS `valor_calculado`
                                    FROM `hsfol_calculo` `calculo`
                                        INNER JOIN `hsfol_referencia` `referencia`
                                            ON `referencia`.`id` = `calculo`.`idreferencia`
                                        INNER JOIN `hsfol_evento` `evento`
                                            ON `evento`.`id` = `calculo`.`idevento`
                                    WHERE `calculo`.`idcontrato` = ?
                                    AND `referencia`.`idtipofolha` != -1
                                    AND `referencia`.`datafolha` BETWEEN ? AND ?
                                    AND `referencia`.`status` = 0
                                    AND `evento`.`classificacao` IN (1, 2, 4)
                                    ORDER BY `idcontrato`, `ano`, `mes`, `idtipofolha`,
                                    CAST(`evento`.`codigo` AS UNSIGNED)", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha1 = DB::select("SELECT `calculo`.`idcontrato` AS `idcontrato`,
                                                    `referencia`.`idtipofolha`,
                                                    YEAR(`referencia`.`datafolha`) AS `ano`,
                                                    MONTH(`referencia`.`datafolha`) AS `mes`,
                                                    `evento`.`codigo` AS `cod_evento`,
                                                    `evento`.`descricao` AS `desc_evento`,
                                                    `evento`.`classificacao` AS `classificacao`,
                                                    (SELECT `tipofolha`.`descricao`
                                                        FROM `hsfol_tipofolha` `tipofolha`
                                                        WHERE `referencia`.`idtipofolha` = `tipofolha`.`id`)
                                                        AS `desc_tipofolha`,
                                                    `calculo`.`referencia` AS `valor_referencia`,
                                                    `calculo`.`valor` AS `valor_calculado`
                                                FROM `hsfol_calculo` `calculo`
                                                    INNER JOIN `hsfol_referencia` `referencia`
                                                        ON `referencia`.`id` = `calculo`.`idreferencia`
                                                    INNER JOIN `hsfol_evento` `evento`
                                                        ON `evento`.`id` = `calculo`.`idevento`
                                                WHERE `calculo`.`idcontrato` = ?
                                                AND `referencia`.`idtipofolha` = 1
                                                AND `referencia`.`datafolha` BETWEEN ? AND ?
                                                AND `referencia`.`status` = 0
                                                AND `evento`.`classificacao` IN (1, 2, 4)
                                                ORDER BY `idcontrato`, `ano`, `mes`, `idtipofolha`,
                                                CAST(`evento`.`codigo` AS UNSIGNED)", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha2 = DB::select("SELECT `calculo`.`idcontrato` AS `idcontrato`,
                                                    `referencia`.`idtipofolha`,
                                                    YEAR(`referencia`.`datafolha`) AS `ano`,
                                                    MONTH(`referencia`.`datafolha`) AS `mes`,
                                                    `evento`.`codigo` AS `cod_evento`,
                                                    `evento`.`descricao` AS `desc_evento`,
                                                    `evento`.`classificacao` AS `classificacao`,
                                                    (SELECT `tipofolha`.`descricao`
                                                        FROM `hsfol_tipofolha` `tipofolha`
                                                        WHERE `referencia`.`idtipofolha` = `tipofolha`.`id`)
                                                        AS `desc_tipofolha`,
                                                    `calculo`.`referencia` AS `valor_referencia`,
                                                    `calculo`.`valor` AS `valor_calculado`
                                                FROM `hsfol_calculo` `calculo`
                                                    INNER JOIN `hsfol_referencia` `referencia`
                                                        ON `referencia`.`id` = `calculo`.`idreferencia`
                                                    INNER JOIN `hsfol_evento` `evento`
                                                        ON `evento`.`id` = `calculo`.`idevento`
                                                WHERE `calculo`.`idcontrato` = ?
                                                AND `referencia`.`idtipofolha` = 2
                                                AND `referencia`.`datafolha` BETWEEN ? AND ?
                                                AND `referencia`.`status` = 0
                                                AND `evento`.`classificacao` IN (1, 2, 4)
                                                ORDER BY `idcontrato`, `ano`, `mes`, `idtipofolha`,
                                                CAST(`evento`.`codigo` AS UNSIGNED)", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha3 = DB::select("SELECT `calculo`.`idcontrato` AS `idcontrato`,
                                                    `referencia`.`idtipofolha`,
                                                    YEAR(`referencia`.`datafolha`) AS `ano`,
                                                    MONTH(`referencia`.`datafolha`) AS `mes`,
                                                    `evento`.`codigo` AS `cod_evento`,
                                                    `evento`.`descricao` AS `desc_evento`,
                                                    `evento`.`classificacao` AS `classificacao`,
                                                    (SELECT `tipofolha`.`descricao`
                                                        FROM `hsfol_tipofolha` `tipofolha`
                                                        WHERE `referencia`.`idtipofolha` = `tipofolha`.`id`)
                                                        AS `desc_tipofolha`,
                                                    `calculo`.`referencia` AS `valor_referencia`,
                                                    `calculo`.`valor` AS `valor_calculado`
                                                    FROM `hsfol_calculo` `calculo`
                                                    INNER JOIN `hsfol_referencia` `referencia`
                                                        ON `referencia`.`id` = `calculo`.`idreferencia`
                                                    INNER JOIN `hsfol_evento` `evento`
                                                        ON `evento`.`id` = `calculo`.`idevento`
                                                    WHERE `calculo`.`idcontrato` = ?
                                                    AND `referencia`.`idtipofolha` = 3
                                                    AND `referencia`.`datafolha` BETWEEN ? AND ?
                                                    AND `referencia`.`status` = 0
                                                    AND `evento`.`classificacao` IN (1, 2, 4)
                                                    ORDER BY `idcontrato`, `ano`, `mes`, `idtipofolha`,
                                                    CAST(`evento`.`codigo` AS UNSIGNED)", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha4 = DB::select("SELECT `calculo`.`idcontrato` AS `idcontrato`,
                                                    `referencia`.`idtipofolha`,
                                                    YEAR(`referencia`.`datafolha`) AS `ano`,
                                                    MONTH(`referencia`.`datafolha`) AS `mes`,
                                                    `evento`.`codigo` AS `cod_evento`,
                                                    `evento`.`descricao` AS `desc_evento`,
                                                    `evento`.`classificacao` AS `classificacao`,
                                                    (SELECT `tipofolha`.`descricao`
                                                        FROM `hsfol_tipofolha` `tipofolha`
                                                        WHERE `referencia`.`idtipofolha` = `tipofolha`.`id`)
                                                        AS `desc_tipofolha`,
                                                    `calculo`.`referencia` AS `valor_referencia`,
                                                    `calculo`.`valor` AS `valor_calculado`
                                                    FROM `hsfol_calculo` `calculo`
                                                    INNER JOIN `hsfol_referencia` `referencia`
                                                        ON `referencia`.`id` = `calculo`.`idreferencia`
                                                    INNER JOIN `hsfol_evento` `evento`
                                                        ON `evento`.`id` = `calculo`.`idevento`
                                                    WHERE `calculo`.`idcontrato` = ?
                                                    AND `referencia`.`idtipofolha` = 4
                                                    AND `referencia`.`datafolha` BETWEEN ? AND ?
                                                    AND `referencia`.`status` = 0
                                                    AND `evento`.`classificacao` IN (1, 2, 4)
                                                    ORDER BY `idcontrato`, `ano`, `mes`, `idtipofolha`,
                                                    CAST(`evento`.`codigo` AS UNSIGNED)", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha5 = DB::select("SELECT `calculo`.`idcontrato` AS `idcontrato`,
                                                    `referencia`.`idtipofolha`,
                                                    YEAR(`referencia`.`datafolha`) AS `ano`,
                                                    MONTH(`referencia`.`datafolha`) AS `mes`,
                                                    `evento`.`codigo` AS `cod_evento`,
                                                    `evento`.`descricao` AS `desc_evento`,
                                                    `evento`.`classificacao` AS `classificacao`,
                                                    (SELECT `tipofolha`.`descricao`
                                                        FROM `hsfol_tipofolha` `tipofolha`
                                                        WHERE `referencia`.`idtipofolha` = `tipofolha`.`id`)
                                                        AS `desc_tipofolha`,
                                                    `calculo`.`referencia` AS `valor_referencia`,
                                                    `calculo`.`valor` AS `valor_calculado`
                                                    FROM `hsfol_calculo` `calculo`
                                                    INNER JOIN `hsfol_referencia` `referencia`
                                                        ON `referencia`.`id` = `calculo`.`idreferencia`
                                                    INNER JOIN `hsfol_evento` `evento`
                                                        ON `evento`.`id` = `calculo`.`idevento`
                                                    WHERE `calculo`.`idcontrato` = ?
                                                    AND `referencia`.`idtipofolha` = 5
                                                    AND `referencia`.`datafolha` BETWEEN ? AND ?
                                                    AND `referencia`.`status` = 0
                                                    AND `evento`.`classificacao` IN (1, 2, 4)
                                                    ORDER BY `idcontrato`, `ano`, `mes`, `idtipofolha`,
                                                    CAST(`evento`.`codigo` AS UNSIGNED)", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha6 = DB::select("SELECT `calculo`.`idcontrato` AS `idcontrato`,
                                                    `referencia`.`idtipofolha`,
                                                    YEAR(`referencia`.`datafolha`) AS `ano`,
                                                    MONTH(`referencia`.`datafolha`) AS `mes`,
                                                    `evento`.`codigo` AS `cod_evento`,
                                                    `evento`.`descricao` AS `desc_evento`,
                                                    `evento`.`classificacao` AS `classificacao`,
                                                    (SELECT `tipofolha`.`descricao`
                                                        FROM `hsfol_tipofolha` `tipofolha`
                                                        WHERE `referencia`.`idtipofolha` = `tipofolha`.`id`)
                                                        AS `desc_tipofolha`,
                                                    `calculo`.`referencia` AS `valor_referencia`,
                                                    `calculo`.`valor` AS `valor_calculado`
                                                    FROM `hsfol_calculo` `calculo`
                                                    INNER JOIN `hsfol_referencia` `referencia`
                                                        ON `referencia`.`id` = `calculo`.`idreferencia`
                                                    INNER JOIN `hsfol_evento` `evento`
                                                        ON `evento`.`id` = `calculo`.`idevento`
                                                    WHERE `calculo`.`idcontrato` = ?
                                                    AND `referencia`.`idtipofolha` = 6
                                                    AND `referencia`.`datafolha` BETWEEN ? AND ?
                                                    AND `referencia`.`status` = 0
                                                    AND `evento`.`classificacao` IN (1, 2, 4)
                                                    ORDER BY `idcontrato`, `ano`, `mes`, `idtipofolha`,
                                                    CAST(`evento`.`codigo` AS UNSIGNED)", [$contrato, $datainicial, $datafinal]);

                    $valoresTipoFolha7 = DB::select("SELECT `calculo`.`idcontrato` AS `idcontrato`,
                                                    `referencia`.`idtipofolha`,
                                                    YEAR(`referencia`.`datafolha`) AS `ano`,
                                                    MONTH(`referencia`.`datafolha`) AS `mes`,
                                                    `evento`.`codigo` AS `cod_evento`,
                                                    `evento`.`descricao` AS `desc_evento`,
                                                    `evento`.`classificacao` AS `classificacao`,
                                                    (SELECT `tipofolha`.`descricao`
                                                        FROM `hsfol_tipofolha` `tipofolha`
                                                        WHERE `referencia`.`idtipofolha` = `tipofolha`.`id`)
                                                        AS `desc_tipofolha`,
                                                    `calculo`.`referencia` AS `valor_referencia`,
                                                    `calculo`.`valor` AS `valor_calculado`
                                                    FROM `hsfol_calculo` `calculo`
                                                    INNER JOIN `hsfol_referencia` `referencia`
                                                        ON `referencia`.`id` = `calculo`.`idreferencia`
                                                    INNER JOIN `hsfol_evento` `evento`
                                                        ON `evento`.`id` = `calculo`.`idevento`
                                                    WHERE `calculo`.`idcontrato` = ?
                                                    AND `referencia`.`idtipofolha` = 7
                                                    AND `referencia`.`datafolha` BETWEEN ? AND ?
                                                    AND `referencia`.`status` = 0
                                                    AND `evento`.`classificacao` IN (1, 2, 4)
                                                    ORDER BY `idcontrato`, `ano`, `mes`, `idtipofolha`,
                                                    CAST(`evento`.`codigo` AS UNSIGNED)", [$contrato, $datainicial, $datafinal]);

                    if ($valoresTipoFolha1 != null) {
                        $totalMensal1 = $this->buscaTotaisMensalAno($valoresTipoFolha1);
                    } else {
                        $totalMensal1 = null;
                    }
                    if ($valoresTipoFolha2 != null) {
                        $totalMensal2 = $this->buscaTotaisMensalAno($valoresTipoFolha2);
                    } else {
                        $totalMensal2 = null;
                    }
                    if ($valoresTipoFolha3 != null) {
                        $totalMensal3 = $this->buscaTotaisMensalAno($valoresTipoFolha3);
                    } else {
                        $totalMensal3 = null;
                    }
                    if ($valoresTipoFolha4 != null) {
                        $totalMensal4 = $this->buscaTotaisMensalAno($valoresTipoFolha4);
                    } else {
                        $totalMensal4 = null;
                    }
                    if ($valoresTipoFolha5 != null) {
                        $totalMensal5 = $this->buscaTotaisMensalAno($valoresTipoFolha5);
                    } else {
                        $totalMensal5 = null;
                    }
                    if ($valoresTipoFolha6 != null) {
                        $totalMensal6 = $this->buscaTotaisMensalAno($valoresTipoFolha6);
                    } else {
                        $totalMensal6 = null;
                    }
                    if ($valoresTipoFolha7 != null) {
                        $totalMensal7 = $this->buscaTotaisMensalAno($valoresTipoFolha7);
                    } else {
                        $totalMensal7 = null;
                    }

                    if (($valoresTipoFolha1 == null) && ($valoresTipoFolha2 == null) &&
                        ($valoresTipoFolha3 == null) && ($valoresTipoFolha4 == null) &&
                        ($valoresTipoFolha5 == null) && ($valoresTipoFolha6 == null) && ($valoresTipoFolha7 == null)) {
                        return redirect()->back()->with('error', 'Não existem lançamentos no período informado.');
                    } else {
                        $pdf = PDF::loadView('auth.pdfDemonstrativoPeriodo', compact(
                            'totalMensal1', 'totalMensal2', 'totalMensal3', 'totalMensal4', 'totalMensal5',
                            'totalMensal6', 'totalMensal7', 'servidor', 'dadosorgao', 'contrato', 'tipofolha',
                            'datainicial', 'datafinal', 'nome', 'matricula', 'funcao', 'lotacao', 'padrao',
                            'nivel', 'classe', 'valoresTipoFolha1', 'valoresTipoFolha2', 'valoresTipoFolha3',
                            'valoresTipoFolha4', 'valoresTipoFolha5', 'valoresTipoFolha6', 'valoresTipoFolha7'
                        ));

                        return $pdf->setPaper('a4')->stream('contrachequePeriodo.pdf');
                    }

                } else {
                    $valores = DB::select("SELECT `calculo`.`idcontrato` AS `idcontrato`,
                                `referencia`.`idtipofolha`,
                                YEAR(`referencia`.`datafolha`) AS `ano`,
                                MONTH(`referencia`.`datafolha`) AS `mes`,
                                `evento`.`codigo` AS `cod_evento`,
                                `evento`.`descricao` AS `desc_evento`,
                                `evento`.`classificacao` AS `classificacao`,
                                (SELECT `tipofolha`.`descricao`
                                    FROM `hsfol_tipofolha` `tipofolha`
                                    WHERE `referencia`.`idtipofolha` = `tipofolha`.`id`)
                                    AS `desc_tipofolha`,
                                `calculo`.`referencia` AS `valor_referencia`,
                                `calculo`.`valor` AS `valor_calculado`
                            FROM `hsfol_calculo` `calculo`
                                INNER JOIN `hsfol_referencia` `referencia`
                                    ON `referencia`.`id` = `calculo`.`idreferencia`
                                INNER JOIN `hsfol_evento` `evento`
                                    ON `evento`.`id` = `calculo`.`idevento`
                            WHERE `calculo`.`idcontrato` = ?
                            AND `referencia`.`idtipofolha` = ?
                            AND `referencia`.`datafolha` BETWEEN ? AND ?
                            AND `referencia`.`status` = 0
                            AND `evento`.`classificacao` IN (1, 2, 4)
                            ORDER BY `idcontrato`, `ano`, `mes`, `idtipofolha`,
                            CAST(`evento`.`codigo` AS UNSIGNED)", [$contrato, $tipofolha, $datainicial, $datafinal]);
                }

            }
            if ($valores != null) {
                $totalMensal = $this->buscaTotaisMensalAno($valores);

            }

            if ($valores == null) {
                return redirect()->back()->with('error', 'Não existem lançamentos no período informado.');
            } else {
                $pdf = PDF::loadView('auth.pdfDemonstrativoPeriodo', compact(
                    'totalMensal', 'servidor', 'dadosorgao', 'contrato', 'tipofolha', 'datainicial', 'datafinal',
                    'nome', 'matricula', 'funcao', 'lotacao', 'padrao', 'nivel', 'classe', 'valores'
                ));

                return $pdf->setPaper('a4')->stream('contrachequePeriodo.pdf');
            }

        }
        return redirect()->route('verificaLogin');

    }

    public function buscaTotaisMensal($valores)
    {
        $totais[] = [
            "mes" => $valores[0]->mes,
            "ano" => $valores[0]->ano,
            "desc_tipofolha" => $valores[0]->desc_tipofolha,
        ];

        for ($i = 0; $i < sizeof($valores); $i++) {
            if ($i > 0) {
                if ($valores[$i]->mes != $valores[$i - 1]->mes) {
                    $totais[] = [
                        "mes" => $valores[$i]->mes,
                        "ano" => $valores[$i]->ano,
                        "desc_tipofolha" => $valores[$i]->desc_tipofolha,
                    ];

                }
            }
        }
        return $totais;
    }

    public function buscaTotaisMensalAno($valores)
    {
        $totais[] = [
            "mes" => $valores[0]->mes,
            "ano" => $valores[0]->ano,
            "desc_tipofolha" => $valores[0]->desc_tipofolha,
        ];

        for ($i = 0; $i < sizeof($valores); $i++) {
            if ($i > 0) {
                if ($valores[$i]->mes != $valores[$i - 1]->mes) {
                    $totais[] = [
                        "mes" => $valores[$i]->mes,
                        "ano" => $valores[$i]->ano,
                        "desc_tipofolha" => $valores[$i]->desc_tipofolha,
                    ];

                }
                if ($valores[$i]->ano != $valores[$i - 1]->ano) {
                    $totais[] = [
                        "mes" => $valores[$i]->mes,
                        "ano" => $valores[$i]->ano,
                        "desc_tipofolha" => $valores[$i]->desc_tipofolha,
                    ];

                }
            }
        }
        return $totais;
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
            if (($valor->classificacao == '1') || ($valor->classificacao == 'P')) {
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
            if (($valor->classificacao == '2') || ($valor->classificacao == 'D')) {
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
            if (($valor->classificacao == '4') || ($valor->classificacao == 'B')) {
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
