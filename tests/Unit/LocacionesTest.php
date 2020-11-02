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

        $user_id = User::factory()->create()->id;
        $this->assertNotNull($user_id);

        $locacion_id = Locacion::factory()->create(['Creador'=>$user_id])->id;

        $ingreso = $this->json('POST', '/concurrio/store/'.$locacion_id.'/'.$user_id);

        $this->assertNotNull($ingreso);
        $this->assertEquals($ingreso->user_id, $usuario->id);
        $this->assertEquals($ingreso->locacion_id, $locacion->id);
    }
}
