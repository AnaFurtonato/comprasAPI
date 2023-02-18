<?php
    defined('BASEPATH') or exit ('No direct script access allowed');

    class M_usuario extends CI_Model{
        
        public function inserir($usuario,$senha,$nome,$tipo_usuario,$usu_sistema){
            

            $sql = "insert into usuarios (usuario, senha, nome, tipo) values ('$usuario', md5('$senha'), '$nome', '$tipo_usuario')";

            $this->db->query($sql);

            if($this->db->affected_rows()>0){
                        $this->load->model('m_log');
            
                        $retorno_log = $this->m_log->inserir_log($usu_sistema, $sql);
            
            if ($retorno_log['codigo'] ==1) {
                                     $dados = array('codigo' =>1,
                                     'msg'=> 'Usuário cadastrado corretamente');
            
            }else{
                 $dados = array('codigo' =>8,
                 'msg'=> 'Houve algum problema no salvamento do Log, porém usuario foi cadastrado corretamente');
            }
        }else{
                $dados = array('codigo' => 6,
                                'msg' => 'Houve algum problema na inserção na tabela de usuários');
        }
                    return $dados;
    }
   

    public function consultar($usuario,$nome,$tipo_usuario){

            $sql = "select * from usuarios where estatus = '' ";

        if($usuario != ''){
            $sql = $sql . "and usuario = '$usuario' ";
        }

        if($tipo_usuario != ''){
            $sql = $sql . "and tipo = '$tipo_usuario' ";
        }

        if($nome != ''){
            $sql = $sql . "and nome like '%$nome%' ";
        }

        $retorno = $this->db->query($sql);

        if($retorno->num_rows() > 0){
            $dados = array('codigo' => 1,
                        'msg' => 'Consulta Efetuada com Sucesso',
                            'dados' => $retorno->result());
        } else {
            $dados = array('codigo' => 6,
                            'msg' => 'Dados não encontrados');
        }
        return $dados;
    }

    public function alterar($usuario, $nome, $senha, $tipo_usuario){

		//$this->db->query("update usuarios set nome = '$nome', senha = md5('$senha'), nome = '$nome', tipo = '$tipo_usuario' 
		//where usuario = '$usuario'");

		if($nome != ''){
			$this->db->query("UPDATE usuarios SET nome = '$nome' WHERE usuario = '$usuario'");

			$dados = array('Codigo' => 1, 
			'msg' => 'Nome atualizado corretamente');

		}elseif($senha != ''){
			$this->db->query("UPDATE usuarios SET senha = md5('$senha') WHERE usuario = '$usuario'");

			$dados = array('Codigo' => 1, 
			'msg' => 'Senha atualizado corretamente');

		}elseif($tipo_usuario != ''){
			$this->db->query("UPDATE usuarios SET tipo = '$tipo_usuario' WHERE usuario = '$usuario'");

			$dados = array('Codigo' => 1, 
			'msg' => 'Tipo Usuario atualizado corretamente');

		}else{
			$dados = array('Codigo' => 6,
			'msg' => 'Houve algum problema na atualização na tabela de usuários');
		}
		
		return $dados;
	}

     

    public function desativar($usuario){
        
            $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' and estatus != 'D'";

            $retorno = $this->db->query($sql);

            if($retorno->num_rows() > 0){

                $this->db->query("UPDATE usuarios SET estatus = 'D' WHERE usuario = '$usuario' and estatus != 'D' ");

                    if($this->db->affected_rows() > 0){
                                $dados = array('codigo' => 1,
                                            'msg' => 'Usuário Desativado corretamente ');
            
                    }else{
                            $dados = array('codigo' => 6,
                                            'msg' => "Houve algum problema na Desativação de usuários " );
                            }
                

            }else{
                $dados = array('codigo' => 7,
                                'msg' => "Usuário já desativado!" );
            }
                        
        return $dados;
    }
}
?>