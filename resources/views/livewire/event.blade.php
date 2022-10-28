<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Events') }} - Welcome {{ auth()->user()->name }} {{ auth()->user()->family_name }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto py-16 sm:py-24 lg:max-w-none">
            <div class="flex items-center">
                <h2 class="text-2xl font-extrabold text-gray-900 mr-5">Events</h2>
                <x-actions.action wire:click.prevent="create" title="{{ __('New Event') }}" class="text-gray-800 hover:text-gray-600">
                    <x-icons.add/>
                </x-actions.action>
                <div>
                    <x-text-input wire:click="showMyEvents" id="myevents" type="checkbox" />
                    <label for="myevents">My Events</label>
                </div>
            </div>

            <div class="space-y-12 lg:space-y-6 lg:grid lg:grid-cols-3 lg:gap-x-6">
                @forelse($events as $event)
                    <div class="group mt-6" wire:key="{{ $event->id }}">
                        <div class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1">
                            <a href="#" wire:click.prevent="loadEvent({{ $event->id }})">
                                <img src="{{ $event->image_url }}" alt="Event Image" class="w-full h-full object-center object-cover">
                            </a>
                        </div>
                        <h3 class="mt-6 text-base font-semibold text-gray-900">
                            <a href="#" wire:click.prevent="loadEvent({{ $event->id }})">{{ $event->name }}</a>
                        </h3>
                        <div class="flex items-center" x-data>
                            <x-actions.action wire:click.prevent="loadEvent({{ $event->id }}, true)" title="{{ __('Edit') }}" class="text-gray-800 hover:text-gray-600">
                                <x-icons.edit/>
                            </x-actions.action>
                            <x-actions.delete eventName="deleteEvent" :object="$event"/>
                        </div>
                    </div>
                @empty
                    <h3>{{ __('There are no events to show!') }}</h3>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Modal -->
    <x-modals.modal>
        @if($addOrEditObject)
            <div class="w-full px-6 py-4">
                <form wire:submit.prevent="save">
                    <div>
                        <x-input-label for="name" :value="__('Name')" />

                        <x-text-input wire:model.defer="currentEvent.name" id="name" class="block mt-1 w-full" type="text" required autofocus />

                        @error("currentEvent.name")<div class="mt-1 text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="mt-3">
                        <x-input-label for="startdate" :value="__('Start Date')" />

                        <x-text-input wire:model.defer="currentEvent.start_date" id="startdate" class="block mt-1 w-full" type="date" autofocus />

                        @error("currentEvent.start_date")<div class="mt-1 text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="mt-3">
                        <x-input-label for="enddate" :value="__('End Date')" />

                        <x-text-input wire:model.defer="currentEvent.end_date" id="enddate" class="block mt-1 w-full" type="date" autofocus />

                        @error("currentEvent.end_date")<div class="mt-1 text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>
                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Image')" />

                        <x-inputs.img wire:model="imageFile" id="image">
                            <span class="w-24 rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ $imageFile ? $imageFile->temporaryUrl() : $currentEvent->image_url }}" alt="{{ __('Event image') }}">
                            </span>
                        </x-inputs.img>

                        <div wire:loading wire:target="imageFile" class="mt-1 w-full text-indigo-700">
                            {{__('Verifying file...')}}
                        </div>

                        @error("imageFile")<div class="mt-1 text-red-600 text-sm">{{ $message }}</div>@enderror
                    </div>

                    <div class="mt-4">
                        <x-primary-button class="bg-orange-500">{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </div>
        @else
            <div class="mt-3 text-center sm:mt-0 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                    {{ $currentEvent->name }}
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500 font-semibold">
                        Start Date: {{ $currentEvent->start_date_formatted }}
                    </p>
                    <p class="text-sm text-gray-500 font-semibold">
                        End Date: {{ $currentEvent->end_date_formatted }}
                    </p>
                </div>
                <div class="mt-2">
                    <div class="relative w-full h-80 bg-white rounded-lg overflow-hidden group-hover:opacity-75 sm:aspect-w-2 sm:aspect-h-1 sm:h-64 lg:aspect-w-1 lg:aspect-h-1">
                        <img src="{{ $currentEvent->image_url }}" alt="Event Image" class="w-full h-full object-center object-cover">
                    </div>
                </div>
                <div class="mt-2">
                    <x-text-input wire:click="subscribe" id="subscribe-{{$currentEvent->id}}" type="checkbox" :checked="$hasThisEvent" />
                    <label for="subscribe-{{$currentEvent->id}}">Subscribe</label>
                </div>
            </div>
        @endif
    </x-modals.modal>
</div>
