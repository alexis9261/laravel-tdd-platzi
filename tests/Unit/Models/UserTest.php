<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase; // php artisan test
// use PHPUnit\Framework\TestCase; // vendor/bin/phpunit

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_has_many_respositories()
    {
        $user = new User;

        $this->assertInstanceOf(Collection::class, $user->repositories);
    }
}
