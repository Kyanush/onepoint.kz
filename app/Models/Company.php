<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'county',
        'city',
        'info'
	];

}