<?php

namespace App\Http\Controllers;

use App\Tomador;
use App\Http\Requests\CriaAlteraTomador;
use Illuminate\Http\Request;

class TomadorController extends Controller
{
    private $repository;

    public function __construct(Tomador $tomador)
    {
        $this->repository = $tomador;
    }

    public function index()
    {
        $tomadores = $this->repository->paginate(1);

        return view('fiscal.tomador.tomadores', compact('tomadores'));
    }

    public function verTodos()
    {
        $total = $this->repository->count();
        $tomadores = $this->repository->paginate($total);

        return view('fiscal.tomador.tomadores', compact('tomadores'));

    }

    public function cadastro()
    {
        return view('fiscal.tomador.cadastro');
    }

    public function salvar(CriaAlteraTomador $request, tomador $tomador)
    {

        $insert = $tomador->create($request->all());

        if ($insert) {
            return redirect()->route('fiscal.painel')->with('success', 'Tomador inserido com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao inserir');

    }

    public function detalhes($id)
    {
        $tomador = $this->repository->find($id);

        if (!$tomador) {
            return redirect()->back();
        }

        return view('fiscal.tomador.detalhes', compact('tomador'));
    }

    public function editar($id)
    {
        $tomador = $this->repository->find($id);
        
        if (!$tomador) {
            return redirect()->back();
        }

        return view('fiscal.tomador.edicao', compact('tomador'));
    }

    public function atualizar(Request $request, $id)
    {
        $tomador = $this->repository->find($id);

        if (!$tomador) {
            return redirect()->back();
        }

        $insert = $tomador->update($request->all());

        if ($insert) {
            return redirect()->route('tomadores')->with('success', 'Dados do Tomador alterados com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao inserir');

    }

    public function excluir($id)
    {
        $tomador = $this->repository->find($id);

        if (!$tomador) {
            return redirect()->back();
        }

        $tomador->delete();

        return redirect()->route('tomadores')->with('success', 'Tomador excluído com sucesso!');
    }

    public function buscaPelaRazaoSocial(Request $request)
    {
        $pesquisa = $request->except('_token');

        $tomadores = $this->repository->buscaPelaRazaoSocial($request->pesquisa);

        return view('fiscal.tomador.tomadores', compact('tomadores', 'pesquisa'));
    }

}
