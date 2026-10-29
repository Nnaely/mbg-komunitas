<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'address',
    ];
}
