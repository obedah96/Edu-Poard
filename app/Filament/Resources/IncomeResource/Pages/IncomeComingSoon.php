<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use Filament\Resources\Pages\Page;

class IncomeComingSoon extends Page
{
    protected static string $resource = IncomeResource::class;
    protected static string $route = '/';

    // تعطيل شريط العنوان العلوي (Heading)
    protected static bool $shouldShowPageHeading = false;
    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string
    {
        return '';
    }


    protected static string $view = 'filament.resources.income-resource.pages.income-coming-soon';

    // تحديد التسمية (Label) باللغة العربية والإنجليزية
    protected static ?string $label = 'الدخل'; // التسمية في اللغة العربية
    protected static ?string $pluralLabel = 'الدخل المتوقع'; // التسمية في اللغة العربية

    // التسمية في اللغة الإنجليزية
    protected static function getLabel(): ?string
    {
        return __('income.resource.label'); // سيتم تحميله من ملف الترجمة
    }

    // التسمية في اللغة الإنجليزية
    protected static function getPluralLabel(): ?string
    {
        return __('income.resource.plural_label'); // سيتم تحميله من ملف الترجمة
    }
}
