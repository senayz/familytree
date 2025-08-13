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
$locationsCount = 12; // Hardcoded for now
            $eventsCount =8;// Hardcoded for now
        $recentActivity = $this->getRecentActivity();
      $members = FamilyMember::with(['parents', 'children', 'spouses', 'siblings'])->get();
$memberCount = FamilyMember::count();
 $founders =FamilyMember::where('gender', 'male')->whereDoesntHave('parents')
                ->with(['children' => function($query) {
                    $query->with(['children' => function($query) {
                        $query->with('children'); // Load 3 generations by default
                    }]);
                }])
                ->get();



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
           
        ));
    }

    protected function getRecentActivity()
    {
        // In a real app, you'd have an activity log model
        // This is simplified for demonstration
        return [
            [
                'type' => 'member_added',
                'message' => 'New member added to the family tree',
                'date' => now()->subHours(2),
                'icon' => 'user-plus',
                'color' => 'blue'
            ],
            [
                'type' => 'birthday',
                'message' => 'Upcoming birthday reminder',
                'date' => now()->subDay(),
                'icon' => 'birthday-cake',
                'color' => 'green'
            ],
            // Add more activities as needed
        ];
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