<?php

namespace App\Filament\Resources\StatResource\Pages;

use App\Filament\Resources\StatResource;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\StatResource\Widgets\TotalCustomersWidget;
use App\Filament\Resources\StatResource\Widgets\ActiveTasksWidget;

class StatOverview extends Page
{
    protected static string $resource = StatResource::class;

    public function getTitle(): string
    {
        return '';
    }

    protected static string $view = 'filament.resources.stat-resource.pages.stat-overview';


    public function getHeaderWidgets(): array
    {
        return [
            TotalCustomersWidget::class,
            ActiveTasksWidget::class,
        ];
    }
}
