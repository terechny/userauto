<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_auto extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'auto_id'];

}
