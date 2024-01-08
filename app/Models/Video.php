<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';
    protected $fillable = ['video_url', 'hls_url'];

    // Assume you have 'video_url' and 'hls_url' columns in your 'videos' table.
    // If you are storing file paths, you might want to change the type to 'string'.
    protected $casts = [
        'video_url' => 'string',
        'hls_url' => 'string',
    ];
}