<?php

namespace App\Http\Controllers;

use App\Models\bairro;
use App\Models\categoria;
use App\Models\condutor;
use App\Models\infraccao;
use App\Models\perfil;
use App\Models\RegraTransito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LengthException;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\Response;

class PerfilController extends Controller
{

    private $objInfraccao;
    private $objCondutor;
    private $objRegra;
    private $objBairro;
    private $objCategoria;


    public function __construct()
    {
        $this->objInfraccao = new infraccao();
        $this->objCondutor = new condutor();
        $this->objRegra = new RegraTransito();
        $this->objBairro = new bairro();
        $this->objCategoria = new categoria();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = [];
        $idades = [];
        $numRegras = $this->objRegra->all()->count();
        for($i = 1; $i <= $numRegras; $i++){
           $ifraccoes = $this->objInfraccao->all()->where('idRegraTransito', '=', $i);
           foreach ($ifraccoes as $value) {
              array_push($user, $value->idCondutor);
           }
           foreach ($user as $value) {
               $condutor = $this->objCondutor->all()->where('id', '=', $value); 
           }
           foreach ($condutor as $value) {
              $soma = 0;
              $soma = $soma + $value->idade;
              $genero = DB::select('select genero from condutors where id = ?', [$value->id]);
              $condicao = DB::select('select condicaoFisica from condutors where id = ?', [$value->id]);
              $categoria = DB::select('select nome from categorias where id = ?', [$value->categoria]);
           }
           $media = $soma / $condutor->count();
           $regra = DB::select('select nome from regra_transitos where id = ?', [$i]);
           array_push($idades, ['regra' => $regra[0]->nome ,'media' => $media, 'categoria' => $categoria[0]->nome, 'genero' => $genero[0]->genero, 'condicao' => $condicao[0]->condicaoFisica]);
        }
        
        $perfil =  $idades;
        return response()->json($perfil);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

