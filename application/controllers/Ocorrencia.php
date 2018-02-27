<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ocorrencia extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_client') && !$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Ocorrencia_model');

    }

    /**
     * Método para carregar o gerenciamento de ocorrencias
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        redirect(base_url('./ocorrencia/historico'));
    }

    /**
     * Método para carregar o gerenciamento de ocorrencias
     *
     * @method historico
     * @access public
     * @return void
     */
    public function historico()
    {
        # Titulo da pagina
        $header['titulo'] = "Hist&oacute;rico de Ocorr&ecirc;ncias";

        $this->load->view('header', $header);
        $this->load->view('ocorrencia/ocorrencia_historico');
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de todas ocorrencias
     *
     * @method historico_all
     * @access public
     * @return void
     */
    public function historico_all()
    {
        # Titulo da pagina
        $header['titulo'] = "Hist&oacute;rico de Ocorr&ecirc;ncias";

        $this->load->view('header', $header);
        $this->load->view('ocorrencia/ocorrencia_historico_all');
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de ocorrencia
     *
     * @method abrir
     * @access public
     * @return void
     */
    public function abrir()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerar Ocorr&ecirc;ncia";

        # Sql tb_funcionario
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $this->db->order_by('nome', 'ASC');
        $data['funcs'] = $this->db->get('tb_funcionario')->result();

        # Sql tb_ocorr_motivo
        $data['motivos'] = $this->db->get('tb_ocorr_motivo')->result();

        $this->load->view('header', $header);
        $this->load->view('ocorrencia/ocorrencia_cadastrar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de ocorrencia
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $ocorr    = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $ocorr->func      = $this->input->post('func');
        $ocorr->motivo    = $this->input->post('motivo');
        $ocorr->descricao = $this->input->post('descricao');
        $ocorr->email     = $this->input->post('email');

        if ($ocorr->func != NULL && $ocorr->motivo != NULL && $ocorr->descricao != NULL && $ocorr->email != NULL) {
            $resposta = $this->Ocorrencia_model->setOcorrencia($ocorr);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de historico de ocorrencia
     *
     * @method buscarOcorrencia
     * @access public
     * @return obj Lista de ocorrencia cadastradas
     */
    public function buscarOcorrencia()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "ocorrencia";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Ocorrencia_model->getOcorrencias($search);

        print json_encode($resposta);
    }

    /**
     * Método para popular grid de historico das ocorrencias pelo VT
     *
     * @method buscarOcorrenciaVt
     * @access public
     * @return obj Lista de todas ocorrenciascadastradas
     */
    public function buscarOcorrenciaVt()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "ocorrencia";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Ocorrencia_model->getOcorrencias($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de ocorrencia
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_ocorrencia = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Per&iacute;odo";

        # Sql para busca
        $this->db->where('id_ocorrencia_pk', $id_ocorrencia);
        $data['ocorrencia'] = $this->db->get('tb_ocorrencia')->result();

        $this->load->view('header', $header);
        $this->load->view('ocorrencia/ocorrencia_editar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de edicao de ocorrencia
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $ocorrencia  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $ocorrencia->id      = $this->input->post('id_ocorrencia');
        $ocorrencia->ocorrencia = $this->input->post('nome_ocorrencia');
        $ocorrencia->qtd_dia = $this->input->post('qtd_dia');

        if ($ocorrencia->id != NULL && $ocorrencia->ocorrencia != NULL && $ocorrencia->qtd_dia != NULL) {
            $resposta = $this->Ocorrencia_model->setOcorrencia($ocorrencia);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de ocorrencia
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_ocorrencia = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Ocorr&ecirc;ncia";

        # Verificar Usuario VT p/ alterar visualizacao
        if ($this->session->userdata('user_vt')):
            # Consultar
            $this->db->select('viewed');
            $this->db->from('tb_ocorrencia');
            $this->db->where('id_ocorrencia_pk', $id_ocorrencia);
            $resp = $this->db->get()->result();

            if (!empty($resp) && $resp[0]->viewed == 'n') {
                $dados                         = array();
                $dados['viewed']               = 's';
                $dados['id_usuario_viewed_fk'] = $this->session->userdata('id_vt');
                $dados['dt_hr_viewed']         = date('Y-m-d H:i');
                $this->db->where('id_ocorrencia_pk', $id_ocorrencia);
                $this->db->update('tb_ocorrencia', $dados);
            }
        endif;

        # Sql para busca
        $this->db->select('o.id_ocorrencia_pk, f.nome, f.cpf, om.ocorr_motivo, o.descricao, o.email_retorno, os.ocorr_status, o.dt_hr_cad');
        $this->db->from('tb_ocorrencia o');
        $this->db->join('tb_funcionario f', 'f.id_funcionario_pk = o.id_funcionario_fk', 'inner');
        $this->db->join('tb_empresa e', 'e.id_empresa_pk = o.id_cliente_fk', 'inner');
        $this->db->join('tb_ocorr_motivo om', 'om.id_ocorr_motivo_pk = o.id_motivo_fk', 'inner');
        $this->db->join('tb_ocorr_status os', 'os.id_ocorr_status_pk = o.id_status_ocorren_fk', 'inner');
        $this->db->where('o.id_ocorrencia_pk', $id_ocorrencia);
        $data['ocorr'] = $this->db->get()->result();

        $this->load->view('header', $header);
        if ($this->session->userdata('user_vt')):
            $this->load->view('ocorrencia/ocorrencia_ver_vt', $data);
        else:
            $this->load->view('ocorrencia/ocorrencia_ver', $data);
        endif;
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
        $id_ocorr = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);

        if ($id_ocorr !== NULL) {
            $resposta = $this->Ocorrencia_model->delOcorrencia($id_ocorr);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Excluir! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método de cadastro da resposta da ocorrencia
     *
     * @method cadRespostaOcorrencia
     * @access public
     * @return obj Status da ação
     */
    public function cadRespOcorrencia()
    {
        $ocorr    = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $ocorr->codigo = $this->input->post('cod_ocorrencia');
        $ocorr->resp   = $this->input->post('resposta');

        if ($ocorr->codigo != NULL && $ocorr->resp != NULL) {
            $resposta = $this->Ocorrencia_model->setRespOcorrencia($ocorr);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para alterar status de uma ocorrencia
     *
     * @method alterStatusOcorrencia
     * @access public
     * @return obj Status da Açao
     */
    public function alterStatusOcorrencia()
    {
        # Dados
        $retorno           = new stdClass();
        $status            = new stdClass();
        $status->id_ocorr  = $this->input->post('id_ocorrencia_fk');
        $status->id_status = $this->input->post('status');
        $status->id_user   = ($this->session->userdata('id_vt')) ? $this->session->userdata('id_vt') : FALSE;

        if ($status->id_ocorr != NULL && $status->id_status != NULL && $status->id_user != NULL):
            $retorno = $this->Ocorrencia_model->alterStOcorrencia($status);
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um Erro ao Alterar o Status! Tente Novamente...";
        endif;

        print json_encode($retorno);
    }
    
    /**
     * Método de busca das respostas de um ocorrencia
     *
     * @method getRespOcorrencias
     * @access public
     * @return obj Dados da resposta
     */
    public function getRespOcorrencias()
    {
        $retorno  = new stdClass();
        $resposta = "";

        $id = $this->input->post('id');

        if ($id != NULL) {
            $resposta = $this->Ocorrencia_model->getRespostas($id);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao buscar as mensagens!";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

}

/* End of file ocorrencia.php */
/* Location: ./application/controllers/ocorrencia.php */