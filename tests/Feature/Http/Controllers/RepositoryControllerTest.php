<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * Verifica que todas las url del recurso 'repository' esten protegidas con auth
     */
    public function test_guest()
    {
        $this->get('repositories')->assertRedirect('login');        // index
        $this->get('repositories/1')->assertRedirect('login');      // show
        $this->get('repositories/1/edit')->assertRedirect('login'); // edit
        $this->put('repositories/1')->assertRedirect('login');      // update
        $this->delete('repositories/1')->assertRedirect('login');   // delete
        $this->get('repositories/create')->assertRedirect('login'); // create
        $this->post('repositories', [])->assertRedirect('login');   // store
    }

    /**
     * Verifica que la ruta repositories.store[POST] funcione bien
     * Correspondiente al controladorApp\Controllers\RepositoryController->store()
     */
    public function test_store()
    {
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,

        ];

        $user = User::factory()->create();

        $this
            ->actingAs($user) // simula estar logeado como este usuario
            ->post('repositories', $data) // hace una peticion HTTP Post a la url 'repositories' y envia la $data,  repositories.store
            ->assertRedirect('repositories'); // verifico redireccion a url de edicion de repository, repositories.index

        // verifico que la data se encuentre DB, en la table 'repositories'repositories.edit
        $this->assertDatabaseHas('repositories', $data);
    }

    /**
     * Verifica que la ruta repositories.update[PUT] funcione bien
     * Correspondiente al controladorApp\Controllers\RepositoryController->update()
     */
    public function test_update()
    {
        // Creo un repositorio que sera actualizado
        $repository = Repository::factory()->create();

        // Data a actualizar en el repositorio
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];

        // creo un usuario con el cual estare logeado
        $user = User::factory()->create();

        $this
            ->actingAs($user) // simula estar logeado como este usuario
            ->put("repositories/$repository->id", $data) // hace una peticion HTTP Put a la url 'repositories' y envia la $data, repositories.update
            ->assertRedirect("repositories/$repository->id/edit"); // verifico redireccion a url de edicion de repository, repositories.edit

        // verifico que la data se encuentre DB, en la table 'repositories'repositories.edit
        $this->assertDatabaseHas('repositories', $data);
    }

    /**
     * Verifica que la validacion de los datos en la ruta repositories.store[POST] funcione bien
     * Correspondiente al controladorApp\Controllers\RepositoryController->store()
     * Valida el envio de data vacia, []
     */
    public function test_validate_store()
    {

        $user = User::factory()->create();

        $this
            ->actingAs($user) // simula estar logeado como este usuario
            ->post('repositories', []) // hace una peticion HTTP Post a la url 'repositories' y envia la $data,  repositories.store
            ->assertStatus(302)
            ->assertSessionHasErrors(['url', 'description']); //

    }

    /**
     * Verifica que la validacion de los datos en la la ruta repositories.update[PUT] funcione bien
     * Correspondiente al controladorApp\Controllers\RepositoryController->update()
     */
    public function test_validate_update()
    {
        // Creo un repositorio que sera actualizado
        $repository = Repository::factory()->create();

        // creo un usuario con el cual estare logeado
        $user = User::factory()->create();

        $this
            ->actingAs($user) // simula estar logeado como este usuario
            ->put("repositories/$repository->id", []) // hace una peticion HTTP Put a la url 'repositories' y envia la $data, repositories.update
            ->assertStatus(302)
            ->assertSessionHasErrors(['url', 'description']); //

    }
}
