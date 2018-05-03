<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Periodo_model extends CI_Model {

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
     * Método responsável por cadastrar / editar um periodo
     *
     * @method setPeriodo
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setPeriodo($valores)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $dados   = array();

        $dados['id_empresa_fk'] = $this->session->userdata('id_client');
        $dados['periodo']       = $valores->periodo;
        $dados['qtd_dia']       = $valores->qtd_dia;

        if (isset($valores->id) && $valores->id != ""):
            # Atualiza periodo
            $this->db->where('id_periodo_pk', $valores->id);
            $this->db->update('tb_periodo', $dados);

            if ($this->db->affected_rows() >= 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            # Grava periodo
            $this->db->insert('tb_periodo', $dados);

            if ($this->db->affected_rows() > 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Cadastro realizado com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            }
        endif;

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por pesquisar e buscar periodos
     *
     * @method getPeriodos
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de periodos
     */
    public function getPeriodos($search)
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
        $this->db->select('COUNT(id_periodo_pk) AS total');
        $this->db->from('tb_periodo');
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
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

        # Consultar periodos
        $this->db->select('id_periodo_pk, periodo, qtd_dia');
        $this->db->from('tb_periodo');
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $periods = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_period = $value->id_periodo_pk;
                $url_edit  = base_url('./periodo/editar/'.$id_period);
                $url_view  = base_url('./periodo/ver/'.$id_period);
                $acao      = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Per&iacute;odo' onclick='Periodo.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao     .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Per&iacute;odo' onclick='Periodo.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                $acao     .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Per&iacute;odo' onclick='Periodo.del(\"$id_period\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $period          = new stdClass();
                $period->periodo = $value->periodo;
                $period->qtd_dia = $value->qtd_dia;
                $period->acao    = $acao;
                $periods[]       = $period;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $periods;

        return $dados;
    }

    /**
     * Método de exclusão de um Periodo
     *
     * @method delPeriodo
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delPeriodo($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_periodo_pk', $id);
        $this->db->delete('tb_periodo');

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
}

/* End of file periodo_model.php */
/* Location: ./application/models/periodo_model.php */