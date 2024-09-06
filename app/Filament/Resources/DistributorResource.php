<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DistributorResource\Pages;
use App\Filament\Resources\DistributorResource\RelationManagers;
use App\Models\ContactPerson;
use App\Models\Distributor;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DistributorResource extends Resource
{
    protected static ? string $model = Distributor::class;

    protected static ? string $navigationIcon   = 'heroicon-o-building-library';
    protected static ? string $navigationGroup  = 'Distributor';
    protected static ? string $navigationLabel  = 'Company';
    protected static ? int $navigationSort      = 1;

    protected static ? string $modelLabel       = 'Company';

    protected static ? string $slug = 'distributor-company';

    public static function form(Form $form): Form
    {
        // dd(ContactPerson::all()->pluck('name', 'id'));
        // $contact_person = new ContactPerson();

        return $form
            ->schema([
                Forms\Components\Section::make('Company Area')
                ->description("Put the company details")
                ->schema([
                    Forms\Components\TextInput::make("company_name")
                    ->label('Company Name')
                    ->required()
                    ->columnSpan('2'),

                    Forms\Components\TextInput::make("company_email")
                    ->label('Company Email'),

                    Forms\Components\TextInput::make("company_phone")
                    ->label('Company Contact')
                    ->required(),

                    Forms\Components\Textarea::make("address")
                    ->label('Company Address')
                    ->required()
                    ->columnSpanFull(),
                ])->columns("2"),

                Forms\Components\Section::make('Director & Staff List')
                ->schema([
                    Repeater::make("contact_person")
                    ->label('Director / Staff')
                    ->relationship("contact_person")
                    ->schema([
                        Forms\Components\TextInput::make("name")
                        ->required(),

                        Forms\Components\TextInput::make("phone")
                        ->required(),

                        Forms\Components\TextInput::make("email")
                        ,

                        Forms\Components\Select::make("role")
                        ->options([
                            0 => 'Boss',
                            1 => 'Manager',
                            2 => 'Staff',
                        ])
                        ->searchable()
                        ->required(),
                    ])->columns('4')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_person.name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListDistributors::route('/'),
            'create' => Pages\CreateDistributor::route('/create'),
            'edit' => Pages\EditDistributor::route('/{record}/edit'),
        ];
    }
}
