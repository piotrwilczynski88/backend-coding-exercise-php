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
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

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
     * @throws FileNotFoundException
     *
     * @return Menu[]
     */
    public function getMenus(string $filename): array
    {
        if (!is_readable($filename)) {
            throw new FileNotFoundException(null, 0, null, $filename);
        }
        $file = new SplFileObject($filename);
        // Read file line by line to handle big ones
        while (!$file->eof()) {
            try {
                $line = trim($file->fgets());
                $this->parseLine($line);
            } catch (UnexpectedLineContentException $exception) {
                throw new FileParseException('Unexpected line content at line: ' . $file->key(), $exception->getCode(), $exception);
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
        if ('' === $line && $this->status === self::STATUS_ADDING_MENU_POSITION) {
            $this->status = self::STATUS_ADDING_VENDOR;

            return;
        }

        if (self::STATUS_ADDING_VENDOR === $this->status) {
            $this->currentVendor = $this->getVendor($line);
            $this->currentMenuPosition = new Menu($this->currentVendor);
            $this->menus[] = $this->currentMenuPosition;
            $this->currentMenuPosition->setVendor($this->currentVendor);

            $this->status = self::STATUS_ADDING_MENU_POSITION;

            return;
        }

        if (self::STATUS_ADDING_MENU_POSITION === $this->status) {
            $this->currentMenuPosition->addMeal($this->getMeal($line));

            return;
        }
    }

    /**
     * @throws CreateObjectException
     * @throws UnexpectedLineContentException
     */
    private function getMeal(string $line): Meal
    {
        $attributes = explode(';', $line);
        [$name, $allergiesString, $advanceTime] = $attributes;

        // ensure line is a meal line by validating advance time.
        if (!preg_match('/^\d+h$/', $advanceTime)) {
            throw new UnexpectedLineContentException();
        }
        $allergies = explode(',', $allergiesString);
        if (empty($name)) {
            throw new CreateObjectException(Meal::class);
        }

        return new Meal($name, AdvanceTime::fromHours((int) $advanceTime), $allergies);
    }

    /**
     * @throws CreateObjectException
     * @throws UnexpectedLineContentException
     */
    private function getVendor(string $line): Vendor
    {
        $attributes = explode(';', $line);
        [$name, $postcode, $maxCovers] = $attributes;
        if (!preg_match('/^[0-9]+$/', $maxCovers)) {
            // ensure line is a vendor line. max covers is only numeric, advance time not
            throw new UnexpectedLineContentException();
        }
        if (empty($name) || empty($postcode)) {
            throw new CreateObjectException(Vendor::class);
        }

        return new Vendor($name, $postcode, $maxCovers);
    }
}
