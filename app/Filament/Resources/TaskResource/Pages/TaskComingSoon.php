<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use Filament\Resources\Pages\Page;

class TaskComingSoon extends Page
{
    protected static string $resource = TaskResource::class;
    protected static ?string $title = 'Coming Soon';
    protected static bool $shouldRegisterNavigation = false;
    protected static bool $shouldShowPageHeading = false;
    public function getTitle(): string
    {
        return '';
    }


     protected static string $route = '/';

    protected static string $view = 'filament.resources.task-resource.pages.task-coming-soon';
}
