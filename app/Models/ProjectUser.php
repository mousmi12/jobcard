<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    use HasFactory;
    protected $table = 'projectuser';
    protected $primaryKey = 'id';


    protected $fillable = ['projectid', 'userid'];
}
