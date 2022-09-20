<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Roles;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ReportController extends BaseAPIController
{
    public function index()
    {
        Gate::authorize('view_reports');
        return view('report.dashboard');
    }

    public function get(Request $request)
    {
        Gate::authorize('view_reports');

        $days = [];
        $orders = [];

        $start = Carbon::parse($request->start)->format('Y-m-d');
        $end = Carbon::parse($request->end)->format('Y-m-d');

        $query = "SELECT DATE_FORMAT(created_at, '%Y-%m-%d') as created_date,count(id) as order_count FROM `orders` WHERE created_at BETWEEN '$start' AND '$end 23:59:59' GROUP BY created_date;";
        $result = DB::select($query);

        $period = CarbonPeriod::create($start, $end);

        foreach ($period as $date) {
            $days[] = $date = $date->format('Y-m-d');

            $ordersObj = array_filter($result, function ($element) use ($date) {
                return ($date == $element->created_date);
            });
            $orders[] = !empty($ordersObj) && property_exists($ordersObj[key($ordersObj)], 'order_count') ? $ordersObj[key($ordersObj)]->order_count : 0;
        }

        return $this->success([
            'days' => array_values($days),
            'orders' => array_values($orders)
        ]);
    }
}
