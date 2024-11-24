<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['news_id','user_id','content','attachment'];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
