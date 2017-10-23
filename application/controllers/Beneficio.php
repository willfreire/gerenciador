<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Beneficio extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Beneficio_model');

    }

    /**
     * Método para carregar o gerenciamento de beneficios
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Benef&iacute;cios";

        $this->load->view('header', $header);
        $this->load->view('beneficio/beneficio_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de beneficios
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Benef&iacute;cios";

        $this->load->view('header', $header);
        $this->load->view('beneficio/beneficio_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de beneficio
     *
     * @method cadastrar
     * @access public
     * @return void
     */
    public function cadastrar()
    {
        # Titulo da pagina
        $header['titulo'] = "Cadastro de Benef&iacute;cio";

        # Sql Grupo
        $this->db->order_by('grupo');
        $data['grupo'] = $this->db->get('tb_grupo')->result();

        # Sql Modalidade
        $this->db->order_by('modalidade');
        $data['modalidade'] = $this->db->get('tb_modalidade')->result();

        $this->load->view('header', $header);
        $this->load->view('beneficio/beneficio_cadastrar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de beneficio
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $beneficio = new stdClass();
        $retorno    = new stdClass();
        $resposta   = "";

        $beneficio->grupo       = $this->input->post('grupo');
        $beneficio->descricao   = $this->input->post('descricao');
        $beneficio->vl_unitario = $this->input->post('vl_unitario');
        $beneficio->modalidade  = $this->input->post('modalidade');
        $beneficio->vl_rep_func = $this->input->post('vl_repasse_func');
        $beneficio->vl_repasse  = $this->input->post('vl_repasse');
        $beneficio->status      = $this->input->post('status');

        if ($beneficio->grupo != NULL && $beneficio->descricao != NULL && $beneficio->modalidade != NULL && $beneficio->status != NULL) {
            $resposta = $this->Beneficio_model->setBeneficio($beneficio);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de gerenciamento de beneficio
     *
     * @method buscarBeneficio
     * @access public
     * @return obj Lista de beneficio cadastrados
     */
    public function buscarBeneficio()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "descricao";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Beneficio_model->getBeneficios($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de beneficio
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_beneficio = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Benef&iacute;cio";

        # Sql Beneficio
        $this->db->where('id_item_beneficio_pk', $id_beneficio);
        $data['beneficio'] = $this->db->get('tb_item_beneficio')->result();

        # Sql Grupo
        $this->db->order_by('grupo');
        $data['grupo'] = $this->db->get('tb_grupo')->result();

        # Sql Modalidade
        $this->db->order_by('modalidade');
        $data['modalidade'] = $this->db->get('tb_modalidade')->result();

        $this->load->view('header', $header);
        $this->load->view('beneficio/beneficio_editar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de edicao de beneficio
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $beneficio = new stdClass();
        $retorno   = new stdClass();
        $resposta  = "";

        $beneficio->id          = $this->input->post('id_beneficio');
        $beneficio->grupo       = $this->input->post('grupo');
        $beneficio->descricao   = $this->input->post('descricao');
        $beneficio->vl_unitario = $this->input->post('vl_unitario');
        $beneficio->modalidade  = $this->input->post('modalidade');
        $beneficio->vl_rep_func = $this->input->post('vl_repasse_func');
        $beneficio->vl_repasse  = $this->input->post('vl_repasse');
        $beneficio->status      = $this->input->post('status');

        if ($beneficio->id != NULL && $beneficio->grupo != NULL && $beneficio->descricao != NULL && $beneficio->modalidade != NULL && $beneficio->status != NULL) {
            $resposta = $this->Beneficio_model->setBeneficio($beneficio);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de beneficio
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_beneficio = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Benef&iacute;cio";

        # Sql Beneficio
        $this->db->where('id_item_beneficio_pk', $id_beneficio);
        $data['beneficio'] = $this->db->get('vw_beneficio')->result();

        $this->load->view('header', $header);
        $this->load->view('beneficio/beneficio_ver', $data);
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
        $retorno  =  new stdClass();
        $resposta = "";
        $id_mail  = filter_input(INPUT_POST, "id");

        if ($id_mail !== NULL) {
            $resposta = $this->Beneficio_model->delBeneficio($id_mail);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Excluir! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Buscar cidades pelo estado
     *
     * @method getCities
     * @access public
     * @return obj Lista de cidades
     */
    public function getCities()
    {
        # Var
        $id      = $this->input->post('id');
        $retorno = new stdClass();

        if ($id != NULL):
            $this->db->where("id_estado_fk", $id);
            $this->db->order_by("cidade");
            $rows = $this->db->get("tb_cidade")->result();

            if (!empty($rows)):
                $retorno->status = TRUE;
                $retorno->cities = $rows;
            else:
                $retorno->status = FALSE;
                $retorno->cities = NULL;
            endif;

        else:
            $retorno->status = FALSE;
            $retorno->cities = NULL;
        endif;

        print json_encode($retorno);
    }
}

/* End of file Beneficio.php */
/* Location: ./application/controllers/Beneficio.php */