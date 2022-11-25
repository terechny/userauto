<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AutoTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store()
    {
        
        $response = $this->postJson('/api/auto', ['name' => 'Voldo s500', 'number' => 'A550DD']);
        $response->assertStatus(201);

    }

    public function test_show(){

        $this->postJson('/api/auto', ['name' => 'Voldo s500', 'number' => 'A550DD']);

        $response = $this->get('/api/auto/1');
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'auto' => [
                    'id',
                    'name',
                    'number'
                ]
            ]
        ]);

    }

    public function test_index(){

        $response = $this->get('/api/auto');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'list' => [
                    '*' => [
                        'id',
                        'name',
                        'number'
                    ]
                ]
            ]
        ]);

    }

    public function test_update(){

        $this->postJson('/api/auto', ['name' => 'Voldo s500', 'number' => 'A550DD']);
        $response = $this->putJson('api/auto/1',  ['name' => 'Voldo s500', 'number' => 'A550DD']);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "result"
            ]
        ]);
    }

    public function test_destroy(){

        $this->postJson('/api/auto', ['name' => 'Voldo s500', 'number' => 'A550DD']);
        $response = $this->deleteJson('api/auto/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "result"
            ]
        ]);

    }

    public function test_show_auto(){

        $this->postJson('/api/auto', ['name' => 'Voldo s500', 'number' => 'A550DD']);
        $this->postJson('/api/autouser', ['firstname' => "Adam", 'secondname' => "Smith"]);
        $this->postJson('/api/autouser/setauto', ['user' => 1, 'auto' => 1]);

        $response = $this->get('api/autouser/1/showauto');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'user_auto' => [
                    "id",
                    "firstname",
                    "secondname",
                    "auto_id",
                    "auto_name",
                    "auto_number"
                ]
            ]
        ]);
    }
}
