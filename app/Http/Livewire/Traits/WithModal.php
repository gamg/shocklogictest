<?php

namespace App\Http\Livewire\Traits;

trait WithModal
{
    public bool $openModal = false;
    public bool $addOrEditEvent = false;

    public function openModal($addOrEditEvent = false): void
    {
        $this->addOrEditEvent = $addOrEditEvent;
        $this->openModal = true;
    }
}
