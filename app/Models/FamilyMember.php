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

}