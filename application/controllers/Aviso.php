<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Aviso extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        # Carregar modelo
        $this->load->model('Aviso_model');

    }

    /**
     * Método para carregar o gerenciamento de avisos
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Avisos";

        $this->load->view('header', $header);
        $this->load->view('aviso/aviso_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de avisos
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Avisos";

        $this->load->view('header', $header);
        $this->load->view('aviso/aviso_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de aviso
     *
     * @method cadastrar
     * @access public
     * @return void
     */
    public function cadastrar()
    {
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Titulo da pagina
        $header['titulo'] = "Cadastro de Aviso";

        $this->load->view('header', $header);
        $this->load->view('aviso/aviso_cadastrar');
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de aviso
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        $aviso    = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $aviso->titulo    = $this->input->post('titulo');
        $aviso->descricao = $this->input->post('descricao');

        if ($aviso->titulo != NULL && $aviso->descricao != NULL) {
            $resposta = $this->Aviso_model->setAviso($aviso);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de gerenciamento de aviso
     *
     * @method buscarAviso
     * @access public
     * @return obj Lista de aviso cadastrados
     */
    public function buscarAviso()
    {
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "titulo";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Aviso_model->getAvisos($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de aviso
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_aviso = null)
    {
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Aviso";

        # Sql para busca
        $this->db->where('id_quadro_aviso_pk', $id_aviso);
        $data['aviso'] = $this->db->get('tb_quadro_aviso')->result();

        $this->load->view('header', $header);
        $this->load->view('aviso/aviso_editar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de edicao de aviso
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        $aviso    = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $aviso->id        = $this->input->post('id_aviso');
        $aviso->titulo    = $this->input->post('titulo');
        $aviso->descricao = $this->input->post('descricao');

        if ($aviso->id != NULL && $aviso->titulo != NULL && $aviso->descricao != NULL) {
            $resposta = $this->Aviso_model->setAviso($aviso);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de aviso
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_aviso = null)
    {
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Aviso";

        # Sql para busca
        $this->db->where('id_quadro_aviso_pk', $id_aviso);
        $data['aviso'] = $this->db->get('tb_quadro_aviso')->result();

        $this->load->view('header', $header);
        $this->load->view('aviso/aviso_ver', $data);
        $this->load->view('footer');
    }

    /**
     * Método responsável pela exclusão de um registro
     *
     * @method delete
     * @access public
     * @return obj Status da ação
     */
    public function delete()
    {
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        $retorno  =  new stdClass();
        $resposta = "";
        $id_aviso = filter_input(INPUT_POST, "id");

        if ($id_aviso !== NULL) {
            $resposta = $this->Aviso_model->delAviso($id_aviso);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Excluir! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método responsavel por buscar dados de um aviso
     *
     * @method verAvisoId
     * @access public
     * @return obj dados cadastrados
     */
    public function verAvisoId()
    {
        # Vars
        $id      = $this->input->post('id');
        $retorno = new stdClass();

        # Sql
        $this->db->select("id_quadro_aviso_pk, titulo, descricao, DATE_FORMAT(dt_hr_cad, '%d/%m/%Y') AS dt_hr_cad", FALSE);
        $this->db->from('tb_quadro_aviso');
        $this->db->where('id_quadro_aviso_pk', $id);
        $resp = $this->db->get()->result();

        if (!empty($resp)):
            $retorno->status = TRUE;
            $retorno->dados  = $resp;
            $retorno->msg    = "OK";
        else:
            $retorno->status = FALSE;
            $retorno->dados  = NULL;
            $retorno->msg    = "N&atilde;o foi poss&iacute;vel localizar o Aviso informado!";
        endif;

        print json_encode($retorno);
    }

    /**
     * Método para carregar tela de visualização de todos avisos
     *
     * @method verTodos
     * @access public
     * @return void
     */
    public function verTodos()
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Todos Avisos";

        # Sql
        $this->db->select("id_quadro_aviso_pk, titulo, descricao, DATE_FORMAT(dt_hr_cad, '%d/%m/%Y') AS dt_cadastro", FALSE);
        $this->db->from('tb_quadro_aviso');
        $this->db->order_by('dt_hr_cad', 'DESC');
        $data['avisos'] = $this->db->get()->result();

        $this->load->view('header', $header);
        $this->load->view('aviso/aviso_ver_all', $data);
        $this->load->view('footer');
    }

}

/* End of file Aviso.php */
/* Location: ./application/controllers/Aviso.php */