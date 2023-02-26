<?php

namespace Tests\Feature;

use App\Models\Money;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2022-01-01 00:00:00');
    }

    public function testIndex(): void
    {
        $products = [];

        for ($i = 0; $i < 3; $i++) {
            $product = new Product();
            $product->setName($this->faker->name);
            $product->setPrice((new Money())->setCents($this->faker->randomFloat()));
            $product->setAvailable($this->faker->randomNumber(4));
            $product->setVatRate($this->faker->randomFloat(2, 0, 1));
            $product->setImage($this->faker->name);

            DB::table('products')->insert([
                'name' => $product->getName(),
                'available' => $product->getAvailable(),
                'price' => $product->getPrice()->getCents(),
                'vat_rate' => $product->getVatRate(),
                'image' => $product->getImage(),
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ]);

            $products[] = $product;
        }

        $productsInDatabase = DB::select('select id from products');

        $response = $this->get('/api/v1/products');

        $response->assertStatus(200);
        $response->assertExactJson(
            [ 'data' =>
                [
                    [
                        'id' => $productsInDatabase[0]->id,
                        'name' => $products[0]->getName(),
                        'available' => $products[0]->getAvailable(),
                        'price' => $products[0]->getPrice()->getCents(),
                        'vat_rate' => $products[0]->getVatRate(),
                        'image' => $products[0]->getImage(),
                    ],
                    [
                        'id' => $productsInDatabase[1]->id,
                        'name' => $products[1]->getName(),
                        'available' => $products[1]->getAvailable(),
                        'price' => $products[1]->getPrice()->getCents(),
                        'vat_rate' => $products[1]->getVatRate(),
                        'image' => $products[1]->getImage(),
                    ],
                    [
                        'id' => $productsInDatabase[2]->id,
                        'name' => $products[2]->getName(),
                        'available' => $products[2]->getAvailable(),
                        'price' => $products[2]->getPrice()->getCents(),
                        'vat_rate' => $products[2]->getVatRate(),
                        'image' => $products[2]->getImage(),
                    ],
                ]
            ]
        );
    }

    public function testShow(): void
    {
        $product = new Product();
        $product->setName($this->faker->name);
        $product->setPrice((new Money())->setCents($this->faker->randomFloat()));
        $product->setAvailable($this->faker->randomNumber(4));
        $product->setVatRate($this->faker->randomFloat(2, 0, 1));
        $product->setImage($this->faker->name);

        DB::table('products')->insert([
            'name' => $product->getName(),
            'available' => $product->getAvailable(),
            'price' => $product->getPrice()->getCents(),
            'vat_rate' => $product->getVatRate(),
            'image' => $product->getImage(),
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $productInDatabase = DB::select('select id from products where name = ?', [$product->getName()]);

        $response = $this->get('/api/v1/products/' . $productInDatabase[0]->id);

        $response->assertStatus(200);
        $response->assertExactJson(
            [ 'data' =>
                [
                    'id' => $productInDatabase[0]->id,
                    'name' => $product->getName(),
                    'available' => $product->getAvailable(),
                    'price' => $product->getPrice()->getCents(),
                    'vat_rate' => $product->getVatRate(),
                    'image' => $product->getImage(),
                ],
            ]
        );
    }

    public function testCreate(): void
    {
        $response = $this->post('/api/v1/products', [
            'name' => 'iphone',
            'available' => 2,
            'price' => 1,
            'vatRate' => 0.2,
            'imageUrl' => 'imagineLinkHere',
        ]);

        $responseContent = json_decode($response->getContent());

        $response->assertStatus(201);
        $response->assertExactJson(
            [ 'data' =>
                [
                    'id' => $responseContent->data->id,
                    'name' => 'iphone',
                    'available' => 2,
                    'price' => 100, // price changes from 1 to 100, because it gets converted to cents
                    'vat_rate' => 0.2,
                    'image' => 'imagineLinkHere',
                ]
            ]);

        $this->assertDatabaseHas('products',
            [
                'id' => $responseContent->data->id,
                'name' => 'iphone',
                'available' => 2,
                'price' => 100,
                'vat_rate' => 0.2,
                'image' => 'imagineLinkHere',
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function testUpdate(): void
    {
        $product = new Product();
        $product->setName($this->faker->name);
        $product->setPrice((new Money())->setCents($this->faker->randomFloat()));
        $product->setAvailable($this->faker->randomNumber(4));
        $product->setVatRate($this->faker->randomFloat(2, 0, 1));
        $product->setImage($this->faker->name);

        DB::table('products')->insert([
            'name' => $product->getName(),
            'available' => $product->getAvailable(),
            'price' => $product->getPrice()->getCents(),
            'vat_rate' => $product->getVatRate(),
            'image' => $product->getImage(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $productInDatabase = DB::select('select id from products where name=?', [$product->getName()]);

        $response = $this->put('/api/v1/products/' . $productInDatabase[0]->id, [
            'name' => 'camera',
            'available' => 100,
            'price' => 1,
            'vatRate' => 0.9,
            'imageUrl' => 'imagineLinkHere',
        ]);

        $responseContent = json_decode($response->getContent());

        $response->assertStatus(200);
        $response->assertExactJson(
            [ 'data' =>
                [
                    'id' => $responseContent->data->id,
                    'name' => 'camera',
                    'available' => 100,
                    'price' => 100, // price changes from 1 to 100, because it gets converted to cents
                    'vat_rate' => 0.9,
                    'image' => 'imagineLinkHere',
                ]
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $responseContent->data->id,
            'name' => 'camera',
            'available' => 100,
            'price' => 100, // price changes from 1 to 100, because it gets converted to cents
            'vat_rate' => 0.9,
            'image' => 'imagineLinkHere',
            'created_at' => now()->format('Y-m-d H:i:s'),
            'updated_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    public function testDestroy():void
    {
        $product = new Product();
        $product->setName($this->faker->name);
        $product->setPrice((new Money())->setCents($this->faker->randomFloat()));
        $product->setAvailable($this->faker->randomNumber(4));
        $product->setVatRate($this->faker->randomFloat(2, 0, 1));
        $product->setImage($this->faker->name);

        DB::table('products')->insert([
            'name' => $product->getName(),
            'available' => $product->getAvailable(),
            'price' => $product->getPrice()->getCents(),
            'vat_rate' => $product->getVatRate(),
            'image' => $product->getImage(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $productInDatabase = DB::select('select id from products where name=?', [$product->getName()]);

        $response = $this->delete('/api/v1/products/' . $productInDatabase[0]->id);

        $response->assertStatus(204);
        $response->assertNoContent();
    }
}
