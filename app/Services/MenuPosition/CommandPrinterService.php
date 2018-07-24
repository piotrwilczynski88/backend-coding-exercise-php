<?php

namespace App\Services\MenuPosition;

use App\Models\Menu;
use Symfony\Component\Console\Output\OutputInterface;

class CommandPrinterService
{
    /**
     * @param Menu[]          $menus
     * @param OutputInterface $output
     */
    public function render(array $menus, OutputInterface $output): void
    {
        $output->writeln([
            '*** <info>Available menus</info> ****',
            '=========================',
        ]);
        if (empty($menus)) {
            $output->writeln('<info>No matching results for given query</info>');
        }
        foreach ($menus as $menu) {
            foreach ($menu->getMeals() as $meal) {
                $output->writeln($meal->getName() . ';' . implode(',', $meal->getAllergies()));
            }
        }
    }
}
