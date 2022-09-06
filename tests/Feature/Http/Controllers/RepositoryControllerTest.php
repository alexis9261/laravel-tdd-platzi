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
     * undocumented function summary
     *
     * Undocumented function long description
     *
     **/
    public function test_index_empty()
    {
        Repository::factory()->create(); // user_id = 1
        $user = User::factory()->create(); // id = 2

        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee('No hay repositorios creados');
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     **/
    public function test_index_with_data()
    {
        $user = User::factory()->create(); // id = 2
        $repository = Repository::factory()->create(['user_id' => $user->id]); // user_id = 1

        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee($repository->id)
            ->assertSee($repository->url);
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

        // creo un usuario con el cual estare logeado, que sera el dueño del registro
        $user = User::factory()->create();

        // Creo un repositorio que sera actualizado
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        // Data a actualizar en el repositorio
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];

        $this
            ->actingAs($user) // simula estar logeado como este usuario
            ->put("repositories/$repository->id", $data) // hace una peticion HTTP Put a la url 'repositories' y envia la $data, repositories.update
            ->assertRedirect("repositories/$repository->id/edit"); // verifico redireccion a url de edicion de repository, repositories.edit

        // verifico que la data se encuentre DB, en la table 'repositories'repositories.edit
        $this->assertDatabaseHas('repositories', $data);
    }

    /**
     * Verifica que la ruta repositories.update[PUT] funcione bien
     * Correspondiente al controladorApp\Controllers\RepositoryController->update()
     */
    public function test_update_policy()
    {

        // creo un usuario con el cual estare logeado, que sera el dueño del registro
        $user = User::factory()->create();

        // Creo un repositorio que sera actualizado
        $repository = Repository::factory()->create();

        // Data a actualizar en el repositorio
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];

        $this
            ->actingAs($user) // simula estar logeado como este usuario
            ->put("repositories/$repository->id", $data) // hace una peticion HTTP Put a la url 'repositories' y envia la $data, repositories.update
            ->assertStatus(403);
    }

    /**
     * Verifica que la ruta repositories.update[PUT] funcione bien
     * Correspondiente al controladorApp\Controllers\RepositoryController->update()
     */
    public function test_show()
    {

        // creo un usuario con el cual estare logeado, que sera el dueño del registro
        $user = User::factory()->create();

        // Creo un repositorio que sera actualizado
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this
            ->actingAs($user) // simula estar logeado como este usuario
            ->get("repositories/$repository->id") // hace una peticion HTTP Put a la url 'repositories' y envia la $data, repositories.update
            ->assertStatus(200); // verifico redireccion a url de edicion de repository, repositories.edit
    }

    /**
     * Verifica que la ruta repositories.update[PUT] funcione bien
     * Correspondiente al controladorApp\Controllers\RepositoryController->update()
     */
    public function test_show_policy()
    {

        // creo un usuario con el cual estare logeado, que sera el dueño del registro
        $user = User::factory()->create();

        // Creo un repositorio que sera actualizado
        $repository = Repository::factory()->create();

        $this
            ->actingAs($user) // simula estar logeado como este usuario
            ->get("repositories/$repository->id") // hace una peticion HTTP Put a la url 'repositories' y envia la $data, repositories.update
            ->assertStatus(403);
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


    /**
     * Verifica que la ruta repositories.update[PUT] funcione bien
     * Correspondiente al controladorApp\Controllers\RepositoryController->update()
     */
    public function test_destroy()
    {
        // creo un usuario con el cual estare logeado
        $user = User::factory()->create();

        // Creo un repositorio que sera actualizado
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this
            ->actingAs($user) // simula estar logeado como este usuario
            ->delete("repositories/$repository->id") // hace una peticion HTTP Put a la url 'repositories' y envia la $data, repositories.update
            ->assertRedirect("repositories"); // verifico redireccion a url de edicion de repository, repositories.index

        // verifico que la data se encuentre DB, en la table 'repositories'repositories.edit
        $this->assertDatabaseMissing('repositories', [
            'id' => $repository->id,
            'url' => $repository->url,
            'description' => $repository->description,
        ]);
    }

    /**
     * Verifica que la ruta repositories.update[PUT] funcione bien
     * Correspondiente al controladorApp\Controllers\RepositoryController->update()
     */
    public function test_destroy_policy()
    {
        // creo un usuario con el cual estare logeado
        $user = User::factory()->create(); //user_id = 1

        // Creo un repositorio que sera actualizado
        $repository = Repository::factory()->create(); //user_id = 2

        $this
            ->actingAs($user) // simula estar logeado como este usuario
            ->delete("repositories/$repository->id") // hace una peticion HTTP Put a la url 'repositories' y envia la $data, repositories.update
            ->assertStatus(403); // verifico redireccion a url de edicion de repository, repositories.index

    }
}
