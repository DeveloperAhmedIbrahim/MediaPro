<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\videos;

class Channel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'schedule_duration',
        'user_id',
        'videos',
        'time',
        'ChanelType',
         'anywhere',
         'choose_domain',
        'adtagurl',
        'controllogo',
        'logo',
        'positionleft',
        'positionright',
        ];
        // public function videos()
        // {
        //     return $this->belongsTo(videos::class,'videos');
        // }
}
