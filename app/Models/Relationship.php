<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    protected $fillable = ['person1_id', 'person2_id', 'type'];

    public function person1()
    {
        return $this->belongsTo(FamilyMember::class, 'person1_id');
    }

    public function person2()
    {
        return $this->belongsTo(FamilyMember::class, 'person2_id');
    }
}