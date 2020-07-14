<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateTxtFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a txt file from database';

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
        $countries = Country::get();
        foreach ($countries as $country){
            $countryStates = $country.$country->states;
            try {
                Storage::disk('sftp')->put('text_uploads/'.$country->name.'.txt', $country,);
            } catch (\Exception $th) {
                print $th->getMessage();
            }
            
        }
    }
}
