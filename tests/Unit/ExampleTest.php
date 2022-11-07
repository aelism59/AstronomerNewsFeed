<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Role;
use App\Models\UserRole;
use Tests\TestCase;
use Illuminate\Http\Response;
use PhpParser\Node\Expr\Assign;

class ExampleTest extends TestCase {
    
    public $token;

    protected function setUp():void{
        parent::setUp();
        $payload = ['email' => 'admin@astronomerguy.project', 'password'=> 'astronomer_guy'];
        
        $response = $this->json('post', 'api/login',$payload)
             ->assertStatus(Response::HTTP_OK);
             $this->token=$response->decodeResponseJson()['token'];
    }

    public function testLogin(){
        $payload = ['email' => 'admin@astronomerguy.project', 'password'=> 'astronomer_guy'];
        
        $response = $this->json('post', 'api/login',$payload)
             ->assertStatus(Response::HTTP_OK);
             $this->token=$response->decodeResponseJson()['token'];
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
        $payload = ['email' => 'editor@astronomerguy.project', 'password'=> '1234'];
        
        $response = $this->json('post', 'api/login',$payload)
             ->assertStatus(Response::HTTP_OK);
             $token=$response->decodeResponseJson()['token'];

        $payload = ['title'=> 'Final 5','contents'=> 'Final is a big guy who...'];
        $response = $this->json('post','api/posts',$payload, ['Authorization'=>'Bearer '.$token]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            "title", "contents", "tag", "author_id", "updated_at", "created_at","id"
        ]);
    
    }
    public function testAdminCreateNotExistContentPost(){
        
        $payload = ['title'=> '','content'=> ''];

        $response = $this->json('post','api/posts',$payload, ['Authorization'=>'Bearer '.$this->token]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    
    }
    public function testAdminCreateComments(){
        
        $payload = ['comment'=> 'This is phenomenal'];
        
        $post = Post::all()->first();

        $response = $this->json('post',route('posts.comments.store', ['post'=>$post]),$payload, ['Authorization'=>'Bearer '.$this->token]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            "comment", "is_approved", "user_id", "commentable_id", "commentable_type", "updated_at", "created_at", "id"

        ]);
        
    }
}
