<?php

namespace App\Models;

use App\Models\CarPhoto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'reg_number',
        'brand',
        'model',
        'owner_id'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function photos()
    {
        return $this->hasMany(CarPhoto::class, 'car_id');
    }
}