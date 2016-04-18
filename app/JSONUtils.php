<?php

namespace App;

/**
 * Classe utilitaria (HELPER) para tratar os objetos de retorno para
 * as chamadas REST
 *
 * @author tormen <mentux@gmail.com>
 *
 * **OBS** Helpers no Laravel não devem ser tratados como classes comuns,
 *         para tanto, este exemplo tem somente cunho didático, não seguindo
 *         as boas práticas de registro de classes Helpers para o framework.
 */
class JSONUtils
{

  /**
   * Método privado que concentra todas as chamadas para a composição
   * dos objetos de retorno, construindo o mesmo e retornando-o em um JSON.
   * @param $codigo Código do retorno.
   * @param $mensagem Mensagem do retorno.
   * @param $objeto Objeto para o retorno.
   */
  private static function returnGeneral($codigo, $mensagem, $objeto){
    return response()->json([
      new ObjetoRetorno($codigo,
        ($mensagem ? $mensagem : NULL),
        ($objeto ? $objeto : NULL )
      )
    ]);
  }

  /**
   * Método responsável por prover um objeto de retorno do tipo SUCCESS
   * @param $mensagem Mensagem do retorno.
   * @param $objeto Objeto para o retorno.
   */
  public static function returnSuccess($mensagem,$objeto){
    return self::returnGeneral(ObjetoRetorno::SUCCESS, $mensagem, $objeto);
  }

  /**
   * Método responsável por prover um objeto de retorno do tipo DANGER
   * @param $mensagem Mensagem do retorno.
   * @param $objeto Objeto para o retorno.
   */
  public static function returnDanger($mensagem,$objeto){
    return self::returnGeneral(ObjetoRetorno::DANGER, $mensagem, $objeto);
  }

  /**
   * Método responsável por prover um objeto de retorno do tipo WARNING
   * @param $mensagem Mensagem do retorno.
   * @param $objeto Objeto para o retorno.
   */
  public static function returnWarning($mensagem,$objeto){
    return self::returnGeneral(ObjetoRetorno::WARNING, $mensagem, $objeto);
  }
}
