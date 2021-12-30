<?php

namespace Drupal\exchange_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Exchange Block' Block.
 * @Block(
 * id = "exchange_block", 
 * admin_label = @Translation("Exchange block"),
 * category = @Translation("Exchange rate block"),
 * )
 */
class ExchangeBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        return[
            '#markup' => $this->getExchange(),
            '#cache' => [
                'max-age' => 0,
            ],
        ];
    }
    /**
     * Private function for getting exchange rate
     */
    private function getExchange(){
        $data = file_get_contents("https://api.privatbank.ua/p24api/pubinfo?exchange&json&coursid=11");
        $courses = json_decode($data, true);
        /**
         * Function for style output
         */
        function print_arr($arr) {
            echo '<pre> ' . print_r($arr, true) . ' </pre>';
        }

        foreach($courses as $course => $item){
            if($item['ccy'] == 'USD'){
                print_arr($item['ccy'] . '<br>' . 'Buy ' .round($item['buy'], 2) . '<br>' . 'Sale ' .round($item['sale'], 2));
            }
            else if($item['ccy'] == 'EUR') {
                print_arr($item['ccy'] . '<br>' . 'Buy ' .round($item['buy'], 2) . '<br>' . 'Sale ' .round($item['sale'], 2));
            }
        }
    }
}
