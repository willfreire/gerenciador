<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fornecedor_model extends CI_Model {

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
     * Método responsável por cadastrar / editar um fornecedor
     *
     * @method setFornecedor
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setFornecedor($valores)
    {
        # Atribuir vars
        $retorno   = new stdClass();
        $dados     = array();

        $dados['fornecedor']   = $valores->nome;
        $dados['id_status_fk'] = $valores->status;

        if (isset($valores->id) && $valores->id != ""):
            # Atualiza fornecedor
            $this->db->where('id_fornecedor_pk', $valores->id);
            $this->db->update('tb_fornecedor', $dados);

            if ($this->db->affected_rows() >= 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            # Grava fornecedor
            $this->db->insert('tb_fornecedor', $dados);

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
     * Método responsável por pesquisar e buscar fornecedors
     *
     * @method getFornecedors
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de fornecedors
     */
    public function getFornecedors($search)
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
        $this->db->select('COUNT(f.id_fornecedor_pk) AS total');
        $this->db->from('tb_fornecedor f');
        $this->db->join('tb_status s', 'f.id_status_fk = s.id_status_pk', 'inner');
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

        # Consultar fornecedors
        $this->db->select('f.id_fornecedor_pk, f.fornecedor, s.status');
        $this->db->from('tb_fornecedor f');
        $this->db->join('tb_status s', 'f.id_status_fk = s.id_status_pk', 'inner');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $fornecs = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_fornec = $value->id_fornecedor_pk;
                $url_edit  = base_url('./fornecedor/editar/'.$id_fornec);
                $url_view  = base_url('./fornecedor/ver/'.$id_fornec);
                $acao      = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Fornecedor' onclick='Fornecedor.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao     .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Fornecedor' onclick='Fornecedor.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                $acao     .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Fornecedor' onclick='Fornecedor.del(\"$id_fornec\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $fornec             = new stdClass();
                $fornec->fornecedor = $value->fornecedor;
                $fornec->status     = $value->status;
                $fornec->acao       = $acao;
                $fornecs[]          = $fornec;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $fornecs;

        return $dados;
    }

    /**
     * Método de exclusão de um Fornecedor
     *
     * @method delFornecedor
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delFornecedor($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_fornecedor_pk', $id);
        $this->db->delete('tb_fornecedor');

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

/* End of file fornecedor_model.php */
/* Location: ./application/models/fornecedor_model.php */