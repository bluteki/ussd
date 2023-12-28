<?php

namespace Bluteki\Ussd\Database\Factories;

use Bluteki\Ussd\Models\SessionManager;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SessionManagerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = SessionManager::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'session_id' => Str::random(20),
            'msisdn' => $this->faker->e164PhoneNumber()
        ];
    }
}