<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    # Propriedades
    public $draw;
    public $orderBy;
    public $orderType;
    public $start;
    public $length;
    public $filter;
    public $columns;
    public $recordsTotal;
    public $recordsFiltered;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método responsável por cadastrar / editar um cliente
     *
     * @method setCliente
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setCliente($valores)
    {
        # Atribuir vars
        $retorno   = new stdClass();
        $empresa   = array();
        $empr_log  = array();
        $matriz    = array();
        $end_empr  = array();
        $contato   = array();
        $cond_com  = array();
        $cond_log  = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        $empresa['id_tipo_empresa_fk'] = $valores->tp_empresa;
        $empresa['cnpj']               = $valores->cnpj;
        $empresa['nome_razao']         = $valores->razao_social;
        $empresa['nome_fantasia']      = $valores->nome_fantasia;
        $empresa['inscr_estadual']     = $valores->insc_estadual;
        $empresa['inscr_municipal']    = $valores->inscr_municipal;
        $empresa['id_atividade_fk']    = $valores->atividade;
        $empresa['email']              = $valores->email;
        $empresa['email_adicional']    = $valores->email_adicional;
        $empresa['telefone']           = $valores->tel;
        $empresa['email_primario']     = $valores->email_primario;
        $empresa['email_secundario']   = $valores->email_secundario;
        $empresa['id_status_fk']       = $valores->status;

        if (isset($valores->id) && $valores->id != ""):
            if ($valores->alt_pwd == "1" && $valores->senha != ""):
                $empresa['senha'] = sha1($valores->senha);
            endif;
            # Atualiza cliente
            $this->db->where('id_empresa_pk', $valores->id);
            $this->db->update('tb_empresa', $empresa);

            if ($this->db->affected_rows() >= 0) {

                try {
                    # Log Empresa
                    $id_empr = $valores->id;
                    $empr_log['id_acao_fk']    = 2;
                    $empr_log['id_usuario_fk'] = $this->session->userdata('id_vt');
                    $empr_log['id_empresa_fk'] = $id_empr;
                    $empr_log['dt_hr']         = mdate($timestamp, $data);
                    # Grava Empresa Log
                    $this->db->insert('tb_empresa_log', $empr_log);

                    # Filial - Matriz
                    if ($valores->tp_empresa === "2") {
                        if ($valores->id_filial != NULL):
                            $matriz['id_empresa_matriz_fk'] = $valores->matriz;
                            $matriz['id_empresa_filial_fk'] = $id_empr;
                            # Atualizar Filial - Matriz
                            $this->db->where('id_empresa_filial_pk', $valores->id_filial);
                            $this->db->update('tb_empresa_filial', $matriz);
                        else:
                            $matriz['id_empresa_matriz_fk'] = $valores->matriz;
                            $matriz['id_empresa_filial_fk'] = $id_empr;
                            # Grava Filial - Matriz
                            $this->db->insert('tb_empresa_filial', $matriz);
                        endif;
                    }

                    # Endereco Empresa
                    $end_empr['id_tipo_endereco_fk'] = $valores->tp_endereco;
                    $end_empr['cep']                 = $valores->cep;
                    $end_empr['logradouro']          = $valores->endereco;
                    $end_empr['numero']              = $valores->numero;
                    $end_empr['complemento']         = $valores->complemento;
                    $end_empr['bairro']              = $valores->bairro;
                    $end_empr['id_cidade_fk']        = $valores->cidade;
                    $end_empr['id_estado_fk']        = $valores->estado;
                    $end_empr['resp_recebimento']    = $valores->resp_receb;
                    # Atualiza Endereco
                    $this->db->where('id_empresa_fk', $id_empr);
                    $this->db->update('tb_endereco_empresa', $end_empr);

                    # Contato Empresa
                    $contato['nome']               = $valores->nome_contato;
                    $contato['id_departamento_fk'] = $valores->depto;
                    $contato['id_cargo_fk']        = $valores->cargo;
                    $contato['sexo']               = $valores->sexo;
                    $contato['dt_nasc']            = is_array($valores->dt_nasc) ? $valores->dt_nasc[2].'-'.$valores->dt_nasc[1].'-'.$valores->dt_nasc[0] : NULL;
                    $contato['resp_compra']        = $valores->resp_compra;
                    $contato['email_principal']    = $valores->email_pri_contato;
                    $contato['email_adicional']    = $valores->email_sec_contato;
                    # Update Contato
                    $this->db->where('id_empresa_fk', $id_empr);
                    $this->db->update('tb_contato_empresa', $contato);

                    # Condicao Comercial
                    $cond_com['id_empresa_fk']  = $id_empr;
                    $cond_com['taxa_adm']       = $valores->taxa_adm;
                    $cond_com['taxa_entrega']   = str_replace(',', '.', str_replace('.', '', $valores->taxa_entrega));
                    $cond_com['taxa_fixa_perc'] = $valores->taxa_fixa_perc;
                    $cond_com['taxa_fixa_real'] = str_replace(',', '.', str_replace('.', '', $valores->taxa_fixa_real));
                    $cond_com['taxa_adm_cr']    = $valores->taxa_adm_cr;
                    $cond_com['taxa_adm_ca']    = $valores->taxa_adm_ca;
                    $cond_com['taxa_adm_cc']    = $valores->taxa_adm_cc;
                    # Update Condicao Comercial
                    $this->db->where('id_empresa_fk', $id_empr);
                    $this->db->update('tb_cond_comercial', $cond_com);

                    # Log Condicao Comercial
                    $id_cond                          = $valores->id_cond_com;
                    $cond_log['id_acao_fk']           = 2;
                    $cond_log['id_usuario_fk']        = $this->session->userdata('id_vt');
                    $cond_log['id_cond_comercial_fk'] = $id_cond;
                    $cond_log['dt_hr']                = mdate($timestamp, $data);
                    # Grava Condicao Comercial Log
                    $this->db->insert('tb_cond_comercial_log', $cond_log);

                    $retorno->status = TRUE;
                    $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
                } catch(Exception $e) {
                    # logging_function($e->getMessage());
                    $retorno->status = FALSE;
                    $retorno->msg    = "Houve um erro ao editar!";
                }

            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            # Empresa Senha
            $empresa['senha'] = sha1($valores->senha);

            # Grava Empresa
            $this->db->insert('tb_empresa', $empresa);

            if ($this->db->affected_rows() > 0) {

                try {
                    # Log Empresa
                    $id_empr = $this->db->insert_id();
                    $empr_log['id_acao_fk']    = 1;
                    $empr_log['id_usuario_fk'] = $this->session->userdata('id_vt');
                    $empr_log['id_empresa_fk'] = $id_empr;
                    $empr_log['dt_hr']         = mdate($timestamp, $data);
                    # Grava Empresa Log
                    $this->db->insert('tb_empresa_log', $empr_log);

                    # Filial - Matriz
                    if ($valores->tp_empresa == "2" && $valores->matriz != NULL):
                        $matriz['id_empresa_matriz_fk'] = $valores->matriz;
                        $matriz['id_empresa_filial_fk'] = $id_empr;
                        # Grava Filial - Matriz
                        $this->db->insert('tb_empresa_filial', $matriz);
                    endif;

                    # Endereco Empresa
                    $end_empr['id_empresa_fk']       = $id_empr;
                    $end_empr['id_tipo_endereco_fk'] = $valores->tp_endereco;
                    $end_empr['cep']                 = $valores->cep;
                    $end_empr['logradouro']          = $valores->endereco;
                    $end_empr['numero']              = $valores->numero;
                    $end_empr['complemento']         = $valores->complemento;
                    $end_empr['bairro']              = $valores->bairro;
                    $end_empr['id_cidade_fk']        = $valores->cidade;
                    $end_empr['id_estado_fk']        = $valores->estado;
                    $end_empr['resp_recebimento']    = $valores->resp_receb;
                    # Grava Endereco
                    $this->db->insert('tb_endereco_empresa', $end_empr);

                    # Contato Empresa
                    $contato['id_empresa_fk']      = $id_empr;
                    $contato['nome']               = $valores->nome_contato;
                    $contato['id_departamento_fk'] = $valores->depto;
                    $contato['id_cargo_fk']        = $valores->cargo;
                    $contato['sexo']               = $valores->sexo;
                    $contato['dt_nasc']            = is_array($valores->dt_nasc) ? $valores->dt_nasc[2].'-'.$valores->dt_nasc[1].'-'.$valores->dt_nasc[0] : NULL;
                    $contato['resp_compra']        = $valores->resp_compra;
                    $contato['email_principal']    = $valores->email_pri_contato;
                    $contato['email_adicional']    = $valores->email_sec_contato;
                    # Grava Contato
                    $this->db->insert('tb_contato_empresa', $contato);

                    # Condicao Comercial
                    $cond_com['id_empresa_fk']  = $id_empr;
                    $cond_com['taxa_adm']       = $valores->taxa_adm;
                    $cond_com['taxa_entrega']   = str_replace(',', '.', str_replace('.', '', $valores->taxa_entrega));
                    $cond_com['taxa_fixa_perc'] = $valores->taxa_fixa_perc;
                    $cond_com['taxa_fixa_real'] = str_replace(',', '.', str_replace('.', '', $valores->taxa_fixa_real));
                    $cond_com['taxa_adm_cr']    = $valores->taxa_adm_cr;
                    $cond_com['taxa_adm_ca']    = $valores->taxa_adm_ca;
                    $cond_com['taxa_adm_cc']    = $valores->taxa_adm_cc;
                    # Grava Condicao Comercial
                    $this->db->insert('tb_cond_comercial', $cond_com);

                    # Log Condicao Comercial
                    $id_cond = $this->db->insert_id();
                    $cond_log['id_acao_fk']           = 1;
                    $cond_log['id_usuario_fk']        = $this->session->userdata('id_vt');
                    $cond_log['id_cond_comercial_fk'] = $id_cond;
                    $cond_log['dt_hr']                = mdate($timestamp, $data);
                    # Grava Condicao Comercial Log
                    $this->db->insert('tb_cond_comercial_log', $cond_log);

                    $retorno->status = TRUE;
                    $retorno->msg    = "Cadastro realizado com Sucesso!";
                } catch(Exception $e) {
                    # logging_function($e->getMessage());
                    $retorno->status = FALSE;
                    $retorno->msg    = "Houve um erro ao cadastrar!";
                }

            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            }
        endif;

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por pesquisar e buscar clientes
     *
     * @method getClientes
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de clientes
     */
    public function getClientes($search)
    {
        # Atribuir valores
        $this->draw      = $search->draw;
        $this->orderBy   = $search->orderBy;
        $this->orderType = $search->orderType;
        $this->start     = $search->start;
        $this->length    = $search->length;
        $this->filter    = $search->filter;
        $this->columns   = $search->columns;
        $filter          = array();
        $where           = array();

        # Se houver busca pela grid
        if ($this->filter != NULL):
            for($i=0; $i<count($this->columns); $i++):
                if ($this->columns[$i]['searchable'] === "true"):
                    $column = $this->columns[$i]['data'];
                    $filter[]= "$column LIKE '%{$this->filter}%'";
                endif;
            endfor;
        endif;

        # Contar total de registros
        $this->db->select('COUNT(e.id_empresa_pk) AS total');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_status s', 'e.id_status_fk = s.id_status_pk');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $query            = $this->db->get();
        $respRecordsTotal = $query->result();
        if (!empty($respRecordsTotal)):
            $this->recordsTotal = $respRecordsTotal[0]->total;
        else:
            $this->recordsTotal = 0;
        endif;

        # Consultar clientes
        $this->db->select('e.id_empresa_pk, e.cnpj, e.nome_razao, e.telefone, e.email, s.status');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_status s', 'e.id_status_fk = s.id_status_pk');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $clientes = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_client = $value->id_empresa_pk;
                $url_edit  = base_url('./cliente/editar/'.$id_client);
                $url_view  = base_url('./cliente/ver/'.$id_client);
                $acao      = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Cliente' onclick='Cliente.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao     .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Cliente' onclick='Cliente.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                if ($this->session->userdata('id_perfil_vt') == "1"):
                    $acao .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Cliente' onclick='Cliente.del(\"$id_client\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";
                endif;

                $cliente             = new stdClass();
                $cliente->cnpj       = $value->cnpj;
                $cliente->nome_razao = $value->nome_razao;
                $cliente->telefone   = $value->telefone;
                $cliente->email      = $value->email;
                $cliente->status     = $value->status;
                $cliente->acao       = $acao;
                $clientes[]          = $cliente;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $clientes;

        return $dados;
    }

    /**
     * Método de exclusão de um Cliente
     *
     * @method delCliente
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delCliente($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_empresa_pk', $id);
        $this->db->delete(' tb_empresa');

        if ($this->db->affected_rows() > 0) {
            # Log Empresa
            $timestamp = "%Y-%m-%d %H:%i:%s";
            $data      = time();
            $empr_log  = array();

            $empr_log['id_acao_pk']    = 3;
            $empr_log['id_usuario_fk'] = $this->session->userdata('id_vt');
            $empr_log['id_empresa_fk'] = $id;
            $empr_log['dt_hr']         = mdate($timestamp, $data);
            # Grava Empresa Log
            $this->db->insert('tb_empresa_log', $empr_log);

            $retorno->status = TRUE;
            $retorno->msg    = "Exclus&atilde;o realizada com Sucesso!";
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Excluir! Tente novamente...";
        }

        # retornar
        return $retorno;
    }
}

/* End of file cliente_model.php */
/* Location: ./application/models/cliente_model.php */
