<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mailing_model extends CI_Model {

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
     * Método responsável por cadastrar / editar um mailing
     *
     * @method setMailing
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setMailing($valores)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $dados   = array();

        $dados['cnpj']         = $valores->cnpj;
        $dados['razao_social'] = $valores->razao_social;
        $dados['endereco']     = $valores->endereco;
        $dados['numero']       = $valores->numero;
        $dados['complemento']  = $valores->complemento;
        $dados['bairro']       = $valores->bairro;
        $dados['cep']          = $valores->cep;
        $dados['id_cidade_fk'] = $valores->cidade;
        $dados['id_estado_fk'] = $valores->estado;
        $dados['telefone']     = $valores->tel;
        $dados['email']        = $valores->email;
        $dados['site']         = $valores->site;

        if (isset($valores->id) && $valores->id != ""):
            # Atualiza mailing
            $this->db->where('id_mailing_pk', $valores->id);
            $this->db->update('tb_mailing', $dados);

            if ($this->db->affected_rows() >= 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            # Grava mailing
            $this->db->insert('tb_mailing', $dados);

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
     * Método responsável por pesquisar e buscar mailings
     *
     * @method getMailings
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de mailings
     */
    public function getMailings($search)
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
        $this->db->select('COUNT(id_mailing_pk) AS total');
        $this->db->from('tb_mailing');
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

        # Consultar mailings
        $this->db->select('id_mailing_pk, cnpj, razao_social, telefone, email, dt_atende');
        $this->db->from('tb_mailing');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $mailings = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_mail  = $value->id_mailing_pk;
                $url_edit = base_url('./mailing/editar/'.$id_mail);
                $url_view = base_url('./mailing/ver/'.$id_mail);
                $url_src  = base_url('./prospeccao/prospecMailing/'.$id_mail);
                $acao     = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Fazer Prospec&ccedil;&atilde;o' onclick='Mailing.abrirProspeccao(\"$url_src\")'><i class='fa fa-bar-chart' aria-hidden='true'></i></button>";
                $acao    .= "<button type='button' class='btn btn-warning btn-xs btn-acao' title='Editar Mailing' onclick='Mailing.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao    .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Mailing' onclick='Mailing.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                $acao    .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Mailing' onclick='Mailing.del(\"$id_mail\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $mailing                = new stdClass();
                $mailing->id_mailing_pk = $id_mail;
                $mailing->cnpj          = $value->cnpj;
                $mailing->razao_social  = $value->razao_social;
                $mailing->telefone      = $value->telefone;
                $mailing->email         = $value->email;
                $mailing->dt_atende     = $value->dt_atende != NULL ? date('d/m/Y', strtotime($value->dt_atende)) : "N&atilde;o Cont&eacute;m";
                $mailing->acao          = $acao;
                $mailings[]             = $mailing;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $mailings;

        return $dados;
    }

    /**
     * Método de exclusão de um Mailing
     *
     * @method delMailing
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delMailing($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_mailing_pk', $id);
        $this->db->delete('tb_mailing');

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

/* End of file mailing_model.php */
/* Location: ./application/models/mailing_model.php */