<?php

namespace Tests\Unit;

use App\Models\Advert;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvertsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
 /*   public function testAdvertCreation()
    {

       $advert = factory(Advert::class)->create();

       $this->assertDatabaseHas('adverts', [
            'title' => $advert->title
       ]);
    }

    public function testAddingUserToAdvert()
    {

        $advert = factory(Advert::class)->create();

        $user = factory(User::class)->create();

        $advert->user()->associate($user);

        $advert->save();

        $this->assertDatabaseHas('adverts', [
            'title' => $advert->title,
            'user_id' => $user->id
        ]);
    }

    public function testRequestCreateAdvert()
    {
        $advert = factory(Advert::class)->make();
        $response = $this->post('/api/adverts', $advert->toArray());

        $response->assertStatus(201);


    }*/
}
