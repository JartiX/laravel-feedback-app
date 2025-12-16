<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function feedbacks(): BelongsToMany
    {
        return $this->belongsToMany(Feedback::class)->withTimestamps();
    }

    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', "%{$term}%");
    }

    public function scopeWithFeedbackCount($query)
    {
        return $query->withCount('feedbacks');
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount('feedbacks')
                    ->orderBy('feedbacks_count', 'desc')
                    ->limit($limit);
    }
}