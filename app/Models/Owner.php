<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Car> $cars
 * @property-read int|null $cars_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Owner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'surname'];

    public function cars()
    {
        return $this->hasMany(Car::class, 'owner_id');
    }
}