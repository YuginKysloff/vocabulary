<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hash extends Model
{
    protected $table = 'hashes';
    public $timestamps = false;
    protected $fillable = ['user_id', 'string', 'algorithm', 'hash'];
}
