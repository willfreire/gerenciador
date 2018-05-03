<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Periodo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_client')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Periodo_model');

    }

    /**
     * Método para carregar o gerenciamento de periodos
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Per&iacute;odos";

        $this->load->view('header', $header);
        $this->load->view('periodo/periodo_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de periodos
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Per&iacute;odos";

        $this->load->view('header', $header);
        $this->load->view('periodo/periodo_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de periodo
     *
     * @method cadastrar
     * @access public
     * @return void
     */
    public function cadastrar()
    {
        # Titulo da pagina
        $header['titulo'] = "Cadastro de Per&iacute;odo";

        $this->load->view('header', $header);
        $this->load->view('periodo/periodo_cadastrar');
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de periodo
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $periodo  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $periodo->periodo = $this->input->post('nome_periodo');
        $periodo->qtd_dia = $this->input->post('qtd_dia');

        if ($periodo->periodo != NULL && $periodo->qtd_dia != NULL) {
            $resposta = $this->Periodo_model->setPeriodo($periodo);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de gerenciamento de periodo
     *
     * @method buscarPeriodo
     * @access public
     * @return obj Lista de periodo cadastrados
     */
    public function buscarPeriodo()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "periodo";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Periodo_model->getPeriodos($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de periodo
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_periodo = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Per&iacute;odo";

        # Sql para busca
        $this->db->where('id_periodo_pk', $id_periodo);
        $data['periodo'] = $this->db->get('tb_periodo')->result();

        $this->load->view('header', $header);
        $this->load->view('periodo/periodo_editar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de edicao de periodo
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $periodo  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $periodo->id      = $this->input->post('id_periodo');
        $periodo->periodo = $this->input->post('nome_periodo');
        $periodo->qtd_dia = $this->input->post('qtd_dia');

        if ($periodo->id != NULL && $periodo->periodo != NULL && $periodo->qtd_dia != NULL) {
            $resposta = $this->Periodo_model->setPeriodo($periodo);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de periodo
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_periodo = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Per&iacute;odo";

        # Sql para busca
        $this->db->where('id_periodo_pk', $id_periodo);
        $data['periodo'] = $this->db->get('tb_periodo')->result();

        $this->load->view('header', $header);
        $this->load->view('periodo/periodo_ver', $data);
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
            $resposta = $this->Periodo_model->delPeriodo($id_fornec);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Excluir! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }
}

/* End of file Periodo.php */
/* Location: ./application/controllers/Periodo.php */