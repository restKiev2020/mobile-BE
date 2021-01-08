<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Region;
use App\Models\Street;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;

class ImportTitlesFromCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $stdin = fopen('php://stdin', 'r');
        $progress = new ProgressBar($this->output, 344495);
        $header = fgetcsv($stdin, 1000, ",");
        $progress->start();
        $num = 0;
        $tempRegion = '';
        $tempCity = '';
        $regionId = 0;
        while (($data = fgetcsv($stdin, 1000, ",")) !== FALSE) {
            $num++;
            $currentCity = $data[4];
            $currentRegion = $data[0];
            if ($tempCity && $tempCity == $currentCity) {
                $progress->advance();
                continue;
            }
            $tempCity = $currentCity;
            $city = City::where('name', $tempCity)->first();
            if ($city) {
                continue;
            }

            if (!$tempRegion || $tempRegion != $currentRegion) {
                $region = Region::where('name', $currentRegion)->first();
                if (!$region) {
                    $region = new Region();
                    $region->name = $currentRegion;
                    $region->save();
                }
                $regionId = $region->id;
            }
            $tempRegion = $currentRegion;

            $city = new City();
            $city->name = $currentCity;
            $city->region_id = $regionId;
            $city->save();

            $progress->advance();
        }

        echo $num;

        fclose($stdin);
        $progress->finish();

        return 0;
    }
}
