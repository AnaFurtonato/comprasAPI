<?php
defined('BASEPATH') or exit ('No direct script access allowed');
function troca_caractere($value)
{
    $retorno = str_replace("'", "`", $value);
    return $retorno;
}


?>