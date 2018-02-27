<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Beneficio_model extends CI_Model {

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
     * Método responsável por cadastrar / editar uma beneficio
     *
     * @method setBeneficio
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setBeneficio($valores)
    {
        # Atribuir vars
        $retorno  = new stdClass();
        $dados    = array();
        $ben_func = array();

        $dados['id_grupo_fk']      = $valores->grupo;
        $dados['descricao']        = $valores->descricao;
        $dados['vl_unitario']      = str_replace(',', '.', str_replace('.', '', $valores->vl_unitario));
        $dados['id_modalidade_fk'] = $valores->modalidade;
        $dados['vl_rep_func']      = str_replace(',', '.', str_replace('.', '', $valores->vl_rep_func));
        if ($valores->vl_repasse):
            $dados['vl_repasse'] = $valores->vl_repasse;
        endif;
        $dados['id_status_fk']     = $valores->status;

        if (isset($valores->id) && $valores->id != ""):
            # Atualiza beneficio
            $this->db->where('id_item_beneficio_pk', $valores->id);
            $this->db->update('tb_item_beneficio', $dados);

            if ($this->db->affected_rows() >= 0) {
                # Atualizar valor do beneficio dos funcionarios
                $ben_func['vl_unitario'] = str_replace(',', '.', str_replace('.', '', $valores->vl_unitario));
                $this->db->where('id_item_beneficio_fk', $valores->id);
                $this->db->update('tb_beneficio', $ben_func);

                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            # Grava beneficio
            $this->db->insert('tb_item_beneficio', $dados);

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
     * Método responsável por pesquisar e buscar Beneficios
     *
     * @method getBeneficios
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de beneficios
     */
    public function getBeneficios($search)
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
        $this->db->select('COUNT(id_item_beneficio_pk) AS total');
        $this->db->from('vw_beneficio');
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

        # Consultar prospeccoes
        $this->db->select("id_item_beneficio_pk, grupo, descricao, vl_unitario, modalidade, status");
        $this->db->from('vw_beneficio');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $beneficios = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_benef = $value->id_item_beneficio_pk;
                $url_edit   = base_url('./beneficio/editar/'.$id_benef);
                $url_view   = base_url('./beneficio/ver/'.$id_benef);
                $acao       = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Benef&iacute;cio' onclick='Beneficio.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao      .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Benef&iacute;cio' onclick='Beneficio.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                if ($this->session->userdata('id_perfil_vt') == "1"):
                    $acao.= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Benef&iacute;cio' onclick='Beneficio.del(\"$id_benef\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";
                endif;

                $valor_unid = isset($value->vl_unitario) && $value->vl_unitario != "0.00" ? "R\$ ".number_format($value->vl_unitario, 2, ',', '.') : "R\$ 0,00";

                $beneficio                       = new stdClass();
                $beneficio->id_item_beneficio_pk = $id_benef;
                $beneficio->grupo                = $value->grupo;
                $beneficio->descricao            = $value->descricao;
                $beneficio->vl_unitario          = $valor_unid;
                $beneficio->modalidade           = $value->modalidade;
                $beneficio->status               = $value->status;
                $beneficio->acao                 = $acao;
                $beneficios[]                    = $beneficio;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $beneficios;

        return $dados;
    }

    /**
     * Método de exclusão de um Beneficio
     *
     * @method delBeneficio
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delBeneficio($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_item_beneficio_pk', $id);
        $this->db->delete('tb_item_beneficio');

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

/* End of file beneficio_model.php */
/* Location: ./application/models/beneficio_model.php */
