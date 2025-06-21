<?php

namespace App\Filament\Resources\StatResource\Widgets;

use Filament\Widgets\ChartWidget;


class ActiveTasksWidget extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected int|string|array $columnSpan = 'full';



    protected function getType(): string
    {
        return 'polarArea';
    }
}
