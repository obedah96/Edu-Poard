<?php

namespace App\Filament\Resources\StatResource\Pages;

use App\Filament\Resources\StatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\StatResource\Widgets\TotalCustomersWidget;
use App\Filament\Resources\StatResource\Widgets\ActiveTasksWidget;

class ListStats extends ListRecords
{
    protected static string $resource = StatResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
        ];
    }
}
