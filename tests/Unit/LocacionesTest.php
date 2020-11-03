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
        $ingreso = $locacion->buscarEntrada($user->id);

        $this->assertNotNull($ingreso);
        $this->assertEquals($ingreso->user_id, $user->id);
        $this->assertEquals($ingreso->locacion_id, $locacion->id);
        $this->assertNotNull($locacion->ingresos()->find($ingreso->id));
        $this->assertNotNull($user->visitas()->find($ingreso->id));
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
        $this->assertNull($locacion->buscarEntrada($user_contagiado->id));

        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user_en_riesgo->id);
        $this->assertNull($locacion->buscarEntrada($user_en_riesgo->id));

        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user_no_contagiado->id);
        $this->assertNotNull($locacion->buscarEntrada($user_no_contagiado->id));
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
        $ingreso = $locacion->BuscarEntrada($user->id);
        $this->assertNotNull($ingreso);

        $this->json('POST', '/concurrio/store/'.$locacion2->id.'/'.$user->id);
        $ingreso2 = $locacion2->BuscarEntrada($user->id);
        $this->assertNull($ingreso2);
    }
}
