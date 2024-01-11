<?php

namespace App\Models;

use App\Models\Attribute_value;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function values()
    {
        return $this->hasMany(Attribute_value::class);
    }
}
