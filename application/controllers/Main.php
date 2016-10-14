<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método principal para carregar a tela de login
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        $this->load->view('header');
        if ($this->session->userdata('usuario')):
            $this->load->view('menu_gerenciador');
            $this->load->view('gerenciador');
        else:
            $this->load->view('login');
        endif;
        $this->load->view('footer');
    }

    /**
     * Método para autenticação do usuário
     *
     * @method login
     * @access public
     * @return void
     */
    public function login()
    {

        $usuario = $this->input->post('username');
        $senha = sha1($this->input->post('password'));

        $this->db->select('u.id_deops_user_pk, u.nome, u.login, u.id_perfil_fk, u.id_status_fk');
        $this->db->from('tb_deops_user  u');
        $this->db->where('login', $usuario);
        $this->db->where('senha', $senha);
        $this->db->where('id_status_fk', 1);
        $user = $this->db->get()->result();

        if (count($user) === 1)
        {
            $dados = array(
                'id' => $user[0]->id_deops_user_pk,
                'usuario' => $user[0]->nome,
                'login' => $user[0]->login,
                'perfil' => $user[0]->id_perfil_fk
            );
            $this->session->set_userdata($dados);
            redirect(base_url("/"));
        }
        else
        {
            redirect(base_url("main/erroLogin"));
        }
    }

    /**
     * Método principal para carregar a tela de login
     * informando a mensagem de erro
     *
     * @method erroLogin
     * @access public
     * @return void
     */
    public function erroLogin()
    {
        $data['msg'] = array("Usu&aacute;rio e/ou Senha Incorretos!");
        $this->load->view('header');
        $this->load->view('login', $data);
        $this->load->view('footer');
    }

    /**
     * Método para efetuar o logout do gerenciador
     *
     * @method logoff
     * @access public
     * @return void
     */
    public function logoff()
    {
        $this->session->sess_destroy();
        redirect(base_url("/"));
    }

}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */