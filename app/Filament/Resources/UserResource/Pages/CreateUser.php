<?php

namespace App\Filament\Resources\UserResource\Pages;
use Spatie\Permission\Models\Role;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
     protected function afterCreate(): void
    {
        $user = $this->record;

        $type = $user->type;

        Role::findOrCreate($type);

        $user->assignRole($type);
    }
}
