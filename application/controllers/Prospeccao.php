<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prospeccao extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Prospeccao_model');

    }

    /**
     * Método para carregar o gerenciamento de prospeccoes
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Prospec&ccedil;&otilde;es";

        $this->load->view('header', $header);
        $this->load->view('prospeccao/prospeccao_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar o gerenciamento de prospeccoes
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Prospec&ccedil;&otilde;es";

        $this->load->view('header', $header);
        $this->load->view('prospeccao/prospeccao_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro de prospeccao
     *
     * @method cadastrar
     * @access public
     * @return void
     */
    public function cadastrar()
    {
        # Titulo da pagina
        $header['titulo'] = "Cadastro de Prospec&ccedil;&atilde;o";

        # Sql Mailing
        # Selecionar ids dos mailings
        $this->db->select("id_mailing_fk");
        $this->db->from("tb_prospeccao");
        $ids_prospec = $this->db->get()->result();

        $where_not = array();
        if (!empty($ids_prospec)):
            foreach ($ids_prospec as $value):
                $where_not[] = $value->id_mailing_fk;
            endforeach;
        endif;

        $this->db->select("DISTINCT(m.id_mailing_pk), m.razao_social");
        $this->db->from("tb_mailing m");
        $this->db->from("tb_prospeccao p", "m.id_mailing_pk = p.id_mailing_fk", "left");
        $this->db->where_not_in('m.id_mailing_pk', $where_not);
        $this->db->order_by('m.razao_social');
        $data['mailing'] = $this->db->get()->result();

        # Sql Item Beneficio
        $this->db->order_by('id_item_beneficio_pk');
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
        $this->load->view('prospeccao/prospeccao_cadastrar', $data);
        $this->load->view('footer');
    }

    /**
     * Método para carregar tela de cadastro / edicao de prospeccao pelo Mailing
     *
     * @method prospecMailing
     * @access public
     * @param int $id_mailing Id do Mailing
     * @return void
     */
    public function prospecMailing($id_mailing = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Prospec&ccedil;&atilde;o";

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
        endif;

        $this->db->select("DISTINCT(m.id_mailing_pk), m.razao_social");
        $this->db->from("tb_mailing m");
        $this->db->from("tb_prospeccao p", "m.id_mailing_pk = p.id_mailing_fk", "left");
        $this->db->where_not_in('m.id_mailing_pk', $where_not);
        $this->db->order_by('m.razao_social');
        $data['mailing'] = $this->db->get()->result(); */
        $this->db->order_by('razao_social');
        $data['mailing'] = $this->db->get('tb_mailing')->result();

        # Sql Item Beneficio
        $this->db->order_by('id_item_beneficio_pk');
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

        # Sql Prospeccao
        $this->db->where('id_mailing_fk', $id_mailing);
        $data['prospeccao'] = $this->db->get('tb_prospeccao')->result();

        # Id Mailing - Prospeccao
        $data['prospec_mail'] = $id_mailing;

        $this->load->view('header', $header);
        $this->load->view('prospeccao/prospecmailing', $data);
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de prospeccao
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $prospeccao = new stdClass();
        $retorno    = new stdClass();
        $resposta   = "";

        $prospeccao->time                = $this->input->post('time');
        $prospeccao->mailing             = $this->input->post('mailing');
        $prospeccao->item_beneficio      = $this->input->post('item_beneficio');
        $prospeccao->fornecedor          = $this->input->post('fornecedor');
        $prospeccao->meio_social         = $this->input->post('meio_social');
        $prospeccao->dist_beneficio      = $this->input->post('dist_beneficio');
        $prospeccao->atividade           = $this->input->post('atividade');
        $prospeccao->muda_fornecedor     = $this->input->post('muda_fornecedor');
        $prospeccao->muda_fornec_outro   = $this->input->post('muda_fornec_outro');
        $prospeccao->nao_interesse       = $this->input->post('nao_interesse');
        $prospeccao->nao_interesse_outro = $this->input->post('nao_interesse_outro');
        $prospeccao->contato             = $this->input->post('contato');
        $prospeccao->taxa                = $this->input->post('taxa_adm');
        $prospeccao->aceitou_proposta    = $this->input->post('aceitou_proposta');
        $prospeccao->dt_retorno          = isset($_POST['dt_retorno']) && $_POST['dt_retorno'] != "" ? explode('/', $_POST['dt_retorno']) : NULL;
        $prospeccao->obs                 = $this->input->post('obs');

        if ($prospeccao->mailing != NULL && $prospeccao->item_beneficio != NULL && $prospeccao->fornecedor != NULL && $prospeccao->meio_social != NULL &&
            $prospeccao->atividade != NULL && $prospeccao->contato != NULL && $prospeccao->aceitou_proposta != NULL) {
            $resposta = $this->Prospeccao_model->setProspeccao($prospeccao);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método de cadastrar / editar prospeccao
     *
     * @method doProspec
     * @access public
     * @return obj Status da ação
     */
    public function doProspec()
    {
        $prospeccao = new stdClass();
        $retorno    = new stdClass();
        $resposta   = "";

        $prospeccao->id                  = $this->input->post('id_prospec');
        $prospeccao->time                = $this->input->post('time');
        $prospeccao->mailing             = $this->input->post('mailing');
        $prospeccao->item_beneficio      = $this->input->post('item_beneficio');
        $prospeccao->fornecedor          = $this->input->post('fornecedor');
        $prospeccao->meio_social         = $this->input->post('meio_social');
        $prospeccao->dist_beneficio      = $this->input->post('dist_beneficio');
        $prospeccao->atividade           = $this->input->post('atividade');
        $prospeccao->muda_fornecedor     = $this->input->post('muda_fornecedor');
        $prospeccao->muda_fornec_outro   = $this->input->post('muda_fornec_outro');
        $prospeccao->nao_interesse       = $this->input->post('nao_interesse');
        $prospeccao->nao_interesse_outro = $this->input->post('nao_interesse_outro');
        $prospeccao->contato             = $this->input->post('contato');
        $prospeccao->taxa                = $this->input->post('taxa_adm');
        $prospeccao->aceitou_proposta    = $this->input->post('aceitou_proposta');
        $prospeccao->dt_retorno          = isset($_POST['dt_retorno']) && $_POST['dt_retorno'] != "" ? explode('/', $_POST['dt_retorno']) : NULL;
        $prospeccao->obs                 = $this->input->post('obs');

        if ($prospeccao->mailing != NULL && $prospeccao->item_beneficio != NULL && $prospeccao->fornecedor != NULL && $prospeccao->meio_social != NULL &&
            $prospeccao->atividade != NULL && $prospeccao->contato != NULL && $prospeccao->aceitou_proposta != NULL) {
            $resposta = $this->Prospeccao_model->setProspeccao($prospeccao);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de gerenciamento de prospeccao
     *
     * @method buscarProspeccao
     * @access public
     * @return obj Lista de prospeccao cadastrados
     */
    public function buscarProspeccao()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "razao_social";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "ASC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Prospeccao_model->getProspeccoes($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de edição de prospeccao
     *
     * @method editar
     * @access public
     * @return void
     */
    public function editar($id_prospeccao = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Edi&ccedil;&atilde;o de Prospec&ccedil;&atilde;o";

        # Sql Prospeccao
        $this->db->where('id_prospeccao_pk', $id_prospeccao);
        $data['prospeccao'] = $this->db->get('tb_prospeccao')->result();

        # Mailing
        $this->db->order_by('razao_social');
        $data['mailing'] = $this->db->get('tb_mailing')->result();

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
        $this->load->view('prospeccao/prospeccao_editar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de edicao de prospeccao
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $prospeccao = new stdClass();
        $retorno    = new stdClass();
        $resposta   = "";

        $prospeccao->id                  = $this->input->post('id_prospec');
        $prospeccao->time                = $this->input->post('time');
        $prospeccao->mailing             = $this->input->post('id_mailing');
        $prospeccao->item_beneficio      = $this->input->post('item_beneficio');
        $prospeccao->fornecedor          = $this->input->post('fornecedor');
        $prospeccao->meio_social         = $this->input->post('meio_social');
        $prospeccao->dist_beneficio      = $this->input->post('dist_beneficio');
        $prospeccao->atividade           = $this->input->post('atividade');
        $prospeccao->muda_fornecedor     = $this->input->post('muda_fornecedor');
        $prospeccao->muda_fornec_outro   = $this->input->post('muda_fornec_outro');
        $prospeccao->nao_interesse       = $this->input->post('nao_interesse');
        $prospeccao->nao_interesse_outro = $this->input->post('nao_interesse_outro');
        $prospeccao->contato             = $this->input->post('contato');
        $prospeccao->taxa                = $this->input->post('taxa');
        $prospeccao->aceitou_proposta    = $this->input->post('aceitou_proposta');
        $prospeccao->dt_retorno          = isset($_POST['dt_retorno']) && $_POST['dt_retorno'] != "" ? explode('/', $_POST['dt_retorno']) : NULL;
        $prospeccao->obs                 = $this->input->post('obs');

        if ($prospeccao->id != NULL && $prospeccao->mailing != NULL && $prospeccao->item_beneficio != NULL && $prospeccao->fornecedor != NULL && $prospeccao->meio_social != NULL &&
            $prospeccao->atividade != NULL && $prospeccao->contato != NULL && $prospeccao->aceitou_proposta != NULL) {
            $resposta = $this->Prospeccao_model->setProspeccao($prospeccao);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de prospeccao
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_prospeccao = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Prospec&ccedil;&atilde;o";

        # Sql Prospeccao
        $this->db->where('id_prospeccao_pk', $id_prospeccao);
        $data['prospeccao'] = $this->db->get('tb_prospeccao')->result();

        if (!empty($data['prospeccao'])):
            # Mailing
            $this->db->where('id_mailing_pk', $data['prospeccao'][0]->id_mailing_fk);
            $this->db->order_by('razao_social');
            $data['mailing'] = $this->db->get('tb_mailing')->result();

            # Sql Item Beneficio
            $this->db->where('id_item_beneficio_pk', $data['prospeccao'][0]->id_item_beneficio_fk);
            $this->db->order_by('descricao');
            $data['item_beneficio'] = $this->db->get('tb_item_beneficio')->result();

            # Sql Fornecedor
            $this->db->where('id_fornecedor_pk', $data['prospeccao'][0]->id_fornecedor_fk);
            $this->db->order_by('fornecedor');
            $data['fornecedor'] = $this->db->get('tb_fornecedor')->result();

            # Sql Meio Social
            $this->db->where('id_meio_social_pk', $data['prospeccao'][0]->id_meio_social_fk);
            $this->db->order_by('meio_social');
            $data['meio_social'] = $this->db->get('tb_meio_social')->result();

            # Sql Dist Beneficio
            $this->db->where('id_dist_beneficio_pk', $data['prospeccao'][0]->id_dist_beneficio_fk);
            $this->db->order_by('dist_beneficio');
            $data['dist_beneficio'] = $this->db->get('tb_dist_beneficio')->result();

            # Sql Atividade
            $this->db->where('id_ramo_atividade_pk', $data['prospeccao'][0]->id_ramo_atividade_fk);
            $this->db->order_by('ramo_atividade');
            $data['atividade'] = $this->db->get('tb_ramo_atividade')->result();

            # Sql Mudaria Fornecedor
            $this->db->where('id_muda_fornec_pk', $data['prospeccao'][0]->id_muda_fornec_fk);
            $data['muda_fornecedor'] = $this->db->get('tb_muda_fornecedor')->result();

            # Sql Nao Interesse
            $this->db->where('id_nao_interesse_pk', $data['prospeccao'][0]->id_nao_interesse_fk);
            $data['nao_interesse'] = $this->db->get('tb_nao_interesse')->result();
        endif;

        $this->load->view('header', $header);
        $this->load->view('prospeccao/prospeccao_ver', $data);
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
            $resposta = $this->Prospeccao_model->delProspeccao($id_mail);
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
}

/* End of file Prospeccao.php */
/* Location: ./application/controllers/Prospeccao.php */