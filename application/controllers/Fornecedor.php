<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Fornecedor extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Fornecedor_model');

    }

    /**
     * Método para carregar o gerenciamento de fornecedores
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Fornecedores";

        $this->load->view('header', $header);
        $this->load->view('fornecedor/fornecedor_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de fornecedores
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Fornecedores";

        $this->load->view('header', $header);
        $this->load->view('fornecedor/fornecedor_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de fornecedor
     *
     * @method cadastrar
     * @access public
     * @return void
     */
    public function cadastrar()
    {
        # Titulo da pagina
        $header['titulo'] = "Cadastro de Fornecedor";

        $this->load->view('header', $header);
        $this->load->view('fornecedor/fornecedor_cadastrar');
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de fornecedor
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $fornecedor = new stdClass();
        $retorno    = new stdClass();
        $resposta   = "";

        $fornecedor->nome   = $this->input->post('nome_fornecedor');
        $fornecedor->status = $this->input->post('status');

        if ($fornecedor->nome != NULL && $fornecedor->status != NULL) {
            $resposta = $this->Fornecedor_model->setFornecedor($fornecedor);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de gerenciamento de fornecedor
     *
     * @method buscarFornecedor
     * @access public
     * @return obj Lista de fornecedor cadastrados
     */
    public function buscarFornecedor()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "fornecedor";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Fornecedor_model->getFornecedors($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de fornecedor
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_fornecedor = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Fornecedor";

        # Sql para busca
        $this->db->where('id_fornecedor_pk', $id_fornecedor);
        $data['fornecedor'] = $this->db->get('tb_fornecedor')->result();

        $this->load->view('header', $header);
        $this->load->view('fornecedor/fornecedor_editar', $data);
        $this->load->view('footer');
    }
    
    /**
     * Método de edicao de fornecedor
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $fornecedor  = new stdClass();
        $retorno     = new stdClass();
        $resposta    = "";

        $fornecedor->id      = $this->input->post('id_fornecedor');
        $fornecedor->nome    = $this->input->post('nome_fornecedor');
        $fornecedor->status  = $this->input->post('status');

        if ($fornecedor->id != NULL && $fornecedor->nome != NULL && $fornecedor->status != NULL) {
            $resposta = $this->Fornecedor_model->setFornecedor($fornecedor);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }
    
    /**
     * Método para carregar tela de visualização de fornecedor
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_fornecedor = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Fornecedor";

        # Sql para busca
        $this->db->where('id_fornecedor_pk', $id_fornecedor);
        $data['fornecedor'] = $this->db->get('tb_fornecedor')->result();

        if (!empty($data['fornecedor'])):
            # Sql para Status
            $this->db->where('id_status_pk', $data['fornecedor'][0]->id_status_fk);
            $data['status'] = $this->db->get('tb_status')->result();
        endif;

        $this->load->view('header', $header);
        $this->load->view('fornecedor/fornecedor_ver', $data);
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
        $retorno   =  new stdClass();
        $resposta  = "";
        $id_fornec = filter_input(INPUT_POST, "id");

        if ($id_fornec !== NULL) {
            $resposta = $this->Fornecedor_model->delFornecedor($id_fornec);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Excluir! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }
}

/* End of file Fornecedor.php */
/* Location: ./application/controllers/Fornecedor.php */