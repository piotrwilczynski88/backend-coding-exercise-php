<?php

namespace tests\Unit\Services\MenuPosition;

use App\Services\MenuPosition\FileParserService;
use PHPUnit\Framework\TestCase;

class FileParserServiceTest extends TestCase
{
    public function testGetMenus()
    {
        $fileParser = new FileParserService();
        $filename = $_SERVER['DOCUMENT_ROOT'] . 'tests/resources/test_valid_input.ebnf';
        $menus = $fileParser->getMenus($filename);
        $this->assertCount(4, $menus);

        $mealsCount = 0;
        foreach ($menus as $menu) {
            $mealsCount += count($menu->getMeals());
        }
        $this->assertSame(5, $mealsCount);
    }
}