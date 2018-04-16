<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Recarga extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('id_client')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Recarga_model');
    }

    /**
     * Método para verificar status de recarga
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Status das Recargas";
        
        # Pedido
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $data['pedidos'] = $this->db->get('tb_pedido')->result();

        $this->load->view('header', $header);
        $this->load->view('recarga/recarga_status', $data);
        $this->load->view('footer');
    }

    /**
     * Método para verificar status de recarga
     *
     * @method status
     * @access public
     * @return void
     */
    public function status()
    {
        # Titulo da pagina
        $header['titulo'] = "Status das Recargas";

        # Pedido
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $data['pedidos'] = $this->db->get('tb_pedido')->result();

        $this->load->view('header', $header);
        $this->load->view('recarga/recarga_status', $data);
        $this->load->view('footer');
    }

    
    /**
     * Método para popular grid de Status das Recargas por Pedido
     *
     * @method getStatus
     * @access public
     * @return obj Lista de status de recarga
     */
    public function getStatus()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "cpf";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;
        $search->id_pedido          = $this->input->post('id_pedido');

        # Instanciar modelo
        $resposta = $this->Recarga_model->getRecargaStatus($search);

        print json_encode($resposta);
    }

}

/* End of file Recarga.php */
/* Location: ./application/controllers/Recarga.php */