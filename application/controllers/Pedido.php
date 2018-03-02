<?php

defined('BASEPATH') OR exit('No direct script access allowed');

# Boleto
use OpenBoleto\Banco\Santander;
use OpenBoleto\Agente;

# H2P - PDF
use H2P\Converter\PhantomJS;
use H2P\TempFile;

class Pedido extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_client') && !$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Pedido_model');
    }

    /**
     * Método para carregar o gerenciamento de pedidos
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        if ($this->session->userdata('user_vt')):
            # Titulo da pagina
            $header['titulo'] = "Gerenciamento de Pedidos";
            $this->load->view('header', $header);
            $this->load->view('pedido/pedido_gerenciar');
            $this->load->view('footer');
        elseif ($this->session->userdata('user_client')):
            # Titulo da pagina
            $header['titulo'] = "Acompanhamento de Pedidos";
            $this->load->view('header', $header);
            $this->load->view('pedido/pedido_acompanhar');
            $this->load->view('footer');
        endif;
    }

    /**
     * Método para carregar o gerenciamento de pedidos
     *
     * @method acompanhar
     * @access public
     * @return void
     */
    public function acompanhar()
    {
        if ($this->session->userdata('user_vt')):
            # Titulo da pagina
            $header['titulo'] = "Gerenciamento de Pedidos";
            $this->load->view('header', $header);
            $this->load->view('pedido/pedido_gerenciar');
            $this->load->view('footer');
        elseif ($this->session->userdata('user_client')):
            # Titulo da pagina
            $header['titulo'] = "Consulta de Pedidos";
            $this->load->view('header', $header);
            $this->load->view('pedido/pedido_acompanhar');
            $this->load->view('footer');
        endif;
    }

    /**
     * Método para carregar tela de solicitacao de pedido
     *
     * @method selecionar
     * @access public
     * @return void
     */
    public function selecionar()
    {
        # Titulo da pagina
        $header['titulo'] = "Selecionar Cliente";

        # Sql Empresa
        $this->db->select('id_empresa_pk, cnpj, nome_razao');
        $this->db->from('tb_empresa');
        $data['empresas'] = $this->db->get()->result();

        $this->load->view('header', $header);
        $this->load->view('pedido/pedido_cliente', $data);
        $this->load->view('footer');
    }

    /**
     * Método de setar cliente
     *
     * @method selCliente
     * @access public
     * @return obj Status da ação
     */
    public function selCliente()
    {
        $pedido  = new stdClass();
        $retorno = new stdClass();

        $pedido->id_empresa = $this->input->post('id_empresa');

        if ($pedido->id_empresa != NULL) {
            $retorno->status = TRUE;
            $retorno->msg    = "Ok";

            $dados = array(
                'id_client' => $pedido->id_empresa
            );
            $this->session->set_userdata($dados);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao solicitar! Tente novamente...";
        }

        # retornar resultado
        print json_encode($retorno);
    }

    /**
     * Método para carregar tela de cadastro de pedido
     *
     * @method solicitar
     * @access public
     * @return void
     */
    public function solicitar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerar Pedidos";

        # Sql para vw_cliente
        $this->db->where('id_empresa_pk', $this->session->userdata('id_client'));
        $data['empresa'] = $this->db->get('vw_cliente')->result();

        # Sql para tb_endereco_empresa
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $data['end_entrega'] = $this->db->get('tb_endereco_empresa')->result();

        $this->load->view('header', $header);
        $this->load->view('pedido/pedido_solicitar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de cadastro de pedido
     *
     * @method create
     * @access public
     * @return obj Status da ação
     */
    public function create()
    {
        $pedido   = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $pedido->id_empresa  = $this->input->post('id_empresa');
        $pedido->id_endereco = $this->input->post('id_end_entrega');
        $pedido->nome_resp   = $this->input->post('nome_resp');
        $pedido->dt_pgto     = isset($_POST['dt_pgto']) && $_POST['dt_pgto'] != "" ? explode('/', $_POST['dt_pgto']) : NULL;
        $pedido->periodo     = isset($_POST['periodo']) && $_POST['periodo'] != "" ? explode(' - ', $_POST['periodo']) : NULL;

        if ($pedido->id_empresa != NULL && $pedido->id_endereco != NULL && $pedido->nome_resp != NULL && $pedido->dt_pgto != NULL && $pedido->periodo != NULL) {
            $resposta = $this->Pedido_model->setPedido($pedido);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao solicitar! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para popular grid de acompanhamento de pedido
     *
     * @method buscarPedidoAcompanha
     * @access public
     * @return obj Lista de pedido cadastrados
     */
    public function buscarPedidoAcompanha()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "dt_pgto";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "DESC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Pedido_model->getPedidoAcompanha($search);

        print json_encode($resposta);
    }

    /**
     * Método de busca dos dados do Pedido para Exportação
     *
     * @method exportPedidoXls
     * @access public
     * @return obj Lista de pedido cadastrados
     */
    public function exportPedidoXls()
    {
        # Var
        $id_pedido = $this->input->post('id');

        # Instanciar modelo
        $resposta = $this->Pedido_model->getPedidoExport($id_pedido);

        print json_encode($resposta);
    }

    /**
     * Método para carregar o gerenciamento de pedidos
     *
     * @method gerenciar
     * @access public
     * @return void
     */
    public function gerenciar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerenciamento de Pedidos";

        $this->load->view('header', $header);
        $this->load->view('pedido/pedido_gerenciar');
        $this->load->view('footer');
    }

    /**
     * Método para popular grid de gerenciamento de pedido
     *
     * @method buscarPedido
     * @access public
     * @return obj Lista de pedido cadastrados
     */
    public function buscarPedido()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "dt_pgto";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "DESC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Pedido_model->getPedido($search);

        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de finalizacao de pedido
     *
     * @method finalizar
     * @access public
     * @return void
     */
    public function finalizar($id_pedido = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Finaliza&ccedil;&atilde;o de Pedido";

        # Sql para busca
        $this->db->where('id_pedido_pk', base64_decode($id_pedido));
        $data['pedido'] = $this->db->get('tb_pedido')->result();

        if (!empty($data['pedido']) && $data['pedido'][0]->boleto_gerado === 'n'):
            # Sql para vw_cliente
            $this->db->where('id_empresa_pk', $data['pedido'][0]->id_empresa_fk);
            $data['empresa'] = $this->db->get('vw_cliente')->result();

            # Sql para tb_endereco_empresa
            $this->db->where('id_empresa_fk', $data['pedido'][0]->id_empresa_fk);
            $data['end_entrega'] = $this->db->get('tb_endereco_empresa')->result();

            # Sql para tb_beneficio
            $this->db->select('id_funcionario_pk, cpf, nome, qtd_dia');
            $this->db->from('vw_funcionario');
            $this->db->where(array('id_empresa_fk' => $data['pedido'][0]->id_empresa_fk, 'id_status_fk' => 1));
            $data['beneficiario'] = $this->db->get()->result();

            if (!empty($data['beneficiario'])):
                $benef = array();
                $i     = 0;
                foreach ($data['beneficiario'] as $value):
                    $this->db->select('b.id_beneficio_pk, b.vl_unitario, b.qtd_diaria, b.id_grupo_fk, b.id_item_beneficio_fk, i.id_item_beneficio_pk, i.vl_rep_func, i.vl_repasse');
                    $this->db->from('tb_beneficio b');
                    $this->db->join('tb_item_beneficio i', 'b.id_item_beneficio_fk = i.id_item_beneficio_pk', 'inner');
                    $this->db->where('b.id_funcionario_fk', $value->id_funcionario_pk);
                    $resp = $this->db->get()->result();

                    if (!empty($resp)):
                        foreach ($resp as $vl):
                            $benef['id_grupo_fk'][$i]     = $vl->id_grupo_fk;
                            $benef['id_beneficio_pk'][$i] = $vl->id_beneficio_pk;
                            $benef['vl_unitario'][$i]     = $vl->vl_unitario;
                            $benef['qtd_diaria'][$i]      = $value->qtd_dia;
                            $benef['vl_total'][$i]        = ($vl->vl_unitario*$value->qtd_dia*$vl->qtd_diaria);
                            $benef['vl_repasse'][$i]      = isset($vl->vl_repasse) && $vl->vl_repasse != "" ? (($vl->vl_repasse*(($vl->vl_unitario*$value->qtd_dia*$vl->qtd_diaria)))/100) : 0;
                            $benef['vl_rep_func'][$i]     = isset($vl->vl_rep_func) && $vl->vl_rep_func != "" ? $vl->vl_rep_func : 0;
                            # Devidir Grupos para calcular taxas
                            # Grupo Vale Transporte
                            if ($vl->id_grupo_fk == "1") {
                                $benef['vl_total_vt'][$i] = ($vl->vl_unitario*$value->qtd_dia*$vl->qtd_diaria);
                            } else {
                                $benef['vl_total_vt'][$i] = 0;
                            }

                            # Grupo Vale Refeição
                            if ($vl->id_grupo_fk == "2") {
                                $benef['vl_total_cr'][$i] = ($vl->vl_unitario*$value->qtd_dia*$vl->qtd_diaria);
                            } else {
                                $benef['vl_total_cr'][$i] = 0;
                            }

                            # Grupo Vale Alimentação
                            if ($vl->id_grupo_fk == "3") {
                                $benef['vl_total_ca'][$i] = ($vl->vl_unitario*$value->qtd_dia*$vl->qtd_diaria);
                            } else {
                                $benef['vl_total_ca'][$i] = 0;
                            }

                            # Grupo Vale Combustivel
                            if ($vl->id_grupo_fk == "4") {
                                $benef['vl_total_cc'][$i] = ($vl->vl_unitario*$value->qtd_dia*$vl->qtd_diaria);
                            } else {
                                $benef['vl_total_cc'][$i] = 0;
                            }
                            $i++;
                        endforeach;
                    endif;
                endforeach;
            endif;

            # Calcular Taxas
            $data['vl_itens']    = 0;
            $data['vl_itens_vt'] = 0;
            $data['vl_itens_cr'] = 0;
            $data['vl_itens_ca'] = 0;
            $data['vl_itens_cc'] = 0;
            $data['vl_taxa']     = 0;
            $data['vl_repasse']  = 0;
            $data['vl_total']    = 0;
            if (!empty($benef)):
                $data['vl_itens']       = array_sum($benef['vl_total']);
                $data['vl_itens_vt']    = array_sum($benef['vl_total_vt']);
                $data['vl_itens_cr']    = array_sum($benef['vl_total_cr']);
                $data['vl_itens_ca']    = array_sum($benef['vl_total_ca']);
                $data['vl_itens_cc']    = array_sum($benef['vl_total_cc']);
                $data['vl_taxa_adm_vt'] = $data['vl_itens_vt'] != 0 ? (round($data['vl_itens_vt']*($data['empresa'][0]->taxa_adm/100), 2)) : 0;
                $data['vl_taxa_fx_p']   = $data['vl_itens_vt'] != 0 ? (round($data['vl_itens_vt']*($data['empresa'][0]->taxa_fixa_perc/100), 2)) : 0;
                $data['vl_taxa_adm_cr'] = $data['vl_itens_cr'] != 0 ? (round($data['vl_itens_cr']*($data['empresa'][0]->taxa_adm_cr/100), 2)) : 0;
                $data['vl_taxa_adm_ca'] = $data['vl_itens_ca'] != 0 ? (round($data['vl_itens_ca']*($data['empresa'][0]->taxa_adm_ca/100), 2)) : 0;
                $data['vl_taxa_adm_cc'] = $data['vl_itens_cc'] != 0 ? (round($data['vl_itens_cc']*($data['empresa'][0]->taxa_adm_cc/100), 2)) : 0;
                $data['vl_taxa']        = ($data['vl_taxa_adm_vt']+$data['vl_taxa_fx_p']+$data['empresa'][0]->taxa_fixa_real+$data['empresa'][0]->taxa_entrega+$data['vl_taxa_adm_cr']+$data['vl_taxa_adm_ca']+$data['vl_taxa_adm_cc']);
                $data['vl_repasse']     = round(array_sum($benef['vl_repasse']), 2)+array_sum($benef['vl_rep_func']);
                $data['vl_total']       = ($data['vl_itens']+$data['vl_taxa']+$data['vl_repasse']);
            endif;

            $this->load->view('header', $header);
            $this->load->view('pedido/pedido_finalizar', $data);
            $this->load->view('footer');
        else:
            redirect(base_url('/pedido/acompanhar'));
        endif;
    }

    /**
     * Método de finalizacao de pedido
     *
     * @method update
     * @access public
     * @return obj Status da ação
     */
    public function update()
    {
        $pedido   = new stdClass();
        $retorno  = new stdClass();
        $resposta = "";

        $pedido->id           = $this->input->post('id_pedido');
        $pedido->dt_pgto      = isset($_POST['dt_pgto']) && $_POST['dt_pgto'] != "" ? explode('/', $_POST['dt_pgto']) : NULL;
        $pedido->periodo      = isset($_POST['periodo']) && $_POST['periodo'] != "" ? explode(' - ', $_POST['periodo']) : NULL;
        $pedido->id_func      = $this->input->post('id_funcionario');
        $pedido->taxa_adm     = $this->input->post('taxa_adm');
        $pedido->taxa_entrega = $this->input->post('taxa_entrega');
        $pedido->taxa_repasse = $this->input->post('taxa_repasse');
        $pedido->taxa_fx_perc = $this->input->post('taxa_fixa_perc');
        $pedido->taxa_fx_real = $this->input->post('taxa_fixa_real');
        $pedido->taxa_adm_cr  = $this->input->post('taxa_adm_cr');
        $pedido->taxa_adm_ca  = $this->input->post('taxa_adm_ca');
        $pedido->taxa_adm_cc  = $this->input->post('taxa_adm_cc');
        $pedido->id_cliente   = $this->input->post('id_cliente');

        if ($pedido->id != NULL && $pedido->dt_pgto != NULL && $pedido->periodo != NULL && $pedido->id_func != NULL) {
            $resposta = $this->Pedido_model->finalizaPedido($pedido);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Finalizar o Pedido! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método para carregar tela de visualização de pedido
     *
     * @method ver
     * @access public
     * @return void
     */
    public function ver($id_pedido = null)
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Pedido";

        # Sql para Pedido
        $this->db->select("p.id_pedido_pk, p.id_empresa_fk, e.cnpj, e.nome_razao, p.id_end_empresa_fk, en.cep, en.logradouro, en.numero, en.complemento, en.bairro, en.resp_recebimento,
                           DATE_FORMAT(p.dt_pgto, '%d/%m/%Y') AS dt_pago, CONCAT(DATE_FORMAT(p.dt_ini_beneficio, '%d/%m/%Y'), ' a ', DATE_FORMAT(p.dt_fin_beneficio, '%d/%m/%Y')) AS periodo,
                           p.vl_itens, p.vl_taxa, p.vl_total, p.id_status_pedido_fk, s.status_pedido, IF (p.boleto_gerado = 's', 'Sim', 'Não') AS boleto,
                           DATE_FORMAT(p.dt_hr_solicitacao, '%d/%m/%Y') AS dt_solic", FALSE);
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_endereco_empresa en', 'p.id_empresa_fk = en.id_empresa_fk', 'inner');
        $this->db->join('tb_status_pedido s', 'p.id_status_pedido_fk = s.id_status_pedido_pk', 'inner');
        $this->db->where('p.id_pedido_pk', $id_pedido);
        $data['pedido'] = $this->db->get()->result();

        # Sql para Beneficiarios
        $this->db->select("DISTINCT(f.cpf), f.nome, b.id_funcionario_fk", FALSE);
        $this->db->from('tb_item_pedido i');
        $this->db->join('tb_beneficio b', 'i.id_beneficio_fk = b.id_beneficio_pk', 'inner');
        $this->db->join('tb_funcionario f', 'b.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->where('i.id_pedido_fk', $id_pedido);
        $this->db->order_by('f.nome', 'ASC');
        $data['benefs'] = $this->db->get()->result();

        # Sql Itens dos Beneficiarios
        $this->db->select('ip.id_item_pedido_pk, ip.id_pedido_fk, ip.id_beneficio_fk, b.id_funcionario_fk,
                           b.id_item_beneficio_fk, ib.descricao, ib.vl_unitario');
        $this->db->from('tb_item_pedido ip');
        $this->db->join('tb_beneficio b', 'ip.id_beneficio_fk = b.id_beneficio_pk', 'inner');
        $this->db->join('tb_item_beneficio ib', 'b.id_item_beneficio_fk = ib.id_item_beneficio_pk', 'inner');
        $this->db->where('ip.id_pedido_fk', $id_pedido);
        $this->db->order_by('b.id_funcionario_fk', 'ASC');
        $data['itemben'] = $this->db->get()->result();

        $this->load->view('header', $header);
        if ($this->session->userdata('user_vt')):
            $this->load->view('pedido/pedido_ver_vt', $data);
        elseif ($this->session->userdata('user_client')):
            $this->load->view('pedido/pedido_ver', $data);
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
        $retorno   =  new stdClass();
        $resposta  = "";
        $id_pedido = filter_input(INPUT_POST, "id");

        if ($id_pedido !== NULL) {
            $resposta = $this->Pedido_model->delPedido($id_pedido);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Excluir! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método responsável pela geracao de boleto
     *
     * @method gerarBoleto
     * @access public
     * @return static Boleto
     */
    public function gerarBoleto($id_pedido = null)
    {
        # Selecionar Pedido
        $this->db->select("id_pedido_pk, id_empresa_fk, id_end_empresa_fk, dt_pgto, DATE_FORMAT(dt_ini_beneficio, '%d/%m/%Y') AS dt_ini_beneficio,
                           DATE_FORMAT(dt_fin_beneficio, '%d/%m/%Y') AS dt_fin_beneficio, vl_itens, vl_taxa, vl_total, id_status_pedido_fk, boleto_gerado,
                           dt_hr_solicitacao", FALSE);
        $this->db->from('tb_pedido');
        $this->db->where('id_pedido_pk', base64_decode($id_pedido));
        $pedido = $this->db->get()->result();

        if (!empty($pedido)):
            # Pedido
            $dt_pgto      = !empty($pedido) && $pedido[0]->dt_pgto != "" ? $pedido[0]->dt_pgto : NULL;
            $dt_ini_benef = !empty($pedido) && $pedido[0]->dt_ini_beneficio != "" ? $pedido[0]->dt_ini_beneficio : NULL;
            $dt_fin_benef = !empty($pedido) && $pedido[0]->dt_fin_beneficio != "" ? $pedido[0]->dt_fin_beneficio : NULL;
            $vl_itens     = !empty($pedido) && $pedido[0]->vl_itens != "" ? $pedido[0]->vl_itens : NULL;
            $vl_taxa      = !empty($pedido) && $pedido[0]->vl_taxa != "" ? $pedido[0]->vl_taxa : NULL;
            $vl_total     = !empty($pedido) && $pedido[0]->vl_total != "" ? $pedido[0]->vl_total : NULL;
            $dt_hr_solic  = !empty($pedido) && $pedido[0]->dt_hr_solicitacao != "" ? $pedido[0]->dt_hr_solicitacao : NULL;

            # Selecionar Cliente e Endereco
            $this->db->select('c.id_empresa_pk, c.cnpj, c.nome_razao, e.cep, e.logradouro, e.numero, e.complemento, e.bairro, es.estado, es.sigla, ci.cidade');
            $this->db->from('tb_empresa c');
            $this->db->join('tb_endereco_empresa e', 'c.id_empresa_pk = e.id_empresa_fk', 'inner');
            $this->db->join('tb_estado es', 'e.id_estado_fk = es.id_estado_pk', 'inner');
            $this->db->join('tb_cidade ci', 'e.id_cidade_fk = ci.id_cidade_pk', 'inner');
            $this->db->where(array('c.id_empresa_pk' => $pedido[0]->id_empresa_fk, 'e.id_endereco_empresa_pk' => $pedido[0]->id_end_empresa_fk));
            $cliente = $this->db->get()->result();

            # Cliente
            $cnpj       = !empty($cliente) && $cliente[0]->cnpj != "" ? $cliente[0]->cnpj : NULL;
            $empresa    = !empty($cliente) && $cliente[0]->nome_razao != "" ? $cliente[0]->nome_razao : NULL;
            $cep        = !empty($cliente) && $cliente[0]->cep != "" ? $cliente[0]->cep : NULL;
            $lograd     = !empty($cliente) && $cliente[0]->logradouro != "" ? $cliente[0]->logradouro : NULL;
            $numero     = !empty($cliente) && $cliente[0]->numero != "" ? ", nº ".$cliente[0]->numero : NULL;
            $compl      = !empty($cliente) && $cliente[0]->complemento != "" ? ", ".$cliente[0]->complemento : NULL;
            $bairro     = !empty($cliente) && $cliente[0]->bairro != "" ? ", ".$cliente[0]->bairro : NULL;
            $bairro_m   = !empty($cliente) && $cliente[0]->bairro != "" ? $cliente[0]->bairro : NULL;
            $sigla      = !empty($cliente) && $cliente[0]->sigla != "" ? $cliente[0]->sigla : NULL;
            $cidade     = !empty($cliente) && $cliente[0]->cidade != "" ? $cliente[0]->cidade : NULL;
            $endfull    = $lograd.$numero.$compl.$bairro;
            $endfull_m  = $lograd.$numero.$compl;
            $benef_nome = "VTCARDS COMERCIO E SERVICOS LTDA";
            $benef_cnpj = "25.533.823/0001-03";
            $benef_end  = "Rua Voluntários da Pátria, 654, Sala 302, Santana";
            $benef_cep  = "02010-000";
            $benef_cid  = "São Paulo";
            $benef_uf   = "SP";

            $pagador      = new Agente($empresa, $cnpj, $endfull, $cep, $cidade, $sigla);
            $beneficiario = new Agente($benef_nome, $benef_cnpj, $benef_end, $benef_cep, $benef_cid, $benef_uf);

            $boleto = new Santander(array(
                # Parâmetros obrigatórios
                'dataVencimento' => new DateTime($dt_pgto),
                'valor'          => $vl_total,
                'sequencial'     => str_pad(base64_decode($id_pedido), 7, 0, STR_PAD_LEFT), # Até 13 dígitos
                'sacado'         => $pagador,
                'cedente'        => $beneficiario,
                'agencia'        => "0833", // Até 4 dígitos
                'carteira'       => 101, // 101, 102 ou 201
                'conta'          => 8544140, // Código do cedente: Até 7 dígitos
                # IOS – Seguradoras (Se 7% informar 7. Limitado a 9%)
                # Demais clientes usar 0 (zero)
                'ios' => '0', // Apenas para o Santander
                # Parâmetros recomendáveis
                # 'logoPath' => base_url('/assets/imgs/vtcards_logo_100x40.png'), // Logo da sua empresa - #357CA5
                # 'contaDv'   => 96,
                # 'agenciaDv' => 1,
                'descricaoDemonstrativo' => array(// Até 5
                    "Benefícios - Per&iacute;odo: $dt_ini_benef a $dt_fin_benef",
                ),
                'instrucoes' => array(// Até 8
                    'Após o vencimento pagar somente no Banco Santander'
                ),
                # Parâmetros opcionais
                # 'resourcePath' => '../resources',
                'moeda'             => Santander::MOEDA_REAL,
                'dataDocumento'     => new DateTime($dt_hr_solic),
                'dataProcessamento' => new DateTime(),
                # 'contraApresentacao'   => true,
                # 'pagamentoMinimo'      => 23.00,
                'aceite'               => 'N',
                # 'especieDoc'           => 'ABC',
                # 'numeroDocumento'      => '123.456.789',
                # 'usoBanco'             => 'Uso banco',
                # 'layout'               => 'layout.phtml',
                # 'logoPath'             => 'http://boletophp.com.br/img/opensource-55x48-t.png',
                # 'sacadorAvalista'      => new Agente('Antônio da Silva', '02.123.123/0001-11'),
                # 'descontosAbatimentos' => 123.12,
                # 'moraMulta'            => 123.12,
                # 'outrasDeducoes'       => 123.12,
                # 'outrosAcrescimos'     => 123.12,
                # 'valorCobrado'         => 123.12,
                # 'valorUnitario'        => 123.12,
                'quantidade'             => 1,
            ));

            # Boleto gerado
            $dados                  = array();
            $dados['boleto_gerado'] = 's';
            $this->db->where('id_pedido_pk', base64_decode($id_pedido));
            $this->db->update('tb_pedido', $dados);

            $boleto_html = $boleto->getOutput();

            # Name file
            $date      = date("Ymd");
            $name_file = "boleto_".base64_decode($id_pedido)."_".$date.".pdf";

            /* $converter = new PhantomJS();
            $input     = new TempFile($boleto_html, 'html');

            # Convert e Salva no diretorio
            $converter->convert($input, FILE_PATH.$name_file); */

            # Salvar dados do boleto
            $dados_boleto                          = array();
            $dados_boleto['id_pedido_fk']          = base64_decode($id_pedido);
            $dados_boleto['pagador_nome']          = $empresa;
            $dados_boleto['pagador_cnpj_cpf']      = $cnpj;
            $dados_boleto['pagador_endereco']      = $endfull_m;
            $dados_boleto['pagador_bairro']        = $bairro_m;
            $dados_boleto['pagador_cep']           = $cep;
            $dados_boleto['pagador_cidade']        = $cidade;
            $dados_boleto['pagador_uf']            = $sigla;
            $dados_boleto['beneficiario_nome']     = $benef_nome;
            $dados_boleto['beneficiario_cnpj_cpf'] = $benef_cnpj;
            $dados_boleto['beneficiario_endereco'] = $benef_end;
            $dados_boleto['beneficiario_cep']      = $benef_cep;
            $dados_boleto['beneficiario_cidade']   = $benef_cid;
            $dados_boleto['beneficiario_uf']       = $benef_uf;
            $dados_boleto['dt_vencimento']         = $dt_pgto;
            $dados_boleto['valor']                 = $vl_total;
            $dados_boleto['nosso_numero']          = str_pad(base64_decode($id_pedido), 7, 0, STR_PAD_LEFT);
            $dados_boleto['carteira']              = 101;
            $dados_boleto['agencia']               = "0833";
            $dados_boleto['agencia_dv']            = NULL;
            $dados_boleto['conta']                 = 8544140;
            $dados_boleto['conta_dv']              = 96;
            $dados_boleto['descr_demostrativo']    = "Benefícios - Per&iacute;odo: $dt_ini_benef a $dt_fin_benef";
            $dados_boleto['instrucao']             = "Após o vencimento pagar somente no Banco Santander";
            $dados_boleto['nome_boleto']           = $name_file;
            $dados_boleto['dt_emissao']            = date("Y-m-d");
            $dados_boleto['id_status_boleto_fk']   = 1;

            # Grava Boleto
            $this->db->insert('tb_boleto', $dados_boleto);

            # Enviar Email
            # Msg
            $msg                 = array();
            $msg['sender']       = "faleconosco@vtcards.com.br";
            $msg['sender_name']  = "VTCards";
            $msg['email']        = "pedidos@vtcards.com.br";
            $msg['destinatario'] = "Pedidos";
            $msg['subject']      = "Solicitação de Novo Pedido";
            $msg['mensagem']     = "Olá!<br><br>
                                    Um novo pedido foi solicitado:<br><br>
                                    ID DO PEDIDO: ".base64_decode($id_pedido)."<br>
                                    CNPJ: $cnpj<br>
                                    CLIENTE: $empresa<br>
                                    VALOR: $vl_total<br>
                                    DATA DE VENCIMENTO: $dt_pgto<br><br>
                                    Att.";
            # Enviar email
            $this->sendMailGeral($msg);

            echo $boleto_html;

        else:
            echo "<script>alert('Erro ao gerar o Boleto!'); window.close();</script>";
        endif;
    }

    /**
     * Método para remitir boleto em HTML
     *
     * @method remitirBoletoHtml
     * @access public
     * @param integer $id_pedido Id do Pedido
     * @return obj Status da Açao
     */
    public function remitirBoletoHtml($id_pedido)
    {
        # Consultar boleto
        $this->db->where('id_pedido_fk', $id_pedido);
        $row_bol = $this->db->get('tb_boleto')->result();

        if (!empty($row_bol)):
            # Cliente
            $cnpj        = !empty($row_bol) && $row_bol[0]->pagador_cnpj_cpf != "" ? $row_bol[0]->pagador_cnpj_cpf : NULL;
            $empresa     = !empty($row_bol) && $row_bol[0]->pagador_nome != "" ? $row_bol[0]->pagador_nome : NULL;
            $cep         = !empty($row_bol) && $row_bol[0]->pagador_cep != "" ? $row_bol[0]->pagador_cep : NULL;
            $endfull     = !empty($row_bol) && $row_bol[0]->pagador_endereco != "" ? $row_bol[0]->pagador_endereco : NULL;
            $sigla       = !empty($row_bol) && $row_bol[0]->pagador_uf != "" ? $row_bol[0]->pagador_uf : NULL;
            $cidade      = !empty($row_bol) && $row_bol[0]->pagador_cidade != "" ? $row_bol[0]->pagador_cidade : NULL;
            $benef_nome  = !empty($row_bol) && $row_bol[0]->beneficiario_nome != "" ? $row_bol[0]->beneficiario_nome : NULL;
            $benef_cnpj  = !empty($row_bol) && $row_bol[0]->beneficiario_cnpj_cpf != "" ? $row_bol[0]->beneficiario_cnpj_cpf : NULL;
            $benef_end   = !empty($row_bol) && $row_bol[0]->beneficiario_endereco != "" ? $row_bol[0]->beneficiario_endereco : NULL;
            $benef_cep   = !empty($row_bol) && $row_bol[0]->beneficiario_cep != "" ? $row_bol[0]->beneficiario_cep : NULL;
            $benef_cid   = !empty($row_bol) && $row_bol[0]->beneficiario_cidade != "" ? $row_bol[0]->beneficiario_cidade : NULL;
            $benef_uf    = !empty($row_bol) && $row_bol[0]->beneficiario_uf != "" ? $row_bol[0]->beneficiario_uf : NULL;
            $dt_pgto     = !empty($row_bol) && $row_bol[0]->dt_vencimento != "" ? $row_bol[0]->dt_vencimento : NULL;
            $vl_total    = !empty($row_bol) && $row_bol[0]->valor != "" ? $row_bol[0]->valor : NULL;
            $descr_demo  = !empty($row_bol) && $row_bol[0]->descr_demostrativo != "" ? $row_bol[0]->descr_demostrativo : NULL;
            $instrucao   = !empty($row_bol) && $row_bol[0]->instrucao != "" ? $row_bol[0]->instrucao : NULL;
            $dt_hr_solic = !empty($row_bol) && $row_bol[0]->dt_emissao != "" ? $row_bol[0]->dt_emissao : NULL;

            $pagador      = new Agente($empresa, $cnpj, $endfull, $cep, $cidade, $sigla);
            $beneficiario = new Agente($benef_nome, $benef_cnpj, $benef_end, $benef_cep, $benef_cid, $benef_uf);

            $boleto = new Santander(array(
                # Parâmetros obrigatórios
                'dataVencimento' => new DateTime($dt_pgto),
                'valor'          => $vl_total,
                'sequencial'     => str_pad($id_pedido, 7, 0, STR_PAD_LEFT), # Até 13 dígitos
                'sacado'         => $pagador,
                'cedente'        => $beneficiario,
                'agencia'        => "0833", // Até 4 dígitos
                'carteira'       => 101, // 101, 102 ou 201
                'conta'          => 8544140, // Código do cedente: Até 7 dígitos
                # IOS – Seguradoras (Se 7% informar 7. Limitado a 9%)
                # Demais clientes usar 0 (zero)
                'ios' => '0', // Apenas para o Santander
                # Parâmetros recomendáveis
                # 'logoPath' => base_url('/assets/imgs/vtcards_logo_100x40.png'), // Logo da sua empresa - #357CA5
                # 'contaDv'   => 96,
                # 'agenciaDv' => 1,
                'descricaoDemonstrativo' => array(
                    $descr_demo
                ),
                'instrucoes' => array(// Até 8
                    $instrucao
                ),
                # Parâmetros opcionais
                # 'resourcePath' => '../resources',
                'moeda'             => Santander::MOEDA_REAL,
                'dataDocumento'     => new DateTime($dt_hr_solic),
                'dataProcessamento' => new DateTime(),
                # 'contraApresentacao'   => true,
                # 'pagamentoMinimo'      => 23.00,
                'aceite'               => 'N',
                # 'especieDoc'           => 'ABC',
                # 'numeroDocumento'      => '123.456.789',
                # 'usoBanco'             => 'Uso banco',
                # 'layout'               => 'layout.phtml',
                # 'logoPath'             => 'http://boletophp.com.br/img/opensource-55x48-t.png',
                # 'sacadorAvalista'      => new Agente('Antônio da Silva', '02.123.123/0001-11'),
                # 'descontosAbatimentos' => 123.12,
                # 'moraMulta'            => 123.12,
                # 'outrasDeducoes'       => 123.12,
                # 'outrosAcrescimos'     => 123.12,
                # 'valorCobrado'         => 123.12,
                # 'valorUnitario'        => 123.12,
                'quantidade'             => 1,
            ));

            $boleto_html = $boleto->getOutput();

            echo $boleto_html;

        else:
            echo "<script>alert('Erro ao gerar o Boleto!'); window.close();</script>";
        endif;
    }

    /**
     * Método para alterar status de um pedido
     *
     * @method alterStatusPedido
     * @access public
     * @return obj Status da Açao
     */
    public function alterStatusPedido()
    {
        # Dados
        $retorno           = new stdClass();
        $status            = new stdClass();
        $status->id_pedido = $this->input->post('id_pedido_pk');
        $status->id_status = $this->input->post('status');
        $status->id_user   = ($this->session->userdata('id_vt')) ? $this->session->userdata('id_vt') : FALSE;

        if ($status->id_pedido != NULL && $status->id_status != NULL && $status->id_user != NULL):
            $retorno = $this->Pedido_model->alterStPedido($status);
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um Erro ao Alterar o Status! Tente Novamente...";
        endif;

        print json_encode($retorno);
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
     * Método para buscar item do beneficio informado
     *
     * @method itemBenPedido
     * @access public
     * @return obj Status da Açao
     */
    public function itemBenPedido()
    {
        # Dados
        $retorno   = new stdClass();
        $id_pedido = $this->input->post('id');

        if ($id_pedido != NULL):
            $retorno = $this->Pedido_model->getItemBenPedido($id_pedido);
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um Erro ao Buscar os Benef&iacute;cios! Tente Novamente...";
        endif;

        print json_encode($retorno);
    }

    /**
     * Método para alterar status de um beneficio
     *
     * @method valCredBen
     * @access public
     * @return obj Status da Açao
     */
    public function valCredBen()
    {
        # Dados
        $retorno  = new stdClass();
        $status   = $this->input->post('st');
        $id_benef = $this->input->post('id');

        if ($status != NULL && $id_benef != NULL):
            $retorno = $this->Pedido_model->setValCredBen($status, $id_benef);
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro na Valida&ccedil;&atilde;o dos Cr&eacute;ditos! Favor recarregar a p&aacute;gina.";
        endif;

        print json_encode($retorno);
    }

    /**
     * Método para alterar status de varios beneficios pelo id do pedido
     *
     * @method valAllCredBen
     * @access public
     * @return obj Status da Açao
     */
    public function valAllCredBen()
    {
        # Dados
        $retorno   = new stdClass();
        $status    = $this->input->post('st');
        $id_pedido = $this->input->post('id');

        if ($status != NULL && $id_pedido != NULL):
            $retorno = $this->Pedido_model->setValAllCred($status, $id_pedido);
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro na Valida&ccedil;&atilde;o dos Cr&eacute;ditos! Favor recarregar a p&aacute;gina.";
        endif;

        print json_encode($retorno);
    }

}

/* End of file Pedido.php */
/* Location: ./application/controllers/Pedido.php */
