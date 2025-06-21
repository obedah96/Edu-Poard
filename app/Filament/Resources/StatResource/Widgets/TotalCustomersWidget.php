<?php

namespace App\Filament\Resources\StatResource\Widgets;
use App\Models\Client;
use Filament\Widgets\Widget;

class TotalCustomersWidget extends Widget
{
    protected static string $view = 'filament.resources.stat-resource.widgets.total-customers-widget';
     protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
         return [
        // هنا نحصّل عدد سجلات جدول clients

    ];
    }
}
