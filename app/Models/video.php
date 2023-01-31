<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Channel;

class video extends Model
{
    use HasFactory;
    protected $fillable = [
        'image_url',
        'add_watermark',
        'name',
        'user_id',
        'tag',
        'responsive',
        'fixed',
        'autoplay',
        'volume',
        'showcontrols',
        'show_content_title',
        'show_share_buttons',
        'code',
    ];
}
