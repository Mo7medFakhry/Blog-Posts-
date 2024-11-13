<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];
    public function user()
    {
        return $this->BelongsTo(User::class);
    }
    public function postCreator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
