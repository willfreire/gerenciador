<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prospeccao_model extends CI_Model {

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
     * Método responsável por cadastrar / editar uma prospeccao
     *
     * @method setProspeccao
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setProspeccao($valores)
    {
        # Atribuir vars
        $retorno   = new stdClass();
        $dados     = array();
        $mail      = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        $dados['id_mailing_fk']        = $valores->mailing;
        $dados['id_item_beneficio_fk'] = $valores->item_beneficio;
        $dados['id_fornecedor_fk']     = $valores->fornecedor;
        $dados['id_meio_social_fk']    = $valores->meio_social;
        $dados['id_dist_beneficio_fk'] = $valores->dist_beneficio;
        $dados['id_ramo_atividade_fk'] = $valores->atividade;
        $dados['id_muda_fornec_fk']    = $valores->muda_fornecedor;
        $dados['muda_fornec_outro']    = $valores->muda_fornec_outro;
        $dados['id_nao_interesse_fk']  = $valores->nao_interesse;
        $dados['nao_interesse_outro']  = $valores->nao_interesse_outro;
        $dados['contato']              = $valores->contato;
        $dados['taxa']                 = $valores->taxa;
        $dados['aceitou_proposta']     = $valores->aceitou_proposta;
        $dados['dt_retorno']           = is_array($valores->dt_retorno) ? $valores->dt_retorno[2].'-'.$valores->dt_retorno[1].'-'.$valores->dt_retorno[0] : NULL;
        $dados['observacao']           = $valores->obs;

        # Dados do Mailing na prospeccao
        if ($valores->aceitou_proposta === "s"):
            $mail['cliente'] = $valores->aceitou_proposta;
        endif;
        $mail['dt_atende'] = mdate($timestamp, $data);
        # Atualiza Mailing
        $this->db->where('id_mailing_pk', $valores->mailing);
        $this->db->update('tb_mailing', $mail);

        if (isset($valores->id) && $valores->id != ""):
            $dados['tempo_alt']         = $valores->time;
            $dados['id_usuario_alt_fk'] = $this->session->userdata('id_vt');
            $dados['dt_hr_alt']         = mdate($timestamp, $data);

            # Atualiza prospeccao
            $this->db->where('id_prospeccao_pk', $valores->id);
            $this->db->update('tb_prospeccao', $dados);

            if ($this->db->affected_rows() >= 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            $dados['tempo_cad']     = $valores->time;
            $dados['id_usuario_fk'] = $this->session->userdata('id_vt');
            $dados['dt_hr_cad']     = mdate($timestamp, $data);

            # Grava prospeccao
            $this->db->insert('tb_prospeccao', $dados);

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
     * Método responsável por pesquisar e buscar Prospecções
     *
     * @method getProspeccoes
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de prospeccaos
     */
    public function getProspeccoes($search)
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
        $this->db->select('COUNT(p.id_prospeccao_pk) AS total');
        $this->db->from('tb_prospeccao p');
        $this->db->join('tb_mailing m', 'p.id_mailing_fk = m.id_mailing_pk', 'inner');
        $this->db->join('tb_item_beneficio b', 'p.id_item_beneficio_fk = b.id_item_beneficio_pk', 'inner');
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
        $this->db->select("p.id_prospeccao_pk, p.id_mailing_fk, m.razao_social, b.descricao, p.contato, CONCAT(p.taxa, '%') AS taxa, IF (p.aceitou_proposta = 's', 'Sim',
                          IF (p.aceitou_proposta = 'e', 'Em Negocia&ccedil;&atilde;o', 'N&atilde;o')) AS aceitou_proposta", FALSE);
        $this->db->from('tb_prospeccao p');
        $this->db->join('tb_mailing m', 'p.id_mailing_fk = m.id_mailing_pk', 'inner');
        $this->db->join('tb_item_beneficio b', 'p.id_item_beneficio_fk = b.id_item_beneficio_pk', 'inner');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $prospeccaos = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_prospec = $value->id_prospeccao_pk;
                $url_edit   = base_url('./prospeccao/editar/'.$id_prospec);
                $url_view   = base_url('./prospeccao/ver/'.$id_prospec);
                $acao       = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Prospec&ccedil;&atilde;o' onclick='Prospeccao.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao      .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Prospec&ccedil;&atilde;o' onclick='Prospeccao.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                if ($this->session->userdata('id_perfil_vt') == "1"):
                    $acao.= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Prospec&ccedil;&atilde;o' onclick='Prospeccao.del(\"$id_prospec\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";
                endif;

                $prospeccao                   = new stdClass();
                $prospeccao->id_mailing_fk    = $value->id_mailing_fk;
                $prospeccao->razao_social     = $value->razao_social;
                $prospeccao->descricao        = $value->descricao;
                $prospeccao->contato          = $value->contato;
                $prospeccao->taxa             = $value->taxa;
                $prospeccao->aceitou_proposta = $value->aceitou_proposta;
                $prospeccao->acao             = $acao;
                $prospeccaos[]                = $prospeccao;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $prospeccaos;

        return $dados;
    }

    /**
     * Método de exclusão de um Prospeccao
     *
     * @method delProspeccao
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delProspeccao($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_prospeccao_pk', $id);
        $this->db->delete('tb_prospeccao');

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

/* End of file prospeccao_model.php */
/* Location: ./application/models/prospeccao_model.php */