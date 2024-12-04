<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Announcement extends Model
{
    use InteractsWithMedia; 
    
    protected $fillable = [
        'header',
        'description'
    ];
}
