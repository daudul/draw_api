<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public static function boot() {
        parent::boot();
        static::creating(function($post) {
            $post->created_by = auth()->user()->id;
        });

        static::updating(function($post) {
            $post->updated_by = auth()->user()->id;
        });
    }
}
