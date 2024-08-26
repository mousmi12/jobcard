<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMapping extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'id';


    protected $fillable = ['userid', 'group'];
}
