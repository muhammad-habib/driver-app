<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreateTasksBulkTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);

        $response = $this->json('POST', '/api/tasks-bulk', [
            "awb" => "1",
            "company_id" => 1,
            "tasks" => [
                [
                "complete_after" => "2018-04-15 13:54:37",
                "complete_before" => "2018-04-15 23:54:37",
                "address" => "cairo",
                "lat" => "123",
                "long" => "321",
                "awb" => "1",
                "customer_name" => "test_customer",
                "customer_phone" => "0123",
                "city" => "lol",
                "area" => "lol",
                "total_price"=>100,
                "payment_type_id"=>1,
                "country" => "eg",
                "street_number" => "1",
                "street_name" => "st",
                "lol" => "",
            ],
                [
                    "complete_after" => "2018-04-15 13:54:37",
                    "complete_before" => "2018-04-15 23:54:37",
                    "address" => "cairo",
                    "lat" => "123",
                    "long" => "321",
                    "awb" => "2",
                    "customer_name" => "test_customer",
                    "customer_phone" => "0123",
                    "city" => "lol",
                    "area" => "lol",
                    "country" => "eg",
                    "total_price"=>200,
                    "payment_type_id"=>2,
                        "street_number" => "1",
                    "street_name" => "st",
                ],
            ],
        ]
        );

        $response->assertStatus(200)
                 ->assertJson([
                            "message" => "Bulk created successfully",
                        ]);

    }
}
