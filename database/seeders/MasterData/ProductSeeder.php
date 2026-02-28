<?php

namespace Database\Seeders\MasterData;

use Illuminate\Database\Seeder;
use App\Repositories\MasterData\Product\ProductRepository;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $studios = \App\Models\MasterData\Studio::pluck('id')->toArray();
        $description = "
        <ul>
            <li>Tanpa Batasan Orang!</li>
            <li>Foto Sebanyak-banyaknya!</li>
            <li>15 Menit Sesi Foto</li>
            <li>5 Menit Pemilihan Foto</li>
            <li>Reschedule di hari H dapat dilakukan selambat-lambatnya 1 jam sebelum sesi yang dipesan dan sudah mendapat konfirmasi dari CS. Untuk jadwal yang dapat dipilih adalah jadwal yang masih kosong di hari tersebut. JIka tidak ada jadwal yang kosong, maka reschedule tidak dapat dilakukan.</li>
            <li>Toleransi keterlambatan maksimal 5 menit / waktu akan terpotong secara otomatis</li>
            <li>Disarankan datang 10 menit lebih awal untuk touch up / persiapan</li>
            <li>Follow IG, Tag Story Instagram @, &nbsp;dan Isi Kuesioner yang disediakan di meja Customer Service untuk mendapatkan&nbsp;<strong>SEMUA FULLCOLOR SOFTCOPY GRATIS</strong>&nbsp;yang dikirim melalui Drive</li>
            <li>Tidak diperbolehkan membawa hewan peliharaan</li>
            <li>Booking sesi yang sudah masuk di sistem, tidak bisa di refund/cancel</li>
        </ul>
        ";

        foreach ($studios as $studio) {
            for ($i = 0; $i < 5; $i++) {
                ProductRepository::create([
                    'studio_id' => $studio,
                    'name' => "PRODUCT " . $faker->word(),
                    'description' => $description,
                    'price' => $faker->randomElement([
                        10_000,
                        20_000,
                        25_000,
                        50_000,
                        100_000,
                    ]),
                    'image' => $faker->randomElement([
                        'bg-3.jpg',
                        'bg-black.jpg',
                        'bg-blue.jpg',
                        'bg-pink.jpg',
                    ]),
                    'note' => "FYI kapasitas studio kami sesuai product yang dipilih 15 orang ya kak, lebih dari itu nanti hasil nya kurang optimal hihi 😍",
                ]);
            }
        }
    }
}
