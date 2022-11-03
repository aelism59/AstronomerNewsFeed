<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\Response;

class ExampleTest extends TestCase {
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_true_is_true() {
        $this->assertTrue(true);
    }

    public function testLoginWithNoPassword(){
        $payload = [
            'email' => 'admin@astronomerguy.project'
        ];
        
        $this->json('post', 'api/login')
             ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function testLoginWithNoEmail(){
        $payload = [
            'password' => 'astronomer_guy'
        ];
        
        $this->json('post', 'api/login')
             ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY); 
    }
}
