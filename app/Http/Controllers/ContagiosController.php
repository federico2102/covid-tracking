<?php

namespace App\Http\Controllers;

use App\Services\ContagioService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContagiosController extends Controller
{
    public function informarContagio(Request $request): \Illuminate\Http\RedirectResponse
    {
        $fecha_diagnostico = Carbon::create($request->input('fecha'));
        $fecha_minima = $fecha_diagnostico->subDays(env('TIEMPO_DE_CONTAGIO', 7));

        $contagioService = new ContagioService();
        $contagioService->handleContagion(Auth::user(), $fecha_minima, $fecha_diagnostico);

        return redirect("/home");
    }
}
