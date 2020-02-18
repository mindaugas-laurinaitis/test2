<?php

namespace App\Tests\Service\Unit;

use App\Service\CategoryService;
use PHPUnit\Framework\TestCase;

class CategoryServiceTest extends TestCase
{
    public function testGetAvailableCategories()
    {
        $categoryService = new CategoryService();
        $categories = $categoryService->getAvailableCategories();

        foreach ($categories as $key => $category){
            $this->assertEquals($key, $category);
        }
    }
}
