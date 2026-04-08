<?php
// app/Http/Controllers/FamilyMemberController.php

namespace App\Http\Controllers;

use App\Models\FamilyMember;
use App\Models\FamilyRelationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FamilyMemberController extends Controller
{
    public function index()
    {
        return view('members.index', [
            'members' => FamilyMember::latest()->paginate(12)
        ]);
    }

    public function create()
    {
        return view('members.create', [
            'familyMembers' => FamilyMember::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'death_date' => 'nullable|date|after:birth_date',
            'death_place' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female,other',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
            'relation_type' => 'nullable|in:parent,child,spouse,sibling',
            'related_to' => 'nullable|exists:family_members,id'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('family-photos', 'public');
            $validated['photo_path'] = $path;
        }

        $member = FamilyMember::create($validated);

        if ($request->relation_type && $request->related_to) {
            FamilyRelationship::create([
                'member1_id' => $request->related_to,
                'member2_id' => $member->id,
                'relationship_type' => $request->relation_type
            ]);

            // Create reciprocal relationship
            $reciprocalType = $this->getReciprocalRelationshipType($request->relation_type);
            if ($reciprocalType) {
                FamilyRelationship::create([
                    'member1_id' => $member->id,
                    'member2_id' => $request->related_to,
                    'relationship_type' => $reciprocalType
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Family member added successfully!');
    }

    public function show(FamilyMember $familyMember)
    {
        
        return view('members.show', [
            'member' => $familyMember->load(['parents', 'children', 'spouses', 'siblings'])
        ]);
    }

    public function edit(FamilyMember $familyMember)
    {
        return view('members.edit', [
            'member' => $familyMember,
            'familyMembers' => FamilyMember::where('id', '!=', $familyMember->id)->get()
        ]);
    }

    public function update(Request $request, FamilyMember $familyMember)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'death_date' => 'nullable|date|after:birth_date',
            'death_place' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female,other',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string'
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($familyMember->photo_path) {
                Storage::disk('public')->delete($familyMember->photo_path);
            }
            
            $path = $request->file('photo')->store('family-photos', 'public');
            $validated['photo_path'] = $path;
        }

        $familyMember->update($validated);

        return redirect()->route('family-members.show', $familyMember)->with('success', 'Family member updated successfully!');
    }

    public function destroy(FamilyMember $familyMember)
    {
        if ($familyMember->photo_path) {
            Storage::disk('public')->delete($familyMember->photo_path);
        }
        
        $familyMember->delete();
        return redirect()->route('dashboard')->with('success', 'Family member deleted successfully!');
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
    public function search(Request $request)
    {
        $query = $request->input('q');
        $gender = $request->input('gender');
        
        $members = FamilyMember::query()
            ->when($query, function($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                  ->orWhere('last_name', 'like', "%{$query}%");
            })
            ->when($gender, function($q) use ($gender) {
                $q->where('gender', $gender);
            })
            ->latest()
            ->paginate(12);

        return view('members.index', compact('members'));
    }

    public function getMaleFounders()
{
    $maleFounders = FamilyMember::where('gender', 'male')
                    ->whereDoesntHave('parents')
                    ->with(['spouses', 'children'])
                    ->get();
    
    return view('family-tree', ['members' => $maleFounders]);
}
}