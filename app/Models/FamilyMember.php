<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'death_date',
        'gender',
        'photo_path',
        'bio'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    // app/Models/FamilyMember.php

public function relationships()
{
    return $this->hasMany(FamilyRelationship::class, 'member1_id');
}

public function relatives()
{
    return $this->belongsToMany(FamilyMember::class, 'family_relationships', 'member1_id', 'member2_id')
        ->withPivot('relationship_type');
}

public function parents()
{
    return $this->belongsToMany(FamilyMember::class, 'family_relationships', 'member1_id', 'member2_id')
        ->wherePivot('relationship_type', 'parent')
        ->withTimestamps();
}

public function children()
{
    return $this->belongsToMany(FamilyMember::class, 'family_relationships', 'member1_id', 'member2_id')
        ->wherePivot('relationship_type', 'child')
        ->withTimestamps();
}


public function spouses()
{
    return $this->belongsToMany(FamilyMember::class, 'family_relationships', 'member1_id', 'member2_id')
        ->wherePivot('relationship_type', 'spouse')
        ->withTimestamps();
}

// Singular relationship for first spouse (returns relationship instance)
public function spouse()
{
    return $this->spouses()->limit(1);
}

// Helper method to get the actual spouse model (for use in views)
public function getSpouseAttribute()
{
    return $this->spouses->first();
}


public function siblings()
{
    return $this->belongsToMany(FamilyMember::class, 'family_relationships', 'member1_id', 'member2_id')
        ->wherePivot('relationship_type', 'sibling')
        ->withTimestamps();
}

// Accessor to dynamically resolve all siblings (explicit, implicit via parents, and transitive)
public function getAllSiblingsAttribute()
{
    // 1. Explicitly linked siblings
    $explicit = $this->siblings()->get();
    
    // 2. Implicit siblings (those who share parents)
    $parentIds = $this->parents->pluck('id')->toArray();
    $implicitViaParents = collect();
    
    if (!empty($parentIds)) {
        // Query the relationships table directly to avoid Eloquent alias/whereHas complexities
        $siblingIdsViaParents = \Illuminate\Support\Facades\DB::table('family_relationships')
            ->whereIn('member2_id', $parentIds)
            ->where('relationship_type', 'parent')
            ->where('member1_id', '!=', $this->id)
            ->pluck('member1_id')
            ->toArray();
            
        if (!empty($siblingIdsViaParents)) {
            $implicitViaParents = self::whereIn('id', $siblingIdsViaParents)->get();
        }
    }
    
    // 3. Transitive siblings (siblings of my explicit siblings)
    $siblingIds = $explicit->pluck('id')->toArray();
    $transitiveSiblings = collect();
    
    if (!empty($siblingIds)) {
        $transitiveSiblingIds = \Illuminate\Support\Facades\DB::table('family_relationships')
            ->whereIn('member2_id', $siblingIds)
            ->where('relationship_type', 'sibling')
            ->where('member1_id', '!=', $this->id)
            ->pluck('member1_id')
            ->toArray();
            
        if (!empty($transitiveSiblingIds)) {
            $transitiveSiblings = self::whereIn('id', $transitiveSiblingIds)->get();
        }
    }
    
    // Merge all, remove current member if accidentally included, and return unique
    return $explicit->merge($implicitViaParents)->merge($transitiveSiblings)
        ->where('id', '!=', $this->id)
        ->unique('id')
        ->values();
}

// Accessor to dynamically resolve all parents (including spouses of explicitly linked parents)
public function getAllParentsAttribute()
{
    $explicitParents = $this->parents()->get();
    
    $parentSpouses = collect();
    foreach ($explicitParents as $parent) {
        $parentSpouses = $parentSpouses->merge($parent->spouses);
    }
    
    return $explicitParents->merge($parentSpouses)
        ->where('id', '!=', $this->id)
        ->unique('id')
        ->values();
}

// Accessor to dynamically resolve all children (including children of spouses)
public function getAllChildrenAttribute()
{
    $explicitChildren = $this->children()->get();
    
    $spouseChildren = collect();
    foreach ($this->spouses()->get() as $spouse) {
        $spouseChildren = $spouseChildren->merge($spouse->children);
    }
    
    return $explicitChildren->merge($spouseChildren)
        ->where('id', '!=', $this->id)
        ->unique('id')
        ->values();
}

}