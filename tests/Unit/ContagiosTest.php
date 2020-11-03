<?php

namespace Tests\Unit;

use App\Models\Compartieron;
use App\Models\Contagio;
use App\Models\Locacion;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ContagiosTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function usuario_puede_informar_contagio()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $user->contagiar(date("Y-m-d h:i:sa"), date("Y-m-d h:i:sa"));

        $this->assertEquals('Contagiado', $user->estado);
    }

    /** @test */
    public function usuario_contagiado_puede_informar_alta()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $user->contagiar(date("Y-m-d h:i:sa"), date("Y-m-d h:i:sa"));
        $user->curado(date("Y-m-d h:i:sa"));

        self::assertEquals('No contagiado', $user->estado);
    }

    /** @test */
    public function usuario_puede_contagiar_usuarios()
    {
        $this->disableExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $user2 = User::factory()->create();
        $this->actingAs($user2);

        $user3 = User::factory()->create();
        $this->actingAs($user3);

        $locacion = Locacion::factory()->create(['user_id'=>$user->id]);

        // Entran los 3 usuarios
        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user->id);
        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user2->id);
        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user3->id);

        // Salen los 3 usuarios
        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user->id);
        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user2->id);
        $this->json('POST', '/concurrio/store/'.$locacion->id.'/'.$user3->id);

        $salidas_abiertas = Compartieron::all()->whereNull('hasta');
        $this->assertNull($salidas_abiertas->first());

        $user->contagiar(date("Y-m-d h:i:sa"), date("Y-m-d h:i:sa"));
        //dd($user2->estado);

        $this->assertEquals('En riesgo', User::find($user2->id)->estado);
        $this->assertEquals('En riesgo', User::find($user3->id)->estado);
    }

    /** @test */
    public function usuario_en_riesgo_puede_informar_alta_o_contagio()
    {
        $user = User::factory()->create(['estado'=>'En riesgo']);
        Contagio::factory()->create(['user_id'=>$user->id]);
        $this->actingAs($user);

        $user->curado(date("Y-m-d h:i:sa"));
        $this->assertEquals('No contagiado', User::find($user->id)->estado);

        $user2 = User::factory()->create(['estado'=>'En riesgo']);
        Contagio::factory()->create(['user_id'=>$user2->id]);
        $this->actingAs($user2);

        $this->json('GET', '/informarcontagio');
        $this->assertEquals('Contagiado', User::find($user2->id)->estado);
    }
}
