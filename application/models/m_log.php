<?php
    defined('BASEPATH') or exit ('No direct script access allowed');

    class M_log extends CI_Model{

        public function inserir_log($usuario, $comando){

            $dblog = $this->load->database('log', TRUE);
        
            $comando = troca_caractere($comando);

            $dblog->query("insert into log(usuario, comando) values ('$usuario','$comando')");

            if($dblog->affected_rows() > 0 ){
                $dados = array('codigo'=> 1,
                'msg'=> 'Log cadastrado corretamente'
              
            );
        }
            else{
                $dados = array('codigo'=>6,
                'msg'=> 'Houve algum problema na inserção do log'
              
            );

        }
            $dblog->close();

            return $dados;
        }
       
    }

?>