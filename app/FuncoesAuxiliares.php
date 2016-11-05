<?php

namespace App;

class FuncoesAuxiliares
{

  /**
   * Função retorno para formatar códigos e complementar com 0.
   * Exemplo:  0001
   * @param $cod Código para formatação.
   * @param $max Quantidade máxima de digitos.
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


    /**
    *
    *   @author Johnny
    *
    *   @description
    *   Método utilizado para fazer o upload das fotos, decodificando a string em base64
    *   Da imagem e criando uma imagem a partir da string e salvando no caminho do parametro
    *
    *   @param {String} $base64 String da base64 para ser decodificada
    *   @param {String} $name   Nome do caminho aonde a imagem vai ser salva
    *
    */
    public static function UploadImage( $base64, $name )
    {
           
        /**
        *
        *   Pega o request em base64 e decodifica, transformando em imagem a partir da string
        *   Usa o nome da pasta publica do Laravel com o titulo e ID do imovel, para nunca repetir
        *   Salva na pasta com resolução de 75% e depois destroi o objeto da imagem
        */
        $foto64     = explode(',', $base64);
        
        // Verifica se existe a posição 1 no array, o que indicará que é um base64
        if(array_key_exists(1, $foto64) ){

            $StringFoto = base64_decode($foto64[1]);    
            $source     = imagecreatefromstring($StringFoto);
            $imageSave  = imagejpeg($source, public_path().$name ,75);

            imagedestroy($source);  

            return true;
        } else{
            return false;
        }

    }
}
