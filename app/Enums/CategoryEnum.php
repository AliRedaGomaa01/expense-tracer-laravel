<?php 

namespace App\Enums;

class CategoryEnum {
    
    public static function toArray(){
        return [
            [ 'id' => 1, 'name' => 'Essentials & Regular' ],
            [ 'id' => 2, 'name' => ' Optional or Luxury Spending' ],
            ['id' => 3, 'name' => 'High-Cost & Not Repeated'],
        ];
    }
}