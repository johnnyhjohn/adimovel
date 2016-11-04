<?php

namespace App;

class FuncoesAuxiliares
{

  /**
   * Função retorno para formatar códigos e complementar com 0.
   * Exemplo:  0001
   * @param $cod Código para formatação.
   * @param $max Quantidade máximade digitos.
   */
  public static function formataDigitos($cod,$max){
    
      $zeros = '';
      $x = ($max - strlen($cod));
      
      for($i = 0; $i < $x; $i++)
      {
          $zeros .= '0';
      }
      
      return $zeros.$cod;
  }

}
