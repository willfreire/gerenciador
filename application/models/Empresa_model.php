<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa_model extends CI_Model {

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
     * Método responsável por editar um empresa
     *
     * @method setEmpresa
     * @param obj $valores Dados para edicao
     * @access public
     * @return obj Status de ação
     */
    public function setEmpresa($valores)
    {
        # Atribuir vars
        $retorno   = new stdClass();
        $empresa   = array();
        $empr_log  = array();
        $end_empr  = array();
        $contato   = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

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

        if ($valores->alt_pwd == "1" && $valores->senha != ""):
            $empresa['senha'] = sha1($valores->senha);
        endif;

        # Atualiza empresa
        $this->db->where('id_empresa_pk', $valores->id);
        $this->db->update('tb_empresa', $empresa);

        if ($this->db->affected_rows() >= 0) {

            try {
                # Log Empresa
                $id_empr = $valores->id;
                $empr_log['id_acao_fk']        = 2;
                $empr_log['id_empresa_alt_fk'] = $this->session->userdata('id_client');
                $empr_log['id_empresa_fk']     = $id_empr;
                $empr_log['dt_hr']             = mdate($timestamp, $data);
                # Grava Empresa Log
                $this->db->insert('tb_empresa_log', $empr_log);

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

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por pesquisar e buscar empresas
     *
     * @method getEmpresas
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de empresas
     */
    public function getEmpresas($search)
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

        # Consultar empresas
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
        $empresas = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_client = $value->id_empresa_pk;
                $url_edit  = base_url('./empresa/editar/'.$id_client);
                $url_view  = base_url('./empresa/ver/'.$id_client);
                $acao      = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Empresa' onclick='Empresa.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao     .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Empresa' onclick='Empresa.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                if ($this->session->userdata('id_perfil_vt') == "1"):
                    $acao .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Empresa' onclick='Empresa.del(\"$id_client\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";
                endif;

                $empresa             = new stdClass();
                $empresa->cnpj       = $value->cnpj;
                $empresa->nome_razao = $value->nome_razao;
                $empresa->telefone   = $value->telefone;
                $empresa->email      = $value->email;
                $empresa->status     = $value->status;
                $empresa->acao       = $acao;
                $empresas[]          = $empresa;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $empresas;

        return $dados;
    }

    /**
     * Método de exclusão de um Empresa
     *
     * @method delEmpresa
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delEmpresa($id)
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

/* End of file empresa_model.php */
/* Location: ./application/models/empresa_model.php */