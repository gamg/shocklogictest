<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class UsersReportController extends Controller
{
    public string $type = 'line';
    public int $days = 30;

    public function index(Request $request)
    {
        $this->type = $request->has('chart_type') ? $request->chart_type : $this->type;
        $this->days = $request->has('days') ? $request->days : $this->days;

        return view('report', ['chart' => $this->getChart()]);
    }

    private function getChart()
    {
        return new LaravelChart([
            'chart_title' => 'Users by day',
            'report_type' => 'group_by_date',
            'model' => "App\Models\User",
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => $this->type,
            'filter_field' => 'created_at',
            'filter_days' => $this->days,
            'continuous_time' => true,
            'total' => User::count(),
            'filter_total' => User::where('created_at', '>=', now()->subDays($this->days))->count()
        ]);
    }
}
