<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Enums\ProductCategory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'id'                     => (string) Str::uuid(),
            'nom'                    => $this->faker->words(2, true),
            'slug'                   => $this->faker->unique()->slug,
            'fabricant'              => $this->faker->company,
            'description'            => $this->faker->paragraph,
            'imageUrl'               => $this->faker->imageUrl(640, 480, 'tech', true),
            'resolutionX'            => $this->faker->randomElement([720, 1080, 1920, 3840]),
            'resolutionY'            => $this->faker->randomElement([480, 720, 1080, 2160]),
            'taillePouces'           => $this->faker->randomFloat(1, 10, 100),
            'luminositeNits'         => $this->faker->numberBetween(300, 2000),
            'tauxRafraichissementHz' => $this->faker->randomElement([60, 120, 144]),
            'puissanceWatts'         => $this->faker->randomFloat(1, 50, 500),
            'prixLocation'           => $this->faker->randomFloat(2, 100, 1000),
            'prixVente'              => $this->faker->randomFloat(2, 500, 10000),
            'category'               => $this->faker->randomElement(ProductCategory::cases()),
        ];
    }
}

