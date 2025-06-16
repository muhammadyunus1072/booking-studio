<?php

namespace App\Repositories\Dashboard;

use Carbon\Carbon;
use App\Models\Transaction\Transaction;

class SummaryRepository
{
    // SUMMARY
    public static function transactionCount()
    {
        return Transaction::count();
    }
    public static function bookingActive()
    {
        return Transaction::where('status', Transaction::STATUS_PAID)
            ->whereNull('scanned_at')
            ->count();
    }
    public static function bookingPending()
    {
        return Transaction::where('status', Transaction::STATUS_PENDING)
            ->count();
    }
    public static function bookingPaid()
    {
        return Transaction::where('status', Transaction::STATUS_PAID)
            ->count();
    }
    public static function bookingExpired()
    {
        return Transaction::where('status', Transaction::STATUS_EXPIRED)
            ->count();
    }

    // DAILY SUMMARY
    public static function transactionToday()
    {
        return Transaction::selectRaw('grand_total')
            ->where('status', Transaction::STATUS_PAID)
            ->whereDate('created_at', now())
            ->get();
    }
    public static function transactionDaily()
    {
        return Transaction::selectRaw('DATE(created_at) as transaction_date, COUNT(*) as transaction_amount, SUM(grand_total) as transaction_value')
            ->where('status', Transaction::STATUS_PAID)
            ->whereDate('created_at', '!=', now())
            ->groupBy('transaction_date')
            ->orderBy('transaction_date', 'DESC');            
    }

    // WEEKLY SUMMARY
    public static function transactionWeekly()
    {
        // 1 Minggu Sebelum
        return Transaction::selectRaw('DAYNAME(created_at) as transaction_day, COUNT(*) as transaction_amount')
        ->whereBetween('created_at', [now()->subDays(6), now()])
        ->groupBy('transaction_day')
        ->orderByRaw("FIELD(transaction_day, 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday')")
        ->get()
        ->keyBy('transaction_day');

        // 1 Minggu Sekarang
        return Transaction::selectRaw("
            DAYNAME(created_at) as transaction_day, 
            COUNT(*) as transaction_amount
        ")
        ->where('status', Transaction::STATUS_PAID)
        ->whereBetween('created_at', [Carbon::now()->startOfWeek(Carbon::SUNDAY), Carbon::now()->endOfWeek(Carbon::SATURDAY)])
        ->groupBy('transaction_day')
        ->get();
    }
    // MONTHLY SUMMARY
    public static function transactionMonthly()
    {
        return Transaction::selectRaw('DATE(created_at) as transaction_date, COUNT(*) as transaction_amount, SUM(grand_total) as transaction_value')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->groupBy('transaction_date')
        ->where('status', Transaction::STATUS_PAID)
        ->orderBy('transaction_date')
        ->get();
    }

    // YEARLY SUMMARY
    public static function transactionYearly()
    {
        return Transaction::selectRaw('grand_total')
            ->where('status', Transaction::STATUS_PAID)
            ->whereYear('created_at', now())
            ->get();
    }
}
