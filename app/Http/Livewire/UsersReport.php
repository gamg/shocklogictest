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
            'chart_type' => $this->type,
            'filter_days' => 28,
            'continuous_time' => true,
            'total' => User::count()
        ]);
    }

    public function render()
    {
        $this->getChart();
        return view('livewire.users-report', ['chart' => $this->getChart()]);
    }
}
