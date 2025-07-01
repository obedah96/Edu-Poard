<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\MenuItem;
use App\Http\Middleware\SetLocale;
   use Filament\View\PanelsRenderHook;
   use Illuminate\Support\Facades\View;
   use Illuminate\Support\Facades\Blade;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('MAVE')
            ->brandLogo( asset('storage/logo.jpeg'))
            ->brandLogoHeight('6rem')
            ->colors([
                'primary'   => '#60A5FA',  // أزرق فاتح
                'secondary' => '#E5E7EB',  // رمادي فاتح (مثال)
                'success'   => '#10B981',
                'warning'   => '#F59E0B',
                'danger'    => '#EF4444',
                'gray'      => '#6B7280',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([

            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                SetLocale::class
            ])

             ->userMenuItems([
                MenuItem::make()
                     ->label(fn() => app()->getLocale() === 'en' ? 'اللغة العربية' : 'English')
                     ->icon('heroicon-o-globe-alt')
                    ->url(fn() => route('language.switch', [app()->getLocale() === 'en' ? 'ar' : 'en']))
                     ->openUrlInNewTab(false),
             ])
             ->renderHook(
                PanelsRenderHook::SIDEBAR_NAV_START,
                // هذه هي الطريقة الصحيحة: استخدام Blade::render() لعرض المحتوى كـ HTML
                fn (): string => Blade::render(view('filament.admin.partials.sidebar-header')->render()),
            );


    }
}
