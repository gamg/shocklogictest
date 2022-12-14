<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class UsersReport extends Component
{
    public string $type = 'line';

    private function getChart()
    {
        return new LaravelChart([
            'chart_title' => 'Users by day',
            'report_type' => 'group_by_date',
            'model' => "App\Models\User",
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'count',
            'chart_type' => $this->type,
            'filter_field' => 'created_at',
            'filter_days' => 15,
            'continuous_time' => true,
            'total' => User::count(),
            'filter_total' => User::where('created_at', '>=', now()->subDays(15))->count()
        ]);
    }

    public function render()
    {
        return view('livewire.users-report', ['chart' => $this->getChart()]);
    }
}
