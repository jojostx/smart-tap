<?php

namespace App\Models;

use App\Models\Traits\Geographical;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory, Geographical;

    /**
     * The attributes that are mass assignable.
     *
     * @var array <int, string>
     */
    protected $fillable = [
        'model',
        'plate_number',
        'color',
        'longitude',
        'latitude',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * The owners of this car.
     *
     */
    public function owners()
    {
        return $this->belongsToMany(Owner::class);
    }

    /**
     * The current client this car is parked at.
     *
     */
    public function client()
    {
        return $this->belongsToMany(Client::class);
    }
}
