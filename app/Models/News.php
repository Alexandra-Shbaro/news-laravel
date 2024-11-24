<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable =['title','content','restricted_age','attachment'];

    public function articles(){
        return $this->hasMany(Article::class);
    }

    public function isAccessibleForAge($age){
        return $age->$this->restricted_age;
    }
}
