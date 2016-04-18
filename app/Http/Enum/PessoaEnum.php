<?php  
namespace App\Http\Enum;

use MyCLabs\Enum\Enum;

class PessoaEnum extends Enum {
    const __default = self::PROPRIETARIO;

    const PROPRIETARIO 	= "PRO";
    const INQUILINO	 	= "INQ";
}

?>