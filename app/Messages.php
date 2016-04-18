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

class Messages
{
    CONST MSG_SAVE_SUCCESS = 'Registro salvo com sucesso!';
    CONST MSG_REMOVE_SUCCESS = 'Registro removido com sucesso!';
    CONST MSG_QUERY_SUCCESS = 'Consulta efetuada com sucesso!';
}
