<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BeneficioCartao_model extends CI_Model {

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
     * Método responsável por cadastrar / editar um Beneficio e/ou Cartao
     *
     * @method setBeneficioCartao
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setBeneficioCartao($valores)
    {
        # Atribuir vars
        $retorno  = new stdClass();
        $benef    = array();
        $card     = array();
        $id_benef = NULL;

        $benef['id_funcionario_fk']    = $valores->id_func;
        $benef['id_grupo_fk']          = $valores->id_grp;
        $benef['id_item_beneficio_fk'] = $valores->id_benef;
        $benef['vl_unitario']          = str_replace(',', '.', str_replace('.', '', $valores->vl_unit));
        $benef['qtd_diaria']           = $valores->qtd_dia;

        if (isset($valores->id) && $valores->id != ""):
            # Atualiza Beneficio
            $this->db->where('id_beneficio_pk', $valores->id);
            $this->db->update('tb_beneficio', $benef);

            if ($this->db->affected_rows() >= 0) {

                if ($valores->cartao === "1"):
                    # Cartao
                    $this->db->select("id_cartao_pk");
                    $this->db->from("tb_cartao");
                    $this->db->where(array('id_funcionario_fk' => $valores->id_func, 'id_beneficio_fk' => $valores->id));
                    $rows_card = $this->db->get()->result();

                    $id_benef                    = $valores->id;
                    $card['id_funcionario_fk']   = $valores->id_func;
                    $card['id_beneficio_fk']     = $id_benef;
                    $card['num_cartao']          = $valores->num_cartao;
                    $card['id_status_cartao_fk'] = $valores->status;

                    if (!empty($rows_card)) {
                        # Atualiza Cartao
                        $this->db->where(array('id_funcionario_fk' => $valores->id_func, 'id_beneficio_fk' => $valores->id));
                        $this->db->update('tb_cartao', $card);
                    } else {
                        # Grava Cartao
                        $this->db->insert('tb_cartao', $card);
                    }
                elseif ($valores->cartao === "2"):
                    # Delete Cartao
                    $this->db->where(array('id_funcionario_fk' => $valores->id_func, 'id_beneficio_fk' => $valores->id));
                    $this->db->delete('tb_cartao');
                endif;

                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            # Grava Beneficio
            $this->db->insert('tb_beneficio', $benef);

            if ($this->db->affected_rows() > 0) {
                if ($valores->cartao === "1"):
                    # Cartao
                    $id_benef = $this->db->insert_id();
                    $card['id_funcionario_fk']   = $valores->id_func;
                    $card['id_beneficio_fk']     = $id_benef;
                    $card['num_cartao']          = $valores->num_cartao;
                    $card['id_status_cartao_fk'] = $valores->status;
                    # Grava Cartao
                    $this->db->insert('tb_cartao', $card);
                endif;

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
     * Método responsável por cadastrar / editar um Beneficio e/ou Cartao pelo Modal
     *
     * @method setBeneficioCartaoModal
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setBeneficioCartaoModal($valores)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $benef   = array();

        $benef['num_tmp']              = $valores->num_tmp;
        $benef['id_grupo_fk']          = $valores->id_grp;
        $benef['id_item_beneficio_fk'] = $valores->id_benef;
        $benef['vl_unitario']          = str_replace(',', '.', str_replace('.', '', $valores->vl_unit));
        $benef['qtd_diaria']           = $valores->qtd_dia;
        $benef['cartao']               = $valores->cartao;
        $benef['num_cartao']           = $valores->num_cartao;
        $benef['id_status_cartao_fk']  = $valores->status;

        if (isset($valores->id) && $valores->id != ""):
            # Atualiza Beneficio TMP
            $this->db->where('id_beneficio_tmp_pk', $valores->id);
            $this->db->update('tb_beneficio_tmp', $benef);

            if ($this->db->affected_rows() >= 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            # Grava Beneficio TMP
            $this->db->insert('tb_beneficio_tmp', $benef);

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
     * Método responsável por pesquisar e buscar Beneficio / Cartao
     *
     * @method getBenefCartao
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de beneficios / cartoes
     */
    public function getBenefCartao($search)
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
        $this->db->select('COUNT(id_beneficio_pk) AS total');
        $this->db->from('vw_benefico_cartao');
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

        # Consultar vw_benefico_cartao
        $this->db->select('id_beneficio_pk, nome, descricao, num_cartao');
        $this->db->from('vw_benefico_cartao');
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
        $benfcards = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_benef = $value->id_beneficio_pk;
                $url_edit = base_url('./beneficiocartao/editar/'.$id_benef);
                $url_view = base_url('./beneficiocartao/ver/'.$id_benef);
                $acao     = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Benef&iacute;cio - Cart&atilde;o' onclick='Bencard.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao    .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Benef&iacute;cio - Cart&atilde;o' onclick='Bencard.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                $acao    .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Benef&iacute;cio - Cart&atilde;o' onclick='Bencard.del(\"$id_benef\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $num_card = isset($value->num_cartao) ? $value->num_cartao : "N&atilde;o Possui";

                $benfcard             = new stdClass();
                $benfcard->nome       = $value->nome;
                $benfcard->descricao  = $value->descricao;
                $benfcard->num_cartao = $num_card;
                $benfcard->acao       = $acao;
                $benfcards[]          = $benfcard;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $benfcards;

        return $dados;
    }

    /**
     * Método responsável por pesquisar e buscar Beneficio / Cartao TMP
     *
     * @method getBenefTmp
     * @param integer $id_func Id do Funcionário
     * @access public
     * @return obj Lista de beneficios
     */
    public function getBenefTmp($id_func)
    {
        $this->db->select('b.id_beneficio_tmp_pk, b.num_tmp, b.id_grupo_fk, g.grupo,
                           b.id_item_beneficio_fk, ib.descricao, b.vl_unitario, b.qtd_diaria,
                           b.cartao, b.num_cartao, b.id_status_cartao_fk, sc.status_cartao');
        $this->db->from('tb_beneficio_tmp b');
        $this->db->join('tb_grupo g', 'b.id_grupo_fk = g.id_grupo_pk', 'inner');
        $this->db->join('tb_item_beneficio ib', 'b.id_item_beneficio_fk = ib.id_item_beneficio_pk', 'inner');
        $this->db->join('tb_status_cartao sc', 'b.id_status_cartao_fk = sc.id_status_cartao_pk', 'left');
        $this->db->where('b.num_tmp', $id_func);
        $rows = $this->db->get()->result();

        $retorno = new stdClass();
        $benfs   = array();
        if (!empty($rows)):

            foreach ($rows as $value):
                # Botao
                $id_benef = $value->id_beneficio_tmp_pk;
                $acao     = "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Benef&iacute;cio - Cart&atilde;o' onclick='Bencard.delModal(\"$id_benef\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $vl_unitario = isset($value->vl_unitario) ? "R$ ".number_format($value->vl_unitario, 2, ',', '.') : "R$ 0,00";
                $num_card    = isset($value->num_cartao) ? $value->num_cartao : "N&atilde;o Possui";

                $benf              = new stdClass();
                $benf->descricao   = $value->descricao;
                $benf->vl_unitario = $vl_unitario;
                $benf->qtd_diaria  = $value->qtd_diaria;
                $benf->acao        = $acao;
                $benfs[]           = $benf;
            endforeach;

            $retorno->status = TRUE;
            $retorno->dados  = $benfs;

        endif;

        return $retorno;
    }

    /**
     * Método responsável por pesquisar e buscar Beneficio / Cartao
     *
     * @method getBeneficios
     * @param integer $id_func Id do Funcionário
     * @access public
     * @return obj Lista de beneficios
     */
    public function getBeneficios($id_func)
    {
        $this->db->select('id_beneficio_pk, id_funcionario_fk, id_grupo_fk, grupo, id_item_beneficio_fk, descricao,
                           vl_unitario, qtd_diaria, num_cartao, id_status_cartao_fk, status_cartao');
        $this->db->from('vw_benefico_cartao');
        $this->db->where('id_funcionario_fk', $id_func);
        $rows = $this->db->get()->result();

        $retorno = new stdClass();
        $benfs   = array();
        if (!empty($rows)):

            foreach ($rows as $value):
                # Botao
                $id_benef = $value->id_beneficio_pk;
                $acao     = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Benef&iacute;cio - Cart&atilde;o' onclick='Bencard.editBenef(\"$id_benef\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao    .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Benef&iacute;cio - Cart&atilde;o' onclick='Bencard.del(\"$id_benef\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $vl_unitario = isset($value->vl_unitario) ? "R$ ".number_format($value->vl_unitario, 2, ',', '.') : "R$ 0,00";
                $num_card    = isset($value->num_cartao) ? $value->num_cartao : "N&atilde;o Possui";

                $benf              = new stdClass();
                $benf->descricao   = $value->descricao;
                $benf->vl_unitario = $vl_unitario;
                $benf->qtd_diaria  = $value->qtd_diaria;
                $benf->acao        = $acao;
                $benfs[]           = $benf;
            endforeach;

            $retorno->status = TRUE;
            $retorno->dados  = $benfs;

        endif;

        return $retorno;
    }

    /**
     * Método de exclusão de um Beneficio / Cartao
     *
     * @method delBeneficioCartao
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delBeneficioCartao($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_beneficio_pk', $id);
        $this->db->delete('tb_beneficio');

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
     * Método de exclusão de um Beneficio / Cartao pelo Modal
     *
     * @method delBenefCartaoTmp
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delBenefCartaoTmp($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_beneficio_tmp_pk', $id);
        $this->db->delete('tb_beneficio_tmp');

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

/* End of file BeneficioCartao_model.php */
/* Location: ./application/models/BeneficioCartao_model.php */