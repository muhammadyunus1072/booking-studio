<?php

namespace Database\Seeders\Transaction;

use App\Models\MasterData\PaymentMethod;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\MasterData\Product;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');

        // Ambil semua produk dan booking time
        $paymentMethods = PaymentMethod::all();
        $products = Product::all();
        $users = User::all();

        for ($day = 0; $day < 300; $day++) {
            $bookingDate = Carbon::now()->subDays($day);

            $randTransactionCount = rand(5, 10);
            for ($i = 0; $i < $randTransactionCount; $i++) {
                $user = $faker->randomElement($users);

                $bookingCount = rand(1, 3);
                $bookings = [];
                $booking = 0;
                while ($booking < $bookingCount) {
                    // Pilih produk acak
                    $product = $faker->randomElement($products); // Get full product model

                    // Pilih product_detail_id yang sesuai dengan product_id
                    if ($product->productDetails->isEmpty()) {
                        continue; // Skip if no product details available
                    }
                    $productDetail = $faker->randomElement($product->productDetails);

                    // Pilih product_booking_time_id yang sesuai dengan product_detail_id
                    if ($product->productBookingTimes->isEmpty()) {
                        continue; // Skip if no booking times available
                    }
                    $productBookingTime = $faker->randomElement($product->productBookingTimes);

                    // Cek ketersediaan sebelum booking
                    $isNotAvailable = TransactionDetail::isNotAvailable(
                        $bookingDate,
                        $product->id,
                        $productBookingTime->id
                    );

                    if ($isNotAvailable) {
                        continue; // Skip if already booked
                    }

                    $bookings[] = [
                        'product_id' => $product->id,
                        'product_detail_id' => $productDetail->id,
                        'product_booking_time_id' => $productBookingTime->id,
                        'price' => $product->price + $productDetail->price,
                    ];

                    $booking++; // Increase booking count
                }
                $paymentMethod = $faker->randomElement($paymentMethods); // Contoh metode pembayaran
                $subtotal = collect($bookings)->sum('price');
                $admin_fee = 0;
                $grandTotal = 0;
                if ($paymentMethod->type === PaymentMethod::TYPE_PERCENTAGE) {
                    $admin_fee = calculatedAdminFee($subtotal, $paymentMethod->amount);
                    $grandTotal = $subtotal + $admin_fee;
                } else {
                    $admin_fee = $paymentMethod->amount;
                    $grandTotal = $subtotal + $admin_fee;
                }
                $t_status = $faker->randomElement([
                    Transaction::STATUS_PENDING,
                    Transaction::STATUS_PAID,
                    Transaction::STATUS_EXPIRED,
                ]);
                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $faker->phoneNumber(),
                    'customer_label' => 'Customer',
                    'payment_method_id' => $paymentMethod->id,
                    'voucher_id' => null,
                    'created_at' => $bookingDate,
                    'status' => $t_status,
                    'booking_code' => $t_status == Transaction::STATUS_PAID ? substr(strtoupper(md5(uniqid() . 1)), 0, 3) . str_pad($faker->word(), 4, '0', STR_PAD_LEFT) : null,
                    'grand_total' => $grandTotal,
                    'subtotal' => $subtotal,
                    'admin_fee' => $admin_fee,
                    'discount' => 0,
                ]);

                foreach ($bookings as $book) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'booking_date' => $bookingDate,
                        'product_id' => $book['product_id'],
                        'product_detail_id' => $book['product_detail_id'],
                        'product_booking_time_id' => $book['product_booking_time_id'],
                    ]);
                }
            }
        }
    }
}
