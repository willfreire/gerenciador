<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Financeiro extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Financeiro_model');

    }

    /**
     * Método para carregar a visualizacao de boletos
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Boletos";

        $this->load->view('header', $header);
        $this->load->view('financeiro/boleto_visualizar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar a visualizacao de boletos
     *
     * @method boleto
     * @access public
     * @return void
     */
    public function boleto()
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Boletos";

        $this->load->view('header', $header);
        $this->load->view('financeiro/boleto_visualizar');
        $this->load->view('footer');
    }

    /**
     * Método para popular grid de gerenciamento de financeiro
     *
     * @method buscarBoleto
     * @access public
     * @return obj Lista de financeiro cadastrados
     */
    public function buscarBoleto()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "id_pedido_fk";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Financeiro_model->getBoletos($search);

        print json_encode($resposta);
    }

}

/* End of file Financeiro.php */
/* Location: ./application/controllers/Financeiro.php */