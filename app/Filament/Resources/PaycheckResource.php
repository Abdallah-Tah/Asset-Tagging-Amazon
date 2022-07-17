<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Paycheck;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaycheckResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaycheckResource\RelationManagers;
use Filament\Tables\Filters\Filter;

class PaycheckResource extends Resource
{
    protected static ?string $model = Paycheck::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Menu';

    protected static ?string $recordTitleAttribute = 'site';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('site')->required(),
                Forms\Components\TextInput::make('amount')->required()->rule('numeric'),
                DatePicker::make('from')->required(),
                DatePicker::make('to')->required(),
                Select::make('is_paid')
                    ->options([
                        '0' => 'No',
                        '1' => 'Yes',
                    ])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('site')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('amount')->sortable()->money('usd'),
                Tables\Columns\TextColumn::make('from')->sortable(),
                Tables\Columns\TextColumn::make('to')->sortable(),
                Tables\Columns\BooleanColumn::make('is_paid')
                ->trueIcon('heroicon-o-badge-check')
                ->falseIcon('heroicon-o-x-circle')
            ])
            ->defaultSort('from', 'asc')
            ->filters([
                Filter::make('from')
                ->form([
                    Forms\Components\DatePicker::make('created_from'),
                    Forms\Components\DatePicker::make('created_until'),
                ])->query(function ($query, array $data) {
                    if (isset($data['created_from'])) {
                        $query->where('from', '>=', $data['created_from']);
                    }
                    if (isset($data['created_until'])) {
                        $query->where('to', '<=', $data['created_until']);
                    }
                }),
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
            'index' => Pages\ListPaychecks::route('/'),
            'create' => Pages\CreatePaycheck::route('/create'),
            'edit' => Pages\EditPaycheck::route('/{record}/edit'),
        ];
    }
}
