<?php

namespace App\Observers;

use App\Models\Relationship;
use App\Models\ActivityLog;
use App\Models\FamilyMember;

class RelationshipObserver
{
    public function created(Relationship $relationship)
    {
        $person1 = FamilyMember::find($relationship->person1_id);
        $person2 = FamilyMember::find($relationship->person2_id);

        ActivityLog::create([
            'type' => 'relationship_added',
            'description' => "{$person1->full_name} was linked as {$relationship->type} of {$person2->full_name}",
            'subject_id' => $relationship->id,
            'subject_type' => get_class($relationship),
            'user_id' => auth()->id(),
            'metadata' => $relationship->toArray()
        ]);
    }

    public function deleted(Relationship $relationship)
    {
        ActivityLog::create([
            'type' => 'relationship_removed',
            'description' => "A family relationship was removed",
            'subject_id' => $relationship->id,
            'subject_type' => get_class($relationship),
            'user_id' => auth()->id(),
            'metadata' => $relationship->toArray()
        ]);
    }
}