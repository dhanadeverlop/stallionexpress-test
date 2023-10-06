<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Property;

use Illuminate\Support\Facades\DB;

class DailyPropertyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-property-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update the properties to update existing properties and add new one';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //HTTP get to get response from server to get properties details
        $response = Http::get('https://trial.craig.mtcserver15.com/api/properties', [
            'api_key' => '3NLTTNlXsi6rBWl7nYGluOdkl2htFHug'
        ]);

        $result = json_decode($response->getBody(), true);

        //If data is present, update it or create new one into the property table
        if(count($result) > 0) {
            foreach($result['data'] as $res) {
                $flight = Property::updateOrCreate(
                    [
                        'uuid'=>$res['uuid'],
                        'property_type_id'=>$res['property_type_id'],
                        'county'=>$res['county'],
                        'country'=>$res['country'],
                        'town'=>$res['town'],
                        'postcode'=>"",
                        'description'=>$res['description'],
                        'address'=>$res['address'],
                        'image_full'=>$res['image_full'],
                        'image_thumbnail'=>$res['image_thumbnail'],
                        'latitude'=>$res['latitude'],
                        'longitude'=>$res['longitude'],
                        'num_bedrooms'=>$res['num_bedrooms'],
                        'num_bathrooms'=>$res['num_bathrooms'],
                        'type'=>$res['type'],
                        'property_type'=> json_encode($res['property_type'])
                    ]
                );
            }
        }
        Log::info($response);
        $this->info('Daily Update has been updated successfully');
    }
}
