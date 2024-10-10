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
//        $this->disableExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);


        $locacion = Locacion::factory()->create(['user_id'=>$user->id]);

        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user->id);
        $ingreso = User::find($user->id)->locacion;

        $this->assertEquals($locacion->id, $ingreso);
    }

    /** @test */
    public function usuario_puede_ingresar_no_contagiado()
    {
        $this->disableExceptionHandling();

        $user_contagiado = User::factory()->create(['estado'=>'Contagiado']);
        $this->actingAs($user_contagiado);

        $user_en_riesgo = User::factory()->create(['estado'=>'En riesgo']);
        $this->actingAs($user_en_riesgo);

        $user_no_contagiado = User::factory()->create(['estado'=>'No contagiado']);
        $this->actingAs($user_no_contagiado);

        $locacion = Locacion::factory()->create(['user_id'=>$user_contagiado->id]);

        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user_contagiado->id);
        $ingreso_contagiado = User::find($user_contagiado->id)->locacion;
        $this->assertEquals(0, $ingreso_contagiado);

        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user_en_riesgo->id);
        $ingreso_en_riesgo = User::find($user_en_riesgo->id)->locacion;
        $this->assertEquals(0, $ingreso_en_riesgo);

        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user_no_contagiado->id);
        $ingreso_no_contagiado = User::find($user_no_contagiado->id)->locacion;
        $this->assertEquals($locacion->id, $ingreso_no_contagiado);
    }

    /** @test */
    public function usuario_solo_puede_estar_en_una_locacion()
    {
        $this->disableExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $locacion = Locacion::factory()->create(['user_id'=>$user->id]);
        $locacion2 = Locacion::factory()->create(['user_id'=>$user->id]);

        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user->id);
        $ingreso = User::find($user->id)->locacion;
        $this->assertEquals($locacion->id,$ingreso);

        $this->json('POST', '/concurrio/store/'.$locacion2->id.'/'.$user->id);
        $ingreso2 = User::find($user->id)->locacion;
        $this->assertEquals($locacion->id,$ingreso2);
    }

    /** @test */
    public function usuario_no_puede_ingresar_si_locacion_esta_llena()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $user2 = User::factory()->create();
        $this->actingAs($user2);

        $locacion = Locacion::factory()->create(['user_id'=>$user->id, 'CapacidadMax'=>1]);

        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user->id);
        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user2->id);
        $ingreso = User::find($user2->id)->locacion;

        $this->assertEquals(0, $ingreso);
    }

    /** @test */
    public function usuario_puede_salir_de_locacion()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $locacion = Locacion::factory()->create(['user_id'=>$user->id]);

        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user->id);
        $ingreso = User::find($user->id)->locacion;
        $this->assertEquals($locacion->id, $ingreso);

        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user->id);
        $ingreso = User::find($user->id)->locacion;
        $this->assertEquals(0, $ingreso);
    }
}
