<?php
namespace Queries;

use Symfony\Component\Console\Command\Command;
// This is the base class which those 2 class will need the function to read the csv file

class BaseCommand extends Command
{

    public function readServices($filename)
    {
        // Read services from CSV file
        $services = [];
        $file = fopen($filename, 'r');
        fgetcsv($file);
        while (($row = fgetcsv($file)) !== false) {
            $services[] = [
                'Ref' => $row[0],
                'Centre' => $row[1],
                'Service' => $row[2],
                'Country' => $row[3],
            ];
        }
        fclose($file);
        return $services;
    }
}

?>