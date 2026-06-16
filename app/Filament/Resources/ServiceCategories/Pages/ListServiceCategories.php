<?php

namespace App\Filament\Resources\ServiceCategories\Pages;

use App\Filament\Resources\ServiceCategories\ServiceCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\HtmlString;

class ListServiceCategories extends ListRecords
{
    protected static string $resource = ServiceCategoryResource::class;

    public function getSubheading(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return new HtmlString('<span class="text-sm text-gray-500 font-normal">Kelola kategori layanan kasir</span>');
    }
    
    public function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()->label('Tambah Kategori Baru'),
        ];
    }
    
}
