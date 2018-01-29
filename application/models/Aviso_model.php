<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aviso_model extends CI_Model {

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
     * Método responsável por cadastrar / editar um aviso
     *
     * @method setAviso
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setAviso($valores)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $dados   = array();

        $dados['id_usuario_fk'] = $this->session->userdata('id_perfil_vt');
        $dados['titulo']        = trim($valores->titulo);
        $dados['descricao']     = htmlentities(trim($valores->descricao));

        if (isset($valores->id) && $valores->id != ""):
            # Atualiza aviso
            $this->db->where('id_quadro_aviso_pk', $valores->id);
            $this->db->update('tb_quadro_aviso', $dados);

            if ($this->db->affected_rows() >= 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            $dados['dt_hr_cad'] = date("Y-m-d H:i:s");
            
            # Grava aviso
            $this->db->insert('tb_quadro_aviso', $dados);

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
     * Método responsável por pesquisar e buscar avisos
     *
     * @method getAvisos
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de avisos
     */
    public function getAvisos($search)
    {
        # Atribuir valores
        $this->draw      = $search->draw;
        $this->orderBy   = $search->orderBy;
        $this->orderType = $search->orderType;
        $this->start     = $search->start;
        $this->length    = $search->length;
        $this->filter    = htmlentities($search->filter);
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
        $this->db->select('COUNT(id_quadro_aviso_pk) AS total');
        $this->db->from('tb_quadro_aviso');
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

        # Consultar avisos
        $this->db->select("id_quadro_aviso_pk, titulo, descricao, DATE_FORMAT(dt_hr_cad, '%d/%m/%Y') AS dt_hr_cad", FALSE);
        $this->db->from('tb_quadro_aviso');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $avisos = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_aviso = $value->id_quadro_aviso_pk;
                $url_edit = base_url('./aviso/editar/'.$id_aviso);
                $url_view = base_url('./aviso/ver/'.$id_aviso);
                $acao     = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Aviso' onclick='Aviso.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao    .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Aviso' onclick='Aviso.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                $acao    .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Aviso' onclick='Aviso.del(\"$id_aviso\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $aviso            = new stdClass();
                $aviso->dt_hr_cad = $value->dt_hr_cad;
                $aviso->titulo    = $value->titulo;
                $aviso->descricao = $value->descricao;
                $aviso->acao      = $acao;
                $avisos[]         = $aviso;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $avisos;

        return $dados;
    }

    /**
     * Método de exclusão de um Aviso
     *
     * @method delAviso
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delAviso($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_quadro_aviso_pk', $id);
        $this->db->delete('tb_quadro_aviso');

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

/* End of file aviso_model.php */
/* Location: ./application/models/aviso_model.php */