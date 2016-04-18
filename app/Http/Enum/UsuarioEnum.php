<?php  
namespace App\Http\Enum;

use MyCLabs\Enum\Enum;

class UsuarioEnum extends Enum {
    const __default = self::CORRETOR;

    const ADMINISTRADOR 	= "ADM";
    const CORRETOR	 		= "COR";
}

?>