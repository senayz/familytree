<!-- resources/views/members/index.blade.php -->

@extends('layouts.app')

@section('title', 'Family Members')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Family Members</h1>
        <a href="{{ route('family-members.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            <i class="fas fa-plus mr-2"></i> Add Member
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Birth Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Relationships</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/40x40' }}" alt="{{ $member->first_name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $member->gender }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $member->birth_date?->format('M d, Y') ?? 'Unknown' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $member->gender === 'male' ? 'bg-blue-100 text-blue-800' : ($member->gender === 'female' ? 'bg-pink-100 text-pink-800' : 'bg-purple-100 text-purple-800') }}">
                                {{ ucfirst($member->gender) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
    @if($member->parents->count())
        <span class="text-xs bg-gray-100 px-2 py-1 rounded">Parents: {{ $member->parents->count() }}</span>
    @endif
    @if($member->children->count())
        <span class="text-xs bg-gray-100 px-2 py-1 rounded ml-1">Children: {{ $member->children->count() }}</span>
    @endif
    @if($member->spouses->isNotEmpty())
        <span class="text-xs bg-gray-100 px-2 py-1 rounded ml-1">Spouse</span>
    @endif
</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('family-members.show', $member) }}" class="text-indigo-600 hover:text-indigo-900 mr-3"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('family-members.edit', $member) }}" class="text-yellow-600 hover:text-yellow-900 mr-3"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('family-members.destroy', $member) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this member?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No family members found. <a href="{{ route('family-members.create') }}" class="text-indigo-600 hover:underline">Add your first family member</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection