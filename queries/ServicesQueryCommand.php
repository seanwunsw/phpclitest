<?php
namespace Queries;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ServicesQueryCommand extends BaseCommand
{
    protected static $defaultName = 'services:query';
    
    //basic setting for this command
    protected function configure()
    {
        $this->setName('servicebycountry')
             ->setDescription('Query services by country code and display summary')
             ->addArgument('filename', InputArgument::REQUIRED, 'Path to the CSV file')
             ->addArgument('country', InputArgument::REQUIRED, 'Country code to filter services');
    }

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $filename = $input->getArgument('filename');
        $countryCode = strtoupper($input->getArgument('country'));
        $services = $this->readServices($filename);
        
        $io = new SymfonyStyle($input, $output);
        

        // Filter services by country code
        $filteredServices = array_filter($services, function ($service) use ($countryCode) {
            return strtoupper($service['Country']) === $countryCode;
        });

        // Display filtered services
        if (!empty($filteredServices)) {
            $io->title("Services provided by $countryCode:");
        
            $tableRows = [];
            foreach ($filteredServices as $service) {
                $tableRows[] = [$service['Ref'], $service['Service'], $service['Centre']];
            }
        
            $io->table(['Ref', 'Service', 'Centre'], $tableRows);
        } else {
            $io->warning("No services found for $countryCode.");
        }

        return Command::SUCCESS;
    }

}

