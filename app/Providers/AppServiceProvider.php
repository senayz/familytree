<?php

namespace App\Providers;

use App\Models\FamilyEvent;
use App\Models\FamilyMember;
use App\Models\Relationship;
use App\Observers\FamilyEventObserver;
use App\Observers\FamilyMemberObserver;
use App\Observers\RelationshipObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('logging.log_activity')) {
        FamilyMember::observe(FamilyMemberObserver::class);
        Relationship::observe(RelationshipObserver::class);
        FamilyEvent::observe(FamilyEventObserver::class);
    }
    }
}
