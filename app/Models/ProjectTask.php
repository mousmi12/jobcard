<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;
    protected $table = 'projecttask';
    protected $primaryKey = 'id';


    protected $fillable = ['projectid', 'taskid'];
}
