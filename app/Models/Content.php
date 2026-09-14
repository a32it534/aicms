<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'summary',
        'body',
        'keywords',
        'prompt',
        'model',
        'image_path',
        'status',
    ];

    protected static function booted(): void
    {
        static::saving(function (Content $content) {
            if (blank($content->slug)) {
                $base = Str::slug($content->title, '-', null) ?: 'content';
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '!=', $content->id)->exists()) {
                    $slug = $base . '-' . (++$i);
                }
                $content->slug = $slug;
            }
        });
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image_path ? Storage::disk('public')->url($this->image_path) : null,
        );
    }


    protected function jalaliCreatedAt(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at 
                ? Jalalian::fromCarbon($this->created_at)->format('Y/m/d H:i') 
                : '—',
        );
    }

    protected function jalaliAgo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at 
                ? Jalalian::fromCarbon($this->created_at)->ago() 
                : '—',
        );
    }
}
