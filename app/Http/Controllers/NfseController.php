<?php

namespace App\Http\Controllers;

use App\Nfse;
use App\Prestador;
use DB;
use PDF;
use Illuminate\Http\Request;

class NfseController extends Controller
{
    private $repository;

    public function __construct(Nfse $nfse)
    {

        $this->repository = $nfse;
    }

    public function index()
    {

    }

    public function emissaoPrimeiraEtapa()
    {
        $prestador_id = auth()->user()->prestador_id;
        $prestador = Prestador::where('id', '=', $prestador_id)->first();

        $totalNfse = Nfse::where('prestador_id', '=', $prestador->id)->count();
        $numeronfse = $totalNfse + 1;

        $ano = date("Y");

        return view('prestador.nfse.emissao.primeiraetapa', compact('numeronfse', 'ano', 'prestador'));
    }

    public function emissaoSegundaEtapa(Request $request)
    {
        $dados = $request->all();

        $id = $request->id;

        // Busca CNAES do Prestador
        $cnaes = DB::select('SELECT * FROM `cnae` inner join `prestador_cnae` on cnae.id = prestador_cnae.cnae_id
        where prestador_cnae.prestador_id = ? ', [$id]);

        // Busca Atividades do Prestador
        $atividades = DB::select('SELECT * FROM `atividades` inner join `prestador_atividades` on atividades.id = prestador_atividades.atividades_id
        where prestador_atividades.prestador_id = ? ', [$id]);

        return view('prestador.nfse.emissao.segundaetapa', compact('dados', 'cnaes', 'atividades'));

    }

    public function emissaoTerceiraEtapa(Request $request)
    {
        // Recupera os dados das etapas anteriores
        $dadosNfse = json_decode($request->dados);

        // Recupera todos os dados
        $dados = (object) $request->all();

        // Recupera o CNAE completo (Serviço 01)
        $cnae = $request->cnaes;
        $cnaeCompleto = DB::select('SELECT * from `cnae` where `id` = ?', [$cnae]);
        // Recupera a Atividade completa
        $atividade = $request->atividades;
        $atividadeCompleta = DB::select('SELECT * from `atividades` where `id` = ?', [$atividade]);

        // Recupera o CNAE completo (Serviço 02)
        $cnae2 = $request->cnaes_2;
        $cnaeCompleto2 = DB::select('SELECT * from `cnae` where `id` = ?', [$cnae2]);
        // Recupera a Atividade completa
        $atividade2 = $request->atividades_2;
        $atividadeCompleta2 = DB::select('SELECT * from `atividades` where `id` = ?', [$atividade2]);

        // Recupera o CNAE completo (Serviço 03)
        $cnae3 = $request->cnaes_3;
        $cnaeCompleto3 = DB::select('SELECT * from `cnae` where `id` = ?', [$cnae3]);
        // Recupera a Atividade completa
        $atividade3 = $request->atividades_3;
        $atividadeCompleta3 = DB::select('SELECT * from `atividades` where `id` = ?', [$atividade3]);

        // Recupera o CNAE completo (Serviço 04)
        $cnae4 = $request->cnaes_4;
        $cnaeCompleto4 = DB::select('SELECT * from `cnae` where `id` = ?', [$cnae4]);
        // Recupera a Atividade completa
        $atividade4 = $request->atividades_4;
        $atividadeCompleta4 = DB::select('SELECT * from `atividades` where `id` = ?', [$atividade4]);

        // Recupera o CNAE completo (Serviço 05)
        $cnae5 = $request->cnaes_5;
        $cnaeCompleto5 = DB::select('SELECT * from `cnae` where `id` = ?', [$cnae5]);
        // Recupera a Atividade completa
        $atividade5 = $request->atividades_5;
        $atividadeCompleta5 = DB::select('SELECT * from `atividades` where `id` = ?', [$atividade5]);

        return view('prestador.nfse.emissao.terceiraetapa',
            compact('dados', 'dadosNfse', 'cnaeCompleto', 'atividadeCompleta',
                'cnaeCompleto2', 'atividadeCompleta2', 'cnaeCompleto3', 'atividadeCompleta3',
                'cnaeCompleto4', 'atividadeCompleta4', 'cnaeCompleto5', 'atividadeCompleta5'));

    }

    public function emitir(Request $request)
    {
        $dadosNfse = json_decode($request->dadosNfse);
        $dados = json_decode($request->dados);
        $cnaeCompleto = json_decode($request->cnaecompleto);
        $atividadeCompleta = json_decode($request->atividadecompleta);
       // dd($dadosNfse);

        // Salva os dados da NFS-e
        $numero = $dadosNfse->numeronfse;
        $dataemissao = $dadosNfse->dataemissao;
        $dataprestacao = $dadosNfse->dataprestacao;
        $serie = $dadosNfse->serie;
        $competencia = $dadosNfse->competencia;
        $ano = $dadosNfse->ano;
        $basecalculo = $dados->valor;
        $total = $dados->valor;
        $aliquota = $dados->aliquota;
        $valoriss = ($total * $aliquota)/100;
        $valorliquido = $total - $valoriss;
        $usuario_id = auth()->user()->id;
        $prestador_id = $dadosNfse->id;
        
        $insert = DB::table('notasfiscais')->insert([
            'numero' => $numero,
            'dataemissao' => $dataemissao,
            'dataprestacao' => $dataprestacao,
            'serie' => $serie,
            'competencia' => $competencia,
            'ano' => $ano,
            'basecalculo' => $basecalculo,
            'total' => $total,
            'valoriss' => $valoriss,
            'valorliquido' => $valorliquido,
            'usuario_id' => $usuario_id,
            'prestador_id' => $prestador_id,
            'tomador_id' => 1,

        ]);

        //dd($insert);

        $pdf = PDF::loadView('pdf.nfse', compact('dados', 'dadosNfse', 'cnaeCompleto', 'atividadeCompleta'));

        return $pdf->setPaper('a4')->stream('NFSE.pdf');


    }

}
