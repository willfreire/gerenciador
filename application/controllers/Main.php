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
        $this->db->from('tb_usuario u');
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
     * Método para autenticação de Cliente
     *
     * @method loginClient
     * @access public
     * @return void
     */
    public function loginClient()
    {
        # Vars
        $retorno = new stdClass();
        $cnpj    = $this->input->post('cnpj');
        $senha   = sha1($this->input->post('pwd_cliente'));

        $this->db->select('e.id_empresa_pk, e.id_tipo_empresa_fk, t.tipo_empresa, e.cnpj, e.nome_razao, DATE_FORMAT(el.dt_hr, \'%d/%m/%Y\') AS dt_cad');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_tipo_empresa t', 'e.id_tipo_empresa_fk = t.id_tipo_empresa_pk', 'inner');
        $this->db->join('tb_empresa_log el', 'e.id_empresa_pk = el.id_empresa_fk', 'inner');
        $this->db->where('e.cnpj', $cnpj);
        $this->db->where('e.senha', $senha);
        $this->db->where('el.id_acao_fk', 1);
        $this->db->where('e.id_status_fk', 1);
        $client = $this->db->get()->result();

        if (count($client) === 1)
        {
            $first_name = explode(" ", $client[0]->nome_razao);

            $dados = array(
                'id_client'      => $client[0]->id_empresa_pk,
                'user_client'    => $client[0]->nome_razao,
                'user_st_client' => is_array($first_name) ? $first_name[0] : $client[0]->nome_razao,
                'cnpj_client'    => $client[0]->cnpj,
                'id_tipo_client' => $client[0]->id_tipo_empresa_fk,
                'tipo_client'    => $client[0]->tipo_empresa,
                'dt_cad_client'  => $client[0]->dt_cad
            );
            $this->session->set_userdata($dados);

            $retorno->status = TRUE;
            $retorno->msg    = "OK";
            $retorno->url    = base_url("main/dashboard_client");
        }
        else
        {
            $retorno->status = FALSE;
            $retorno->msg    = "CNPJ e/ou Senha Inv&aacute;lida!";
            $retorno->url    = "";
        }

        print json_encode($retorno);
    }
    
    /**
     * Método load Dashboard do Cliente
     *
     * @method dashboard_client
     * @access public
     * @return void
     */
    public function dashboard_client()
    {
        $data           = array();
        $data['titulo'] = "Dashboard";
        
        $this->load->view('header', $data);
        # Validar acesso
        if (!empty($this->session->userdata('user_client'))):
            $this->load->view('dashboard_client');
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