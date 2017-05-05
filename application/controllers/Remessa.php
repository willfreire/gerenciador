<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Remessa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Remessa_model');

    }

    /**
     * Método para carregar a tela para gerar Remessa
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerar Remessa";

        $this->load->view('header', $header);
        $this->load->view('financeiro/remessa_gerar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar a visualizacao de boletos
     *
     * @method boleto
     * @access public
     * @return void
     */
    public function gerar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerar Remessa";

        $this->load->view('header', $header);
        $this->load->view('financeiro/remessa_gerar');
        $this->load->view('footer');
    }

    /**
     * Método de cadastro da header da remessa
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $pedido   = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $pedido->ids = $this->input->post('ids_boleto');
        
        if (!empty($pedido->ids) && is_array($pedido->ids)) {
            $resposta = $this->Remessa_model->setRemessaHeader($pedido);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Gerar Remessa! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }
    
    /**
     * Método de busca geral dos boletos gerados
     *
     * @method getBoletos
     * @access public
     * @return obj Lista de Boletos
     */
    public function getBoletos()
    {
        # SQL
        $this->db->select('id_pedido_fk, sacado_cnpj_cpf, sacado_nome, valor');
        $this->db->from('tb_boleto');
        $this->db->order_by('id_pedido_fk', 'ASC');
        $retorno = $this->db->get()->result();

        $valor = array();

        if ($retorno):

            foreach ($retorno as $value):
                $vl      = isset($value->valor) && $value->valor != "0.00" ? "R\$ ".number_format($value->valor, 2, ',', '.') : "R\$ 0,00";
                $valor[] = $value->id_pedido_fk." / ".$value->sacado_cnpj_cpf." / ".$value->sacado_nome." / $vl";
            endforeach;

        endif;

        print json_encode($valor);
    }

}

/* End of file Remessa.php */
/* Location: ./application/controllers/Remessa.php */