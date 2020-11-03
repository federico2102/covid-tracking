<?php

namespace Tests\Unit;

use App\Models\Locacion;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ContagiosTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function usuario_puede_informar_contagio()
    {
        $user = User::factory()->create();
        $this->actingAs($user);


    }
}
