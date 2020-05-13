<?php

namespace App\Http\Controllers;

use App\Escritorio;
use App\Http\Requests\CriaAlteraPrestador;
use App\Prestador;
use DB;
use Illuminate\Http\Request;

class PrestadorController extends Controller
{
    private $repository;

    public function __construct(Prestador $prestador)
    {
        $this->repository = $prestador;
    }

    public function index()
    {
        $prestadores = $this->repository->paginate(15);

        return view('fiscal.prestador.prestadores', compact('prestadores'));
    }

    public function verTodos()
    {
        $total = $this->repository->count();
        $prestadores = $this->repository->paginate($total);

        return view('fiscal.prestador.prestadores', compact('prestadores'));

    }

    public function cadastro()
    {
        $escritorios = Escritorio::all();
        $cnaes = DB::table('cnae')->get();
        $atividades = DB::table('atividades')->get();
        return view('fiscal.prestador.cadastro', compact('escritorios', 'cnaes', 'atividades'));
    }

    public function salvar(CriaAlteraPrestador $request, Prestador $prestador)
    {
        //Insere o Prestador
        $insertPrestador = $prestador->create($request->all());

        // Pega os resultados do select de CNAES
        $cnaes = $request->cnaes;

        // Pega os resultados do select de Atividades
        $atividades = $request->atividades;

        $prestador_id = DB::table('prestadores')->where('cpfcnpj', 'LIKE', "{$request->cpfcnpj}")->value('id');

        //Insert na tabela prestador_cnaes
        foreach ($cnaes as $cnae) {
            $insertCnaes = DB::table('prestador_cnae')->insert([
                'prestador_id' => $prestador_id,
                'cnae_id' => $cnae,
            ]);
        }

        //Insert na tabela prestador_atividades
        foreach ($atividades as $atividade) {
            $insertAtividades = DB::table('prestador_atividades')->insert([
                'prestador_id' => $prestador_id,
                'atividades_id' => $atividade,
            ]);
        }

        if (($insertPrestador) && ($insertCnaes) && ($insertAtividades)) {
            return redirect()->route('fiscal.painel')->with('success', 'Prestador inserido com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao inserir Prestador');

    }

    public function detalhes($id)
    {
        $prestador = $this->repository->find($id);
        $escritorio = Escritorio::where('id', '=', $prestador->escritorio_id)->first();

        $cnaes = DB::select('SELECT * FROM `cnae` inner join `prestador_cnae` on cnae.id = prestador_cnae.cnae_id
                             where prestador_cnae.prestador_id = ? ', [$id]);

        $atividades = DB::select('SELECT * FROM `atividades` inner join `prestador_atividades` on atividades.id = prestador_atividades.atividades_id
        where prestador_atividades.prestador_id = ? ', [$id]);

        if (!$prestador) {
            return redirect()->back();
        }

        return view('fiscal.prestador.detalhes', compact('prestador', 'escritorio', 'cnaes', 'atividades'));
    }

    public function editar($id)
    {
        $prestador = $this->repository->find($id);
        $escritorio = Escritorio::where('id', '=', $prestador->escritorio_id)->first();
        $escritorios = Escritorio::all();
        $cnaes = DB::table('cnae')->get();
        $atividades = DB::table('atividades')->get();

        $cnaes_cad = DB::select('SELECT * FROM `cnae` inner join `prestador_cnae` on cnae.id = prestador_cnae.cnae_id
        where prestador_cnae.prestador_id = ? ', [$id]);

        $atividades_cad = DB::select('SELECT * FROM `atividades` inner join `prestador_atividades` on atividades.id = prestador_atividades.atividades_id
        where prestador_atividades.prestador_id = ? ', [$id]);

        if (!$prestador) {
            return redirect()->back();
        }

        return view('fiscal.prestador.edicao', compact('prestador', 'escritorio', 'escritorios', 'cnaes', 'atividades', 'cnaes_cad', 'atividades_cad'));
    }

    public function atualizar(Request $request, $id)
    {

        // Pega os resultados do select de CNAES
        $cnaes = $request->cnaes;

        // Pega os resultados do select de Atividades
        $atividades = $request->atividades;

        // Busca o Prestador pelo id
        $prestador = $this->repository->find($id);

        if (!$prestador) {
            return redirect()->back();
        }

        // Deleta os CNAEs e Atividades cadastradas
        $deletaCnae = DB::delete('delete from prestador_cnae where prestador_id = ?', [$id]);
        $deletaAtividades = DB::delete('delete from prestador_atividades where prestador_id = ?', [$id]);

        //Insere os cnaes na tabela prestador_cnaes
        foreach ($cnaes as $cnae) {
            $insertCnaes = DB::table('prestador_cnae')->insert([
                'prestador_id' => $id,
                'cnae_id' => $cnae,
            ]);
        }

        //Insere as atividades tabela prestador_atividades
        foreach ($atividades as $atividade) {
            $insertAtividades = DB::table('prestador_atividades')->insert([
                'prestador_id' => $id,
                'atividades_id' => $atividade,
            ]);
        }

        $insert = $prestador->update($request->all());

        if (($insert) && ($insertCnaes) && ($insertAtividades)) {
            return redirect()->route('prestadores')->with('success', 'Dados do Prestador alterados com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao inserir');

    }

    public function excluir($id)
    {
        $prestador = $this->repository->find($id);

        if (!$prestador) {
            return redirect()->back();
        }

        $prestador->delete();

        return redirect()->route('prestadores')->with('success', 'Prestador excluído com sucesso!');
    }

    public function buscaPelaRazaoSocial(Request $request)
    {
        $pesquisa = $request->except('_token');

        $prestadores = $this->repository->buscaPelaRazaoSocial($request->pesquisa);

        return view('fiscal.prestador.prestadores', compact('prestadores', 'pesquisa'));
    }

    public function testeAjax(Request $request)
    {
        $cpfcnpj = $request->cpfcnpj;
        $email = $request->email;

        flash('Email enviado com sucesso! {{ $email }}')->success();

        return response()->json(['success' => 'Form is successfully submitted!']);
    }

}
