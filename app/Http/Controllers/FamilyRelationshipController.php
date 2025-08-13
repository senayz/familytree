<?php

// app/Http/Controllers/FamilyRelationshipController.php

namespace App\Http\Controllers;

use App\Models\FamilyRelationship;
use Illuminate\Http\Request;

class FamilyRelationshipController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'member1_id' => 'required|exists:family_members,id',
            'member2_id' => 'required|exists:family_members,id|different:member1_id',
            'relationship_type' => 'required|in:parent,child,spouse,sibling'
        ]);

        // Check if relationship already exists
        $existing = FamilyRelationship::where('member1_id', $validated['member1_id'])
            ->where('member2_id', $validated['member2_id'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'This relationship already exists.');
        }

        // Create the relationship
        $relationship = FamilyRelationship::create($validated);

        // Create reciprocal relationship
        $reciprocalType = $this->getReciprocalRelationshipType($validated['relationship_type']);
        if ($reciprocalType) {
            FamilyRelationship::create([
                'member1_id' => $validated['member2_id'],
                'member2_id' => $validated['member1_id'],
                'relationship_type' => $reciprocalType
            ]);
        }

        return back()->with('success', 'Relationship added successfully!');
    }

    public function destroy(FamilyRelationship $familyRelationship)
    {
        // Find and delete reciprocal relationship
        $reciprocalType = $this->getReciprocalRelationshipType($familyRelationship->relationship_type);
        if ($reciprocalType) {
            FamilyRelationship::where('member1_id', $familyRelationship->member2_id)
                ->where('member2_id', $familyRelationship->member1_id)
                ->where('relationship_type', $reciprocalType)
                ->delete();
        }

        $familyRelationship->delete();

        return back()->with('success', 'Relationship removed successfully!');
    }

    private function getReciprocalRelationshipType($type)
    {
        $map = [
            'parent' => 'child',
            'child' => 'parent',
            'spouse' => 'spouse',
            'sibling' => 'sibling'
        ];

        return $map[$type] ?? null;
    }
}