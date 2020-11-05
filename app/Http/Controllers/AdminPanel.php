<?php

namespace App\Http\Controllers;

use App\Models\Locacion;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPanel extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        $amount_locaciones = count(Locacion::all());
        $amount_users = count(User::all());
        $amount_infected = count(User::all()->where('estado', 'Contagiado'));
        $amount_at_risk = count(User::all()->where('estado', 'En riesgo'));
        return view('adminpanel', [
            'Locaciones'=> $amount_locaciones,
            'Usuarios'=> $amount_users,
            'Infectados'=> $amount_infected,
            'Riesgo'=> $amount_at_risk,
            'layout'=>'index']
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
