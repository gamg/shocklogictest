<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users graphic report') }}
        </h2>
    </x-slot>

{{--    <div class="text-center">--}}
{{--        <h3 class="font-bold">Chart Type</h3>--}}
{{--        <x-text-input id="line" wire:model="type" value="line" type="radio" />--}}
{{--        <label for="line">Line</label>--}}
{{--        <x-text-input id="bar" wire:model="type" value="bar" type="radio" />--}}
{{--        <label for="bar">Bar</label>--}}
{{--        <x-text-input id="pie" wire:model="type" value="pie" type="radio" />--}}
{{--        <label for="pie">Pie</label>--}}
{{--    </div>--}}

    <h1 class="font-bold">{{ $chart->options['chart_title'] }}</h1>
    <h2 class="font-semibold">Total: {{ $chart->options['total'] }}</h2>
    <h2 class="font-semibold">Last 30 days: {{ $chart->options['filter_total'] }}</h2>
    {!! $chart->renderHtml() !!}

    @push('scripts')
        {!! $chart->renderChartJsLibrary() !!}
        {!! $chart->renderJs() !!}
    @endpush
</div>
