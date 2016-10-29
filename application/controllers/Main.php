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
        if ($this->session->userdata('user_vt')):
            redirect(base_url("main/dashboard"));
        elseif ($this->session->userdata('user_client')):
            redirect(base_url("main/dashboard_client"));
        else:
            $this->load->view('login');
        endif;
        $this->load->view('footer');
    }

    /**
     * Método para autenticação de usuários da VT Card
     *
     * @method loginVT
     * @access public
     * @return void
     */
    public function loginVT()
    {
        # Vars
        $retorno = new stdClass();
        $email   = $this->input->post('email');
        $senha   = sha1($this->input->post('pwd_empresa'));

        $this->db->select('u.id_usuario_pk, u.nome, u.email, u.id_perfil_fk, u.id_status_fk, p.perfil, DATE_FORMAT(u.dt_hr_cad, \'%d/%m/%Y\') AS dt_cad');
        $this->db->from('tb_usuario  u');
        $this->db->join('tb_perfil p', 'u.id_perfil_fk = p.id_perfil_pk', 'inner');
        $this->db->where('u.email', $email);
        $this->db->where('u.senha', $senha);
        $this->db->where('u.id_status_fk', 1);
        $user = $this->db->get()->result();

        if (count($user) === 1)
        {
            $first_name = explode(" ", $user[0]->nome);

            $dados = array(
                'id_vt'        => $user[0]->id_usuario_pk,
                'user_vt'      => $user[0]->nome,
                'user_st'      => is_array($first_name) ? $first_name[0] : $user[0]->nome,
                'email_vt'     => $user[0]->email,
                'id_perfil_vt' => $user[0]->id_perfil_fk,
                'perfil_vt'    => $user[0]->perfil,
                'dt_cad_vt'    => $user[0]->dt_cad
            );
            $this->session->set_userdata($dados);

            $retorno->status = TRUE;
            $retorno->msg    = "OK";
            $retorno->url    = base_url("main/dashboard");
        }
        else
        {
            $retorno->status = FALSE;
            $retorno->msg    = "E-mail e/ou Senha Inv&aacute;lida!";
            $retorno->url    = "";
        }

        print json_encode($retorno);
    }

    /**
     * Método load Dashboard da VT Card
     *
     * @method dashboard
     * @access public
     * @return void
     */
    public function dashboard()
    {
        $data           = array();
        $data['titulo'] = "Dashboard";

        $this->load->view('header', $data);
        # Validar acesso
        if (!empty($this->session->userdata('user_vt'))):
            $this->load->view('dashboard');
        else:
            redirect(base_url("/"));
        endif;
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