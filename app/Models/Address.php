<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'city',
        'district',
        'street',
        'building_no',
        'additional_info',
        'lat',
        'lng',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'lat' => 'float',
        'lng' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->city,
            $this->district ? "حي {$this->district}" : null,
            $this->street ? "شارع {$this->street}" : null,
            $this->building_no ? "مبنى {$this->building_no}" : null,
        ]);

        return implode(' - ', $parts);
    }
}
