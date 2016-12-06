<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mailing extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Mailing_model');

    }

    /**
     * Método para carregar o gerenciamento de mailings
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Mailings";

        # Sql Mailing
        # Selecionar ids dos mailings
        /* $this->db->select("id_mailing_fk");
        $this->db->from("tb_prospeccao");
        $ids_prospec = $this->db->get()->result();

        $where_not = array();
        if (!empty($ids_prospec)):
            foreach ($ids_prospec as $value):
                $where_not[] = $value->id_mailing_fk;
            endforeach;
        endif; */

        $this->db->select("DISTINCT(m.id_mailing_pk), m.razao_social");
        $this->db->from("tb_mailing m");
        $this->db->from("tb_prospeccao p", "m.id_mailing_pk = p.id_mailing_fk", "left");
        # $this->db->where_not_in('m.id_mailing_pk', $where_not);
        $this->db->order_by('m.razao_social');
        $data['mailing'] = $this->db->get()->result();

        # Sql Item Beneficio
        $this->db->order_by('descricao');
        $data['item_beneficio'] = $this->db->get('tb_item_beneficio')->result();

        # Sql Fornecedor
        $this->db->where('id_status_fk', '1');
        $this->db->order_by('fornecedor');
        $data['fornecedor'] = $this->db->get('tb_fornecedor')->result();

        # Sql Meio Social
        $this->db->order_by('meio_social');
        $data['meio_social'] = $this->db->get('tb_meio_social')->result();

        # Sql Dist Beneficio
        $this->db->order_by('dist_beneficio');
        $data['dist_beneficio'] = $this->db->get('tb_dist_beneficio')->result();

        # Sql Atividade
        $this->db->order_by('ramo_atividade');
        $data['atividade'] = $this->db->get('tb_ramo_atividade')->result();

        # Sql Mudaria Fornecedor
        $data['muda_fornecedor'] = $this->db->get('tb_muda_fornecedor')->result();

        # Sql Nao Interesse
        $data['nao_interesse'] = $this->db->get('tb_nao_interesse')->result();

        $this->load->view('header', $header);
        $this->load->view('mailing/mailing_gerenciar', $data);
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de mailings
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Mailings";

        # Sql Mailing
        # Selecionar ids dos mailings
        /* $this->db->select("id_mailing_fk");
        $this->db->from("tb_prospeccao");
        $ids_prospec = $this->db->get()->result();

        $where_not = array();
        if (!empty($ids_prospec)):
            foreach ($ids_prospec as $value):
                $where_not[] = $value->id_mailing_fk;
            endforeach;
        endif; */

        $this->db->select("DISTINCT(m.id_mailing_pk), m.razao_social");
        $this->db->from("tb_mailing m");
        $this->db->from("tb_prospeccao p", "m.id_mailing_pk = p.id_mailing_fk", "left");
        # $this->db->where_not_in('m.id_mailing_pk', $where_not);
        $this->db->order_by('m.razao_social');
        $data['mailing'] = $this->db->get()->result();

        # Sql Item Beneficio
        $this->db->order_by('descricao');
        $data['item_beneficio'] = $this->db->get('tb_item_beneficio')->result();

        # Sql Fornecedor
        $this->db->where('id_status_fk', '1');
        $this->db->order_by('fornecedor');
        $data['fornecedor'] = $this->db->get('tb_fornecedor')->result();

        # Sql Meio Social
        $this->db->order_by('meio_social');
        $data['meio_social'] = $this->db->get('tb_meio_social')->result();

        # Sql Dist Beneficio
        $this->db->order_by('dist_beneficio');
        $data['dist_beneficio'] = $this->db->get('tb_dist_beneficio')->result();

        # Sql Atividade
        $this->db->order_by('ramo_atividade');
        $data['atividade'] = $this->db->get('tb_ramo_atividade')->result();

        # Sql Mudaria Fornecedor
        $data['muda_fornecedor'] = $this->db->get('tb_muda_fornecedor')->result();

        # Sql Nao Interesse
        $data['nao_interesse'] = $this->db->get('tb_nao_interesse')->result();

        $this->load->view('header', $header);
        $this->load->view('mailing/mailing_gerenciar', $data);
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de mailing
     *
     * @method cadastrar
     * @access public
     * @return void
     */
    public function cadastrar()
    {
        # Titulo da pagina
        $header['titulo'] = "Cadastro de Mailing";

        # Sql para Estado
        $this->db->order_by('estado');
        $data['estado'] = $this->db->get('tb_estado')->result();

        # Sql para Cidade
        $this->db->where('id_estado_fk', 26);
        $this->db->order_by('cidade');
        $data['cidade'] = $this->db->get('tb_cidade')->result();

        $this->load->view('header', $header);
        $this->load->view('mailing/mailing_cadastrar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de mailing
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $mailing  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $mailing->cnpj         = $this->input->post('cnpj');
        $mailing->razao_social = $this->input->post('razao_social');
        $mailing->endereco     = $this->input->post('endereco');
        $mailing->numero       = $this->input->post('numero');
        $mailing->complemento  = $this->input->post('complemento');
        $mailing->bairro       = $this->input->post('bairro');
        $mailing->cep          = $this->input->post('cep');
        $mailing->estado       = $this->input->post('estado');
        $mailing->cidade       = $this->input->post('cidade');
        $mailing->tel          = $this->input->post('tel');
        $mailing->email        = $this->input->post('email');
        $mailing->site         = $this->input->post('site');

        if ($mailing->cnpj != NULL && $mailing->razao_social != NULL && $mailing->endereco != NULL && $mailing->numero != NULL && $mailing->bairro != NULL &&
            $mailing->cep != NULL && $mailing->estado != NULL && $mailing->cidade != NULL && $mailing->tel != NULL && $mailing->email != NULL) {
            $resposta = $this->Mailing_model->setMailing($mailing);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de gerenciamento de mailing
     *
     * @method buscarMailing
     * @access public
     * @return obj Lista de mailing cadastrados
     */
    public function buscarMailing()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "cnpj";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Mailing_model->getMailings($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de mailing
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_mailing = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Mailing";

        # Sql para busca
        $this->db->where('id_mailing_pk', $id_mailing);
        $data['mailing'] = $this->db->get('tb_mailing')->result();

        # Sql para Estado
        $this->db->order_by('estado');
        $data['estado'] = $this->db->get('tb_estado')->result();

        # Sql para Cidade
        $id_estado = isset($data['mailing'][0]->id_estado_fk) ? $data['mailing'][0]->id_estado_fk : NULL;
        $this->db->where('id_estado_fk', $id_estado);
        $this->db->order_by('cidade');
        $data['cidade'] = $this->db->get('tb_cidade')->result();

        $this->load->view('header', $header);
        $this->load->view('mailing/mailing_editar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de edicao de mailing
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $mailing  = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $mailing->id           = $this->input->post('id_mailing');
        $mailing->cnpj         = $this->input->post('cnpj');
        $mailing->razao_social = $this->input->post('razao_social');
        $mailing->endereco     = $this->input->post('endereco');
        $mailing->numero       = $this->input->post('numero');
        $mailing->complemento  = $this->input->post('complemento');
        $mailing->bairro       = $this->input->post('bairro');
        $mailing->cep          = $this->input->post('cep');
        $mailing->estado       = $this->input->post('estado');
        $mailing->cidade       = $this->input->post('cidade');
        $mailing->tel          = $this->input->post('tel');
        $mailing->email        = $this->input->post('email');
        $mailing->site         = $this->input->post('site');

        if ($mailing->id != NULL && $mailing->cnpj != NULL && $mailing->razao_social != NULL && $mailing->endereco != NULL && $mailing->numero != NULL &&
            $mailing->bairro != NULL && $mailing->cep != NULL && $mailing->estado != NULL && $mailing->cidade != NULL && $mailing->tel != NULL && $mailing->email != NULL) {
            $resposta = $this->Mailing_model->setMailing($mailing);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de mailing
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_mailing = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Mailing";

        # Sql para busca
        $this->db->where('id_mailing_pk', $id_mailing);
        $data['mailing'] = $this->db->get('tb_mailing')->result();

        if (!empty($data['mailing'])):
            # Sql para Estado
            $this->db->where('id_estado_pk', $data['mailing'][0]->id_estado_fk);
            $this->db->order_by('estado');
            $data['estado'] = $this->db->get('tb_estado')->result();

            # Sql para Cidade
            $this->db->where('id_cidade_pk', $data['mailing'][0]->id_cidade_fk);
            $this->db->order_by('cidade');
            $data['cidade'] = $this->db->get('tb_cidade')->result();
        endif;

        $this->load->view('header', $header);
        $this->load->view('mailing/mailing_ver', $data);
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
            $resposta = $this->Mailing_model->delMailing($id_mail);
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
     * Método para buscar dados da prospeccao
     *
     * @method getProspec
     * @access public
     * @return obj Status da ação
     */
    public function getProspec()
    {
        # Atribuir vars
        $retorno = new stdClass();

        $id = $this->input->post('id_prospec');

        # SQL
        $this->db->where('id_prospeccao_pk', $id);
        $row = $this->db->get('tb_prospeccao')->result();

        if (!empty($row)):
            $retorno->status = TRUE;
            $retorno->dados  = $row;
        else:
            $retorno->status = FALSE;
            $retorno->dados  = NULL;
        endif;

        # retornar
        print json_encode($retorno);
    }
}

/* End of file Mailing.php */
/* Location: ./application/controllers/Mailing.php */