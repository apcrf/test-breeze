<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

	protected $primaryKey = 'post_id';
    protected $fillable = ['post_title', 'post_content'];
}
