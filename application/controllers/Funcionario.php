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

        $id_client = $this->session->userdata('id_client');

        # Consultar Periodo
        $this->db->where('id_empresa_fk', $id_client);
        $this->db->order_by('periodo');
        $periodo = $this->db->get('tb_periodo')->result();

        # Montar Periodo
        $opt = "<select class='form-control' name='periodo_func_all' id='periodo_func_all' onchange='Funcionario.mudaPeriodoAll(\"$id_client\", this)'>";
        if (!empty($periodo)):
            $opt .= "<option value=''>Selecione</option>";
            foreach ($periodo as $period):
                $opt .= "<option value='{$period->id_periodo_pk}'>{$period->periodo} - {$period->qtd_dia}</option>";
            endforeach;
        else:
            $opt .= "<option value=''>Sem Per&iacute;odo</option>";
        endif;
        $opt .= "</select>";
        $data['sel_periodo'] = $opt;

        $this->load->view('header', $header);
        $this->load->view('funcionario/funcionario_gerenciar', $data);
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

        $id_client = $this->session->userdata('id_client');

        # Consultar Periodo
        $this->db->where('id_empresa_fk', $id_client);
        $this->db->order_by('periodo');
        $periodo = $this->db->get('tb_periodo')->result();

        # Montar Periodo
        $opt = "<select class='form-control' name='periodo_func_all' id='periodo_func_all' onchange='Funcionario.mudaPeriodoAll(\"$id_client\", this)'>";
        if (!empty($periodo)):
            $opt .= "<option value=''>Selecione</option>";
            foreach ($periodo as $period):
                $opt .= "<option value='{$period->id_periodo_pk}'>{$period->periodo} - {$period->qtd_dia}</option>";
            endforeach;
        else:
            $opt .= "<option value=''>Sem Per&iacute;odo</option>";
        endif;
        $opt .= "</select>";
        $data['sel_periodo'] = $opt;

        $this->load->view('header', $header);
        $this->load->view('funcionario/funcionario_gerenciar', $data);
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

        # Sql Grupo
        $this->db->order_by('grupo');
        $data['grps'] = $this->db->get('tb_grupo')->result();

        # Sql Beneficio
        $this->db->where(array('id_grupo_fk' => 1, 'id_status_fk' => 1));
        $data['itens_benef'] = $this->db->get('tb_item_beneficio')->result();

        # Sql Status Cartao
        $this->db->order_by('status_cartao');
        $data['sts_card'] = $this->db->get('tb_status_cartao')->result();

        # Proximo Id
        $next_id = $this->db->query("SHOW TABLE STATUS LIKE 'tb_funcionario'");
        $data['next_id'] = $next_id->row(0);

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
        $funcionario->matricula     = $this->input->post('matricula');
        $funcionario->depto         = $this->input->post('depto');
        $funcionario->cargo         = $this->input->post('cargo');
        $funcionario->periodo       = $this->input->post('periodo');
        $funcionario->email         = $this->input->post('email_func');
        $funcionario->ender_empresa = $this->input->post('ender_empresa');

        if ($funcionario->cpf != NULL && $funcionario->nome_func != NULL && $funcionario->dt_nasc[0] != NULL && $funcionario->sexo != NULL && $funcionario->estado_civil != NULL &&
            $funcionario->rg != NULL && $funcionario->dt_exped[0]!= NULL &&  $funcionario->orgao_exped != NULL && $funcionario->uf_exped != NULL && $funcionario->nome_mae != NULL &&
            $funcionario->status != NULL && $funcionario->matricula != NULL && $funcionario->depto != NULL && $funcionario->cargo != NULL && $funcionario->periodo != NULL &&
            $funcionario->ender_empresa != NULL) {
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

        # Sql Grupo
        $this->db->order_by('grupo');
        $data['grps'] = $this->db->get('tb_grupo')->result();

        # Sql Beneficio
        $this->db->where(array('id_grupo_fk' => 1, 'id_status_fk' => 1));
        $data['itens_benef'] = $this->db->get('tb_item_beneficio')->result();

        # Sql Beneficio Geral
        $data['ibenef_geral'] = $this->db->get('tb_item_beneficio')->result();

        # Sql Status Cartao
        $this->db->order_by('status_cartao');
        $data['sts_card'] = $this->db->get('tb_status_cartao')->result();

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
        $funcionario->matricula     = $this->input->post('matricula');
        $funcionario->depto         = $this->input->post('depto');
        $funcionario->cargo         = $this->input->post('cargo');
        $funcionario->periodo       = $this->input->post('periodo');
        $funcionario->email         = $this->input->post('email_func');
        $funcionario->ender_empresa = $this->input->post('ender_empresa');

        if ($funcionario->id != NULL && $funcionario->cpf != NULL && $funcionario->nome_func != NULL && $funcionario->dt_nasc[0] != NULL && $funcionario->sexo != NULL &&
            $funcionario->estado_civil != NULL && $funcionario->rg != NULL && $funcionario->dt_exped[0]!= NULL &&  $funcionario->orgao_exped != NULL && $funcionario->uf_exped != NULL &&
            $funcionario->nome_mae != NULL &&  $funcionario->status != NULL && $funcionario->matricula != NULL && $funcionario->depto != NULL && $funcionario->cargo != NULL &&
            $funcionario->periodo != NULL && $funcionario->ender_empresa != NULL) {
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

        # Beneficio
        if (!empty($data['funcionario'])):
            $this->db->select('id_beneficio_pk, id_funcionario_fk, id_grupo_fk, grupo, id_item_beneficio_fk, descricao,
                               vl_unitario, qtd_diaria, num_cartao, id_status_cartao_fk, status_cartao');
            $this->db->from('vw_benefico_cartao');
            $this->db->where('id_funcionario_fk', $data['funcionario'][0]->id_funcionario_pk);
            $data['benef'] = $this->db->get()->result();
        endif;

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

    /**
     * Atualiza status do Funcionário
     *
     * @method alterStatus
     * @access public
     * @return obj Status da ação
     */
    public function alterStatus()
    {
        # Var
        $id      = $this->input->post('id');
        $status  = $this->input->post('id_status');
        $retorno = new stdClass();

        if ($id != NULL):
            try {
                # Atualiza tb_funcionario
                $data['id_status_fk'] = $status;
                $this->db->where('id_funcionario_pk', $id);
                $this->db->update('tb_funcionario', $data);

                $retorno->status = TRUE;
                $retorno->msg    = "Status Alterado com Sucesso!";
            } catch(Exception $e) {
                # logging_function($e->getMessage());
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao mudar o Status do Funcion&aacute;rio! Tente novamente...";
            }
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Funcion&aacute;rio n&atilde;o Localizado!";
        endif;

        print json_encode($retorno);
    }

    /**
     * Atualiza status de todos Funcionários
     *
     * @method alterStatusAll
     * @access public
     * @return obj Status da ação
     */
    public function alterStatusAll()
    {
        # Var
        $id_client = $this->input->post('id');
        $status    = $this->input->post('st');
        $retorno   = new stdClass();

        if ($id_client != NULL):
            try {
                # Atualiza tb_funcionario
                $data['id_status_fk'] = $status;
                $this->db->where('id_empresa_fk', $id_client);
                $this->db->update('tb_funcionario', $data);

                $retorno->status = TRUE;
                $retorno->msg    = "Status Alterados com Sucesso!";
            } catch(Exception $e) {
                # logging_function($e->getMessage());
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao mudar os Status dos Funcion&aacute;rios! Tente novamente...";
            }
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Empresa n&atilde;o Localizada!";
        endif;

        print json_encode($retorno);
    }

    /**
     * Atualiza periodo de beneficio do funcionário
     *
     * @method alterPeriodo
     * @access public
     * @return obj Status da ação
     */
    public function alterPeriodo()
    {
        # Var
        $id      = $this->input->post('id');
        $periodo = $this->input->post('id_period');
        $retorno = new stdClass();

        if ($id != NULL && $periodo != NULL):
            try {
                # Atualiza tb_dados_profissional
                $data['id_periodo_pk'] = $periodo;
                $this->db->where('id_funcionario_fk', $id);
                $this->db->update('tb_dados_profissional', $data);

                $retorno->status = TRUE;
                $retorno->msg    = "Per&iacute;odo Alterado com Sucesso!";
            } catch(Exception $e) {
                # logging_function($e->getMessage());
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao mudar o Per&iacute;odo do Funcion&aacute;rio! Tente novamente...";
            }
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao atualizar! Tente novamente...";
        endif;

        print json_encode($retorno);
    }

    /**
     * Atualiza periodo de beneficio de todos funcionários
     *
     * @method alterPeriodoAll
     * @access public
     * @return obj Status da ação
     */
    public function alterPeriodoAll()
    {
        # Var
        $id      = $this->input->post('id');
        $periodo = $this->input->post('id_period');
        $retorno = new stdClass();

        if ($id != NULL && $periodo != NULL):
            try {
                # Consultar Funcionarios
                $this->db->where('id_empresa_fk', $id);
                $funcs = $this->db->get('tb_funcionario')->result();

                if (!empty($funcs)):
                    foreach ($funcs as $valor):
                        # Atualiza tb_dados_profissional
                        $data['id_periodo_pk'] = $periodo;
                        $this->db->where('id_funcionario_fk', $valor->id_funcionario_pk);
                        $this->db->update('tb_dados_profissional', $data);
                    endforeach;
                endif;

                $retorno->status = TRUE;
                $retorno->msg    = "Per&iacute;odos Alterados com Sucesso!";
            } catch(Exception $e) {
                # logging_function($e->getMessage());
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao mudar os Per&iacute;odos dos Funcion&aacute;rios! Tente novamente...";
            }
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao atualizar! Tente novamente...";
        endif;

        print json_encode($retorno);
    }

}

/* End of file Funcionario.php */
/* Location: ./application/controllers/Funcionario.php */