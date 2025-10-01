<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Str;


class Contact extends Model
{

use HasUuids;
     public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'message',
        "status",
    ];

}
