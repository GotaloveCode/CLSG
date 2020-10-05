<?php
namespace Database\Seeders;

use App\Models\Connection;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Connection::firstOrCreate(['name' => 'Individual connections (x Average house Size)']);
        Connection::firstOrCreate(['name' => 'Public standpoints (x Average no served per kiosk)']);
    }
}
