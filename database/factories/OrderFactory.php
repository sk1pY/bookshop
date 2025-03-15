<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=> User::inRandomOrder()->first()->id,
            'address_id' => Address::inRandomOrder()->first()->id,
            'status' => 'Получен',
            'price' => 0,
            ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $books = Book::inRandomOrder()->limit(rand(1, 5))->get();
            $orderPrice = 0;
            foreach ($books as $book) {
                $quantity = rand(1, 3);

              $order_item =   OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'quantity' => $quantity,
                ]);
                $book->increment('numberOfPurchased', $quantity);;

                $orderPrice += $quantity * $book->price;
            }
            $order->update(['price' => $orderPrice]);
        });
    }
}
