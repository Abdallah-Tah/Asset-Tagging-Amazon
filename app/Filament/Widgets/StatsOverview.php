<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\PayCheck;
use App\Models\Subsistence;
use COM;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use League\CommonMark\Extension\FrontMatter\FrontMatterParser;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {

        $paychecks = PayCheck::where('is_paid', true)
        ->whereBetween('from', [
            now()->subDays(30),
            now()
        ])->sum('amount') / 100;

        $total_paychecks = PayCheck::where('is_paid', true)->sum('amount') / 100;

        $total_unpaid = PayCheck::where('is_paid', false)->sum('amount') / 100;

        $amount = number_format(($paychecks / 100), 2);

        $expense = Expense::sum('amount')/ 100;

        $percent_site = number_format(($paychecks / $total_paychecks) * 100, 2);

        return [
            Card::make('PayChecks', '$'.number_format($total_paychecks, 2))
            ->description($amount .'% increase')
            ->chart([0, 4, 8, $amount])
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),
            Card::make('Sites Finished', (PayCheck::where('is_paid', true)->count()))
            ->description((PayCheck::where('is_paid', true)->count()). '/'. PayCheck::where('is_paid', false)->count(). ' increase')
            ->chart([0, 1, PayCheck::where('is_paid', true)->count()])
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),
            Card::make('Sites Unfinished', (PayCheck::where('is_paid', false)->count()))
            ->chart([PayCheck::where('is_paid', false)->count(), PayCheck::where('is_paid', true)->count()])
            ->description((PayCheck::where('is_paid', false)->count()). '/'. PayCheck::count(). ' decrease')
            ->descriptionIcon('heroicon-s-trending-down')
            ->color('danger'),
            Card::make('Unpaid', '$'.number_format($total_unpaid, 2)),
            Card::make('Expenses', '$'.number_format($expense, 2)),
            Card::make('Subsistence Paid', '$'.number_format(Subsistence::where('is_paid', true)->sum('amount') / 100, 2))
            ->chart([Subsistence::where('is_paid', false)->sum('amount') / 100, Subsistence::where('is_paid', true)->sum('amount') / 100, 2])
            ->description((Subsistence::where('is_paid', true)->count()). '/'. PayCheck::count(). ' increase')
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),
            Card::make('Subsistence Unpaid', '$'.number_format(Subsistence::where('is_paid', false)->sum('amount') / 100, 2))
            ->chart([Subsistence::where('is_paid', false)->sum('amount') / 100, 2, 95, 58, 10])
            ->description((Subsistence::where('is_paid', false)->count()). '/'. PayCheck::count(). ' decrease')
            ->descriptionIcon('heroicon-s-trending-down')
            ->color('danger'),

            Card::make('Total', ('$'.number_format(PayCheck::sum('amount')/ 100 - $expense, 2) )),
        ];
    }
}
