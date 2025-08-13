<?php
use App\Models\FamilyMember;
use App\Models\Relationship;

Route::get('/family-tree', function () {
    $members = FamilyMember::all();
    $relationships = Relationship::all();

    $nodes = $members->map(function ($member) {
        return [
            'id' => $member->id,
            'label' => $member->full_name,
            'title' => $member->birth_date 
                ? "Born: " . $member->birth_date->format('Y-m-d') . "\nAge: " . $member->age
                : "No birth date",
            'group' => $member->gender,
            'shape' => 'box'
        ];
    });

    $edges = $relationships->map(function ($rel) {
        return [
            'from' => $rel->person1_id,
            'to' => $rel->person2_id,
            'label' => $rel->type,
            'arrows' => 'to'
        ];
    });

    return response()->json([
        'nodes' => $nodes,
        'edges' => $edges
    ]);
});