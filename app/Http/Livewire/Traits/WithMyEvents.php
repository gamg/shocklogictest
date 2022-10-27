<?php

namespace App\Http\Livewire\Traits;

use App\Models\Event as EventModel;

trait WithMyEvents
{
    public bool $myEvents = false;
    public bool $hasThisEvent = false;

    public function showMyEvents()
    {
        $this->myEvents = !$this->myEvents;

        $this->events = $this->myEvents ? auth()->user()->events()->get() : EventModel::get();
    }

    public function subscribe()
    {
        auth()->user()->events()->toggle([$this->currentEvent->id]);
        $this->notify('Subscription saved successfully!');
    }

    public function verifyUserEvent()
    {
        $myEvent = auth()->user()->events->where('id', $this->currentEvent->id)->first();

        $this->hasThisEvent = is_null($myEvent) ? false : true;
    }
}
