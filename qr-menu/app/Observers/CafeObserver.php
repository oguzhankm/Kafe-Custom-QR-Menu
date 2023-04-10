<?php

namespace App\Observers;

use App\Models\Cafe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CafeObserver
{
    /**
     * Handle the Cafe "creating" event.
     *
     * @param \App\Models\Cafe $cafe
     * @return void
     */
    public function creating(Cafe $cafe)
    {
        $cafe->user_id = Auth::id();
        $cafe->slug = Str::slug($cafe->title . '-' . $cafe->user_id);
    }

    /**
     * Handle the Cafe "created" event.
     *
     * @param \App\Models\Cafe $cafe
     * @return void
     */
    public function created(Cafe $cafe)
    {
        //
    }

    /**
     * Handle the Cafe "updated" event.
     *
     * @param \App\Models\Cafe $cafe
     * @return void
     */
    public function updated(Cafe $cafe)
    {
        //
    }

    /**
     * Handle the Cafe "deleted" event.
     *
     * @param \App\Models\Cafe $cafe
     * @return void
     */
    public function deleted(Cafe $cafe)
    {
        //
    }

    /**
     * Handle the Cafe "restored" event.
     *
     * @param \App\Models\Cafe $cafe
     * @return void
     */
    public function restored(Cafe $cafe)
    {
        //
    }

    /**
     * Handle the Cafe "force deleted" event.
     *
     * @param \App\Models\Cafe $cafe
     * @return void
     */
    public function forceDeleted(Cafe $cafe)
    {
        //
    }
}
