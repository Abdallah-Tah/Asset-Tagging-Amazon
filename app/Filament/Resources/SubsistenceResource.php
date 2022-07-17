<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\PayCheck;
use App\Models\Subsistence;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubsistenceResource\Pages;
use App\Filament\Resources\SubsistenceResource\RelationManagers;

class SubsistenceResource extends Resource
{
    protected static ?string $model = Subsistence::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Menu';

    protected static ?string $recordTitleAttribute = 'site';

    public static function form(Form $form): Form
    {
        $paychecks = PayCheck::all();
        return $form
            ->schema([
                Forms\Components\Select::make('paycheck_id')
                    ->options($paychecks->pluck('site', 'id'))
                    ->required(),
                Forms\Components\DatePicker::make('from')->required(),
                Forms\Components\DatePicker::make('to')->required(),
                Forms\Components\Select::make('is_paid')
                    ->options([
                        '0' => 'No',
                        '1' => 'Yes',
                    ])->required(),
                Forms\Components\TextInput::make('amount')->required()->rule('numeric'),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paycheck.site')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('amount')->sortable()->money('usd'),
                Tables\Columns\TextColumn::make('from')->sortable(),
                Tables\Columns\TextColumn::make('to')->sortable(),
                Tables\Columns\TextColumn::make('number_days')
                ->sortable(),
                Tables\Columns\BooleanColumn::make('is_paid')
                    ->trueIcon('heroicon-o-badge-check')
                    ->falseIcon('heroicon-o-x-circle')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubsistences::route('/'),
            'create' => Pages\CreateSubsistence::route('/create'),
            'edit' => Pages\EditSubsistence::route('/{record}/edit'),
        ];
    }
}
