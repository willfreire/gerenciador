<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Beneficiocartao extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_client')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('BeneficioCartao_model');

    }

    /**
     * Método para carregar o gerenciamento de Beneficios - Cartoes
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Benef&iacute;cios - Cart&otilde;es";

        $this->load->view('header', $header);
        $this->load->view('beneficio_cartao/beneficiocartao_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de Beneficios - Cartoes
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Benef&iacute;cios - Cart&otilde;es";

        $this->load->view('header', $header);
        $this->load->view('beneficio_cartao/beneficiocartao_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de Beneficio / Cartao
     *
     * @method cadastrar
     * @access public
     * @return void
     */
    public function cadastrar()
    {
        # Titulo da pagina
        $header['titulo'] = "Cadastro de Benef&iacute;cio - Cart&atilde;o";

        # Sql Funcionario
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $this->db->order_by('nome');
        $data['funcs'] = $this->db->get('tb_funcionario')->result();

        # Sql Grupo
        $this->db->order_by('grupo');
        $data['grps'] = $this->db->get('tb_grupo')->result();

        # Sql Beneficio
        $this->db->where(array('id_grupo_fk' => 1, 'id_status_fk' => 1));
        $data['itens_benef'] = $this->db->get('tb_item_beneficio')->result();
        
        # Sql Status Cartao
        $this->db->order_by('status_cartao');
        $data['sts_card'] = $this->db->get('tb_status_cartao')->result();

        $this->load->view('header', $header);
        $this->load->view('beneficio_cartao/beneficiocartao_cadastrar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de Beneficio / Cartao
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $bencard  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $bencard->id_func    = $this->input->post('func');
        $bencard->id_grp     = $this->input->post('grp');
        $bencard->id_benef   = $this->input->post('beneficio');
        $bencard->vl_unit    = $this->input->post('vl_unitario');
        $bencard->qtd_dia    = $this->input->post('qtd_dia');
        $bencard->cartao     = $this->input->post('cartao');
        $bencard->num_cartao = $this->input->post('num_cartao');
        $bencard->status     = $this->input->post('status_card');

        if ($bencard->id_func != NULL && $bencard->id_grp != NULL && $bencard->id_benef != NULL && $bencard->vl_unit != NULL && $bencard->qtd_dia != NULL) {
            $resposta = $this->BeneficioCartao_model->setBeneficioCartao($bencard);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de gerenciamento de Beneficio / Cartao
     *
     * @method buscarBenefCartao
     * @access public
     * @return obj Lista de Beneficio / Cartao cadastrados
     */
    public function buscarBenefCartao()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "nome";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->BeneficioCartao_model->getBenefCartao($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de Beneficio / Cartao
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_benefcard = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Benef&iacute;cio - Cart&atilde;o";

        # Sql para busca
        $this->db->where('id_beneficio_pk', $id_benefcard);
        $data['benefcard'] = $this->db->get('vw_benefico_cartao')->result();

        # Sql Funcionario
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $this->db->order_by('nome');
        $data['funcs'] = $this->db->get('tb_funcionario')->result();

        # Sql Grupo
        $this->db->order_by('grupo');
        $data['grps'] = $this->db->get('tb_grupo')->result();

        # Sql Beneficio
        $this->db->where(array('id_grupo_fk' => $data['benefcard'][0]->id_grupo_fk, 'id_status_fk' => 1));
        $data['itens_benef'] = $this->db->get('tb_item_beneficio')->result();
        
        # Sql Status Cartao
        $this->db->order_by('status_cartao');
        $data['sts_card'] = $this->db->get('tb_status_cartao')->result();

        $this->load->view('header', $header);
        $this->load->view('beneficio_cartao/beneficiocartao_editar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de edicao de Beneficio / Cartao
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $bencard  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $bencard->id         = $this->input->post('id_benefcard');
        $bencard->id_func    = $this->input->post('func');
        $bencard->id_grp     = $this->input->post('grp');
        $bencard->id_benef   = $this->input->post('beneficio');
        $bencard->vl_unit    = $this->input->post('vl_unitario');
        $bencard->qtd_dia    = $this->input->post('qtd_dia');
        $bencard->cartao     = $this->input->post('cartao');
        $bencard->num_cartao = $this->input->post('num_cartao');
        $bencard->status     = $this->input->post('status_card');

        if ($bencard->id != NULL && $bencard->id_func != NULL && $bencard->id_grp != NULL && $bencard->id_benef != NULL && 
            $bencard->vl_unit != NULL && $bencard->qtd_dia != NULL) {
            $resposta = $this->BeneficioCartao_model->setBeneficioCartao($bencard);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de Beneficio / Cartao
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_benefcard = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Benef&iacute;cio - Cart&atilde;o";

        # Sql para busca
        $this->db->where('id_beneficio_pk', $id_benefcard);
        $data['benefcard'] = $this->db->get('vw_benefico_cartao')->result();

        $this->load->view('header', $header);
        $this->load->view('beneficio_cartao/beneficiocartao_ver', $data);
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
        $id_benef = filter_input(INPUT_POST, "id");

        if ($id_benef !== NULL) {
            $resposta = $this->BeneficioCartao_model->delBeneficioCartao($id_benef);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Excluir! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Buscar Qtde de Dias do Funcionario
     *
     * @method getQtdeDias
     * @access public
     * @return obj Total de dias
     */
    public function getQtdeDias()
    {
        # Var
        $id      = $this->input->post('id');
        $retorno = new stdClass();

        if ($id != NULL):
            $this->db->where("id_funcionario_pk", $id);
            $rows = $this->db->get("vw_funcionario")->result();

            if (!empty($rows)):
                $retorno->status = TRUE;
                $retorno->dados = $rows;
            else:
                $retorno->status = FALSE;
                $retorno->dados = NULL;
            endif;

        else:
            $retorno->status = FALSE;
            $retorno->dados = NULL;
        endif;
        
        print json_encode($retorno);
    }

    /**
     * Buscar Valor Unitario do Beneficio
     *
     * @method getVlUnit
     * @access public
     * @return obj Valor do beneficio
     */
    public function getVlUnit()
    {
        # Var
        $id      = $this->input->post('id');
        $retorno = new stdClass();

        if ($id != NULL):
            $this->db->where("id_item_beneficio_pk", $id);
            $rows = $this->db->get("vw_beneficio")->result();

            if (!empty($rows)):
                $retorno->status = TRUE;
                $retorno->dados = $rows;
            else:
                $retorno->status = FALSE;
                $retorno->dados = NULL;
            endif;

        else:
            $retorno->status = FALSE;
            $retorno->dados = NULL;
        endif;
        
        print json_encode($retorno);
    }

    /**
     * Buscar Beneficios por Grupo
     *
     * @method getBeneficioGrp
     * @access public
     * @return obj Item de Benefício
     */
    public function getBeneficioGrp()
    {
        # Var
        $id      = $this->input->post('id');
        $retorno = new stdClass();

        if ($id != NULL):
            $this->db->where("id_grupo_fk", $id);
            $this->db->where("id_status_fk", 1);
            $rows = $this->db->get("tb_item_beneficio")->result();

            if (!empty($rows)):
                $retorno->status = TRUE;
                $retorno->dados = $rows;
            else:
                $retorno->status = FALSE;
                $retorno->dados = NULL;
            endif;

        else:
            $retorno->status = FALSE;
            $retorno->dados = NULL;
        endif;
        
        print json_encode($retorno);
    }

}

/* End of file Beneficiocartao.php */
/* Location: ./application/controllers/Beneficiocartao.php */