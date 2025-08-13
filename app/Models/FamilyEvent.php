<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamilyEvent extends Model
{
    protected $fillable = [
        'title', 'description', 'date', 'location', 'type', 'family_member_id'
    ];

    protected $dates = ['date'];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }
}