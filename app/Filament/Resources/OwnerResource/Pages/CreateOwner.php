<?php

namespace App\Filament\Resources\OwnerResource\Pages;

use App\Filament\Resources\OwnerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Owner;
use Spatie\Permission\Models\Role;


class CreateOwner extends CreateRecord
{
    protected static string $resource = OwnerResource::class;


}
