<?php

namespace App\Commands;

use App\Exceptions\ValidationException;
use App\Rules\MealDeliveryDeadlineRule;
use App\Rules\MenuCoversMoreThanRule;
use App\Rules\MenuPostcodeRule;
use App\Services\MenuPosition\CommandPrinterService;
use App\Services\MenuPosition\FileParserService;
use App\Services\MenuPosition\MenuFilterService;
use App\Validators\IInputValidator;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class GetMenuCommand extends Command
{
    /** @var FileParserService */
    protected $fileParser;

    /** @var CommandPrinterService */
    protected $commandPrinter;

    /** @var MenuFilterService */
    protected $menuFilter;

    /** @var IInputValidator */
    protected $inputValidator;

    public function __construct(
        $name,
        FileParserService $fileParser,
        CommandPrinterService $commandPrinter,
        MenuFilterService $menuFilterService,
        IInputValidator $inputValidator
    ) {
        parent::__construct($name);
        $this->fileParser = $fileParser;
        $this->commandPrinter = $commandPrinter;
        $this->menuFilter = $menuFilterService;
        $this->inputValidator = $inputValidator;
    }

    public function configure()
    {
        $this->setName('getMenus')
            ->setDescription('Search for available menus.')
            ->setHelp('This command allows you to search its database of vendors for menu items available given day, time, location and a headcount.')
            ->addArgument('filename', InputArgument::REQUIRED, 'input file with the vendors data')
            ->addArgument('day', InputArgument::REQUIRED, 'delivery day (dd/mm/yy)')
            ->addArgument('time', InputArgument::REQUIRED, 'delivery time in 24h format (hh:mm)')
            ->addArgument('location', InputArgument::REQUIRED, 'delivery location (postcode without spaces, e.g. NW43QB)')
            ->addArgument('covers', InputArgument::REQUIRED, 'number of people to feed');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        try {
            $this->inputValidator->validate($input);
        } catch (ValidationException $validationException) {
            $output->writeln('<error>' . $validationException->getMessage() . '</error>');
            return;
        }
        $output->writeln([
            '*** <info>Available menus</info> ****',
            '=========================',
        ]);

        $coversRule = new MenuCoversMoreThanRule($input->getArgument('covers'));
        $postcodeRule = new MenuPostcodeRule($input->getArgument('location'));

        $deadline = DateTime::createFromFormat(
            'd/m/y H:i',
            $input->getArgument('day') .
            ' ' .
            $input->getArgument('time')
        );
        $mealDeadlineRule = new MealDeliveryDeadlineRule($deadline);
        $menuRules = [$coversRule, $postcodeRule];
        $mealRules = [$mealDeadlineRule];

        try {
            $filename = $_SERVER['DOCUMENT_ROOT'] . 'resources/files/' . $input->getArgument('filename');
            $menus = $this->fileParser->getMenus($filename);
            $menus = $this->menuFilter->filter($menus, $menuRules, $mealRules);
            $this->commandPrinter->render($menus, $output);
        } catch (Throwable $throwable) {
            $output->writeln('Unable to get products:');
            $output->writeln('<error>' . $throwable->getMessage() . '</error>');
        }
    }
}
