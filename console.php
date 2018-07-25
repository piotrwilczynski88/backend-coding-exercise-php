<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Commands\GetMenuCommand;
use App\Services\MenuPosition\CommandPrinterService;
use App\Services\MenuPosition\FileParserService;
use App\Services\MenuPosition\MenuFilterService;
use App\Validators\GetMenuCommandValidator;
use Symfony\Component\Console\Application;

$app = new Application();
$app->add(new GetMenuCommand(
    'getMenus',
    new FileParserService(),
    new CommandPrinterService(),
    new MenuFilterService(),
    new GetMenuCommandValidator()
));
$app->run();