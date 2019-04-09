<?php
use App\User;
use App\Restaurant;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS = 0');
      User::truncate();
      Restaurant::truncate();

      $cantidadUsuarios=10;
      $cantidadRestaurantes=10;
      factory(User::class, $cantidadUsuarios)->create();
      factory(Restaurant::class,$cantidadRestaurantes)->create();
    }
}
