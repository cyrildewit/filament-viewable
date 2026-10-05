<?php

declare(strict_types=1);

namespace Workbench\App\Filament\Resources\Posts\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Workbench\App\Filament\Resources\Posts\PostResource;

class ListPosts extends ListRecords
{
    #[\Override]
    protected static string $resource = PostResource::class;

    #[\Override]
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
