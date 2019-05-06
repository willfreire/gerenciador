<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Roteirizacao extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_client') && !$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Roteirizacao_model');

    }

    /**
     * Método para carregar as consultas de roteirizacoes
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        if (!empty($this->session->userdata('user_client'))):
            redirect(base_url('./roteirizacao/consultar'));
        elseif (!empty($this->session->userdata('user_vt'))):
            redirect(base_url('./roteirizacao/solicitadas'));
        endif;
    }

    /**
     * Método para carregar as consultas de roteirizacoes
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function consultar()
    {
        # Titulo da pagina
        $header['titulo'] = "Consulta de Roteiriza&ccedil;&atilde;o";

        if (!empty($this->session->userdata('id_plano')) && $this->session->userdata('id_plano') == 2):
            $this->load->view('header', $header);
            $this->load->view('roteirizacao/roteirizacao_consulta');
            $this->load->view('footer');
        else:
            redirect(base_url('./'));
        endif;
    }

    /**
     * Método para carregar tela de cadastro de roteirizacao
     *
     * @method gerar
     * @access public
     * @return void
     */
    public function gerar()
    {
        # Titulo da pagina
        $header['titulo'] = "Roteiriza&ccedil;&atilde;o de Funcion&aacute;rios";

        if (!empty($this->session->userdata('id_plano')) && $this->session->userdata('id_plano') == 2):
            # Sql Enderecos
            $id_cliente = $this->session->userdata('id_client');
            $sql = "(
                        SELECT e.id_endereco_empresa_pk, e.cep, e.logradouro, e.numero, e.complemento, e.bairro,
                               e.id_cidade_fk, c.cidade, e.id_estado_fk, es.estado
                        FROM tb_endereco_empresa e
                        INNER JOIN tb_cidade c ON c.id_cidade_pk = e.id_cidade_fk
                        INNER JOIN tb_estado es ON es.id_estado_pk = e.id_estado_fk
                        WHERE e.id_empresa_fk = $id_cliente
                    ) UNION (
                        SELECT e.id_endereco_empresa_pk, e.cep, e.logradouro, e.numero, e.complemento, e.bairro,
                               e.id_cidade_fk, c.cidade, e.id_estado_fk, es.estado
                        FROM tb_endereco_empresa e
                        INNER JOIN tb_cidade c ON c.id_cidade_pk = e.id_cidade_fk
                        INNER JOIN tb_estado es ON es.id_estado_pk = e.id_estado_fk
                        INNER JOIN tb_empresa_filial ef ON ef.id_empresa_filial_fk = e.id_empresa_fk
                        WHERE ef.id_empresa_matriz_fk = $id_cliente
                    )";
            $data['enderecos'] = $this->db->query($sql)->result();

            # Sql para Estado
            $this->db->where('id_estado_pk', 26);
            $this->db->order_by('estado');
            $data['estado'] = $this->db->get('tb_estado')->result();

            # Sql para Cidade
            $this->db->where('id_estado_fk', 26);
            $this->db->order_by('cidade');
            $data['cidade'] = $this->db->get('tb_cidade')->result();

            $this->load->view('header', $header);
            $this->load->view('roteirizacao/roteirizacao_cadastrar', $data);
            $this->load->view('footer');
        else:
            redirect(base_url('./'));
        endif;
    }

    /**
     * Buscar dados do funcionario
     *
     * @method getDadosFunc
     * @access public
     * @return obj Dados do funcionario
     */
    public function getDadosFunc()
    {
        # Var
        $cpf     = $this->input->post('cpf');
        $retorno = new stdClass();

        if ($cpf != NULL):
            $this->db->select("f.id_funcionario_pk, f.cpf, f.nome, ef.cep, ef.logradouro, ef.numero, ef.complemento, ef.bairro, ef.id_estado_fk, ef.id_cidade_fk");
            $this->db->from("tb_funcionario f");
            $this->db->join("tb_endereco_funcionario ef", "ef.id_funcionario_fk = f.id_funcionario_pk", "left");
            $this->db->where("f.cpf", $cpf);
            $rows = $this->db->get()->result();

            if (!empty($rows)):
                $retorno->status = TRUE;
                $retorno->msg    = "Ok";
                $retorno->dados  = $rows;
            else:
                $retorno->status = FALSE;
                $retorno->msg    = "Funcionario n&atilde;o localizado!";
                $retorno->dados  = NULL;
            endif;

        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro na busca! Tente novamente...";
            $retorno->dados  = NULL;
        endif;

        print json_encode($retorno);
    }

    /**
     * Buscar dados da Cidade
     *
     * @method getCidade
     * @access public
     * @return obj Id da cidade
     */
    public function getCidade()
    {
        # Var
        $cidade  = $this->input->post('city');
        $retorno = new stdClass();

        if ($cidade != NULL):
            $this->db->select("c.id_cidade_pk");
            $this->db->from("tb_cidade c");
            $this->db->where(array("c.cidade" => $cidade, "id_estado_fk" => 26));
            $rows = $this->db->get()->result();

            if (!empty($rows)):
                $retorno->status = TRUE;
                $retorno->msg    = "Ok";
                $retorno->dados  = $rows;
            else:
                $retorno->status = FALSE;
                $retorno->msg    = "Cidade n&atilde;o localizada!";
                $retorno->dados  = NULL;
            endif;

        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro na busca! Tente novamente...";
            $retorno->dados  = NULL;
        endif;

        print json_encode($retorno);
    }

    /**
     * Método de cadastro de roteirizacao
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $roteiriza = new stdClass();
        $retorno   = new stdClass();
        $resposta  = "";

        $roteiriza->id_end_empresa = $this->input->post('endereco_empresa');
        $roteiriza->cpf            = $this->input->post('cpf');
        $roteiriza->nome_func      = $this->input->post('nome_func');
        $roteiriza->id_funcionario = $this->input->post('id_funcionario');
        $roteiriza->cep            = $this->input->post('cep');
        $roteiriza->endereco       = $this->input->post('endereco');
        $roteiriza->numero         = $this->input->post('numero');
        $roteiriza->complemento    = $this->input->post('complemento');
        $roteiriza->bairro         = $this->input->post('bairro');
        $roteiriza->id_estado      = $this->input->post('estado');
        $roteiriza->id_cidade      = $this->input->post('cidade');
        $roteiriza->vl_solic       = $this->input->post('vl_solicitado');

        if ($roteiriza->id_end_empresa != NULL && $roteiriza->cpf != NULL && $roteiriza->nome_func != "" &&
            $roteiriza->cep != "" && $roteiriza->endereco != "" && $roteiriza->numero != "" &&
            $roteiriza->id_estado != "" && $roteiriza->id_cidade != "" && $roteiriza->vl_solic != "") {
            $resposta = $this->Roteirizacao_model->setRoteirizacao($roteiriza);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Processar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de consulta de roteirizacao
     *
     * @method consultaRoteirizacao
     * @access public
     * @return obj Lista de roteirizacao cadastrados
     */
    public function consultaRoteirizacao()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "id_roteirizacao_pk";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Roteirizacao_model->getConsultaRoteiriza($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar as roteirizacaos solicitadas
     *
     * @method solicitadas
     * @access public
     * @return void
     */
    public function solicitadas()
    {
        # Titulo da pagina
        $header['titulo'] = "Roteiriza&ccedil;&otilde;es Solicitadas";

        $data['status'] = $this->db->get('tb_status_roteiriza')->result();

        $this->load->view('header', $header);
        $this->load->view('roteirizacao/roteirizacao_solicitada', $data);
        $this->load->view('footer');
    }

    /**
     * Método para popular grid de roteirizacoes solicitadas
     *
     * @method solicitadaRoteirizacao
     * @access public
     * @return obj Lista de roteirizacao solicitadas
     */
    public function solicitadaRoteirizacao()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "id_roteirizacao_pk";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Roteirizacao_model->getSolicitadaRoteiriza($search);

        print json_encode($resposta);
    }

    /**
     * Método de edicao de roteirizacao do Status
     *
     * @method alterStatus
     * @access public
     * @return obj Status da ação
     */
    public function alterStatus()
    {
        $roteiriza = new stdClass();
        $retorno   = new stdClass();
        $resposta  = "";
        $path_proj = PATH_PROJ;
        $so        = filter_input(INPUT_SERVER, 'SERVER_SIGNATURE', FILTER_SANITIZE_STRING);

        # Verificar se há envio de Anexo
        if (isset($_FILES)) {
            # Diretorio
            $output_dir = NULL;
            if (isset($_FILES['anexo'])) {
                $output_dir = $path_proj."/assets/roteirizacao/";
            }

            # Msg Error
            $error = NULL;
            if (isset($_FILES['anexo']["error"])) {
                $error = $_FILES["anexo"]["error"];
            }

            # File Temp
            $file_tmp = NULL;
            if (isset($_FILES['anexo']["tmp_name"])) {
                $file_tmp = $_FILES["anexo"]["tmp_name"];
            }

            # File name
            $file_name = NULL;
            if (isset($_FILES['anexo']["name"])) {
                $file_name = $_FILES["anexo"]["name"];
            }

            if (!is_array($file_name)) {
                if (strpos($so, "Win")):
                    $fileName = iconv("UTF-8", "CP1252", $file_name);
                else:
                    $fileName = $file_name;
                endif;

                if (move_uploaded_file($file_tmp, $output_dir.$fileName)) {
                    $roteiriza->anexo = $fileName;
                } else {
                    $roteiriza->anexo = NULL;
                }
            }
            /* Fim Anexo */
        }

        $roteiriza->id_roteiriza = $this->input->post('id_roteiriza', TRUE);
        $roteiriza->id_status    = $this->input->post('id_status', TRUE);

        if ($roteiriza->id_roteiriza != NULL && $roteiriza->id_status != NULL) {
            $resposta = $this->Roteirizacao_model->setStatus($roteiriza);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao alterar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de roteirizacao
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_roteirizacao = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Roteiriza&ccedil;&atilde;o";

        # Sql para busca
        $this->db->select("r.id_roteirizacao_pk, e.cnpj, e.nome_razao, s.status_roteiriza, en.cep AS cep_empr, en.logradouro AS logradouro_empr,
                           en.numero AS numero_empr, en.complemento AS complemento_empr, en.bairro AS bairro_empr, een.estado AS estado_empr,
                           cen.cidade AS cidade_empr, r.cpf, r.nome, r.cep, r.logradouro, r.numero, r.complemento, r.bairro, er.estado,
                           cr.cidade, DATE_FORMAT(dt_hr, '%d/%m/%Y') AS dt_hr, r.arquivo, DATE_FORMAT(dt_hr_usuario, '%d/%m/%Y') AS dt_hr_usuario", FALSE);
        $this->db->from('tb_roteirizacao r');
        $this->db->join('tb_empresa e', 'e.id_empresa_pk = r.id_cliente_fk', 'inner');
        $this->db->join('tb_endereco_empresa en', 'en.id_endereco_empresa_pk = r.id_endereco_empresa_fk', 'inner');
        $this->db->join('tb_estado een', 'een.id_estado_pk = en.id_estado_fk', 'inner');
        $this->db->join('tb_cidade cen', 'cen.id_cidade_pk = en.id_cidade_fk', 'inner');
        $this->db->join('tb_estado er', 'er.id_estado_pk = r.id_estado_fk', 'inner');
        $this->db->join('tb_cidade cr', 'cr.id_cidade_pk = r.id_cidade_fk', 'inner');
        $this->db->join('tb_status_roteiriza s', 's.id_status_roteiriza_pk = r.id_status_roteiriza_fk', 'inner');
        $this->db->where("r.id_roteirizacao_pk", $id_roteirizacao);
        $data['roteiriza'] = $this->db->get()->result();

        $this->load->view('header', $header);
        $this->load->view('roteirizacao/roteirizacao_ver', $data);
        $this->load->view('footer');
    }

    /**
     * Método para carregar historicos das roteirizacoes
     *
     * @method historico
     * @access public
     * @return void
     */
    public function historico()
    {
        # Titulo da pagina
        $header['titulo'] = "Hist&o&oacute;rico de Roteiriza&ccedil;&otilde;es";

        $this->load->view('header', $header);
        $this->load->view('roteirizacao/roteirizacao_historico');
        $this->load->view('footer');
    }

    /**
     * Método para popular grid de historico de roteirizacoes
     *
     * @method historicoRoteirizacao
     * @access public
     * @return obj Lista de roteirizacoes
     */
    public function historicoRoteirizacao()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "id_roteirizacao_pk";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Roteirizacao_model->getHistoricoRoteiriza($search);

        print json_encode($resposta);
    }
}

/* End of file Roteirizacao.php */
/* Location: ./application/controllers/Roteirizacao.php */