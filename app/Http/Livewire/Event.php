<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event as EventModel;
use App\Http\Livewire\Traits\WithModal;
use App\Http\Livewire\Traits\WithMyEvents;
use App\Http\Livewire\Traits\WithImageFile;
use App\Http\Livewire\Traits\WithNotification;

class Event extends Component
{
    use WithModal, WithImageFile, WithFileUploads, WithNotification, WithMyEvents;

    public $events;
    public EventModel $currentEvent;

    protected $listeners = ['deleteEvent'];

    protected $rules = [
        'currentEvent.name' => 'required|max:255',
        'currentEvent.start_date' => 'nullable|date',
        'currentEvent.end_date' => 'nullable|date',
        'imageFile' => 'nullable|image|max:1024',
    ];

    public function mount()
    {
        $this->events = EventModel::get();
        $this->currentEvent = new EventModel();
    }

    public function loadEvent(EventModel $event, $toEdit = false)
    {
        if ($this->currentEvent->isNot($event)) {
            $this->currentEvent = $event;
            $this->reset('imageFile');
        }

        if (!$toEdit) {
            $this->verifyUserEvent();
        }

        $this->openModal(addOrEditObject: $toEdit);
    }

    public function create()
    {
        if ($this->currentEvent->getKey()) {
            $this->currentEvent = new EventModel();
        }

        $this->openModal(addOrEditObject: true);
    }

    public function save()
    {
        $this->validate();

        if ($this->imageFile) {
            $this->deleteFile('event', $this->currentEvent->image); // if there is an old image
            $this->currentEvent->image = $this->imageFile->store('/', 'event');
        }

        $this->currentEvent->save();

        $this->mount();
        $this->reset(['imageFile', 'openModal']);
        $this->notify('Event saved successfully!');
    }

    public function deleteEvent(EventModel $event)
    {
        $this->deleteFile('event', $event->image);
        $event->delete();
        $this->mount();
        $this->notify('Event has been deleted.', 'deleteMessage');
    }

    public function render()
    {
        return view('livewire.event');
    }
}
