<?php

use App\Events;
use App\TicketedUsers;
use App\User;
use App\album;
use App\client;
use App\groupSingers;
use App\locations;
use App\seller;
use App\singers;
use App\songs;
use App\tickets;
use App\vendors;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(App\User::class, function (Faker $faker) {
    static $password;
	$date = date("Y-M-d");
	$x = $faker->numberBetween(1,10);
	$usedDate =  date("Y-m-d",strtotime($date." +". $x. "days"));
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role' => $faker->randomElement([User::subscriber,User::regular_user,User::admin]),
        'vendor'=> $faker->randomElement([User::seller,null]),
        'endSubscription' => $usedDate,
    ];
});


// Events factory

$factory->define(App\locations::class, function (Faker $faker) {
 return [
  'location' =>  $faker->name,
  'image'=> $faker->randomElement(['location1.jpg','location2.jpg','location3.jpg']),
 ];
});

// Events factory

$factory->define(App\Events::class, function (Faker $faker) {
	$date = date("Y-M-d");
	$x = $faker->numberBetween(1,10);
	$usedDate =  date("Y-m-d",strtotime($date." +". $x. "days"));
    return [
   		'event_name' => $faker->name,
      'location' => $faker->name,
   		'date' => $usedDate,
      'availableTickets' => $faker->numberBetween(10000,100000),
      'user_id'=> $faker->numberBetween(1,20),
      'description' => $faker->sentence,
    ];
});

// vendor factory

$factory->define(App\seller::class, function (Faker $faker) {
     
    return [
   		 'user_id' =>  null,
       'vendorName' =>  $faker->name,
        'address'  =>  $faker->name,
        'email'  =>  $faker->email,
        'sellingRate' => $faker->numberBetween(10000,200000),
    ];
});

// client Factory

$factory->define(App\client::class, function (Faker $faker) {
    return [
      'user_id' =>User::all()->random()->id,
      'event_id' => Events::all()->random()->id,
      'vendors_id' => seller::all()->random()->id,
    ];
});

// tickets factory

$factory->define(App\tickets::class, function (Faker $faker) {
    return [
      'price_adult' => $faker->numberBetween(100,500),
      'price_child' => $faker->numberBetween(50,100),
      'user_id' =>  $faker->numberBetween(1,20),
    ];
});

// TicketsRequests factory

$factory->define(App\TicketsRequests::class, function (Faker $faker) {
    return [
   		 'vendors_id' => seller::all()->random()->id,
   		 'numberTickets_adult' => $faker->numberBetween(1,7),
        'numberTickets_child' => $faker->numberBetween(1,7),
        'user_id' => $faker->numberBetween(1,20),
    ];
});

// TicketedUsers factory information about tickets being processed

$factory->define(App\TicketedUsers::class, function (Faker $faker) {
    return [
   		 'ticketNumber' => str_random(10),
        'vendors_id' => seller::all()->random()->id,
        'user_id' => $faker->numberBetween(1,20),  
        'ticket_type'=>$faker->randomElement(['child','adult']),

    ];
});

// album factory

$factory->define(App\album::class, function (Faker $faker) {
    return [
    	'name'=> $faker->name,
   		 'ablumCover' =>  $faker->randomElement(["album1.jpg","album2.jpg","album3.jpg"]),
    ];
});

// group_singers factory

$factory->define(App\groupSingers::class, function (Faker $faker) {
    return [
   		'groupName'  => $faker->name,
   		 'singersCover' => $faker->randomElement(["singers1.jpg","singers2.jpg","singers3.jpg"]),
   		];
});

// songs factory

$factory->define(App\songs::class, function (Faker $faker) {
    return [
    	'name'=> $faker->name,
   		 'subscriber_id' => $faker->numberBetween(0,1),
   		 'event_id' => Events::all()->random()->id,
   		 'path' => $faker->randomElement(['song1.mp3','song2.mp3','song3.mp3']),
   		 'songCover' =>  $faker->randomElement(["song1.jpg","song2.jpg","song3.jpg"]),
    ];
});

// singers factory

$factory->define(App\singers::class, function (Faker $faker) {
    return [
   		 'singerName' => $faker->name,
   		  'singerCover' => $faker->randomElement(["singer1.jpg","singer2.jpg","singer3.jpg"]),
    ];
});

// vendor factory

$factory->define(App\vendor_datas::class, function (Faker $faker) {
    return [
    	'vendor_id' =>  TicketedUsers::all()->random()->vendor_id,
    	'client_id' => TicketedUsers::all()->random()->client_id,
    	'confirmedTicked_id' => TicketedUsers::all()->random()->ticketNumber,
    	'numberTickets' => TicketedUsers::all()->random()->numberTickets,
    ];
});

