<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@andrecarros.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        $brandRecords = collect(['Toyota', 'Honda', 'Chevrolet', 'Volkswagen'])
            ->mapWithKeys(fn (string $name) => [$name => Brand::firstOrCreate(['name' => $name])]);

        $colorRecords = collect([
            ['name' => 'Prata', 'hex' => '#C0C0C0'],
            ['name' => 'Preto', 'hex' => '#000000'],
            ['name' => 'Branco', 'hex' => '#FFFFFF'],
            ['name' => 'Vermelho', 'hex' => '#C52D2F'],
        ])->mapWithKeys(function (array $color) {
            $record = Color::firstOrCreate(
                ['name' => $color['name']],
                ['hex_code' => $color['hex']]
            );

            return [$color['name'] => $record];
        });

        $modelRecords = collect([
            ['brand' => 'Toyota', 'name' => 'Corolla'],
            ['brand' => 'Toyota', 'name' => 'Yaris'],
            ['brand' => 'Honda', 'name' => 'Civic'],
            ['brand' => 'Honda', 'name' => 'HR-V'],
            ['brand' => 'Chevrolet', 'name' => 'Onix'],
            ['brand' => 'Chevrolet', 'name' => 'Tracker'],
            ['brand' => 'Volkswagen', 'name' => 'T-Cross'],
            ['brand' => 'Volkswagen', 'name' => 'Polo'],
        ])->mapWithKeys(function (array $model) use ($brandRecords) {
            $record = CarModel::firstOrCreate(
                ['brand_id' => $brandRecords[$model['brand']]->id, 'name' => $model['name']]
            );

            return [$model['name'] => $record];
        });

        $vehicles = [
            [
                'title' => 'Toyota Corolla Altis Hybrid',
                'brand' => 'Toyota',
                'model' => 'Corolla',
                'color' => 'Prata',
                'year' => 2023,
                'mileage' => 12000,
                'price' => 189900,
                'description' => 'Sedã híbrido completo com pacote Toyota Safety Sense, multimídia com Android Auto/Apple CarPlay e todos os revisões realizadas em concessionária.',
                'photos' => [
                    'https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg',
                    'https://images.pexels.com/photos/358070/pexels-photo-358070.jpeg',
                    'https://images.pexels.com/photos/358070/pexels-photo-358070.jpeg?auto=compress&cs=tinysrgb&w=800',
                ],
            ],
            [
                'title' => 'Honda HR-V Touring Turbo',
                'brand' => 'Honda',
                'model' => 'HR-V',
                'color' => 'Branco',
                'year' => 2022,
                'mileage' => 18500,
                'price' => 214500,
                'description' => 'SUV com motor turbo, teto panorâmico, bancos em couro e pacote completo de segurança Honda Sensing. Garantia de fábrica até 2027.',
                'photos' => [
                    'https://images.pexels.com/photos/1119798/pexels-photo-1119798.jpeg',
                    'https://images.pexels.com/photos/972391/pexels-photo-972391.jpeg',
                    'https://images.pexels.com/photos/3812924/pexels-photo-3812924.jpeg',
                ],
            ],
            [
                'title' => 'Chevrolet Onix Premier 1.0 Turbo',
                'brand' => 'Chevrolet',
                'model' => 'Onix',
                'color' => 'Preto',
                'year' => 2021,
                'mileage' => 34000,
                'price' => 89900,
                'description' => 'Versão topo com acabamento premium, Wi-Fi a bordo, 8 airbags e pacote RS. Revisado, em perfeito estado.',
                'photos' => [
                    'https://images.pexels.com/photos/170811/pexels-photo-170811.jpeg?auto=compress&cs=tinysrgb&w=800',
                    'https://images.pexels.com/photos/2449452/pexels-photo-2449452.jpeg',
                    'https://images.pexels.com/photos/2449457/pexels-photo-2449457.jpeg',
                ],
            ],
            [
                'title' => 'Volkswagen T-Cross Highline 250 TSI',
                'brand' => 'Volkswagen',
                'model' => 'T-Cross',
                'color' => 'Vermelho',
                'year' => 2024,
                'mileage' => 8500,
                'price' => 169900,
                'description' => 'SUV compacto com motor TSI, pacote tecnológico completo, painel digital Active Info Display e rodas aro 18.',
                'photos' => [
                    'https://images.pexels.com/photos/1402787/pexels-photo-1402787.jpeg',
                    'https://images.pexels.com/photos/210019/pexels-photo-210019.jpeg',
                    'https://images.pexels.com/photos/358070/pexels-photo-358070.jpeg',
                ],
            ],
        ];

        foreach ($vehicles as $vehicleData) {
            $photos = collect($vehicleData['photos'])->unique()->values();

            if ($photos->count() < 3) {
                continue;
            }

            $vehicle = Vehicle::updateOrCreate(
                ['title' => $vehicleData['title']],
                [
                    'brand_id' => $brandRecords[$vehicleData['brand']]->id,
                    'car_model_id' => $modelRecords[$vehicleData['model']]->id,
                    'color_id' => $colorRecords[$vehicleData['color']]->id,
                    'year' => $vehicleData['year'],
                    'mileage' => $vehicleData['mileage'],
                    'price' => $vehicleData['price'],
                    'main_photo_url' => $photos->first(),
                    'description' => $vehicleData['description'],
                ]
            );

            $vehicle->photos()->delete();

            $photos->each(function (string $url, int $index) use ($vehicle): void {
                $vehicle->photos()->create([
                    'url' => $url,
                    'is_primary' => $index === 0,
                ]);
            });
        }

        $this->command?->info('Usuario administrador: '.$admin->email.' | senha: admin123');
    }
}
