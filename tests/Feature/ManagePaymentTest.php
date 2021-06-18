<?php

namespace Tests\Feature;

use Tests\CreatesUser;
use Tests\TestCase;

class ManagePaymentTest extends TestCase
{
    use CreatesUser;
    
    public function test_a_user_can_subscribe_to_a_paid_plan()
    {

        $this->actingAs($this->premium_user)
        ->post('subscribe', [
            'payment_method' => 'pm_card_visa',
            'plan' => 'price_1IkRFRLZUh8627nbly70s6t3',
        ])
        ->assertSessionDoesntHaveErrors()
        ->assertStatus(200);
    }

    public function test_a_user_can_unsubscribe_to_a_paid_plan()
    {
        $this->actingAs($this->premium_user)->post('unsubscribe')
        ->assertSessionDoesntHaveErrors()
        ->assertStatus(302);
    }
}
