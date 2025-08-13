<?php

namespace App\Observers;

use App\Models\FamilyEvent;
use App\Models\ActivityLog;

class FamilyEventObserver
{
    public function created(FamilyEvent $event)
    {
        $description = "New {$event->type} event: {$event->title}";
        if ($event->familyMember) {
            $description .= " for {$event->familyMember->full_name}";
        }

        ActivityLog::create([
            'type' => 'event_created',
            'description' => $description,
            'subject_id' => $event->id,
            'subject_type' => get_class($event),
            'user_id' => auth()->id(),
            'metadata' => $event->toArray()
        ]);
    }

    public function updated(FamilyEvent $event)
    {
        ActivityLog::create([
            'type' => 'event_updated',
            'description' => "{$event->title} event was updated",
            'subject_id' => $event->id,
            'subject_type' => get_class($event),
            'user_id' => auth()->id(),
            'metadata' => [
                'old' => $event->getOriginal(),
                'new' => $event->getChanges()
            ]
        ]);
    }

    public function deleted(FamilyEvent $event)
    {
        ActivityLog::create([
            'type' => 'event_deleted',
            'description' => "{$event->title} event was removed",
            'subject_id' => $event->id,
            'subject_type' => get_class($event),
            'user_id' => auth()->id(),
            'metadata' => $event->toArray()
        ]);
    }
}