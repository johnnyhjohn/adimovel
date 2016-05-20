<?php  
namespace App\Http\Enum;

use MyCLabs\Enum\Enum;

class ImoveisEnum extends Enum {
    const __default = self::AMBOS;

    const AMBOS 		= "AMB";
    const LOCACAO	 	= "LOC";
    const VENDA	 		= "VEN";
}

?>