<?php

namespace App\Http\Livewire\Traits;

trait WithNotification
{
    public function notify($message = '', $event = 'notify')
    {
        $this->dispatchBrowserEvent($event, ['message' => $message]);
    }
}
