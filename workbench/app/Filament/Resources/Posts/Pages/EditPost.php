<?php

declare(strict_types=1);

namespace Workbench\App\Filament\Resources\Posts\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Workbench\App\Filament\Resources\Posts\PostResource;

class EditPost extends EditRecord
{
    #[\Override]
    protected static string $resource = PostResource::class;

    #[\Override]
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
