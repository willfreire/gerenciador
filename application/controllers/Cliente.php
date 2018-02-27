<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Cliente_model');

    }

    /**
     * Método para carregar o gerenciamento de clientes
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Clientes";

        $this->load->view('header', $header);
        $this->load->view('cliente/cliente_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de clientes
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Clientes";

        $this->load->view('header', $header);
        $this->load->view('cliente/cliente_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de cliente
     *
     * @method cadastrar
     * @access public
     * @return void
     */
    public function cadastrar()
    {
        # Titulo da pagina
        $header['titulo'] = "Cadastro de Cliente";

        # Sql para Mailings
        $this->db->where('cliente', 's');
        $this->db->order_by('razao_social');
        $data['mailing'] = $this->db->get('tb_mailing')->result();

        # Sql para Empresas
        $this->db->where('id_tipo_empresa_fk', 1);
        $this->db->order_by('nome_razao');
        $data['matriz'] = $this->db->get('tb_empresa')->result();

        # Sql para Atividades
        $this->db->order_by('ramo_atividade');
        $data['atividades'] = $this->db->get('tb_ramo_atividade')->result();

        # Sql para Estado
        $this->db->order_by('estado');
        $data['estado'] = $this->db->get('tb_estado')->result();

        # Sql para Cidade
        $this->db->where('id_estado_fk', 26);
        $this->db->order_by('cidade');
        $data['cidade'] = $this->db->get('tb_cidade')->result();

        # Sql para Departamento
        $this->db->order_by('departamento');
        $data['dpto'] = $this->db->get('tb_departamento')->result();

        # Sql para Cargo
        $this->db->order_by('cargo');
        $data['cargo'] = $this->db->get('tb_cargo')->result();

        $this->load->view('header', $header);
        $this->load->view('cliente/cliente_cadastrar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de cliente
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $cliente  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $cliente->tp_empresa        = $this->input->post('tp_empresa');
        $cliente->matriz            = $this->input->post('matriz');
        $cliente->cnpj              = $this->input->post('cnpj');
        $cliente->razao_social      = $this->input->post('razao_social');
        $cliente->nome_fantasia     = $this->input->post('nome_fantasia');
        $cliente->insc_estadual     = $this->input->post('insc_estadual');
        $cliente->inscr_municipal   = $this->input->post('inscr_municipal');
        $cliente->atividade         = $this->input->post('atividade');
        $cliente->email             = $this->input->post('email');
        $cliente->email_adicional   = $this->input->post('email_adicional');
        $cliente->tel               = $this->input->post('tel');
        $cliente->email_primario    = $this->input->post('email_primario');
        $cliente->email_secundario  = $this->input->post('email_secundario');
        $cliente->senha             = $this->input->post('senha_cliente');
        $cliente->status            = $this->input->post('status');
        $cliente->tp_endereco       = $this->input->post('tp_endereco');
        $cliente->cep               = $this->input->post('cep');
        $cliente->endereco          = $this->input->post('endereco');
        $cliente->numero            = $this->input->post('numero');
        $cliente->complemento       = $this->input->post('complemento');
        $cliente->bairro            = $this->input->post('bairro');
        $cliente->estado            = $this->input->post('estado');
        $cliente->cidade            = $this->input->post('cidade');
        $cliente->resp_receb        = $this->input->post('resp_receb');
        $cliente->nome_contato      = $this->input->post('nome_contato');
        $cliente->depto             = $this->input->post('depto');
        $cliente->cargo             = $this->input->post('cargo');
        $cliente->sexo              = $this->input->post('sexo');
        $cliente->dt_nasc           = isset($_POST['dt_nasc']) && $_POST['dt_nasc'] != "" ? explode('/', $_POST['dt_nasc']) : NULL;
        $cliente->resp_compra       = $this->input->post('resp_compra');
        $cliente->email_pri_contato = $this->input->post('email_pri_contato');
        $cliente->email_sec_contato = $this->input->post('email_sec_contato');
        $cliente->taxa_adm          = $this->input->post('taxa_adm');
        $cliente->taxa_entrega      = $this->input->post('taxa_entrega');
        $cliente->taxa_fixa_perc    = $this->input->post('taxa_fixa_perc');
        $cliente->taxa_fixa_real    = $this->input->post('taxa_fixa_real');
        $cliente->taxa_adm_cr       = $this->input->post('taxa_adm_cr');
        $cliente->taxa_adm_ca       = $this->input->post('taxa_adm_ca');
        $cliente->taxa_adm_cc       = $this->input->post('taxa_adm_cc');

        if ($cliente->tp_empresa != NULL && $cliente->cnpj != NULL && $cliente->razao_social != NULL && $cliente->atividade != NULL && $cliente->email != NULL && $cliente->tel != NULL &&
            $cliente->senha != NULL && $cliente->status != NULL && $cliente->tp_endereco != NULL && $cliente->cep != NULL && $cliente->endereco != NULL && $cliente->numero != NULL &&
            $cliente->bairro != NULL && $cliente->estado != NULL && $cliente->cidade != NULL && $cliente->resp_receb != NULL && $cliente->nome_contato != NULL && $cliente->depto != NULL &&
            $cliente->cargo != NULL && $cliente->sexo != NULL && $cliente->dt_nasc != NULL && $cliente->resp_compra != NULL && $cliente->email_pri_contato != NULL) {
            $resposta = $this->Cliente_model->setCliente($cliente);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de gerenciamento de cliente
     *
     * @method buscarCliente
     * @access public
     * @return obj Lista de cliente cadastrados
     */
    public function buscarCliente()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "nome_razao";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Cliente_model->getClientes($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de cliente
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_cliente = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Cliente";

        # Sql Cliente
        $this->db->where('id_empresa_pk', $id_cliente);
        $data['cliente'] = $this->db->get('vw_cliente')->result();

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
        $id_estado = isset($data['cliente'][0]->id_estado_fk) ? $data['cliente'][0]->id_estado_fk : NULL;
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
        $this->load->view('cliente/cliente_editar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de edicao de cliente
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $cliente  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $cliente->id                = $this->input->post('id_cliente');
        $cliente->id_filial         = $this->input->post('id_filial');
        $cliente->id_cond_com       = $this->input->post('id_cond_com');
        $cliente->tp_empresa        = $this->input->post('tp_empresa');
        $cliente->matriz            = $this->input->post('matriz');
        $cliente->cnpj              = $this->input->post('cnpj');
        $cliente->razao_social      = $this->input->post('razao_social');
        $cliente->nome_fantasia     = $this->input->post('nome_fantasia');
        $cliente->insc_estadual     = $this->input->post('insc_estadual');
        $cliente->inscr_municipal   = $this->input->post('inscr_municipal');
        $cliente->atividade         = $this->input->post('atividade');
        $cliente->email             = $this->input->post('email');
        $cliente->email_adicional   = $this->input->post('email_adicional');
        $cliente->tel               = $this->input->post('tel');
        $cliente->email_primario    = $this->input->post('email_primario');
        $cliente->email_secundario  = $this->input->post('email_secundario');
        $cliente->senha             = $this->input->post('senha_cliente');
        $cliente->status            = $this->input->post('status');
        $cliente->tp_endereco       = $this->input->post('tp_endereco');
        $cliente->cep               = $this->input->post('cep');
        $cliente->endereco          = $this->input->post('endereco');
        $cliente->numero            = $this->input->post('numero');
        $cliente->complemento       = $this->input->post('complemento');
        $cliente->bairro            = $this->input->post('bairro');
        $cliente->estado            = $this->input->post('estado');
        $cliente->cidade            = $this->input->post('cidade');
        $cliente->resp_receb        = $this->input->post('resp_receb');
        $cliente->nome_contato      = $this->input->post('nome_contato');
        $cliente->depto             = $this->input->post('depto');
        $cliente->cargo             = $this->input->post('cargo');
        $cliente->sexo              = $this->input->post('sexo');
        $cliente->dt_nasc           = isset($_POST['dt_nasc']) && $_POST['dt_nasc'] != "" ? explode('/', $_POST['dt_nasc']) : NULL;
        $cliente->resp_compra       = $this->input->post('resp_compra');
        $cliente->email_pri_contato = $this->input->post('email_pri_contato');
        $cliente->email_sec_contato = $this->input->post('email_sec_contato');
        $cliente->taxa_adm          = $this->input->post('taxa_adm');
        $cliente->taxa_entrega      = $this->input->post('taxa_entrega');
        $cliente->taxa_fixa_perc    = $this->input->post('taxa_fixa_perc');
        $cliente->taxa_fixa_real    = $this->input->post('taxa_fixa_real');
        $cliente->taxa_adm_cr       = $this->input->post('taxa_adm_cr');
        $cliente->taxa_adm_ca       = $this->input->post('taxa_adm_ca');
        $cliente->taxa_adm_cc       = $this->input->post('taxa_adm_cc');
        $cliente->alt_pwd           = $this->input->post('alt_senha');

        if ($cliente->id != NULL && $cliente->tp_empresa != NULL && $cliente->cnpj != NULL && $cliente->razao_social != NULL && $cliente->atividade != NULL && $cliente->email != NULL &&
            $cliente->tel != NULL && $cliente->status != NULL && $cliente->tp_endereco != NULL && $cliente->cep != NULL && $cliente->endereco != NULL && $cliente->numero != NULL && 
            $cliente->bairro != NULL && $cliente->estado != NULL && $cliente->cidade != NULL && $cliente->resp_receb != NULL && $cliente->nome_contato != NULL && $cliente->depto != NULL && 
            $cliente->cargo != NULL && $cliente->sexo != NULL && $cliente->dt_nasc[0] != NULL && $cliente->resp_compra != NULL && $cliente->email_pri_contato != NULL) {
            $resposta = $this->Cliente_model->setCliente($cliente);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de cliente
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_cliente = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Cliente";

        # Sql Cliente
        $this->db->where('id_empresa_pk', $id_cliente);
        $data['cliente'] = $this->db->get('vw_cliente')->result();

        $this->load->view('header', $header);
        $this->load->view('cliente/cliente_ver', $data);
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
            $resposta = $this->Cliente_model->delCliente($id_mail);
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

    /**
     * Buscar dados da empresa cliente
     *
     * @method importMailing
     * @access public
     * @return obj Dados da empresa
     */
    public function importMailing()
    {
        # Var
        $id      = $this->input->post('id');
        $retorno = new stdClass();

        if ($id != NULL):
            $this->db->select("p.id_mailing_fk, m.cnpj, m.razao_social, m.endereco, m.numero, m.complemento, m.bairro, m.cep,
                               m.id_cidade_fk, m.id_estado_fk, m.telefone, m.email, p.contato, p.taxa");
            $this->db->from("tb_prospeccao p");
            $this->db->join("tb_mailing m", "p.id_mailing_fk = m.id_mailing_pk", "inner");
            $this->db->where("p.id_mailing_fk", $id);
            $rows = $this->db->get()->result();

            if (!empty($rows)):
                $retorno->status = TRUE;
                $retorno->msg    = "Ok";
                $retorno->mail   = $rows;
            else:
                $retorno->status = FALSE;
                $retorno->msg    = "Cliente n&atilde;o localizado!";
                $retorno->mail   = NULL;
            endif;

        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro na busca! Tente novamente...";
            $retorno->mail   = NULL;
        endif;

        print json_encode($retorno);
    }
}

/* End of file Cliente.php */
/* Location: ./application/controllers/Cliente.php */
