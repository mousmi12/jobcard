<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'project';
    protected $primaryKey = 'id';


    protected $fillable = ['name', 'user','department','priority','description', 'status','workstatus','document','startdate','enddate'];
}
