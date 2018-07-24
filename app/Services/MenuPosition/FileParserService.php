<?php

namespace App\Services\MenuPosition;

use App\Exceptions\CreateObjectException;
use App\Exceptions\FileParseException;
use App\Exceptions\UnexpectedLineContentException;
use App\Models\AdvanceTime;
use App\Models\Meal;
use App\Models\Menu;
use App\Models\Vendor;
use Exception;
use SplFileObject;

class FileParserService
{
    const STATUS_ADDING_VENDOR = 1;
    const STATUS_ADDING_MENU_POSITION = 2;

    /** @var int */
    private $status = self::STATUS_ADDING_VENDOR;

    /** @var Menu|null $currentMenuPosition */
    private $currentMenuPosition;

    /** @var Vendor|null */
    private $currentVendor;

    /** @var array */
    private $menus;

    public function __construct()
    {
        $this->status = self::STATUS_ADDING_VENDOR;
        $this->currentMenuPosition = null;
        $this->currentVendor = null;
        $this->menus = [];
    }

    /**
     * @throws Exception
     *
     * @return Menu[]
     */
    public function getMenus(string $filename): array
    {
        if (!is_readable($filename)) {
            throw new Exception('File ' . $filename . ' is not readable');
        }
        $file = new SplFileObject($filename);
        // Read file line by line to handle big ones
        while (!$file->eof()) {
            try {
                $line = $file->fgets();
                $this->parseLine($line);
            } catch (UnexpectedLineContentException $exception) {
                throw new FileParseException('Unexpected line content at line: ' . $file->key());
            }

        }

        return $this->menus;
    }

    /**
     * @param mixed $line
     *
     * @throws CreateObjectException
     * @throws UnexpectedLineContentException
     */
    private function parseLine(string $line): void
    {
        if ("\r\n" === $line) {
            $this->status = self::STATUS_ADDING_VENDOR;
            return;
        }

        if (self::STATUS_ADDING_VENDOR === $this->status) {
            $this->currentMenuPosition = new Menu();
            $this->menus[] = $this->currentMenuPosition;
            $this->currentVendor = $this->getVendor($line);
            $this->currentMenuPosition->setVendor($this->currentVendor);

            $this->status = self::STATUS_ADDING_MENU_POSITION;
            return;
        }

        if (self::STATUS_ADDING_MENU_POSITION === $this->status) {
            $this->currentMenuPosition->addMeal($this->getMeal($line));
            return;
        }
        throw new UnexpectedLineContentException();
    }

    /**
     * @throws CreateObjectException
     */
    private function getMeal(string $line): Meal
    {
        $attributes = explode(';', $line);
        [$name, $allergiesString, $advanceTime] = $attributes;
        $allergies = explode(',', $allergiesString);
        if (empty($name) || empty($advanceTime)) {
            throw new CreateObjectException(Meal::class);
        }

        return new Meal($name, AdvanceTime::fromHours((int) $advanceTime), $allergies);
    }

    /**
     * @throws CreateObjectException
     */
    private function getVendor(string $line): Vendor
    {
        $attributes = explode(';', $line);
        [$name, $postcode, $maxCovers] = $attributes;
        if (empty($name) || empty($postcode) || empty($maxCovers)) {
            throw new CreateObjectException(Vendor::class);
        }

        return new Vendor($name, $postcode, $maxCovers);
    }
}
