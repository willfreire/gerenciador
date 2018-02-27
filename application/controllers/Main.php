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
        $retorno    = new stdClass();
        $cnpj       = $this->input->post('cnpj');
        $senha      = sha1($this->input->post('pwd_cliente'));
        $onde       = "";
        $where      = array();
        $where[]    = "e.cnpj = '$cnpj'";
        $where[]    = "(e.senha = '$senha' OR e.senha_master = '$senha')";
        $where[]    = "el.id_acao_fk = 1";
        $where[]    = "e.id_status_fk = 1";

        if (!empty($where)):
            $onde = implode(" AND ", $where);
        endif;

        $this->db->select('e.id_empresa_pk, e.id_tipo_empresa_fk, t.tipo_empresa, e.cnpj, e.nome_razao, DATE_FORMAT(el.dt_hr, \'%d/%m/%Y\') AS dt_cad');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_tipo_empresa t', 'e.id_tipo_empresa_fk = t.id_tipo_empresa_pk', 'inner');
        $this->db->join('tb_empresa_log el', 'e.id_empresa_pk = el.id_empresa_fk', 'inner');
        $this->db->where($onde);
        $client = $this->db->get()->result();

        if (count($client) === 1)
        {

            # Buscar Filiais
            $this->db->select('e.id_empresa_pk, e.id_tipo_empresa_fk, t.tipo_empresa, e.cnpj, e.nome_razao, DATE_FORMAT(el.dt_hr, \'%d/%m/%Y\') AS dt_cad');
            $this->db->from('tb_empresa e');
            $this->db->join('tb_tipo_empresa t', 'e.id_tipo_empresa_fk = t.id_tipo_empresa_pk', 'inner');
            $this->db->join('tb_empresa_filial ef', 'ef.id_empresa_filial_fk = e.id_empresa_pk', 'inner');
            $this->db->join('tb_empresa_log el', 'el.id_empresa_fk = ef.id_empresa_filial_fk', 'inner');
            $this->db->where(array('ef.id_empresa_matriz_fk' => $client[0]->id_empresa_pk, 'el.id_acao_fk' => 1));
            $filiais = $this->db->get()->result();

            $filiais_empr = array();
            if (!empty($filiais)) {
                foreach ($filiais as $value) {
                    $first_name_filial = explode(" ", $value->nome_razao);

                    $filial_empr                 = new stdClass();
                    $filial_empr->id_client      = $value->id_empresa_pk;
                    $filial_empr->user_client    = $value->nome_razao;
                    $filial_empr->user_st_client = is_array($first_name_filial) ? $first_name_filial[0] : $value->nome_razao;
                    $filial_empr->cnpj_client    = $value->cnpj;
                    $filial_empr->id_tipo_client = $value->id_tipo_empresa_fk;
                    $filial_empr->tipo_client    = $value->tipo_empresa;
                    $filial_empr->dt_cad_client  = $value->dt_cad;
                    $filiais_empr[]              = $filial_empr;
                }
            }

            # Vars
            $first_name     = explode(" ", $client[0]->nome_razao);
            $id_empresa     = $client[0]->id_empresa_pk;
            $user_client    = $client[0]->nome_razao;
            $user_st_client = is_array($first_name) ? $first_name[0] : $client[0]->nome_razao;
            $cnpj_client    = $client[0]->cnpj;
            $id_tipo_client = $client[0]->id_tipo_empresa_fk;
            $tipo_client    = $client[0]->tipo_empresa;
            $dt_cad_client  = $client[0]->dt_cad;
            
            # Matriz
            $matriz_vt                 = new stdClass();
            $matriz_vt->id_client      = $id_empresa;
            $matriz_vt->user_client    = $user_client;
            $matriz_vt->user_st_client = $user_st_client;
            $matriz_vt->cnpj_client    = $cnpj_client;
            $matriz_vt->id_tipo_client = $id_tipo_client;
            $matriz_vt->tipo_client    = $tipo_client;
            $matriz_vt->dt_cad_client  = $dt_cad_client;

            # Setar Sessao
            $dados = array(
                'id_client'      => $id_empresa,
                'user_client'    => $user_client,
                'user_st_client' => $user_st_client,
                'cnpj_client'    => $cnpj_client,
                'id_tipo_client' => $id_tipo_client,
                'tipo_client'    => $tipo_client,
                'dt_cad_client'  => $dt_cad_client,
                'matriz'         => $matriz_vt,
                'filiais'        => $filiais_empr
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

        # Consultar Quadro Avisos
        $this->db->select("id_quadro_aviso_pk, titulo, descricao, DATE_FORMAT(dt_hr_cad, '%d/%m/%Y') AS dt_cadastro", FALSE);
        $this->db->from('tb_quadro_aviso');
        $this->db->order_by('dt_hr_cad', 'DESC');
        $this->db->limit(7);
        $data['avisos'] = $this->db->get()->result();

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

    /**
     * Método para gerar nova senha ao VT
     *
     * @method newPwdVt
     * @access public
     * @return obj Resultado
     */
    public function newPwdVt()
    {
        # Vars
        $retorno     = new stdClass();
        $email       = $this->input->post('email_pwd_vt');
        $senha_cript = sha1($this->input->post('send_pwd_vt'));
        $senha       = $this->input->post('send_pwd_vt');

        # Verificar se usuario existe
        $this->db->select('id_usuario_pk, nome, email');
        $this->db->from('tb_usuario');
        $this->db->where('email', $email);
        $row = $this->db->get()->result();

        if (!empty($row)):
            # Atualiza senha
            $dados          = array();
            $dados['senha'] = $senha_cript;

            $this->db->where('email', $email);
            $this->db->update('tb_usuario', $dados);

            # Msg
            $msg                 = array();
            $msg['destinatario'] = $row[0]->nome;
            $msg['email']        = $email;
            $msg['senha']        = $senha;
            $msg['mensagem']     = "Olá {$row[0]->nome}!<br><br>Sua nova senha de acesso ao sistema VT Cards é <strong>{$msg['senha']}</strong><br><br>Att.";

            $retorno->status = TRUE;
            $retorno->msg    = "Sua Nova Senha foi Enviada para o E-mail <strong>$email</strong>";

            # Enviar email
            $this->sendNewPwd($msg);
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Usu&aacute;rio n&atilde;o Encontrado!";
        endif;

        print json_encode($retorno);
    }

    /**
     * Método para gerar nova senha ao Cliente
     *
     * @method newPwdClient
     * @access public
     * @return obj Resultado
     */
    public function newPwdClient()
    {
        # Vars
        $retorno     = new stdClass();
        $cnpj        = $this->input->post('cnpj_pwd_client');
        $senha_cript = sha1($this->input->post('send_pwd_client'));
        $senha       = $this->input->post('send_pwd_client');

        # Verificar se cliente existe
        $this->db->select('id_empresa_pk, cnpj, nome_razao, email');
        $this->db->from('tb_empresa');
        $this->db->where('cnpj', $cnpj);
        $row = $this->db->get()->result();

        if (!empty($row)):
            # Atualiza senha
            $dados          = array();
            $dados['senha'] = $senha_cript;

            $this->db->where('cnpj', $cnpj);
            $this->db->update('tb_empresa', $dados);

            # Msg
            $msg                 = array();
            $msg['destinatario'] = $row[0]->nome_razao;
            $msg['email']        = $row[0]->email;
            $msg['senha']        = $senha;
            $msg['mensagem']     = "Olá {$row[0]->nome_razao}!<br><br>Sua nova senha de acesso ao sistema VT Cards é <strong>$senha</strong><br><br>Att.";

            $retorno->status = TRUE;
            $retorno->msg    = "Sua Nova Senha foi Enviada para o E-mail <strong>{$row[0]->email}</strong>";

            # Enviar email
            $this->sendNewPwd($msg);
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Cliente n&atilde;o Encontrado!";
        endif;

        print json_encode($retorno);
    }

    /**
     * Enviar nova senha por email
     *
     * @method sendNewPwd
     * @access public
     * @param array $msg Mensagem pra envio
     * @return void
     */
    public function sendNewPwd($msg)
    {
        # Carrega a library email
        $this->load->library('email');
        # Atribuir dados
        $dados = $msg;

        # Inicia o processo de configuração para o envio do email
        $config['protocol'] = 'mail'; // define o protocolo utilizado
        $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
        $config['validate'] = TRUE; // define se haverá validação dos endereços de email
        $config['mailtype'] = 'html';

        # Inicializa a library Email, passando os parâmetros de configuração
        $this->email->initialize($config);

        # Define remetente e destinatário
        $this->email->from('faleconosco@vtcards.com.br', 'VTCards');
        $this->email->to($dados['email'], $dados['destinatario']);

        #  Define o assunto do email
        $this->email->subject('Nova senha VTCards');

        # Template
        $this->email->message($this->load->view('email_template', $dados, TRUE));

        /*
         * Se foi selecionado o envio de um anexo, insere o arquivo no email
         * através do método 'attach' da library 'Email'
         */
        /* if (isset($dados['anexo'])):
            $this->email->attach('./assets/images/unici/logo.png');
        endif; */

        /*
         * Se o envio foi feito com sucesso, define a mensagem de sucesso
         * caso contrário define a mensagem de erro, e carrega a view home
         */
        if (!$this->email->send()):
            echo $this->email->print_debugger();
        endif;
    }

    /**
     * Enviar email geral
     *
     * @method sendMailGeral
     * @access public
     * @param array $msg Mensagem pra envio
     * @return void
     */
    public function sendMailGeral($msg)
    {
        # Carrega a library email
        $this->load->library('email');

        # Atribuir dados
        $dados   = $msg;
        $retorno = new stdClass();

        # Inicia o processo de configuração para o envio do email
        $config['protocol'] = 'mail'; // define o protocolo utilizado
        $config['wordwrap'] = TRUE; // define se haverá quebra de palavra no texto
        $config['validate'] = TRUE; // define se haverá validação dos endereços de email
        $config['mailtype'] = 'html';

        # Inicializa a library Email, passando os parâmetros de configuração
        $this->email->initialize($config);

        # Define remetente e destinatário
        $this->email->from($dados['sender'], $dados['sender_name']);
        $this->email->to($dados['email'], $dados['destinatario']);

        #  Define o assunto do email
        $this->email->subject($dados['subject']);

        # Template
        $this->email->message($this->load->view('email_template', $dados, TRUE));

        /*
         * Se o envio foi feito com sucesso, define a mensagem de sucesso
         * caso contrário define a mensagem de erro, e carrega a view home
         */
        if ($this->email->send()):
            $retorno->status = TRUE;
            $retorno->msg    = "E-mail enviado com sucesso!";
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao enviar o E-mail!";
        endif;

        return $retorno;
    }

    /**
     * Método para trocar sessao
     *
     * @method changeSession
     * @access public
     * @return void
     */
    public function changeSession()
    {
        # Vars
        $retorno = new stdClass();
        $id      = $this->input->post('id', TRUE);

        # Alterar Sessao
        $this->db->select('e.id_empresa_pk, e.id_tipo_empresa_fk, t.tipo_empresa, e.cnpj, e.nome_razao, DATE_FORMAT(el.dt_hr, \'%d/%m/%Y\') AS dt_cad');
        $this->db->from('tb_empresa e');
        $this->db->join('tb_tipo_empresa t', 'e.id_tipo_empresa_fk = t.id_tipo_empresa_pk', 'inner');
        $this->db->join('tb_empresa_log el', 'e.id_empresa_pk = el.id_empresa_fk', 'inner');
        $this->db->where(array('e.id_empresa_pk' => base64_decode($id), 'el.id_acao_fk' => 1));
        $client = $this->db->get()->result();

        # Setar Sessao
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
        
        print json_encode($retorno);
    }
}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */