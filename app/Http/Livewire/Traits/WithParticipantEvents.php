<?php

namespace App\Http\Livewire\Traits;

use App\Models\Event;

trait WithParticipantEvents
{
    public $allEvents;
    public array $participantEvents = [];

    public function loadParticipantEvents()
    {
        $this->reset('participantEvents');

        $this->allEvents = Event::select('id', 'name')->get();

        foreach ($this->currentParticipant->events as $event) {
            $this->participantEvents[] = $event->id;
        }
    }
}
