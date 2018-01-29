<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ocorrencia_model extends CI_Model {

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
     * Método responsável por cadastrar / editar uma ocorrencia
     *
     * @method setOcorrencia
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setOcorrencia($valores)
    {
        # Atribuir vars
        $retorno   = new stdClass();
        $dados     = array();
        $log       = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        $dados['id_funcionario_fk']    = $valores->func;
        $dados['id_cliente_fk']        = $this->session->userdata('id_client');
        $dados['id_motivo_fk']         = $valores->motivo;
        $dados['descricao']            = trim($valores->descricao);
        $dados['email_retorno']        = trim($valores->email);
        $dados['id_status_ocorren_fk'] = 1;
        $dados['dt_hr_cad']            = mdate($timestamp, $data);
        $dados['viewed']               = 'n';

        if (isset($valores->id) && $valores->id != ""):
            # Atualiza ocorrencia
            $this->db->where('id_ocorrencia_pk', $valores->id);
            $this->db->update('tb_ocorrencia', $dados);

            if ($this->db->affected_rows() >= 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            # Grava ocorrencia
            $this->db->insert('tb_ocorrencia', $dados);

            if ($this->db->affected_rows() > 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Cadastro realizado com Sucesso!";

                # Gravar log
                $last_id                     = $this->db->insert_id();
                $log['id_ocorrencia_fk']     = $last_id;
                $log['id_status_ocorren_fk'] = 1;
                $log['id_usuario_acao_fk']   = $this->session->userdata('id_client');
                $log['dt_hr_ocorr']          = mdate($timestamp, $data);
                $this->db->insert('tb_ocorrencia_log', $log);
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            }
        endif;

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por pesquisar e buscar ocorrencias
     *
     * @method getOcorrencias
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de ocorrencias
     */
    public function getOcorrencias($search)
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
        $this->db->select('COUNT(o.id_ocorrencia_pk) AS total');
        $this->db->from('tb_ocorrencia o');
        $this->db->join('tb_funcionario f', 'f.id_funcionario_pk = o.id_funcionario_fk', 'inner');
        $this->db->join('tb_empresa e', 'e.id_empresa_pk = o.id_cliente_fk', 'inner');
        $this->db->join('tb_ocorr_motivo om', 'om.id_ocorr_motivo_pk = o.id_motivo_fk', 'inner');
        $this->db->join('tb_ocorr_status os', 'os.id_ocorr_status_pk = o.id_status_ocorren_fk', 'inner');
        if ($this->session->userdata('id_client')):
            $this->db->where('o.id_cliente_fk', $this->session->userdata('id_client'));
        endif;

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

        # Consultar ocorrencias
        $this->db->select('o.id_ocorrencia_pk, f.nome, f.cpf, om.ocorr_motivo, o.descricao, o.email_retorno, 
                           os.ocorr_status, o.id_status_ocorren_fk, o.dt_hr_cad, e.cnpj, e.nome_razao');
        $this->db->from('tb_ocorrencia o');
        $this->db->join('tb_funcionario f', 'f.id_funcionario_pk = o.id_funcionario_fk', 'inner');
        $this->db->join('tb_empresa e', 'e.id_empresa_pk = o.id_cliente_fk', 'inner');
        $this->db->join('tb_ocorr_motivo om', 'om.id_ocorr_motivo_pk = o.id_motivo_fk', 'inner');
        $this->db->join('tb_ocorr_status os', 'os.id_ocorr_status_pk = o.id_status_ocorren_fk', 'inner');
        if ($this->session->userdata('id_client')):
            $this->db->where('o.id_cliente_fk', $this->session->userdata('id_client'));
        endif;

        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $ocorrens = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_ocorr  = $value->id_ocorrencia_pk;
                $id_status = $value->id_status_ocorren_fk;
                # $url_edit  = base_url('./ocorrencia/editar/'.$id_ocorr);
                $url_view  = base_url('./ocorrencia/ver/'.$id_ocorr);
                # $acao      = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Ocorr&ecirc;ncia' onclick='Ocorrencia.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao  = "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Ocorr&ecirc;ncia' onclick='Ocorrencia.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                if ($this->session->userdata('id_vt')):
                    $acao .= "<button type='button' class='btn btn-warning btn-xs btn-acao' title='Editar Status da Ocorr&ecirc;ncia' onclick='Ocorrencia.alterStatus(\"$id_ocorr\", \"$id_status\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                endif;
                $acao .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Ocorr&ecirc;ncia' onclick='Ocorrencia.del(\"$id_ocorr\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $ocorren                   = new stdClass();
                $ocorren->id_ocorrencia_pk = $value->id_ocorrencia_pk;
                $ocorren->dt_hr_cad        = date('d/m/Y', strtotime($value->dt_hr_cad));
                $ocorren->nome_razao       = $value->nome_razao.' - CNPJ: '.$value->cnpj;
                $ocorren->nome             = $value->nome;
                $ocorren->ocorr_motivo     = $value->ocorr_motivo;
                $ocorren->email_retorno    = $value->email_retorno;
                $ocorren->ocorr_status     = $value->ocorr_status;
                $ocorren->acao             = $acao;
                $ocorrens[]                = $ocorren;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $ocorrens;

        return $dados;
    }

    /**
     * Método de exclusão de uma Ocorrencia
     *
     * @method delOcorrencia
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delOcorrencia($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_ocorrencia_pk', $id);
        $this->db->delete('tb_ocorrencia');

        if ($this->db->affected_rows() > 0) {
            $retorno->status = TRUE;
            $retorno->msg    = "Exclus&atilde;o realizada com Sucesso!";
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Excluir! Tente novamente...";
        }

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por cadastrar a resposta da ocorrencia
     *
     * @method setRespOcorrencia
     * @param obj $valores Dados para cadastro
     * @access public
     * @return obj Status de ação
     */
    public function setRespOcorrencia($valores)
    {
        # Atribuir vars
        $retorno   = new stdClass();
        $dados     = array();
        $log       = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        $dados['id_ocorrencia_fk'] = $valores->codigo;
        if (!empty($this->session->userdata('id_vt'))):
            $dados['id_usuario_fk'] = $this->session->userdata('id_vt');
        elseif (!empty($this->session->userdata('id_client'))):
            $dados['id_cliente_fk'] = $this->session->userdata('id_client');
        endif;
        $dados['resposta']   = trim($valores->resp);
        $dados['dt_hr_resp'] = mdate($timestamp, $data);

        # Grava ocorrencia
        $this->db->insert('tb_ocorrencia_resp', $dados);

        if ($this->db->affected_rows() > 0) {
            $retorno->status = TRUE;
            $retorno->msg    = "Mensagem Enviada com Sucesso!";
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar sua Mensagem! Tente novamente...";
        }

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por alterar o status de uma ocorrencia
     *
     * @method alterStOcorrencia
     * @access public
     * @param obj $status Dados para alteraçao
     * @return obj Status da Acao
     */
    public function alterStOcorrencia($status)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $dados   = array();
        $ocorren = array();

        # Alterar Status no tb_ocorrencia
        $ocorren['id_status_ocorren_fk'] = $status->id_status;
        $this->db->where('id_ocorrencia_pk', $status->id_ocorr);
        $this->db->update('tb_ocorrencia', $ocorren);

        if ($this->db->affected_rows() > 0) {
            # Timestamp
            $timestamp = "%Y-%m-%d %H:%i:%s";
            $data      = time();

            # Campos
            $dados['id_ocorrencia_fk']     = $status->id_ocorr;
            $dados['id_status_ocorren_fk'] = $status->id_status;
            $dados['id_usuario_acao_fk']   = $status->id_user;
            $dados['dt_hr_ocorr']          = mdate($timestamp, $data);

            # Grava dados
            $this->db->insert('tb_ocorrencia_log', $dados);

            $retorno->status = TRUE;
            $retorno->msg    = "Status Alterado com Sucesso!";
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Status n&atilde;o Alterado!";
        }

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por buscar todas as respostas de uma ocorrencia
     *
     * @method getRespostas
     * @access public
     * @param int $id Id da ocorrencia
     * @return obj Dados das repostas
     */
    public function getRespostas($id)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $dados   = array();

        # Consulta
        $this->db->select("r.id_ocorr_resp_pk, r.id_ocorrencia_fk, r.id_usuario_fk, r.id_cliente_fk, r.resposta,
                           DATE_FORMAT(r.dt_hr_resp, '%d/%m/%Y %H:%i\h') AS dt_hr, u.nome, e.cnpj, e.nome_razao", TRUE);
        $this->db->from('tb_ocorrencia_resp r');
        $this->db->join('tb_usuario u', 'u.id_usuario_pk = r.id_usuario_fk', 'left');
        $this->db->join('tb_empresa e', 'e.id_empresa_pk = r.id_cliente_fk', 'left');
        $this->db->where('r.id_ocorrencia_fk', $id);
        $rows = $this->db->get()->result();

        if (!empty($rows)) {
            $retorno->status = TRUE;
            $retorno->msg    = "Ok!";
            $retorno->dados  = $rows;
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Nenhuma Mensagem Encontrada!";
        }

        # retornar
        return $retorno;
    }

}

/* End of file ocorrencia_model.php */
/* Location: ./application/models/ocorrencia_model.php */