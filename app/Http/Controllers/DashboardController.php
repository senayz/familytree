<?php
namespace App\Http\Controllers;

use App\Models\FamilyMember;
use App\Models\FamilyEvent;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = FamilyMember::count();
      
      
             $upcomingBirthdays = FamilyMember::whereMonth('birth_date', '>=', now()->month)
            ->whereDay('birth_date', '>=', now()->day)
            ->orderByRaw("MONTH(birth_date), DAY(birth_date)")
            ->take(5)
            ->get();
            $upcomingBirthdaysCount = $upcomingBirthdays->count();

        $upcomingEvents = FamilyEvent::where('date', '>=', now())
            ->orderBy('date')
            ->take(5)
            ->get();
        
        $locationsCount = FamilyMember::whereNotNull('birth_place')->distinct('birth_place')->count() 
                        + FamilyMember::whereNotNull('death_place')->distinct('death_place')->count();
        $eventsCount = FamilyEvent::count();
        
        $recentActivity = \App\Models\ActivityLog::with(['subject', 'user'])
            ->latest()
            ->take(5)
            ->get();

        $members = FamilyMember::with(['parents', 'children', 'spouses', 'siblings'])->get();
$memberCount = FamilyMember::count();
        $focusId = request('focus');
        $depth = request('depth', 3);
        
        $query = FamilyMember::query();
        
        if ($focusId) {
            $query->where('id', $focusId);
        } else {
            $query->where('gender', 'male')->whereDoesntHave('parents');
        }

        $founders = $query->with(['children' => function($query) use ($depth) {
            if ($depth > 1) {
                $query->with(['children' => function($query) use ($depth) {
                    if ($depth > 2) {
                        $query->with('children');
                    }
                }]);
            }
        }])->get();

        $genderDist = [
            'male' => FamilyMember::where('gender', 'male')->count(),
            'female' => FamilyMember::where('gender', 'female')->count(),
            'other' => FamilyMember::where('gender', 'other')->count(),
        ];



        return view('dashboard', compact(
            'totalMembers',
            'memberCount',
            'upcomingBirthdays',
            'upcomingBirthdaysCount',
            'upcomingEvents',
            'recentActivity',
            'members',
            'locationsCount',
            'eventsCount',
            'founders',
            'genderDist'
        ));
    }

    protected function getUpcomingBirthdays()
{
    return FamilyMember::whereMonth('birth_date', '>=', now()->month)
        ->whereDay('birth_date', '>=', now()->day)
        ->orderByRaw("MONTH(birth_date), DAY(birth_date)")
        ->take(5)
        ->get();
}
}