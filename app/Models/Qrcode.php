<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'name',
        'longitude',
        'latitude',
        'image',
    ];

    /**
     * The organization that owns this qrcode.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
