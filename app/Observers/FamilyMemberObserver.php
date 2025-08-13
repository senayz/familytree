<?php

namespace App\Observers;

use App\Models\FamilyMember;
use App\Models\ActivityLog;

class FamilyMemberObserver
{
    public function created(FamilyMember $familyMember)
    {
        ActivityLog::create([
            'type' => 'member_added',
            'description' => "{$familyMember->full_name} was added to the family tree",
            'subject_id' => $familyMember->id,
            'subject_type' => get_class($familyMember),
            'user_id' => auth()->id() ?? null,
            'metadata' => $familyMember->toArray()
        ]);
    }

    public function updated(FamilyMember $familyMember)
    {
        ActivityLog::create([
            'type' => 'member_updated',
            'description' => "{$familyMember->full_name}'s details were updated",
            'subject_id' => $familyMember->id,
            'subject_type' => get_class($familyMember),
            'user_id' => auth()->id(),
            'metadata' => [
                'old' => $familyMember->getOriginal(),
                'new' => $familyMember->getChanges()
            ]
        ]);
    }

    public function deleted(FamilyMember $familyMember)
    {
        ActivityLog::create([
            'type' => 'member_removed',
            'description' => "{$familyMember->full_name} was removed from the family tree",
            'subject_id' => $familyMember->id,
            'subject_type' => get_class($familyMember),
            'user_id' => auth()->id(),
            'metadata' => $familyMember->toArray()
        ]);
    }
}