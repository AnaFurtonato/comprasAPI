<?php

defined('BASEPATH') or exit ('No direct script acess allowed');

class m_acesso extends CI_Model {

    public function validalogin($usuario, $senha){

        $retorno = $this->db->query("SELECT * FROM usuarios WHERE usuario = '$usuario' and estatus = ''");

        if ($retorno-> num_rows() > 0) {
               
            if ($retorno->row()->senha != md5($senha)){
                $dados = array('codigo' => 4,
                                'msg' => 'Senha incorreta');
            }
            
            else{
                $dados = array('codigo' => 1,
                                'msg' => 'Logado com sucesso. Usuário e senha estão corretos.');
            }
            
        }
        else{
            $dados = array('codigo' => 5,
                            'msg' => 'Nome de usuario incorreto');
        }

        
        return $dados;

    }
    
}

?>