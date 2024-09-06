<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactPersonResource\Pages;
use App\Filament\Resources\ContactPersonResource\RelationManagers;
use App\Models\ContactPerson;
use App\Models\Distributor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactPersonResource extends Resource
{
    protected static ?string $model = ContactPerson::class;

    protected static ? string $navigationIcon   = 'heroicon-o-user';
    protected static ? string $navigationGroup  = 'Distributor';
    protected static ? string $navigationLabel  = 'Contact Person';
    protected static ? int $navigationSort      = 2;

    protected static ? string $modelLabel       = 'Contacts';

    protected static ? string $slug = 'distributor-contact-person';

    public static function form(Form $form): Form
    {
        $contact_person = new ContactPerson();

        return $form
            ->schema([
                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make("name")
                            ->label('Name')
                            ->required(),

                        Forms\Components\TextInput::make("phone")
                            ->label('Phone')
                            ->required(),

                        Forms\Components\TextInput::make("email")
                            ->label('Email'),

                        Forms\Components\Select::make("role")
                            ->label('Role')
                            ->options($contact_person->role)
                            ->native(false)
                            ->required(),

                        Forms\Components\Select::make("distributor_id")
                            ->label('Company')
                            ->relationship(name: 'distributor', titleAttribute:'company_name')
                            ->native(false)
                            ->createOptionForm([
                                Forms\Components\TextInput::make("company_name")
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make("company_phone")
                                    ->required(),
                                Forms\Components\TextInput::make("company_email")
                                    ,
                                Forms\Components\Textarea::make("address")
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->required(),

                    ])->columns("2"),
            ]);
    }

    public static function table(Table $table): Table
    {
        $contact_person = new ContactPerson();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->formatStateUsing(function($state) use ($contact_person) {
                        return $contact_person->role[$state];
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('distributor.company_name')
                    ->label('Company')
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
            'index' => Pages\ListContactPeople::route('/'),
            'create' => Pages\CreateContactPerson::route('/create'),
            'edit' => Pages\EditContactPerson::route('/{record}/edit'),
        ];
    }
}
