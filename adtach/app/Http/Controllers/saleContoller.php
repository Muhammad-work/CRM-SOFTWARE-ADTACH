<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class saleContoller extends Controller
{
    
    public function showMonthlySales(){
        $currentMonth = now()->month; // Current month
        $currentYear = now()->year;  // Current year

        // Get all agents
        $agents = user::all();

        // Prepare data for dashboard
        $salesData = [];

        foreach ($agents as $agent) {
            $salesCount = $agent->getSalesCountForMonth($currentMonth, $currentYear);
            $salesData[] = [
                'agent_name' => $agent->name,  // Assuming Agent model has 'name' field
                'sales_count' => $salesCount,
            ];
        }

        return view('admin.current_mont',compact('salesData', 'currentMonth', 'currentYear'));
    }

    // For fetching sales count in the last month and displaying it
    public function showLastMonthSales()
    {
        $lastMonth = now()->subMonth()->month;
        $currentYear = now()->year;

        // Get all agents
        $agents = Agent::all();

        // Prepare data for dashboard
        $salesData = [];

        foreach ($agents as $agent) {
            $salesCount = $agent->getSalesCountForMonth($lastMonth, $currentYear);
            $salesData[] = [
                'agent_name' => $agent->name,
                'sales_count' => $salesCount,
            ];
        }

        return view('dashboard', compact('salesData', 'lastMonth', 'currentYear'));
    }
}
