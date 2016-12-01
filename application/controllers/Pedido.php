<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use OpenBoleto\Banco\Santander;
use OpenBoleto\Agente;

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
        # Titulo da pagina
        $header['titulo'] = "Acompanhamento de Pedidos";

        $this->load->view('header', $header);
        $this->load->view('pedido/pedido_acompanhar');
        $this->load->view('footer');
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
        $header['titulo'] = "Solicita&ccedil;&atilde;o de Pedido";

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
            $this->db->select('id_funcionario_pk, cpf, nome');
            $this->db->from('tb_funcionario');
            $this->db->where(array('id_empresa_fk' => $data['pedido'][0]->id_empresa_fk, 'id_status_fk' => 1));
            $data['beneficiario'] = $this->db->get()->result();

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

        if ($pedido->id != NULL && $pedido->dt_pgto != NULL && $pedido->periodo != NULL && $pedido->id_func != NULL &&
            $pedido->taxa_adm != NULL && $pedido->taxa_entrega != NULL) {
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
        $this->db->select("DISTINCT(f.cpf), f.nome", FALSE);
        $this->db->from('tb_item_pedido i');
        $this->db->join('tb_beneficio b', 'i.id_beneficio_fk = b.id_beneficio_pk', 'inner');
        $this->db->join('tb_funcionario f', 'b.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->where('i.id_pedido_fk', $id_pedido);
        $this->db->order_by('f.nome', 'ASC');
        $data['benefs'] = $this->db->get()->result();

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
            $cnpj    = !empty($cliente) && $cliente[0]->cnpj != "" ? $cliente[0]->cnpj : NULL;
            $empresa = !empty($cliente) && $cliente[0]->nome_razao != "" ? $cliente[0]->nome_razao : NULL;
            $cep     = !empty($cliente) && $cliente[0]->cep != "" ? $cliente[0]->cep : NULL;
            $lograd  = !empty($cliente) && $cliente[0]->logradouro != "" ? $cliente[0]->logradouro : NULL;
            $numero  = !empty($cliente) && $cliente[0]->numero != "" ? ", nº ".$cliente[0]->numero : NULL;
            $compl   = !empty($cliente) && $cliente[0]->complemento != "" ? ", ".$cliente[0]->complemento : NULL;
            $bairro  = !empty($cliente) && $cliente[0]->bairro != "" ? ", ".$cliente[0]->bairro : NULL;
            $sigla   = !empty($cliente) && $cliente[0]->sigla != "" ? $cliente[0]->sigla : NULL;
            $cidade  = !empty($cliente) && $cliente[0]->cidade != "" ? $cliente[0]->cidade : NULL;
            $endfull = $lograd.$numero.$compl.$bairro;

            $sacado  = new Agente($empresa, $cnpj, $endfull, $cep, $cidade, $sigla);
            $cedente = new Agente('VTCARDS', '00.000.00/0001-10', 'Rua Voluntários da Pátria', '02010-000', 'São Paulo', 'SP');

            $boleto = new Santander(array(
                # Parâmetros obrigatórios
                'dataVencimento' => new DateTime($dt_pgto),
                'valor' => $vl_total,
                'sequencial' => 12345678901, // Até 13 dígitos
                'sacado' => $sacado,
                'cedente' => $cedente,
                'agencia' => 1234, // Até 4 dígitos
                'carteira' => 102, // 101, 102 ou 201
                'conta' => 1234567, // Código do cedente: Até 7 dígitos
                # IOS – Seguradoras (Se 7% informar 7. Limitado a 9%)
                # Demais clientes usar 0 (zero)
                'ios' => '0', // Apenas para o Santander
                # Parâmetros recomendáveis
                # 'logoPath' => base_url('/assets/imgs/vtcards_logo_100x40.png'), // Logo da sua empresa - #357CA5
                'contaDv' => 2,
                'agenciaDv' => 1,
                'descricaoDemonstrativo' => array(// Até 5
                    "Benefícios Vale Transporte - Per&iacute;odo: $dt_ini_benef a $dt_fin_benef",
                ),
                'instrucoes' => array(// Até 8
                    'Após o vencimento pagar somente no Banco Santander'
                ),
                # Parâmetros opcionais
                # 'resourcePath' => '../resources',
                'moeda' => Santander::MOEDA_REAL,
                'dataDocumento' => new DateTime($dt_hr_solic),
                'dataProcessamento' => new DateTime(),
                # 'contraApresentacao' => true,
                # 'pagamentoMinimo' => 23.00,
                # 'aceite' => 'N',
                # 'especieDoc' => 'ABC',
                # 'numeroDocumento' => '123.456.789',
                # 'usoBanco' => 'Uso banco',
                # 'layout' => 'layout.phtml',
                # 'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
                # 'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
                # 'descontosAbatimentos' => 123.12,
                # 'moraMulta' => 123.12,
                # 'outrasDeducoes' => 123.12,
                # 'outrosAcrescimos' => 123.12,
                # 'valorCobrado' => 123.12,
                # 'valorUnitario' => 123.12,
                'quantidade' => 1,
            ));

            # Boleto gerado
            $dados                  = array();
            $dados['boleto_gerado'] = 's';
            $this->db->where('id_pedido_pk', base64_decode($id_pedido));
            $this->db->update('tb_pedido', $dados);

            echo $boleto->getOutput();
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
}

/* End of file Pedido.php */
/* Location: ./application/controllers/Pedido.php */