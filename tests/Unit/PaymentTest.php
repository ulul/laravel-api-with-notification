<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PaymentTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */
    public function visitApi()
    {
        $response = $this->get('/api');

        $response->assertStatus(200);
    }

    /** @test */
    public function visitIndexPayment()
    {
        $response = $this->get('api/payments');

        $response->assertStatus(200);
    }

    /** @test */
    public function storeWithInvalidEmail()
    {
        $response = $this->json('POST', '/api/payments', [
            'name' => 'Ulul', 
            'email' => 'ulul'
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function storeWithBlankName()
    {
        $response = $this->json('POST', '/api/payments', [
            'name' => '', 
            'email' => 'ulul'
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function storeWithValidData()
    {
        $response = $this->json('POST', '/api/payments', [
            'name' => 'ulul',
            'email' => 'ulul@email.test'
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function updateDataWithInvalidId()
    {
        $response = $this->json('PUT', '/api/payments/11', [
            'name' => 'New name',
            'email' => 'new@email.test'
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function updateDataWithValidData()
    {
        $response = $this->json('PUT', '/api/payments/1', [
            'name' => 'New name',
            'email' => 'new@email.test'
        ]);
        
        $response->assertStatus(200);
    }

    /** @test */
    public function deleteDataWithInvalidId()
    {
        $response = $this->json('DELETE', '/api/payments/15');

        $response->assertStatus(404);
    }

    /** @test */
    public function deleteDataWithValidId()
    {
        $response = $this->json('DELETE', '/api/payments/10');

        $response->assertStatus(200);
    }

    /** @test */
    public function invalideMethodInActivate()
    {
        $response = $this->json('PUT', '/api/payments/10/activate');

        $response->assertStatus(405);
    }

    /** @test */
    public function paymentNotFoundMethodInActivate()
    {
        $response = $this->json('PATCH', '/api/payments/12/activate');

        $response->assertStatus(404);
    }

    /** @test */
    public function valideMethodInActivate()
    {
        $response = $this->json('PATCH', '/api/payments/10/activate');

        $response->assertStatus(200);
    }

    /** @test */
    public function invalideMethodInDeactivate()
    {
        $response = $this->json('PUT', '/api/payments/10/deactivate');

        $response->assertStatus(405);
    }

    /** @test */
    public function paymentNotFoundMethodInDeactivate()
    {
        $response = $this->json('PATCH', '/api/payments/12/deactivate');

        $response->assertStatus(404);
    }

    /** @test */
    public function valideMethodInDeactivate()
    {
        $response = $this->json('PATCH', '/api/payments/10/deactivate');

        $response->assertStatus(200);
    }


}
