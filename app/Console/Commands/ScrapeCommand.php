<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use App\Models\Country;
use App\Models\State;

class ScrapeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scraper:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start scraper a page';

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
     * @return int
     */
    public function handle()
    {
        $states = [];
        $url = env('URL_SCRAPING');
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $crawler = $client->request('GET', $url);

        // Filtering States Name
        $crawler->filter('tr > th > div > div')->each(function ($node) use (&$states) {
            $states[] = $node->text();
        });
        array_splice($states, 0, 11);

        $data = [];
        $cases = [];
        $deaths = [];

        //Filtering data
        $crawler->filter('tr > td')->each(function ($node) use (&$data) {
            $data[] = $node->text();
        });
        array_splice($data, 0, 5);

        //Extract cases
        for ($i = 0; $i < count($data); $i += 5){
            $cases[] = str_replace(".", "", $data[$i]);
        }

        //Extract deaths
        for ($i = 4; $i < count($data); $i += 5){
            $deaths[] = str_replace(".", "", $data[$i]);
        }

        //Add in database
        $this->_handleDatabase($cases, $states, $deaths);
    }


    protected function _handleDatabase($cases, $states, $deaths){
        $country = Country::updateOrCreate(
            [
                'name' => $states[0]
            ],
            [
                'cases' => $cases[0],
                'deaths' => $deaths[0]
            ]
        );
        $country_id = $country->id;

        for ($i = 1; $i < count($cases); $i++){
            $state = State::updateOrCreate([
                'name' => $states[$i]
            ],
            [
                'cases' => $cases[$i],
                'deaths' => $deaths[$i],
                'country_id' => $country_id
            ]);
        }
    }
}
