<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DominionApiFeatureTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /*
    public function testBasicTest()
    {
        $response = $this->get('/home');
        $response->assertStatus(200);

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/user', ['name' => 'Sally']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
        $response = $this->withSession(['foo' => 'bar'])
            ->get('/');
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('/');
        $this->actingAs($user, 'api');
        $response = $this->json('POST', '/user', ['name' => 'Sally']);

        $response
            ->assertStatus(200)
            ->assertJson([
                'created' => true,
            ]);
    }
    /*
     * 必要なテスト
     * showHand
     * 
     * /

    public function testClean()
    {
    }
     */
    public function testNone()
    {
        $response = $this->get('/dummy');
        $response->assertStatus(200);
                 
    }
}

