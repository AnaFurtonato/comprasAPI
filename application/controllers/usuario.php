<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class usuario  extends CI_Controller {

        public function inserir(){


            $json = file_get_contents('php://input');
            $resultado = json_decode($json);

            $usuario = $resultado->usuario;
            $senha = $resultado->senha;
            $nome = $resultado->nome;
            $tipo_usuario = strtoupper($resultado->tipo_usuario);
            $usu_sistema = strtoupper($resultado->usu_sistema);

            if (trim($usu_sistema) =='') {
                $retorno = array('codigo' => 7,
                'msg' => 'Usuário do sistema não informado');
            }
            elseif(trim($usuario) == ''){
                $retorno = array('codigo' => 2,
                                'msg' => 'Usuário não informado');
            } elseif (trim($senha) == ''){
                $retorno = array('codigo' => 3,
                                'msg' => 'senha não informado');       
                } elseif 
                    (trim($nome) == ''){
                        $retorno = array('codigo' => 4,
                                        'msg' => 'Nome não informado');
                } elseif ((trim($tipo_usuario) != 'ADMINISTRADOR' &&
                        trim($tipo_usuario) != 'COMUM'    ) ||
                        trim($tipo_usuario) == ''){
                            $retorno = array('codigo' => 5,
                                'msg' => 'Tipo de Usuário inválido');
                        } else {
                            $this->load->model('m_usuario');

                            $retorno = $this->m_usuario->inserir($usuario,$senha,$nome,$tipo_usuario,$usu_sistema);
                        }

                        echo json_encode($retorno);
    }

    public function consultar(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $usuario = $resultado->usuario;
        $nome = $resultado->nome;
        $tipo_usuario = strtoupper($resultado->tipo_usuario);

        
            if (trim($tipo_usuario) != 'ADMINISTRADOR' &&
                    trim($tipo_usuario) != 'COMUM'    &&
                    trim($tipo_usuario) != ''){

                        $retorno = array('codigo' => 5,
                            'msg' => 'Tipo de Usuário inválido');
                    } else {
                        $this->load->model('m_usuario');

                        $retorno = $this->m_usuario->consultar($usuario,$nome,$tipo_usuario);
                    }

                    echo json_encode($retorno);
    }


    public function alterar()
	{
		$json = file_get_contents('php://input');
		$resultado = json_decode($json);

		$usuario 		= $resultado->usuario;
		$senha  		= $resultado->senha;
		$nome  			= $resultado->nome;
		$tipo_usuario	= strtoupper($resultado->tipo_usuario);

		if (trim($usuario == '')) {
			$retorno = array(
				'codigo' => 2,
				'msg' => 'Usuário não Informado'
			);
		

		} elseif (trim($nome) == '' &&
				  trim($senha) == '' &&
				  trim($tipo_usuario) == '') {

			$retorno = array(
				'codigo' => 2,
				'msg' => 'Dados em branco, digite alguma coisa para alterar');
			
		}
		
		else{
			$this->load->model('m_usuario');	
			$retorno = $this->m_usuario->alterar($usuario, $nome, $senha, $tipo_usuario);
		}

		echo json_encode($retorno);
	}



    public function desativar(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
       
        $usuario = $resultado->usuario;


     if(trim($usuario == '')){
        $retorno = array('codigo' => 2,
                        'msg' => 'Usuario não informado'); 
        }else {
            $this->load->model('m_usuario');

            $retorno = $this->m_usuario->desativar($usuario);
        }
        echo json_encode($retorno);
    }
}

?>