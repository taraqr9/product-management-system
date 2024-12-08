<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Laravel Book',
            'description' => 'A Laravel book is a guide that provides in-depth knowledge and practical tutorials about the Laravel framework. It covers topics such as routing, controllers, middleware, Eloquent ORM, Blade templating, API development, and advanced features like authentication and testing, helping developers build robust web applications efficiently.',
            'price' => 50,
            'stock' => '10',
        ];
    }
}
