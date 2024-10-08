<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables\Actions\CreateAction;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function beforeCreate()
    {
        // CreateAction::make()
        //   ->mutateFormDataUsing(function (array $data): array {
        //     $data['order_code'] = '72343824';

        //     return $data;
        // });

        logger("Before Create");
        // logger($this->record);
    }

    protected function afterCreate(): void
    {
        logger("After Create");
        // Runs after the form fields are saved to the database.
    }
}
