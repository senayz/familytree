<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyMemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date|after_or_equal:birth_date',
            'gender' => 'required|in:male,female,other',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'role' => 'nullable|string|max:255',
        ];
    }
}