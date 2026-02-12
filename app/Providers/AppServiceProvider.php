<?php

namespace App\Providers;

use App\Models\Note;
use App\Models\mouvement;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrap();

        //to open and close the mouvement period
        $period_mouv = DB::table('mv_megrations')->value('PERIOD_MOUV');
        View::share('period_mouv', $period_mouv);

        //to show the number of out mouvement in the navbar in admin dashboard 
        $outMouvcountTotal = mouvement::with("employee")
            //status ==0 to ignort the validat mouvement (statut =1)
            ->where("STATUS", "0")
            ->count();
        View::share('outMouvcountTotal', $outMouvcountTotal);

        //to show the Notes
      // $notes = Note::latest()->get();
       $notes = Note::orderBy('created_at', 'asc')->get();
        View::share('notes', $notes);
        


    }
}
