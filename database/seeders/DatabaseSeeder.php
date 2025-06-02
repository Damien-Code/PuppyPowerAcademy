<?php

namespace Database\Seeders;

use App\Models\TrainingCategory;
use App\Models\User;
// use App\Models\Cart;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Cart_Product;
use App\Models\Cart_Training;
use App\Models\Category_Order;
use App\Models\Contact;
use App\Models\Dog;
use App\Models\Daycare;
use App\Models\Daycare_Dog;
use App\Models\Training;
use App\Models\Dog_Training;
use App\Models\Order;
use App\Models\Order_Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => '1'
        ]);
        User::factory()->create([
            'name' => 'test test',
            'email' => 'test@test.test',
            'role_id' => '1'
        ]);

        User::factory(10)->create(['role_id' => 2]);
        // Cart::factory(10)->create();
        Product::factory(10)->create();
        Order::factory(10)->create();
        Dog::factory(10)->create();

        TrainingCategory::factory()->create([
            'name' => 'Puppy',
            'price' => '29',
            'descriptors' => json_encode([
            "Basis Commando's",
            "Socialisatie Vaardigheden",
            "Zindelijkheidstraining",
            "Bijtremming",
            "Aan de Lijn Lopen"
            ])
        ]);

        TrainingCategory::factory()->create([
            'name' => 'Vuurwerk',
            'price' => '99',
            'descriptors' => json_encode([
            "Angstreductie Technieken",
            "Geluid Gewenning",
            "Stressvrije Omgeving",
            "Gedragstherapie",
            "Kalmeringstechnieken"
            ])
        ]);

        TrainingCategory::factory()->create([
            'name' => 'Gedrag',
            'price' => '499',
            'descriptors' => json_encode([
            "Probleemgedrag Aanpak",
            "Gedragsverandering Technieken",
            "Sociale Vaardigheden", 
            "Stress Management",
            "Vertrouwen Opbouwen"
            ])
        ]);

        Training::factory(10)->create();
        Daycare::factory(10)->create();
        Contact::factory(10)->create();

        Daycare_Dog::factory(10)->create();
        Dog_Training::factory(10)->create();
        Cart::factory(count(User::all()))->create();
        Cart_Product::factory(count(User::all()))->create();
        Cart_Training::factory(count(User::all()))->create();
        Order_Product::factory(10)->create();
        Category_Order::factory(10)->create();
    }
}
