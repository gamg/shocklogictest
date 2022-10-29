<div class="align-middle min-w-full overflow-x-auto shadow overflow-hidden sm:rounded-lg">
    <div class="px-6 py-4">
        <x-text-input wire:model="search" class="w-full" type="text" placeholder="Write the name or the family name to search"/>
    </div>

    <table class="min-w-full divide-y divide-gray-200">
        <thead>
        <tr class="bg-gray-100 text-left">
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Family Name</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3">
                <span class="text-left text-xs leading-4 font-medium text-cool-gray-500 uppercase tracking-wider"></span>
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @forelse($participants as $participant)
            <tr>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                    {{ $participant->name }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                    {{ $participant->family_name }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-{{ $participant->status_color }}-100 text-{{ $participant->status_color }}-800 capitalize">
                        {{ $participant->status_text }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5">
                    <div class="flex items-center" x-data>
                        <x-actions.action wire:click.prevent="loadParticipant({{ $participant->id }})" title="{{ __('Show') }}" class="text-gray-800 hover:text-gray-600">
                            <x-icons.show/>
                        </x-actions.action>
                        <x-actions.action wire:click.prevent="loadParticipant({{ $participant->id }}, true)" title="{{ __('Edit') }}" class="text-gray-800 hover:text-gray-600">
                            <x-icons.edit/>
                        </x-actions.action>
                        <x-actions.delete eventName="deleteParticipant" :object="$participant"/>
                    </div>
                </td>
            </tr>
        @empty
            <h3 class="px-6 py-4">{{ __('There are no participants to show!') }}</h3>
        @endforelse
        </tbody>
    </table>
    @if($participants->hasPages())
        <div class="px-6 py-3">{{ $participants->links() }}</div>
    @endif

    <!-- Modal -->
    <x-modals.modal>
        @if($addOrEditObject)
            <div class="w-full px-6 py-4">
                <form wire:submit.prevent="save">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />

                        <x-text-input wire:model.defer="currentParticipant.name" id="name" class="block mt-1 w-full" type="text" required autofocus />

                        @error("currentParticipant.name")<div class="mt-1 text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="mt-3">
                        <x-input-label for="familyname" :value="__('Family Name')" />

                        <x-text-input wire:model.defer="currentParticipant.family_name" id="familyname" class="block mt-1 w-full" type="text" required autofocus />

                        @error("currentParticipant.family_name")<div class="mt-1 text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="mt-3">
                        <x-input-label for="dateofbirth" :value="__('Date of birth')" />

                        <x-text-input wire:model.defer="currentParticipant.date_of_birth" id="dateofbirth" class="block mt-1 w-full" type="date" autofocus />

                        @error("currentParticipant.date_of_birth")<div class="mt-1 text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="mt-3">
                        <x-input-label for="email" :value="__('Email')" />

                        <x-text-input wire:model.defer="currentParticipant.email" id="email" class="block mt-1 w-full" type="email" required autofocus />

                        @error("currentParticipant.email")<div class="mt-1 text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold">Status</h3>
                        <x-text-input id="active" wire:model="currentParticipant.active" value="1" type="radio" />
                        <label for="active">Active</label>
                        <x-text-input id="inactive" wire:model="currentParticipant.active" value="0" type="radio" />
                        <label for="inactive">Inactive</label>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-bold">Events</h3>
                        @forelse($allEvents as $currentEvent)
                            <div>
                                <x-text-input wire:model="participantEvents" id="event-{{$currentEvent->id}}" value="{{$currentEvent->id}}" type="checkbox" />
                                <label for="event-{{$currentEvent->id}}">{{$currentEvent->name}}</label>
                            </div>
                        @empty
                            <h3>{{ __('There are no events to show!') }}</h3>
                        @endforelse

                        @error("participantEvents")<div class="mt-1 text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="mt-4">
                        <x-primary-button class="bg-orange-500">{{ __('Update') }}</x-primary-button>
                    </div>
                </form>
            </div>
        @else
            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Participant Information</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $currentParticipant->name }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Family Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $currentParticipant->family_name }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $currentParticipant->date_of_birth }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $currentParticipant->email }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-{{ $currentParticipant->status_color }}-600 sm:col-span-2 sm:mt-0">{{ $currentParticipant->status_text }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Events</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                <ul role="list" class="divide-y divide-gray-200 rounded-md border border-gray-200">
                                    @forelse($currentParticipant->events as $event)
                                        <li class="flex items-center justify-between py-3 pl-3 pr-4 text-sm">
                                            <div class="flex w-0 flex-1 items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                                </svg>
                                                <span class="ml-2 w-0 flex-1 truncate">{{ $event->name }}</span>
                                            </div>
                                        </li>
                                    @empty
                                        <h3>{{ __('There are no events to show!') }}</h3>
                                    @endforelse
                                </ul>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        @endif
    </x-modals.modal>
</div>
