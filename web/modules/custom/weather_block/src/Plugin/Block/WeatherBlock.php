<?php 

namespace Drupal\weather_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;


/**
 * Provides a 'Weather Block' Block.
 * @Block(
 * id = "weather_block", 
 * admin_label = @Translation("Weather block"),
 * category = @Translation("Weather block"),
 * )
 */
class WeatherBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        return[
            '#markup' => $this->getWeather(),
            '#cache' => [
                'max-age' => 0,
            ],
        ];
    }

    /**
     * Private function for getting weather
     */
    private function getWeather(){
        $url = 'http://api.openweathermap.org/data/2.5/weather';

        $options = array(
            'q' => 'Lutsk',
            'APPID' => '4a7154eee026ffafb290d2741b70fb8c',
            'units' => 'metric',
            'lang' => 'en',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($options));

        $response = curl_exec($ch);
        $data = json_decode($response, true);
        curl_close($ch);

        function print_arr($arr){
            echo '<pre>' . print_r($arr, true) . ' </pre>';
        }

        foreach($data['main'] as $item => $value){
            if($item == 'temp'){
                print_arr('<b>' . 'Weather in Lutsk' . '</b>' . '<br>' . 'Temperature: ' .$value);
            }
            else if($item == 'temp_min') {
                print_arr('Minimal temperature: ' .$value);
            }
        }
        // print_arr($data['main']);

        // echo '<pre>';
        // print_r($data);
    }
}