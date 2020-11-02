<?php

namespace Tests\Unit;

use App\Models\Locacion;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class LocacionesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function usuario_puede_ingresar_a_locacion()
    {
        $this->disableExceptionHandling();

        $user = User::factory()->create();
        $this->assertNotNull($user);

        $locacion = Locacion::factory()->create(['user_id'=>$user->id]);

        $ingreso = $locacion->ingresarUsuario($user->id);

        $this->assertNotNull($ingreso);
        $this->assertEquals($ingreso->user_id, $user->id);
        $this->assertEquals($ingreso->locacion_id, $locacion->id);
        $this->assertNotNull($locacion->ingresos()->find($ingreso->id));
        $this->assertNotNull($user->visitas()->find($ingreso->id));
    }

    /** @test */
    public function usuario_puede_ingresar_no_contagiado()
    {
        $user_contagiado = User::factory()->create(['estado'=>'Contagiado']);
        $user_en_riesgo = User::factory()->create(['estado'=>'En riesgo']);
        $user_no_contagiado = User::factory()->create(['estado'=>'No contagiado']);

        $locacion = Locacion::factory()->create(['user_id'=>$user_contagiado->id]);

        $this->assertNull($locacion->ingresarUsuario($user_contagiado));
        $this->assertNull($locacion->ingresarUsuario($user_en_riesgo));
        $this->assertNotNull($locacion->ingresarUsuario($user_no_contagiado));
    }

    /** @test */
    public function usuario_solo_puede_estar_en_una_locacion()
    {
        $user = User::factory()->create();

        $locacion = Locacion::factory()->create(['user_id'=>$user->id]);
        $locacion2 = Locacion::factory()->create(['user_id'=>$user->id]);


        $ingreso = $locacion->ingresarUsuario($user->id);
        $ingreso2 = $locacion2->ingresarUsuario($user->id);

        $this->assertNotNull($ingreso);
        $this->assertNull($ingreso2);
    }
}
