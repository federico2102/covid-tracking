<?php

namespace Database\Factories;

use App\Models\Contagio;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContagioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contagio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'estado'=>'En riesgo',
            'fecha'=>Carbon::now(),
            'user_id'=>0,
        ];
    }
}
