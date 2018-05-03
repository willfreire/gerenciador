<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Usuario_model');

    }

    /**
     * Método para carregar o gerenciamento de usuários
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Sessao
        if ($this->session->userdata('id_perfil_vt') == "2") {
            redirect(base_url('./'));
        }

        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Usu&aacute;rios";

        $this->load->view('header', $header);
        $this->load->view('usuario/usuario_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de usuários
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Sessao
        if ($this->session->userdata('id_perfil_vt') == "2") {
            redirect(base_url('./'));
        }

        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Usu&aacute;rios";

        $this->load->view('header', $header);
        $this->load->view('usuario/usuario_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de usuário
     *
     * @method cadastrar
     * @access public
     * @return void
     */
    public function cadastrar()
    {
        # Sessao
        if ($this->session->userdata('id_perfil_vt') == "2") {
            redirect(base_url('./'));
        }

        # Titulo da pagina
        $header['titulo'] = "Cadastro de Usu&aacute;rio";

        # Sql para Perfil
        $data['perfil'] = $this->db->get('tb_perfil')->result();

        $this->load->view('header', $header);
        $this->load->view('usuario/usuario_cadastrar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de usuário
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $usuario  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $usuario->nome   = $this->input->post('nome_usuario');
        $usuario->email  = $this->input->post('email_usuario');
        $usuario->senha  = $this->input->post('senha_usuario');
        $usuario->perfil = $this->input->post('perfil');
        $usuario->status = $this->input->post('status');

        if ($usuario->nome != NULL && $usuario->email != NULL && $usuario->senha != NULL && $usuario->perfil != NULL && $usuario->status != NULL) {
            $resposta = $this->Usuario_model->setUsuario($usuario);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de gerenciamento de usuário
     *
     * @method buscarUsuario
     * @access public
     * @return obj Lista de usuário cadastrados
     */
    public function buscarUsuario()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "u.nome";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Usuario_model->getUsuarios($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de usuário
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_usuario = null)
    {
        # Sessao
        if ($this->session->userdata('id_perfil_vt') == "2" && ($this->session->userdata('id_vt') != $id_usuario)) {
            redirect(base_url('./'));
        }

        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Usu&aacute;rio";

        # Sql para busca
        $this->db->where('id_usuario_pk', $id_usuario);
        $data['usuario'] = $this->db->get('tb_usuario')->result();

        # Sql para Perfil
        $data['perfil'] = $this->db->get('tb_perfil')->result();

        $this->load->view('header', $header);
        $this->load->view('usuario/usuario_editar', $data);
        $this->load->view('footer');
    }
    
    /**
     * Método de edicao de usuário
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $usuario  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $usuario->id      = $this->input->post('id_usuario');
        $usuario->nome    = $this->input->post('nome_usuario');
        $usuario->email   = $this->input->post('email_usuario');
        $usuario->senha   = $this->input->post('senha_usuario');
        $usuario->perfil  = $this->input->post('perfil');
        $usuario->status  = $this->input->post('status');
        $usuario->alt_pwd = $this->input->post('alt_senha');

        if ($usuario->id != NULL && $usuario->nome != NULL && $usuario->email != NULL && $usuario->perfil != NULL && $usuario->status != NULL) {
            $resposta = $this->Usuario_model->setUsuario($usuario);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }
    
    /**
     * Método para carregar tela de visualização de usuário
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_usuario = null)
    {
        # Sessao
        if ($this->session->userdata('id_perfil_vt') == "2" && ($this->session->userdata('id_vt') != $id_usuario)) {
            redirect(base_url('./'));
        }

        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Usu&aacute;rio";

        # Sql para busca
        $this->db->where('id_usuario_pk', $id_usuario);
        $data['usuario'] = $this->db->get('tb_usuario')->result();

        if (!empty($data['usuario'])):
            # Sql para Perfil
            $this->db->where('id_perfil_pk', $data['usuario'][0]->id_perfil_fk);
            $data['perfil'] = $this->db->get('tb_perfil')->result();

            # Sql para Status
            $this->db->where('id_status_pk', $data['usuario'][0]->id_status_fk);
            $data['status'] = $this->db->get('tb_status')->result();
        endif;

        $this->load->view('header', $header);
        $this->load->view('usuario/usuario_ver', $data);
        $this->load->view('footer');
    }
    
}

/* End of file Usuario.php */
/* Location: ./application/controllers/Usuario.php */