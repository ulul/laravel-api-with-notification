<?php

namespace App\Models;

use App\Notifications\PaymentNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Payment extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'is_active',
    ];

    /**
     * Send notification payment is active or deactive
     *
     * @return void
     */
    public function sendNotification()
    {
        $this->notify(PaymentNotification::class);
    }
}
