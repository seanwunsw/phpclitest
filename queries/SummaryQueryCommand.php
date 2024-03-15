<?php
namespace Queries;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SummaryQueryCommand extends BaseCommand
{
    protected static $defaultName = 'services:summary';

    //basic setting for this command
    protected function configure()
    {
        $this
        ->setName('printsummary')
        ->setDescription('Display summary of services by country')
        ->setHelp('This allow you to get list of services from your selected country')
        ->addArgument('filename', InputArgument::REQUIRED, 'Path to the CSV file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $services = $input->getArgument('filename');
        $countrySummary = $this->readServices($services);
        $io = new SymfonyStyle($input, $output);
        $io->title("Summary:");

        // Normalize country codes to uppercase for case-insensitive counting
        $normalizedCountryCodes = array_map('strtoupper', array_column($countrySummary, 'Country'));

        // Count the number of services for each country
        $serviceCountByCountry = array_count_values($normalizedCountryCodes);
        $tableRows = [];
        foreach ($serviceCountByCountry as $country => $count) {
            $tableRows[] = [$country, $count];
        }

        $io->table(['Country', 'Total Services'], $tableRows);

        return Command::SUCCESS;
    }

   

}
?>