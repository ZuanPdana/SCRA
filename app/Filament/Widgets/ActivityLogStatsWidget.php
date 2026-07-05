<?php

namespace App\Filament\Widgets;

use App\Models\ActivityLog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class ActivityLogStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();

        $totalActivityToday = ActivityLog::whereDate('created_at', $today)->count();
        $totalActivityWeek = ActivityLog::whereBetween('created_at', [$startOfWeek, Carbon::now()])->count();
        $totalLoginToday = ActivityLog::whereDate('created_at', $today)
            ->where('title', 'Login')
            ->count();
        $totalReservationToday = ActivityLog::whereDate('created_at', $today)
            ->where('module', 'Reservations')
            ->count();

        return [
            Stat::make('Total Aktivitas Hari Ini', $totalActivityToday)
                ->color('primary')
                ->icon('heroicon-o-clock'),
            Stat::make('Total Aktivitas Minggu Ini', $totalActivityWeek)
                ->color('success')
                ->icon('heroicon-o-calendar-days'),
            Stat::make('Jumlah Login Hari Ini', $totalLoginToday)
                ->color('info')
                ->icon('heroicon-o-arrow-right-on-rectangle'),
            Stat::make('Jumlah Reservasi Hari Ini', $totalReservationToday)
                ->color('warning')
                ->icon('heroicon-o-calendar'),
        ];
    }
}
