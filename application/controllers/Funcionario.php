<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionario extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_client')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Funcionario_model');

    }

    /**
     * Método para carregar o gerenciamento de funcionarios
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Funcion&aacute;rios";

        $this->load->view('header', $header);
        $this->load->view('funcionario/funcionario_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de funcionarios
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Funcion&aacute;rios";

        $this->load->view('header', $header);
        $this->load->view('funcionario/funcionario_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de funcionario
     *
     * @method cadastrar
     * @access public
     * @return void
     */
    public function cadastrar()
    {
        # Titulo da pagina
        $header['titulo'] = "Cadastro de Funcion&aacute;rio";
        
        # Sql Estado Civil
        $this->db->order_by('estado_civil');
        $data['estado_civil'] = $this->db->get('tb_estado_civil')->result();

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

        # Sql Periodo
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $this->db->order_by('periodo');
        $data['periodo'] = $this->db->get('tb_periodo')->result();

        # Sql Endereco
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $data['end_empresa'] = $this->db->get('tb_endereco_empresa')->result();

        $this->load->view('header', $header);
        $this->load->view('funcionario/funcionario_cadastrar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de funcionario
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $funcionario = new stdClass();
        $retorno     = new stdClass();
        $resposta    = "";

        $funcionario->cpf           = $this->input->post('cpf');
        $funcionario->nome_func     = $this->input->post('nome_func');
        $funcionario->dt_nasc       = isset($_POST['dt_nasc']) && $_POST['dt_nasc'] != "" ? explode('/', $_POST['dt_nasc']) : NULL;
        $funcionario->sexo          = $this->input->post('sexo');
        $funcionario->estado_civil  = $this->input->post('estado_civil');
        $funcionario->rg            = $this->input->post('rg');
        $funcionario->dt_exped      = isset($_POST['dt_exped']) && $_POST['dt_exped'] != "" ? explode('/', $_POST['dt_exped']) : NULL;
        $funcionario->orgao_exped   = $this->input->post('orgao_exped');
        $funcionario->uf_exped      = $this->input->post('uf_exped');
        $funcionario->nome_mae      = $this->input->post('nome_mae');
        $funcionario->nome_pai      = $this->input->post('nome_pai');
        $funcionario->status        = $this->input->post('status');
        $funcionario->cep           = $this->input->post('cep');
        $funcionario->endereco      = $this->input->post('endereco');
        $funcionario->numero        = $this->input->post('numero');
        $funcionario->complemento   = $this->input->post('complemento');
        $funcionario->bairro        = $this->input->post('bairro');
        $funcionario->estado        = $this->input->post('estado');
        $funcionario->cidade        = $this->input->post('cidade');
        $funcionario->matricula     = $this->input->post('matricula');
        $funcionario->depto         = $this->input->post('depto');
        $funcionario->cargo         = $this->input->post('cargo');
        $funcionario->periodo       = $this->input->post('periodo');
        $funcionario->email         = $this->input->post('email_func');
        $funcionario->ender_empresa = $this->input->post('ender_empresa');

        if ($funcionario->cpf != NULL && $funcionario->nome_func != NULL && $funcionario->dt_nasc[0] != NULL && $funcionario->sexo != NULL && $funcionario->estado_civil != NULL &&
            $funcionario->rg != NULL && $funcionario->dt_exped[0]!= NULL &&  $funcionario->orgao_exped != NULL && $funcionario->uf_exped != NULL && $funcionario->nome_mae != NULL && 
            $funcionario->status != NULL && $funcionario->cep != NULL &&  $funcionario->endereco != NULL && $funcionario->numero != NULL && $funcionario->bairro != NULL && 
            $funcionario->estado != NULL && $funcionario->cidade != NULL &&  $funcionario->matricula != NULL && $funcionario->depto != NULL && $funcionario->cargo != NULL && 
            $funcionario->periodo != NULL && $funcionario->ender_empresa != NULL) {
            $resposta = $this->Funcionario_model->setFuncionario($funcionario);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de gerenciamento de funcionario
     *
     * @method buscarFuncionario
     * @access public
     * @return obj Lista de funcionario cadastrados
     */
    public function buscarFuncionario()
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
        $resposta = $this->Funcionario_model->getFuncionarios($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de funcionario
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_funcionario = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Funcion&aacute;rio";

        # Sql Funcionario
        $this->db->where('id_funcionario_pk', $id_funcionario);
        $data['funcionario'] = $this->db->get('vw_funcionario')->result();

        # Sql Estado Civil
        $this->db->order_by('estado_civil');
        $data['estado_civil'] = $this->db->get('tb_estado_civil')->result();

        # Sql para Estado
        $this->db->order_by('estado');
        $data['estado'] = $this->db->get('tb_estado')->result();

        # Sql para Cidade
        $this->db->where('id_estado_fk', $data['funcionario'][0]->id_estado_fk);
        $this->db->order_by('cidade');
        $data['cidade'] = $this->db->get('tb_cidade')->result();

        # Sql para Departamento
        $this->db->order_by('departamento');
        $data['dpto'] = $this->db->get('tb_departamento')->result();

        # Sql para Cargo
        $this->db->order_by('cargo');
        $data['cargo'] = $this->db->get('tb_cargo')->result();

        # Sql Periodo
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $this->db->order_by('periodo');
        $data['periodo'] = $this->db->get('tb_periodo')->result();

        # Sql Endereco
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $data['end_empresa'] = $this->db->get('tb_endereco_empresa')->result();

        $this->load->view('header', $header);
        $this->load->view('funcionario/funcionario_editar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de edicao de funcionario
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $funcionario = new stdClass();
        $retorno     = new stdClass();
        $resposta    = "";

        $funcionario->id            = $this->input->post('id_func');
        $funcionario->cpf           = $this->input->post('cpf');
        $funcionario->nome_func     = $this->input->post('nome_func');
        $funcionario->dt_nasc       = isset($_POST['dt_nasc']) && $_POST['dt_nasc'] != "" ? explode('/', $_POST['dt_nasc']) : NULL;
        $funcionario->sexo          = $this->input->post('sexo');
        $funcionario->estado_civil  = $this->input->post('estado_civil');
        $funcionario->rg            = $this->input->post('rg');
        $funcionario->dt_exped      = isset($_POST['dt_exped']) && $_POST['dt_exped'] != "" ? explode('/', $_POST['dt_exped']) : NULL;
        $funcionario->orgao_exped   = $this->input->post('orgao_exped');
        $funcionario->uf_exped      = $this->input->post('uf_exped');
        $funcionario->nome_mae      = $this->input->post('nome_mae');
        $funcionario->nome_pai      = $this->input->post('nome_pai');
        $funcionario->status        = $this->input->post('status');
        $funcionario->cep           = $this->input->post('cep');
        $funcionario->endereco      = $this->input->post('endereco');
        $funcionario->numero        = $this->input->post('numero');
        $funcionario->complemento   = $this->input->post('complemento');
        $funcionario->bairro        = $this->input->post('bairro');
        $funcionario->estado        = $this->input->post('estado');
        $funcionario->cidade        = $this->input->post('cidade');
        $funcionario->matricula     = $this->input->post('matricula');
        $funcionario->depto         = $this->input->post('depto');
        $funcionario->cargo         = $this->input->post('cargo');
        $funcionario->periodo       = $this->input->post('periodo');
        $funcionario->email         = $this->input->post('email_func');
        $funcionario->ender_empresa = $this->input->post('ender_empresa');

        if ($funcionario->id != NULL && $funcionario->cpf != NULL && $funcionario->nome_func != NULL && $funcionario->dt_nasc[0] != NULL && $funcionario->sexo != NULL && 
            $funcionario->estado_civil != NULL && $funcionario->rg != NULL && $funcionario->dt_exped[0]!= NULL &&  $funcionario->orgao_exped != NULL && $funcionario->uf_exped != NULL && 
            $funcionario->nome_mae != NULL &&  $funcionario->status != NULL && $funcionario->cep != NULL &&  $funcionario->endereco != NULL && $funcionario->numero != NULL && 
            $funcionario->bairro != NULL &&  $funcionario->estado != NULL && $funcionario->cidade != NULL &&  $funcionario->matricula != NULL && $funcionario->depto != NULL && 
            $funcionario->cargo != NULL && $funcionario->periodo != NULL && $funcionario->ender_empresa != NULL) {
            $resposta = $this->Funcionario_model->setFuncionario($funcionario);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de funcionario
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_funcionario = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Funcion&aacute;rio";

        # Sql Funcionario
        $this->db->where('id_funcionario_pk', $id_funcionario);
        $data['funcionario'] = $this->db->get('vw_funcionario')->result();

        $this->load->view('header', $header);
        $this->load->view('funcionario/funcionario_ver', $data);
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
            $resposta = $this->Funcionario_model->delFuncionario($id_mail);
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
     * Buscar dados da empresa funcionario
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
                $retorno->msg    = "Funcionario n&atilde;o localizado!";
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

/* End of file Funcionario.php */
/* Location: ./application/controllers/Funcionario.php */