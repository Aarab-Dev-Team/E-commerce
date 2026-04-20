<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'country',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'type',
        'is_default',
    ];

protected $casts = [
    'is_default' => 'boolean',
];

public function user()
{
    return $this->belongsTo(User::class);
}
}
