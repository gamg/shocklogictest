<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\Traits\WithModal;
use App\Http\Livewire\Traits\WithNotification;
use App\Http\Livewire\Traits\WithParticipantEvents;

class Participant extends Component
{
    use WithModal, WithNotification, WithParticipantEvents, WithPagination;

    public string $search = '';
    public User $currentParticipant;

    protected $listeners = ['deleteParticipant'];

    protected function rules()
    {
        return [
            'currentParticipant.name' => 'required|string|max:255',
            'currentParticipant.family_name' => 'required|string|max:255',
            'currentParticipant.date_of_birth' => 'nullable|date',
            'currentParticipant.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->currentParticipant->id],
            'currentParticipant.active' => 'boolean',
            'participantEvents' => 'exists:events,id'
        ];
    }

    public function mount()
    {
        $this->currentParticipant = new User();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function loadParticipant(User $participant, $toEdit = false)
    {
        if ($this->currentParticipant->isNot($participant)) {
            $this->currentParticipant = $participant;
        }

        if ($toEdit) {
            $this->loadParticipantEvents();
        }

        $this->openModal(addOrEditObject: $toEdit);
    }

    public function save()
    {
        $this->validate();

        $this->currentParticipant->save();

        $this->currentParticipant->events()->sync($this->participantEvents);

        $this->reset('openModal');
        $this->notify('Participant saved successfully!');
    }

    public function deleteParticipant(User $participant)
    {
        $participant->delete();
        $this->notify('Participant has been deleted.', 'deleteMessage');
    }

    public function render()
    {
        $participants = User::where('role', false)
            ->where(fn ($query) =>
                $query->where('name', 'like', "%$this->search%")
                      ->orWhere('family_name', 'like', "%$this->search%")
            )->paginate(10);

        return view('livewire.participant', ['participants' => $participants]);
    }
}
