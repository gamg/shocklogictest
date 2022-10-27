@props([
    'eventName' => '',
    'object' => null
])

<x-actions.action
    @click.prevent="$dispatch('deleteit', {
            eventName: '{{ $eventName }}',
            id: '{{ $object->id ?? '' }}'
        })"
    title="{{ __('Delete') }}"
    class="text-red-600 hover:text-red-400">
    <x-icons.delete/>
</x-actions.action>
