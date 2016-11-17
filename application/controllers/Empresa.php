<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_client')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Empresa_model');

    }

    /**
     * Método para carregar o gerenciamento de empresas
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
       redirect(base_url('./'));
    }

    /**
     * Método para carregar tela de edição de empresa
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_empresa = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Empresa";

        # Sql Empresa
        $this->db->where('id_empresa_pk', $id_empresa);
        $data['empresa'] = $this->db->get('vw_cliente')->result();

        # Sql para Empresas
        $this->db->where('id_tipo_empresa_fk', 1);
        $this->db->order_by('nome_razao');
        $data['matriz'] = $this->db->get('tb_empresa')->result();

        # Sql para Atividades
        $this->db->order_by('ramo_atividade');
        $data['atividades'] = $this->db->get('tb_ramo_atividade')->result();

        # Sql para Estado
        $this->db->order_by('estado');
        $data['estados'] = $this->db->get('tb_estado')->result();

        # Sql para Cidade
        $id_estado = isset($data['empresa'][0]->id_estado_fk) ? $data['empresa'][0]->id_estado_fk : NULL;
        $this->db->where('id_estado_fk', $id_estado);
        $this->db->order_by('cidade');
        $data['cidades'] = $this->db->get('tb_cidade')->result();

        # Sql para Departamento
        $this->db->order_by('departamento');
        $data['dptos'] = $this->db->get('tb_departamento')->result();

        # Sql para Cargo
        $this->db->order_by('cargo');
        $data['cargos'] = $this->db->get('tb_cargo')->result();

        $this->load->view('header', $header);
        $this->load->view('empresa/empresa_editar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de edicao de empresa
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $empresa  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $empresa->id                = $this->input->post('id_empresa');
        $empresa->razao_social      = $this->input->post('razao_social');
        $empresa->nome_fantasia     = $this->input->post('nome_fantasia');
        $empresa->insc_estadual     = $this->input->post('insc_estadual');
        $empresa->inscr_municipal   = $this->input->post('inscr_municipal');
        $empresa->atividade         = $this->input->post('atividade');
        $empresa->email             = $this->input->post('email');
        $empresa->email_adicional   = $this->input->post('email_adicional');
        $empresa->tel               = $this->input->post('tel');
        $empresa->email_primario    = $this->input->post('email_primario');
        $empresa->email_secundario  = $this->input->post('email_secundario');
        $empresa->senha             = $this->input->post('senha_empresa');
        $empresa->tp_endereco       = $this->input->post('tp_endereco');
        $empresa->cep               = $this->input->post('cep');
        $empresa->endereco          = $this->input->post('endereco');
        $empresa->numero            = $this->input->post('numero');
        $empresa->complemento       = $this->input->post('complemento');
        $empresa->bairro            = $this->input->post('bairro');
        $empresa->estado            = $this->input->post('estado');
        $empresa->cidade            = $this->input->post('cidade');
        $empresa->resp_receb        = $this->input->post('resp_receb');
        $empresa->nome_contato      = $this->input->post('nome_contato');
        $empresa->depto             = $this->input->post('depto');
        $empresa->cargo             = $this->input->post('cargo');
        $empresa->sexo              = $this->input->post('sexo');
        $empresa->dt_nasc           = isset($_POST['dt_nasc']) && $_POST['dt_nasc'] != "" ? explode('/', $_POST['dt_nasc']) : NULL;
        $empresa->resp_compra       = $this->input->post('resp_compra');
        $empresa->email_pri_contato = $this->input->post('email_pri_contato');
        $empresa->email_sec_contato = $this->input->post('email_sec_contato');
        $empresa->alt_pwd           = $this->input->post('alt_senha');

        if ($empresa->id != NULL && $empresa->razao_social != NULL && $empresa->atividade != NULL && $empresa->email != NULL && $empresa->tel != NULL && $empresa->tp_endereco != NULL && 
            $empresa->cep != NULL && $empresa->endereco != NULL && $empresa->numero != NULL && $empresa->bairro != NULL && $empresa->estado != NULL && $empresa->cidade != NULL && 
            $empresa->resp_receb != NULL && $empresa->nome_contato != NULL && $empresa->depto != NULL && $empresa->cargo != NULL && $empresa->sexo != NULL && $empresa->dt_nasc[0] != NULL && 
            $empresa->resp_compra != NULL && $empresa->email_pri_contato != NULL) {
            $resposta = $this->Empresa_model->setEmpresa($empresa);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de empresa
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_empresa = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Empresa";

        # Sql Empresa
        $this->db->where('id_empresa_pk', $id_empresa);
        $data['empresa'] = $this->db->get('vw_cliente')->result();

        $this->load->view('header', $header);
        $this->load->view('empresa/empresa_ver', $data);
        $this->load->view('footer');
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

/* End of file Empresa.php */
/* Location: ./application/controllers/Empresa.php */