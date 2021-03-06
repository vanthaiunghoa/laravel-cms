<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
//$factory->define(JornSchalkwijk\LaravelCMS\Models::class, function (Faker\Generator $faker) {
//    static $password;
//
//    return [
//        'name' => $faker->name,
//        'email' => $faker->unique()->safeEmail,
//        'password' => $password ?: $password = bcrypt('secret'),
//        'remember_token' => str_random(10),
//    ];
//});
    $factory->define(JornSchalkwijk\LaravelCMS\Models::class, function (Faker\Generator $faker) {
        return [
            'user_id' => $faker->unique()->numberBetween(30,1000),
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->companyEmail(),
            'password' => bcrypt('root'),
            'dob' => $faker->date(),
            'function' => $faker->randomElement(['manager','programmer','hr','marketing']),
            'rights' => $faker->randomElement(['Admin','Content Manager','Author']),
            'approved' => $faker->boolean(),
            'trashed' => $faker->boolean(),
            'remember_token' => null,
            'album_id' => 1,
            'img_path' => $faker->file(storage_path('app/public/uploads','/users')),
            'created_by' => 26,
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });

/** @var \Illuminate\Database\Eloquent\Factory $factory */
    $factory->define(JornSchalkwijk\LaravelCMS\Models\Post::class, function (Faker\Generator $faker) {
        $categories = \JornSchalkwijk\LaravelCMS\Models\Category::where('type','post')->pluck('category_id')->toArray();
        $users = \JornSchalkwijk\LaravelCMS\Models::all()->pluck('user_id')->toArray();
        return [
            'post_id' => $faker->unique()->numberBetween(1,1000),
            'title' => $faker->sentence(8,40),
            'description' => $faker->text(50),
            'content' => $faker->paragraph(rand(3,5)),
            'approved' => $faker->boolean(),
            'trashed' => $faker->boolean(),
            'user_id' => $faker->randomElement($users),
            'category_id' => $faker->randomElement($categories),
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });

    /** @var \Illuminate\Database\Eloquent\Factory $factory */
    $factory->define(JornSchalkwijk\LaravelCMS\Models\Category::class, function (Faker\Generator $faker) {
        $users = \JornSchalkwijk\LaravelCMS\Models::all()->pluck('user_id')->toArray();
        $categories = \JornSchalkwijk\LaravelCMS\Models\Category::all()->pluck('category_id');
        if ($categories->count() < 1) {;
            return [
                'category_id' => $faker->unique()->numberBetween(1,1000),
                'title' => $faker->sentence(1,40),
                'description' => $faker->text(50),
                'content' => $faker->paragraph(rand(3,5)),
                'approved' => $faker->boolean(),
                'trashed' => $faker->boolean(),
                'type' => $faker->randomElement(['post','product']),
                'user_id' => $faker->randomElement($users),
                'parent_id' => 0,
                'created_at' => $faker->dateTimeThisYear,
                'updated_at' => $faker->dateTimeThisYear,
            ];
        } else {
            $categories = JornSchalkwijk\LaravelCMS\Models\Category::all()->pluck('category_id')->toArray();
            return [
                'category_id' => $faker->unique()->numberBetween(1,1000),
                'title' => $faker->sentence(1,40),
                'description' => $faker->text(50),
                'content' => $faker->paragraph(rand(3,5)),
                'approved' => $faker->boolean(),
                'trashed' => $faker->boolean(),
                'type' => $faker->randomElement(['post','product']),
                'user_id' => $faker->randomElement($users),
                'parent_id' => $faker->randomElement($categories),
                'created_at' => $faker->dateTimeThisYear,
                'updated_at' => $faker->dateTimeThisYear,
            ];
        }

    });

    $factory->define(JornSchalkwijk\LaravelCMS\Models\Product::class, function (Faker\Generator $faker) {
        $categories = JornSchalkwijk\LaravelCMS\Models\Category::where('type','product')->pluck('category_id')->toArray();
        return [
            'product_id' => $faker->unique()->numberBetween(1,1000),
            'name' => $faker->sentence(8,40),
            'description' => $faker->text(50),
            'price' => 10,
            'quantity' => 10,
            'discount_price' => 0.00,
            'savings' => 0.00,
            'tax_percentage' => 21,
            'tax' => 0.00,
            'img_path' => $faker->file(storage_path('app/public/uploads','/products')),
            'category_id' => $faker->randomElement($categories),
            'folder_id' => 0,
            'approved' => $faker->boolean(),
            'trashed' => $faker->boolean(),
            'created_at' => $faker->dateTimeThisYear,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });

    $factory->define(\JornSchalkwijk\LaravelCMS\Models\Tag::class,function(\Faker\Generator $faker){
        $users = \JornSchalkwijk\LaravelCMS\Models\User::all()->pluck('user_id')->toArray();
        return [
            'tag_id' => $faker->unique()->numberBetween(1,1000),
            'title' => $faker->word(),
            'type' => null,
            'user_id' => $faker->randomElement($users),
            'approved' => $faker->boolean(),
            'trashed' => $faker->boolean(),
            'created_at' => $faker->dateTime,
            'updated_at' => $faker->dateTimeThisYear,
        ];
    });