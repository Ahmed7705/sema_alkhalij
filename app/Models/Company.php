<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cr_number',
        'phone',
        'email',
        'city',
        'address',
        'status',
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
