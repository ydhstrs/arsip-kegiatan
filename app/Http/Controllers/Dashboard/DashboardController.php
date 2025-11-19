<?php
namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Room;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Support\Facades\DB;

class DashboardController extends \App\Http\Controllers\Controller
{
    public function showChart()
    {
$start = Carbon::parse(Transaction::min('date'));
$end = Carbon::now();
$period = CarbonPeriod::create($start, '1 month', $end);

$amountPerMonth = collect($period)->map(function ($date) {
    $startDate = $date->copy()->startOfMonth();
    $endDate = $date->copy()->endOfMonth();

    return [
        'amount' => Transaction::whereBetween('date', [$startDate, $endDate])
            ->where(function ($query) {
                $query->where('transaction_type', 'Checkin')
                      ->orWhere('transaction_type', 'Bill');
            })
            ->sum('amount'), // Menghitung total amount
        'month' => $endDate->format('Y-m-d'),
    ];
});

$data = $amountPerMonth->pluck('amount')->toArray();
$labels = $amountPerMonth->pluck('month')->toArray();

$chart = Chartjs::build()
    ->name('MonthlyTransactionChart')
    ->type('line')
    ->size(['width' => 400, 'height' => 200])
    ->labels($labels)
    ->datasets([
        [
            'label' => 'Total Amount (Monthly)',
            'backgroundColor' => 'rgba(38, 185, 154, 0.31)',
            'borderColor' => 'rgba(38, 185, 154, 0.7)',
            'data' => $data,
        ],
    ])
    ->options([
        'scales' => [
            'x' => [
                'type' => 'time',
                'time' => [
                    'unit' => 'month',
                ],
                'min' => $start->format('Y-m-d'),
            ],
        ],
        'plugins' => [
            'title' => [
                'display' => true,
                'text' => 'Monthly Transaction Amount',
            ],
        ],
    ]);



        $transoutPerMonth = collect($period)->map(function ($date) {
            $startDate = $date->copy()->startOfMonth();
            $endDate = $date->copy()->endOfMonth();

            return [
                'count' => Transaction::whereBetween('date', [$startDate, $endDate])
                    ->where('transaction_type', 'Paying')
                    ->orWhere('transaction_type', 'Buying')
                    ->count(),
                'month' => $endDate->format('Y-m-d'),
            ];
        });

        $data = $transoutPerMonth->pluck('count')->toArray();
        $labels = $transoutPerMonth->pluck('month')->toArray();

        $chartOut = Chartjs::build()
            ->name('UserRegistrationsChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($labels)
            ->datasets([
                [
                    'label' => 'User Registrations',
                    'backgroundColor' => 'rgba(38, 185, 154, 0.31)',
                    'borderColor' => 'rgba(38, 185, 154, 0.7)',
                    'data' => $data,
                ],
            ])
            ->options([
                'scales' => [
                    'x' => [
                        'type' => 'time',
                        'time' => [
                            'unit' => 'month',
                        ],
                        'min' => $start->format('Y-m-d'),
                    ],
                ],
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Monthly Transaction Out',
                    ],
                ],
            ]);

        // Data untuk pie chart
        $fullRooms = Room::where('is_available', 0)->count();
        $availableRooms = Room::where('is_available', 1)->count();
        $chartRoom = Chartjs::build()
            ->name('roomAvailabilityChart')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Available Rooms', 'Full Rooms'])
            ->datasets([
                [
                    'backgroundColor' => ['#28a745', '#dc3545'], // Hijau dan merah
                    'hoverBackgroundColor' => ['#28a745', '#dc3545'],
                    'data' => [$availableRooms, $fullRooms],
                ],
            ])
            ->options([
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Room Availability',
                    ],
                ],
            ]);

        return view('backend.dashboard.index', compact('chart','chartOut' ,'chartRoom'));
    }
}
