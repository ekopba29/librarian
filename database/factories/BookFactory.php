<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'judul' => $this->faker->sentence(),
            'deskripsi' => $this->faker->sentence(),
            'stock' => rand(1,5),
            'category' => $this->faker->sentence(),
            'pengarang' => $this->faker->sentence()
        ];
    }
}
