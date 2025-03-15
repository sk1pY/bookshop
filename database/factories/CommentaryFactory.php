<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Commentary;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->text(100),
            'rating' => rand(1, 5),
            'book_id' => function () {
                return OrderItem::inRandomOrder()->value('book_id');
            },
            'user_id' => function (array $attributes) {
                return Order::whereHas('order_items', function ($query) use ($attributes) {
                    $query->where('book_id', $attributes['book_id']);
                })->inRandomOrder()->value('user_id');
            },
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Commentary $commentary) {
            $book = Book::where('id',$commentary->book_id)->first();
            $avgRating =  $book->commentaries()->avg('rating');
            $book->avgRating = $avgRating;
            $book-> save();
        });
    }
}
