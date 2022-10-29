<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Users Graphic Report
        </h2>
    </x-slot>

    <h2 class="text-center font-bold text-lg">Filters</h2>
    <form method="GET" action="{{ route('report') }}">
        <div class="text-center">
            <x-text-input id="line" name="chart_type" value="line" type="radio" checked="{{ request('chart_type') == 'line' ?? null }}"/>
            <label for="line">Line</label>
            <x-text-input id="bar" name="chart_type" value="bar" type="radio" checked="{{ request('chart_type') == 'bar' ?? null }}" />
            <label for="bar">Bar</label>
            <x-text-input id="pie" name="chart_type" value="pie" type="radio" checked="{{ request('chart_type') == 'pie' ?? null }}" />
            <label for="pie">Pie</label>
        </div>
        <div class="text-center">
            <select name="days" class="w-48 mt-1 pl-3 py-2 mb-4 rounded-md shadow-sm border-gray-300 focus:border-indigo-300">
                <option value="30" {{ request('days') == '30' ? 'selected' : '' }}>Last 30 days</option>
                <option value="60" {{ request('days') == '60' ? 'selected' : '' }}>Last 60 days</option>
                <option value="90" {{ request('days') == '90' ? 'selected' : '' }}>Last 90 days</option>
            </select>
        </div>
        <div class="text-center">
            <x-primary-button class="bg-orange-500">{{ __('Filter') }}</x-primary-button>
            <a href="{{ route('report') }}" class="text-red-600">Reset</a>
        </div>
    </form>

    <h1 class="font-bold">{{ $chart->options['chart_title'] }}</h1>
    <h2 class="font-semibold">Total: {{ $chart->options['total'] }}</h2>
    <h2 class="font-semibold">Last {{ $chart->options['filter_days'] }} days: {{ $chart->options['filter_total'] }}</h2>
    {!! $chart->renderHtml() !!}

    @push('scripts')
        {!! $chart->renderChartJsLibrary() !!}
        {!! $chart->renderJs() !!}
    @endpush
</x-app-layout>
