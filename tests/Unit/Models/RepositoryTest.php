<?php

namespace Tests\Unit\Models;

use App\Models\Repository;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_belongs_to_user()
    {
        // Ejecuto el factory de la clase Repository
        $respository = Repository::factory()->create();

        // verifico si el metodo user retorna una instancia de la clase User
        $this->assertInstanceOf(User::class, $respository->user);
    }
}
