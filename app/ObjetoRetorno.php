<?php

namespace App;

/**
 * Classe utilitaria (HELPER) do objeto de retorno para as chamadas REST
 *
 * @author tormen <mentux@gmail.com>
 *
 * **OBS** Helpers no Laravel não devem ser tratados como classes comuns,
 *         para tanto, este exemplo tem somente cunho didático, não seguindo
 *         as boas práticas de registro de classes Helpers para o framework.
 */

class ObjetoRetorno
{
    //Constante para requisições efetuadas com sucesso.
    CONST SUCCESS = 'SUCCESS';
    //Constante para requisições efetuadas com advertências.
    CONST WARNING = 'WARNING';
    //Constante para requisições efetuadas com problemas.
    CONST DANGER = 'DANGER';

    //Código do retorno
    public $codigo;
    //Mensagem de retorno
    public $mensagem;
    //Objeto de retorno caso necessário
    public $objeto;

    /**
     * Método construtor para a criação do objeto contendo
     * os atributos necessários.
     * @param $codigo Código do retorno.
     * @param $mensagem Mensagem do retorno.
     * @param $objeto Objeto para o retorno.
     */
    public function __construct($codigo, $mensagem, $objeto){
      $this->codigo = $codigo;
      $this->mensagem = $mensagem;
      $this->objeto = $objeto;
    }
}
