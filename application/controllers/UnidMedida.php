<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

class unidmedida  extends CI_Controller {

    public function inserir(){
        //Sigla e descrição
        //Recebidas via JSON e colocadas em variaveis
        //Retornos possiveis:
        //1 - Uniodade cadastrada corretamente (Banco)
        //2 - Faltou informar a sigla (FrontEnd)
        //3 - Quantidade de caracteres da sigla é superior a 3 (FrontEnd)
        //4 - Descrição não informada (FrontEnd)
        //5 - Usuario não informado(FrontEnd)
        //6 - Houve algum problema no insert da tabela (Banco)
        //7 - Houve problema no salvamento do LOG, mas a unidade foi inclusa (Log)
        //8 - Usuario invalido, digite apenas o ID 

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $sigla = $resultado->sigla;
        $descricao = $resultado->descricao;
        $usuario = $resultado->usuario;

        //Faremos uma validação para sabermos se todos os dados foram enviados corretamente
        if (trim($sigla) =='') {
            $retorno = array('codigo' => 2,
                            'msg' => 'Sigla não informada');
        }

        elseif(strlen(trim($sigla)) > 3){
            $retorno = array('codigo' => 3,
                            'msg' => 'Sigla pode conter no máximo 3 caracteres');
        }

        elseif (trim($descricao) == ''){
            $retorno = array('codigo' => 4,
                            'msg' => 'Descrição não informada');       
            }
        elseif 
            (trim ($usuario) == ''){
                    $retorno = array('codigo' => 5,
                                    'msg' => 'Usuário não informado');
            } 
        elseif 
            (is_string($usuario)){
                $retorno = array('codigo' => 8,
                                'msg' => 'Usuario invalido, digite apenas o ID');
        } 
        else {
                //Realizo a intancia da model
                $this->load->model('m_unidmedida');

                //Atributo $retorno recebe array com informação
                $retorno = $this->m_unidmedida->inserir($sigla,$descricao,$usuario);
            }

        //Retorno no formato JSON    
        echo json_encode($retorno);
    }



    public function consultar(){
        //Codigo, Sigla e descrição recebidas via JSON e colocadas em variaveis
        //Retornos possiveis:
        //1 - Dados consultados corretamente (Banco)
        //2 - Quantidade de caracteres da sigla é superior a 3 (FrontEnd)
        //6 - Dados não encontrados (Banco)
        

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $codigo = $resultado->codigo;
        $sigla = $resultado->sigla;
        $descricao = $resultado->descricao;

        //Verifica somente a quantidade de caracteres da sigla, pode ter até 3 caracteres ou nenhum para trazer todas as siglas
        if(strlen(trim($sigla)) > 3){
            $retorno = array('codigo' => 2,
                            'msg' => 'Sigla pode conter no máximo 3 caracteres ou nenhum para todos');       
        }
        else{
            //Realizo a intancia da model
            $this->load->model('m_unidmedida');

            //Atributo $retorno recebe array com informação da consulta de dados
            $retorno = $this->m_unidmedida->consultar($codigo,$sigla,$descricao);
        }
        
        //Retorno no formato JSON 
        echo json_encode($retorno);


    }



    public function alterar(){
        //Codigo, Sigla e descrição recebidas via JSON e colocadas em variaveis
        //Retornos possiveis:
        //1 - Dado(s) alterados corretamente (Banco)
        //2 - Faltou informar o codigo (FrontEnd)
        //3 - Quantidade de caracteres da sigla é superior a 3 (FrontEnd)
        //4 - Sigla ou Descrição não informada, ai não tem o que alterar (FrontEnd)
        //5 - Usuario não informado(FrontEnd)
        //6 - Dados não encontrados (Banco)
        //7 - Houve problema no salvamento do LOG, mas a unidade foi inclusa (Log)

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);
    
        $codigo = $resultado->codigo;
        $sigla = $resultado->sigla;
        $descricao = $resultado->descricao;
        $usuario = $resultado->usuario;
    
        //Faremos uma validação para sabermos se os dados forma enviados corretamente
        if(trim($codigo)==''){
          $retorno = array('codigo'=>2,
                          'msg'=> 'código não informado.');
        }
        elseif(strlen(trim($sigla))>3){
          $retorno = array('codigo'=>3,
                            'msg'=> 'Sigla pode conter no máximo 3 caracteres');
        }
        elseif(trim($descricao)== '' & trim($sigla)==''){
          $retorno = array('codigo'=>4,
                            'msg'=> 'Sigla e a descrição não foram informados');
        }
        elseif(trim($usuario == '')){
          $retorno = array('codigo'=>5,
                            'msg'=> 'Usuário não informado');
        }
        else{
          //Realizando a instancia da Model
          $this->load->model('m_unidmedida');

          //Atributo $retorno recebe array com informação da validade do acesso
          $retorno = $this->m_unidmedida->alterar($codigo,$sigla,$descricao,$usuario);
        }
        //Retorna no formato JSON
        echo json_encode($retorno);
    }
    
    
    
    
      public function desativar(){
        //Codigo da unidade recebido via JSON e colocadas em variaveis
        //Retornos possiveis:
        //1 - Unidade desativada corretamente (Banco)
        //2 - Codigo não informado (FrontEnd)
        //3 - Existe produtos cadastrados com essa unidade de medida
        //5 - Usuario não informado(FrontEnd)
        //6 - Dados não encontrados (Banco)
        //7 - Houve problema no salvamento do LOG, mas a unidade foi inclusa (Log)

        $json = file_get_contents('php://input');
        $resultado = json_decode($json);        
        $usuario = $resultado->usuario;

        $codigo = $resultado->codigo;
    
        //Validação para tipo de usuario que devera ser ADMINISTRADOR, COMUM ou VAZIO
        if(trim($codigo =='')){
          $retorno = array('codigo'=>2,
                            'msg'=> 'Código da unidade não informado.');
        }
        elseif(trim($usuario == '')){
            $retorno = array('codigo'=>5,
                              'msg'=> 'Usuário não informado');
        }
        else{
          //Realizando a instancia da Model
          $this->load->model('m_unidmedida');

           //Atributo $retorno recebe array com informação
          $retorno = $this-> m_unidmedida->desativar($codigo,$usuario);
        }
    
        //Retorna no formato JSON
        echo json_encode($retorno);   
    
    
      }

}
?>