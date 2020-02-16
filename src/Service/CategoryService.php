<?php

namespace App\Service;

class CategoryService
{
    public const CATEGORIES = [
        'Breaking News',
        'Colleges and Universities',
        'Newspapers',
        'Politics',
        'Sports',
        'Technology',
        'Traffic & Roads'
    ];

    public function getAvailableCategories(): array
    {
        return array_combine(self::CATEGORIES, self::CATEGORIES);
    }
}