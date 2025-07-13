<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staf extends Model
{
    use SoftDeletes;

    protected $table = 'stafs';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
