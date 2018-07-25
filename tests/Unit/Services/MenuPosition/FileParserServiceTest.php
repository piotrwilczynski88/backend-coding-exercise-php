<?php

namespace Tests\Unit\Services\MenuPosition;

use App\Exceptions\CreateObjectException;
use App\Exceptions\FileParseException;
use App\Exceptions\UnexpectedLineContentException;
use App\Services\MenuPosition\FileParserService;
use Tests\TestCase;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class FileParserServiceTest extends TestCase
{
    public function testSuccessGetMenus(): void
    {
        $fileParser = new FileParserService();
        $filename = $_SERVER['DOCUMENT_ROOT'] . 'tests/resources/valid_input.ebnf';
        $menus = $fileParser->getMenus($filename);
        $this->assertCount(4, $menus);

        $mealsCount = 0;
        foreach ($menus as $menu) {
            $mealsCount += count($menu->getMeals());
        }
        $this->assertSame(5, $mealsCount);
    }

    public function testSuccessNoMealsForVendor(): void
    {
        $fileParser = new FileParserService();
        $filename = $_SERVER['DOCUMENT_ROOT'] . 'tests/resources/valid_no_meals_for_vendor.ebnf';

        $menus = $fileParser->getMenus($filename);

        $mealsCount = 0;
        foreach ($menus as $menu) {
            $mealsCount += count($menu->getMeals());
        }

        $this->assertSame(0, $mealsCount);
    }

    public function testWrongFilename(): void
    {
        $fileParser = new FileParserService();
        $filename = $_SERVER['DOCUMENT_ROOT'] . 'tests/resources/INVALID_FILENAME_test_valid_input.ebnf';

        $this->expectException(FileNotFoundException::class);

        $fileParser->getMenus($filename);
    }

    public function testTooManyBlankLines(): void
    {
        $fileParser = new FileParserService();
        $filename = $_SERVER['DOCUMENT_ROOT'] . 'tests/resources/invalid_too_many_blank_lines.ebnf';

        $this->expectException(FileParseException::class);

        $fileParser->getMenus($filename);
    }

    public function testWrongAdvanceTime(): void
    {
        $fileParser = new FileParserService();
        $filename = $_SERVER['DOCUMENT_ROOT'] . 'tests/resources/invalid_wrong_advance_time.ebnf';

        $this->expectException(FileParseException::class);

        $fileParser->getMenus($filename);
    }

    public function testWrongPostcode(): void
    {
        $fileParser = new FileParserService();
        $filename = $_SERVER['DOCUMENT_ROOT'] . 'tests/resources/invalid_postcode.ebnf';

        $this->expectException(CreateObjectException::class);

        $fileParser->getMenus($filename);
    }

    public function testWrongVendorName(): void
    {
        $fileParser = new FileParserService();
        $filename = $_SERVER['DOCUMENT_ROOT'] . 'tests/resources/invalid_vendor_name.ebnf';

        $this->expectException(CreateObjectException::class);

        $fileParser->getMenus($filename);
    }

    public function testWrongVendorParameterCount(): void
    {
        $fileParser = new FileParserService();
        $filename = $_SERVER['DOCUMENT_ROOT'] . 'tests/resources/invalid_vendor_parameter_count.ebnf';

        $this->expectException(FileParseException::class);

        $fileParser->getMenus($filename);
    }

    public function testWrongMealParameterCount(): void
    {
        $fileParser = new FileParserService();
        $filename = $_SERVER['DOCUMENT_ROOT'] . 'tests/resources/invalid_meal_parameter_count.ebnf';

        $this->expectException(FileParseException::class);

        $fileParser->getMenus($filename);
    }
}
