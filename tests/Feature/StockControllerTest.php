<?php

namespace Tests\Feature;

use App\Models\Money;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StockControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2022-01-01 00:00:00');
    }

    public function testIndex()
    {
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
        }

        $productsInDatabase = DB::select('select id from products');

        foreach ($productsInDatabase as $productInDatabase) {
            DB::table('stock')->insert([
                'product_id' => $productInDatabase->id,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ]);
        }

        $response = $this->get('/api/v1/stock');

        $responseContent = json_decode($response->getContent());


        $response->assertStatus(200);
        $response->assertExactJson(
            [
                [
                    'id' => $responseContent[0]->id,
                    'product_id' => $productsInDatabase[0]->id,
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => $responseContent[1]->id,
                    'product_id' => $productsInDatabase[1]->id,
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ],
                [
                    'id' => $responseContent[2]->id,
                    'product_id' => $productsInDatabase[2]->id,
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                ],
            ]
        );
    }

    public function testCreate()
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

        $productInDatabase = DB::select('select id from products where name = ?', [$product->getName()]);

        $response = $this->post('/api/v1/stock', [
            'product_id' => $productInDatabase[0]->id,
        ]);

        $responseContent = json_decode($response->getContent());

        $response->assertStatus(201);
        $response->assertExactJson([
            [
                'id' => $responseContent[0]->id,
                'product_id' => $productInDatabase[0]->id,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ]
        ]);

        $this->assertDatabaseHas('stock',
            [
                'id' => $responseContent[0]->id,
                'product_id' => $productInDatabase[0]->id,
                'created_at' => now()->format('Y-m-d H:i:s'),
                'updated_at' => now()->format('Y-m-d H:i:s'),
            ]
        );
    }

    public function testDestroy()
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

        $productInDatabase = DB::select('select id from products where name = ?', [$product->getName()]);

        DB::table('stock')->insert([
            'product_id' => $productInDatabase[0]->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $response = $this->delete('/api/v1/stock/' . $productInDatabase[0]->id);

        $response->assertStatus(204);
        $response->assertNoContent();
    }
}
