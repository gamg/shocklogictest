<?php

namespace App\Http\Livewire\Traits;

trait WithModal
{
    public bool $openModal = false;
    public bool $addOrEditObject = false;

    public function openModal($addOrEditObject = false): void
    {
        $this->addOrEditObject = $addOrEditObject;
        $this->openModal = true;
    }
}
