<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;
use App\Municipe;

class MunicipeController extends Controller
{
    public function verificaLogin()
    {
        $login = Session::get('login');
        if($login){
            return view('auth.painel');
        } else {
            return view('auth.login');
        }
    }

    public function login(Request $request)
    {
        $cpf = $request->cpf;
        $senha = sha1($request->senha);

        $autenticacao = DB::select('SELECT * FROM `hscad_municipedoc` inner join `hscad_cadmunicipal`
        on hscad_cadmunicipal.inscricaomunicipal = hscad_municipedoc.idmunicipe
        where hscad_municipedoc.numero = ? and hscad_cadmunicipal.senhaweb = ?', [$cpf, $senha]);

        if ($autenticacao != null) {
            Session::put('login', true);
            return view('auth.painel');
        } else {
            return view('auth.login');
        }
    }

    public function sair()
    {
        Session::flush();
        return redirect()->route('verificaLogin');;
    }

    public function teste(Request $request)
    {
        $id = '26';
        $municipe = Municipe::where('inscricaomunicipal', '=', $id)->first();
        
       // dd($municipe);

        $login = Session::get('login');

        if ($login) {
            return view('teste');
        } else {
            return view('auth.login');
        }
    }
}
