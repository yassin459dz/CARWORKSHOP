<?php

namespace App\Filament\Resources\BlResource\Pages;

use App\Filament\Resources\BlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBls extends ListRecords
{
    protected static string $resource = BlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
