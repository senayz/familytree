@extends('layouts.app')

@section('title', 'Family Members')

@section('content')
<div class="page-header">
    <h1>Family Members</h1>
    <a href="{{ route('family-members.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Member
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Birth Date</th>
                        <th>Gender</th>
                        <th>Connections</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden border border-gray-100">
                                    <img class="w-full h-full object-cover" src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/40x40' }}" alt="{{ $member->first_name }}">
                                </div>
                                <div>
                                    <div class="font-semibold text-sm">{{ $member->first_name }} {{ $member->last_name }}</div>
                                    <div class="text-xs text-muted">{{ ucfirst($member->gender) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="text-sm font-medium">{{ $member->birth_date?->format('F j, Y') ?? 'Not specified' }}</span>
                        </td>
                        <td>
                            @php
                                $badgeClass = match($member->gender) {
                                    'male' => 'badge-blue',
                                    'female' => 'badge-red',
                                    default => 'badge-gray'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ ucfirst($member->gender) }}
                            </span>
                        </td>
                        <td>
                            <div class="flex flex-wrap gap-1">
                                @if($member->parents->count())
                                    <span class="badge badge-purple">Parents: {{ $member->parents->count() }}</span>
                                @endif
                                @if($member->children->count())
                                    <span class="badge badge-green">Children: {{ $member->children->count() }}</span>
                                @endif
                                @if($member->spouses->isNotEmpty())
                                    <span class="badge badge-orange">Married</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('family-members.show', $member) }}" class="btn btn-outline btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('family-members.edit', $member) }}" class="btn btn-outline btn-sm text-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('family-members.destroy', $member) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-sm text-danger" onclick="return confirm('Are you sure you want to delete this member?')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty">
                            <i class="fas fa-users-slash text-4xl mb-4 block opacity-20"></i>
                            <p>No family members found yet.</p>
                            <a href="{{ route('family-members.create') }}" class="text-primary hover:underline mt-2 inline-block">Add your first family member</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Table styles from Parking layout that weren't in app.css */
    .table-responsive{width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}
    table{width:100%;border-collapse:collapse;font-size:.875rem;min-width:600px}
    th{background:#F8FAFC;padding:12px 16px;text-align:left;font-weight:600;color:var(--muted);font-size:.7rem;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid var(--border)}
    td{padding:14px 16px;border-bottom:1px solid #F1F5F9;color:var(--text);vertical-align:middle}
    tr:last-child td{border-bottom:none}
    tr:hover td{background:#FAFAFA}
    
    .badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:50px;font-size:.7rem;font-weight:600}
    .badge-green{background:#D1FAE5;color:#065F46}
    .badge-red{background:#FEE2E2;color:#991B1B}
    .badge-blue{background:#DBEAFE;color:#1E40AF}
    .badge-gray{background:#F1F5F9;color:#475569}
    .badge-purple{background:#EDE9FE;color:#5B21B6}
    .badge-orange{background:#FFEDD5;color:#9A3412}
    
    .page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:10px}
    .page-header h1{font-size:1.4rem;font-weight:700}
    .empty{text-align:center;padding:60px !important;color:var(--muted)}
    
    .btn-outline{background:transparent;color:var(--text);border:1px solid var(--border)} .btn-outline:hover{background:#F8FAFC}
</style>
@endpush