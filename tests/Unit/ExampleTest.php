<?php

namespace Tests\Unit;

use App\Models\UserRole;
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
        $payload = ['email' => 'admin@astronomerguy.project'];
        
        $this->json('post', 'api/login',$payload)
             ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testLoginWithNoEmail(){
        $payload = ['password' => 'astronomer_guy'];
        
        $this->json('post', 'api/login',$payload)
             ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY); 
    }

    public function testEmailNotExistInDatabase(){
        $payload = ['email' => 'noone@astonomerguy.project','password' =>'astronomer_guy'];

        $this->json('post', 'api/login',$payload)
            ->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testNoEmailNoPass(){
        $payload = ['email' => '','password' => ''];

        $this->json('post', 'api/login',$payload)
             ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        
    }
    public function testEditorCanCreatePost(){
        $editor = UserRole::where('role_id',4)->first();
        $payload = ['title'=> 'Final 5','content'=> 'Final is a big guy who...'];

        $response = $this->actingAs($editor, 'web')
        ->call('POST', route('/api/posts', $payload));

        $response->assertOk();
        $response->assertJsonStructure([
            "title", "contents", "tag", "author_id", "updated_at", "created_at","id"
        ]);
    return $editor;
    
    }
    public function testEditorCreateNotExistContentPost(){
        $user = UserRole::where('role_id',4)->first();
        $payload = ['title'=> '','content'=> ''];

        $response = $this->actingAs($user, 'web')
        ->call('POST', route('/api/posts', $payload));

        $response->assertOk();
        $response->assertJsonStructure([
            "title", "contents", "tag", "author_id", "updated_at", "created_at","id"]);
    
    return $user;
    }
}
