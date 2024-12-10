<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bank;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bank>
 */
class BankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Bank::class;
    public function definition(): array
    {
       
            return [
                'tanggal' => $this->faker->dateTimeBetween('2020-01-01', '2024-12-31')->format('Y-m-d'),
                'keterangan' => $this->faker->sentence(),
                'cabang' => $this->faker->randomElement(['0000', '0011', '0022']),
                'jumlah' => $this->faker->randomFloat(2, 1000, 100000),
                'tipe_transaksi' => $this->faker->randomElement(['DB', 'CR']),
                'saldo' => $this->faker->randomFloat(2, 1000, 100000),
            ];
       
    }
}
