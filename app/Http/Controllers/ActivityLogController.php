<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = ActivityLog::latest()
            ->with(['user', 'subject'])
            ->paginate(20);

        return view('activity.index', compact('activities'));
    }

    public function show(ActivityLog $activity)
    {
        return view('activity.show', compact('activity'));
    }
}