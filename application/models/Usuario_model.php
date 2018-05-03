<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

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
     * Método responsável por cadastrar / editar um usuário
     *
     * @method setUsuario
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setUsuario($valores)
    {
        # Atribuir vars
        $retorno   = new stdClass();
        $dados     = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        $dados['nome']         = $valores->nome;
        $dados['email']        = $valores->email;
        $dados['id_perfil_fk'] = $valores->perfil;
        $dados['id_status_fk'] = $valores->status;

        if (isset($valores->id) && $valores->id != ""):
            if ($valores->alt_pwd == "1" && $valores->senha != ""):
                $dados['senha'] = sha1($valores->senha);
            endif;

            # Atualiza usuario
            $this->db->where('id_usuario_pk', $valores->id);
            $this->db->update('tb_usuario', $dados);

            if ($this->db->affected_rows() >= 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            $dados['senha']             = sha1($valores->senha);
            $dados['id_usuario_cad_fk'] = $this->session->userdata('id_vt');
            $dados['dt_hr_cad']         = mdate($timestamp, $data);

            # Grava usuario
            $this->db->insert('tb_usuario', $dados);

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
     * Método responsável por pesquisar e buscar usuários
     *
     * @method getUsuarios
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de usuários
     */
    public function getUsuarios($search)
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
        $this->db->select('COUNT(u.id_usuario_pk) AS total');
        $this->db->from('tb_usuario u');
        $this->db->join('tb_perfil p', 'u.id_perfil_fk = p.id_perfil_pk', 'inner');
        $this->db->join('tb_status s', 'u.id_status_fk = s.id_status_pk', 'inner');
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

        # Consultar usuarios
        $this->db->select('u.id_usuario_pk, u.nome, u.email, p.perfil, s.status');
        $this->db->from('tb_usuario u');
        $this->db->join('tb_perfil p', 'u.id_perfil_fk = p.id_perfil_pk', 'inner');
        $this->db->join('tb_status s', 'u.id_status_fk = s.id_status_pk', 'inner');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $users = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $url_edit = base_url('./usuario/editar/'.$value->id_usuario_pk);
                $url_view = base_url('./usuario/ver/'.$value->id_usuario_pk);
                $acao     = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Usu&aacute;rio' onclick='Usuario.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao     .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Usu&aacute;rio' onclick='Usuario.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                # $acao        .= "<button type='button' class='btn btn-danger btn-xs' title='Excluir Usu&aacute;rio' style='margin: 3px'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $user         = new stdClass();
                $user->nome   = $value->nome;
                $user->email  = $value->email;
                $user->perfil = $value->perfil;
                $user->status = $value->status;
                $user->acao   = $acao;
                $users[]      = $user;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $users;

        return $dados;
    }

}

/* End of file usuario_model.php */
/* Location: ./application/models/usuario_model.php */