<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'type',
        'description',
        'subject_id',
        'subject_type',
        'user_id',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function subject()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIconAttribute()
    {
        return match($this->type) {
            'member_added' => 'user-plus',
            'relationship_added' => 'users',
            'event_created' => 'calendar',
            'photo_uploaded' => 'camera',
            'member_updated' => 'user-edit',
            default => 'bell'
        };
    }

    public function getColorAttribute()
    {
        return match($this->type) {
            'member_added' => 'blue',
            'relationship_added' => 'green',
            'event_created' => 'purple',
            'photo_uploaded' => 'yellow',
            'member_updated' => 'indigo',
            default => 'gray'
        };
    }
    public function scopeForMember($query, $memberId)
{
    return $query->where('subject_type', FamilyMember::class)
                ->where('subject_id', $memberId);
}

public function scopeRecent($query, $days = 7)
{
    return $query->where('created_at', '>=', now()->subDays($days));
}
}