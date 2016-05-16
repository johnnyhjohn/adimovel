<?php  
namespace App\Http\Enum;

use MyCLabs\Enum\Enum;

class ImoveisEnum extends Enum {
    const __default = self::AMBOS;

    const LOCACAO 	= "LOC";
    const VENDA	 	= "VEN";
    const AMBOS	 	= "AMB";
}

?>