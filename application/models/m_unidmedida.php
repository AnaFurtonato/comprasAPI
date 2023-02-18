<?php
    defined('BASEPATH') or exit ('No direct script access allowed');

    class m_unidmedida extends CI_Model{


        public function inserir($sigla, $descricao, $usuario){
            //Query de inserção dos dados
            $sql = "INSERT INTO unid_medida (sigla, descricao, usucria)
                    values ('$sigla', '$descricao', '$usuario')";

            $this->db->query($sql);

            //Verificando se a inserção ocorreu com sucesso
            if($this->db->affected_rows() > 0){
                //Fazendo a inserção no log na nuvem
                //Fazendo a inserção da model M_log
                $this->load->model('m_log');

                //Fazendo a chamada do método de inserção do log
                $retorno_log = $this->m_log->inserir_log($usuario, $sql);


                if($retorno_log['codigo'] == 1) {
                    $dados = array('codigo' => 1,
                                    'msg' => 'Unidade de medida cadastrada corretamente');
                }else{
                    $dados = array('codigo'=>7,
                                    'msg'=> 'Houve algum problema no slavamento do Log,  porém Unidade de Medida cadastrada corretamente');
                }
            }

            else{
                $dados = array('codigo'=>6,
                                'msg'=> 'Houve algum problema na inserção na tabela de unidade de medida');
            }

            //Enviando o array $dados com as informações tratadas acima pela estrutura de decisão if
            return $dados;
        
        }


        public function consultar($codigo, $sigla, $descricao){
            //---------------------------------------------------
            //Função que servirá para quatro tipos de consultas:
            // * Para todos as unidades de medida;
            // * Para uma determinada sigla de unidade;
            // * Para um codigo de unidade de medida;
            // * Para descrição da unidade de medida;
            //----------------------------------------------------

            //Query para consultar dados de acordo com parametros passados
            $sql = "select * from unid_medida where estatus = '' ";

            if($codigo != '' && $codigo != 0){
                $sql = $sql. "and cod_unidade = '$codigo'";
            }
            if($sigla != ''){
                $sql = $sql. "and sigla = '$sigla'";
            }
            if($descricao != ''){
                $sql = $sql . "and descricao like '%descricao%' ";
            }
            $retorno = $this->db->query($sql);

            //Verificando se a consulta ocorreu com sucesso
            if($retorno-> num_rows()>0){
                $dados = array('codigo'=> 1,
                                'msg'=>'Consulta efetuada com sucesso',
                                'dados' => $retorno->result());
            }
            else{
                $dados = array('codigo'=> 6,
                                'msg'=>'Dados não encontrados');
            }

            //Envia o array $dados com as informações tratadas acimas pela estrutura de decisão if
            return $dados;
        }

        public function alterar($codigo, $sigla, $descricao, $usuario){

            //Query de atualização dos dados
            if(trim($sigla)!= '' && trim($descricao)!=''){
                $sql = "UPDATE unid_medida set sigla = '$sigla', descricao = '$descricao'  
                        where cod_unidade = $codigo";
            }
            elseif(trim($sigla)!= ''){
                $sql = "UPDATE unid_medida set sigla = '$sigla' where cod_unidade = $codigo";
            }
            else{
                $sql = "UPDATE unid_medida set descricao = '$descricao' where cod_unidade = $codigo";
            }

            $this->db->query($sql);

            //Verifica se a atualização ocorreu com sucesso
            if($this->db->affected_rows()>0){
                //Fazendo a instancia no Log na nuvem
                //Fazendo a instancia da model M_Log
                $this->load->model('m_log');

                //Fazemos a chamada do método de instancia do Log
                $retorno_log = $this->m_log->inserir_log($usuario,$sql);
                
                if($retorno_log['codigo']==1){
                    $dados = array ('codigo'=>1,
                                    'msg' => 'Unidade de medida atualizada corretamente');
                }
                else{
                    $dados = array ('codigo'=>7,
                                    'msg' => 'Houve algum problema no salvamento do Log, porém, unidade de medida cadastrada corretamente');
                }

            }else{
                $dados = array ('codigo'=>6,
                                'msg' => 'Houve algum problema na atualização na tabela de unidade de medida');
            }

            //Enviando o array $dados com as informações tratadas acima pela estrutura de decisão if
            return $dados;

        }

        public function desativar($codigo, $usuario){
            //Há necessidade de verificar se existe algum produto com essa unidade de medida já cadastrada, se tiver não podemos desativar essa unidade
            $sql = "SELECT * from produtos where unid_medida = $codigo and estatus = '' ";
            
            $retorno = $this->db->query($sql);

            //Verificando se a consulta trouxe algum produto
            if($retorno->num_rows()>0){
                //Não posso fazer a desativação
                $dados = array('codigo'=>3,
                                'msg'=>'Não podemos desativar, existem produtos com essa unidade de medida cadastrado(s)');
            }else{
                //Query de atualização dos dados
                $sql2 = "UPDATE unid_medida set estatus = 'D' where cod_unidade = $codigo";
            
                $this->db->query($sql2);

                //Verifica se a atualização ocorreu com sucesso
                if($this->db->affected_rows()>0){
                    //Fazendo a instancia no Log na nuvem
                    //Fazendo a instancia da model M_Log
                    $this->load->model('m_log');

                    //Fazemos a chamada do método de instancia do Log
                    $retorno_log = $this->m_log->inserir_log($usuario, $sql2);
                    
                    if($retorno_log['codigo'] == 1){
                        $dados = array('codigo' => 1,
                                        'msg' => 'Unidade de medida DESATIVADA corretamente');
                    }
                    else{
                        $dados = array('codigo' => 8,
                                        'msg' => 'Houve algum problema no salvamento do Log, porém , unidade de medida cadastrada corretamente');
                    }
                }else{
                    $dados = array('codigo' => 1,
                                    'msg' => 'Houve algum problema na DESATIVAÇÃO na tabela de unidade de medida');
                }
            }
            //Enviando o array $dados com as informações tratadas acima pela estrutura de decisão if
            return $dados;
        }

}
?>