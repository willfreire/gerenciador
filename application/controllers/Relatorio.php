<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_client') && !$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Relatorio_model');

    }

    /**
     * Método para realizar relatorio de funcionario
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Relat&oacute;rio de Funcion&aacute;rios";

        $this->load->view('header', $header);
        $this->load->view('relatorio/relatorio_funcionario');
        $this->load->view('footer');
    }

    /**
     * Método para realizar relatorio de funcionario
     *
     * @method funcionario
     * @access public
     * @return void
     */
    public function funcionario()
    {
        # Titulo da pagina
        $header['titulo'] = "Relat&oacute;rio de Funcion&aacute;rios";

        # Pedido
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $data['pedidos'] = $this->db->get('tb_pedido')->result();

        # Departamento
        $this->db->select('DISTINCT(vw.id_departamento_fk) AS id_departamento_fk, vw.departamento', FALSE);
        $this->db->from('vw_funcionario vw');
        $this->db->where('vw.id_empresa_fk', $this->session->userdata('id_client'));
        $this->db->order_by('vw.departamento', 'ASC');
        $data['deptos'] = $this->db->get('tb_pedido')->result();

        $this->load->view('header', $header);
        $this->load->view('relatorio/relatorio_funcionario', $data);
        $this->load->view('footer');
    }

    /**
     * Método para realizar relatorio de funcionario pelo VT
     *
     * @method funcionario_vt
     * @access public
     * @return void
     */
    public function funcionario_vt()
    {
        # Titulo da pagina
        $header['titulo'] = "Relat&oacute;rio de Funcion&aacute;rios";

        # Empresa
        $this->db->select("DISTINCT(e.id_empresa_pk), e.cnpj, e.nome_razao", FALSE);
        $this->db->from('tb_empresa e');
        $this->db->join('tb_pedido p', 'e.id_empresa_pk = p.id_empresa_fk', 'inner');
        $this->db->order_by('e.nome_razao', 'ASC');
        $data['clientes'] = $this->db->get()->result();

        $this->load->view('header', $header);
        $this->load->view('relatorio/relatorio_funcionario_vt', $data);
        $this->load->view('footer');
    }

    /**
     * Método para buscar ids dos pedidos por cliente
     *
     * @method getIdPedidoCliente
     * @access public
     * @return obj Listas de Pedidos
     */
    public function getIdPedidoCliente()
    {
        # Vars
        $retorno    = new stdClass();
        $id_cliente = $this->input->post('id');

        if ($id_cliente != ""):
            $this->db->select("id_pedido_pk");
            $this->db->from("tb_pedido");
            $this->db->where("id_empresa_fk", $id_cliente);
            $rows = $this->db->get()->result();

            if (!empty($rows)) {
                $retorno->status = TRUE;
                $retorno->msg    = "Ok!";
                $retorno->dados  = $rows;
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Nenhum Pedido Encontrado!";
            }
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "N&atilde;o poss&iacute;vel localizar o Cliente!";
        endif;

        print json_encode($retorno);
    }

    /**
     * Método para buscar ids dos departamentos por cliente
     *
     * @method getIdDeptoCliente
     * @access public
     * @return obj Lista dos Departamentos
     */
    public function getIdDeptoCliente()
    {
        # Vars
        $retorno    = new stdClass();
        $id_cliente = $this->input->post('id');

        if ($id_cliente != ""):
            $this->db->select("DISTINCT(d.id_departamento_pk) AS id_departamento_pk, d.departamento", FALSE);
            $this->db->from("tb_dados_profissional dp");
            $this->db->join("tb_funcionario f", "f.id_funcionario_pk = dp.id_funcionario_fk", "inner");
            $this->db->join("tb_pedido p", "p.id_empresa_fk = f.id_empresa_fk", "inner");
            $this->db->join("tb_departamento d", "d.id_departamento_pk = dp.id_departamento_fk", "inner");
            $this->db->where("p.id_empresa_fk", $id_cliente);
            $this->db->order_by("departamento", "ASC");
            $rows = $this->db->get()->result();

            if (!empty($rows)) {
                $retorno->status = TRUE;
                $retorno->msg    = "Ok!";
                $retorno->dados  = $rows;
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Nenhum Pedido Encontrado!";
            }
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "N&atilde;o poss&iacute;vel localizar o Cliente!";
        endif;

        print json_encode($retorno);
    }

    /**
     * Método para realizar relatorio de pedido
     *
     * @method pedido
     * @access public
     * @return void
     */
    public function pedido()
    {
        # Titulo da pagina
        $header['titulo'] = "Relat&oacute;rio de Pedidos";

        # Pedido
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $data['pedidos'] = $this->db->get('tb_pedido')->result();

        $this->load->view('header', $header);
        $this->load->view('relatorio/relatorio_pedido', $data);
        $this->load->view('footer');
    }

    /**
     * Método para realizar relatorio de pedido pelo VT
     *
     * @method pedido_vt
     * @access public
     * @return void
     */
    public function pedido_vt()
    {
        # Titulo da pagina
        $header['titulo'] = "Relat&oacute;rio de Pedidos";

        # Empresa
        $this->db->select("DISTINCT(e.id_empresa_pk), e.cnpj, e.nome_razao", FALSE);
        $this->db->from('tb_empresa e');
        $this->db->join('tb_pedido p', 'e.id_empresa_pk = p.id_empresa_fk', 'inner');
        $this->db->order_by('e.nome_razao', 'ASC');
        $data['clientes'] = $this->db->get()->result();

        $this->load->view('header', $header);
        $this->load->view('relatorio/relatorio_pedido_vt', $data);
        $this->load->view('footer');
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
        $resposta = $this->Relatorio_model->getPedidoExport($id_pedido);

        print json_encode($resposta);
    }

    /**
     * Método para realizar relatorio de inconsistencia
     *
     * @method inconsistencia
     * @access public
     * @return void
     */
    public function inconsistencia()
    {
        # Titulo da pagina
        $header['titulo'] = "Relat&oacute;rio de Inconsist&ecirc;ncias";

        # Pedido
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $data['pedidos'] = $this->db->get('tb_pedido')->result();

        $this->load->view('header', $header);
        $this->load->view('relatorio/relatorio_inconsistencia', $data);
        $this->load->view('footer');
    }

    /**
     * Método para realizar relatorio de inconsistencia pelo VT
     *
     * @method inconsistencia_vt
     * @access public
     * @return void
     */
    public function inconsistencia_vt()
    {
        # Titulo da pagina
        $header['titulo'] = "Relat&oacute;rio de Inconsist&ecirc;ncias";

        # Empresa
        $this->db->select("DISTINCT(e.id_empresa_pk), e.cnpj, e.nome_razao", FALSE);
        $this->db->from('tb_empresa e');
        $this->db->join('tb_pedido p', 'e.id_empresa_pk = p.id_empresa_fk', 'inner');
        $this->db->order_by('e.nome_razao', 'ASC');
        $data['clientes'] = $this->db->get()->result();

        $this->load->view('header', $header);
        $this->load->view('relatorio/relatorio_inconsistencia_vt', $data);
        $this->load->view('footer');
    }

    /**
     * Método de busca Inconsistencia de Pedidos para Exportação
     *
     * @method exportInconsXls
     * @access public
     * @return obj Lista de pedido cadastrados
     */
    public function exportInconsXls()
    {
        # Var
        $id_pedido = $this->input->post('id');

        # Instanciar modelo
        $resposta = $this->Relatorio_model->getInconsistenciaExport($id_pedido);

        print json_encode($resposta);
    }

    /**
     * Método para gerar word do relatorio de funcionarios
     *
     * @method relFuncionario
     * @param obj $busca Periodo para busca
     * @access public
     * @return void
     */
    public function relFuncionario($busca)
    {
        # Load Php Word
        # $phpWord = new \PhpOffice\PhpWord\PhpWord();

        # Init
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
	date_default_timezone_set('America/Sao_Paulo');
        ini_set("pcre.backtrack_limit", "9000000");

        # vars
        $log       = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        # Busca
        $pedido    = base64_decode($busca); parse_str($pedido, $params);
        $id_pedido = $params['id_pedido'];
        $id_depto  = $params['id_depto'];
        /* $datas     = explode(" - ", $params['periodo']);
        $dt_ini    = !empty($datas) && $datas[0] != "" ? explode("/", $datas[0]) : NULL;
        $dt_fin    = !empty($datas) && $datas[1] != "" ? explode("/", $datas[1]) : NULL;
        $dt_ini_bd = !empty($dt_ini) ? $dt_ini[2]."-".$dt_ini[1]."-".$dt_ini[0] : NULL;
        $dt_fin_bd = !empty($dt_fin) ? $dt_fin[2]."-".$dt_fin[1]."-".$dt_fin[0] : NULL; */

        $this->db->select("DISTINCT (f.id_funcionario_pk) AS id_funcionario_pk, p.id_pedido_pk, f.nome, f.matricula, f.id_departamento_fk, 
                           f.departamento, f.turno, f.nome_razao, f.cnpj, f.id_endereco_empresa_fk, ee.logradouro, ee.numero, 
                           ee.complemento, ee.bairro, ee.cep, ec.cidade, ees.sigla, DATE_FORMAT(p.dt_ini_beneficio, '%d/%m/%Y') AS dt_ini_beneficio, 
                           DATE_FORMAT(p.dt_fin_beneficio, '%d/%m/%Y') AS dt_fin_beneficio", FALSE);
        $this->db->from('tb_pedido p');
        $this->db->join('tb_relatorio r', 'p.id_pedido_pk = r.id_pedido_fk', 'inner');
        $this->db->join('vw_funcionario f', 'r.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->join('tb_item_beneficio ib', 'r.id_item_beneficio_fk = ib.id_item_beneficio_pk', 'inner');
        $this->db->join('tb_status_credito sc', 'r.id_status_credito_fk = sc.id_status_pk', 'inner');
        $this->db->join('tb_endereco_empresa ee', 'f.id_endereco_empresa_fk = ee.id_endereco_empresa_pk', 'inner');
        $this->db->join('tb_cidade ec', 'ec.id_cidade_pk = ee.id_cidade_fk', 'inner');
        $this->db->join('tb_estado ees', 'ees.id_estado_pk = ee.id_estado_fk', 'inner');
        $this->db->where('p.id_pedido_pk', $id_pedido);
        if ($id_depto != ""):
            $this->db->where('f.id_departamento_fk ', $id_depto);
        endif;
        $this->db->order_by('f.departamento', 'ASC');
        $this->db->order_by('f.nome', 'ASC');

        $funcs = $this->db->get()->result();

        # Verificar se há pedido
        $pedidos = array();
        if (!empty($funcs)):
            foreach ($funcs as $value) {
                $pedido = new stdClass();
                $pedido->id_funcionario_pk = $value->id_funcionario_pk;
                $pedido->id_pedido_pk      = $value->id_pedido_pk;
                $pedido->nome              = $value->nome;
                $pedido->matricula         = $value->matricula;
                $pedido->departamento      = $value->departamento;
                $pedido->turno             = $value->turno;
                $pedido->nome_razao        = $value->nome_razao;
                $pedido->cnpj              = $value->cnpj;
                $pedido->logradouro        = $value->logradouro;
                $pedido->numero            = $value->numero;
                $pedido->complemento       = $value->complemento;
                $pedido->bairro            = $value->bairro;
                $pedido->cep               = $value->cep;
                $pedido->cidade            = $value->cidade;
                $pedido->sigla             = $value->sigla;
                $pedido->dt_ini_beneficio  = $value->dt_ini_beneficio;
                $pedido->dt_fin_beneficio  = $value->dt_fin_beneficio;
                
                $this->db->select("r.id_relatorio_pk, r.id_item_beneficio_fk, ib.descricao, r.vl_unitario, 
                                   r.qtd_unitaria AS qtd_diaria, sc.status", FALSE);
                $this->db->from('tb_pedido p');
                $this->db->join('tb_relatorio r', 'p.id_pedido_pk = r.id_pedido_fk', 'inner');
                $this->db->join('vw_funcionario f', 'r.id_funcionario_fk = f.id_funcionario_pk', 'inner');
                $this->db->join('tb_item_beneficio ib', 'r.id_item_beneficio_fk = ib.id_item_beneficio_pk', 'inner');
                $this->db->join('tb_status_credito sc', 'r.id_status_credito_fk = sc.id_status_pk', 'inner');
                $this->db->where('p.id_pedido_pk', $id_pedido);
                $this->db->where('r.id_funcionario_fk', $value->id_funcionario_pk);
                if ($id_depto != ""):
                    $this->db->where('f.id_departamento_fk ', $id_depto);
                endif;
                $this->db->order_by('f.departamento', 'ASC');
                $this->db->order_by('f.nome', 'ASC');
                $rows = $this->db->get()->result();

                if (!empty($rows)):
                    $benefics = array();
                    foreach ($rows as $vl):
                        $benefic                       = new stdClass();
                        $benefic->id_item_beneficio_fk = $vl->id_item_beneficio_fk;
                        $benefic->descricao            = $vl->descricao;
                        $benefic->vl_unitario          = $vl->vl_unitario;
                        $benefic->qtd_diaria           = $vl->qtd_diaria;
                        $benefic->status               = $vl->status;
                        $benefics[]                    = $benefic;
                    endforeach;
                endif;
                $pedido->beneficios = $benefics;
                $pedidos[]          = $pedido;
            }
        endif;

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'orientation' => 'L'
        ]);

        $mpdf->SetDisplayMode('fullpage');

        $mpdf->SetHTMLHeader('
            <div style="text-align: left; font-weight: bold;">
                Relatório de Funcionário - Benefícios
            </div>');

        $mpdf->SetHTMLFooter('
            <table width="100%">
                <tr>
                    <td width="33%">&nbsp;</td>
                    <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                    <td width="33%" style="text-align: right;">{DATE j/m/Y H:i}</td>
                </tr>
            </table>');
        
        $html = '';
                
        if (!empty($pedidos)):
            foreach ($pedidos as $value):
                $endereco_empr = array();
                if (isset($value->logradouro)):
                    $endereco_empr[] = $value->logradouro;
                endif;
                if (isset($value->numero)):
                    $endereco_empr[] = $value->numero;
                endif;
                if (isset($value->complemento)):
                    $endereco_empr[] = $value->complemento;
                endif;
                if (isset($value->bairro)):
                    $endereco_empr[] = $value->bairro;
                endif;
                if (isset($value->cep)):
                    $endereco_empr[] = $value->cep;
                endif;
                if (isset($value->cidade)):
                    $endereco_empr[] = $value->cidade;
                endif;
                if (isset($value->sigla)):
                    $endereco_empr[] = $value->sigla;
                endif;
                $html .= '<table border="0" style="width: 100%">
                            <tbody>
                                <tr>
                                    <td style="width: 49%">
                                        <table border="1" style="width: 100%">
                                            <tr>
                                                <td colspan="4">
                                                    <table border="1" style="width: 100%;">
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <img style="vertical-align: middle;" src="./assets/imgs/logo_vtcards_140x67.jpg" width="100" />
                                                            </td>
                                                            <td style="width: 60%">
                                                                <strong>Empresa:</strong> '.$value->nome_razao.'<br>
                                                                <strong>Endereço:</strong> '.implode(", ", $endereco_empr).'<br>
                                                                <strong>CNPJ:</strong> '.$value->cnpj.'
                                                            </td>
                                                            <td style="width: 20%; text-align: center">
                                                               <strong>Pedido</strong><br> '.$value->id_pedido_pk.'
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 30px;">
                                                    <table border="1" style="width: 100%;">
                                                        <tr>
                                                            <td style="height: 30px;">
                                                                <strong>Nome:</strong> '.$value->nome.'
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 30px;">
                                                    <table border="1" style="width: 100%">
                                                        <tr>
                                                            <td style="width: 20%; height: 30px;">
                                                                <strong>Turno:</strong> '.$value->turno.'
                                                            </td>
                                                            <td style="width: 80%; height: 30px;">
                                                                <strong>Departamento:</strong> '.$value->departamento.'
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <table border="1" style="width: 100%">
                                                        <tr>
                                                            <td style="width: 10%; text-align: center">
                                                                <strong>Código</strong>
                                                            </td>
                                                            <td style="width: 50%">
                                                                <strong>Descrição</strong>
                                                            </td>
                                                            <td style="width: 20%; text-align: center">
                                                                <strong>Quantidade</strong>
                                                            </td>
                                                            <td style="width: 20%; text-align: center">
                                                                <strong>Valor</strong>
                                                            </td>
                                                        </tr>';
                                                        $vl_total = 0;
                                                        foreach ($value->beneficios as $benef):
                                                            $beneficio = isset($benef->vl_unitario) && $benef->vl_unitario != "" ? "R\$ ".number_format($benef->vl_unitario, 2, ',', '.') : "R$ 0,00";
                                                            $vl_total += ($benef->vl_unitario*$benef->qtd_diaria);
                                                            $html .= ' 
                                                             <tr>
                                                                 <td style="text-align: center">
                                                                     '.$benef->id_item_beneficio_fk.'
                                                                 </td>
                                                                 <td>
                                                                    '.$benef->descricao.'
                                                                 </td>
                                                                 <td style="text-align: center">
                                                                    '.$benef->qtd_diaria.'
                                                                 </td>
                                                                 <td style="text-align: center">
                                                                    '.$beneficio.'
                                                                 </td>
                                                             </tr>';                                                            
                                                        endforeach;
                                                       
                                                       $html .= '<tr>
                                                            <td colspan="2" style="height: 40px;">
                                                                <p id="txt_periodo">Período de Utilização: '.$value->dt_ini_beneficio.' a '.$value->dt_fin_beneficio.'</p>
                                                            </td>
                                                            <td style="text-align: center">
                                                                <strong>Total</strong>
                                                            </td>
                                                            <td style="text-align: center">
                                                                <strong>'."R\$ ".number_format($vl_total, 2, ',', '.').'</strong>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 40px;">
                                                    <table border="0" style="width: 100%;">
                                                        <tr>
                                                            <td style="width: 30%"><strong>Data:</strong> ____/____/________</td>
                                                            <td style="width: 70%"><strong>Assinatura:</strong> ____________________________________________________</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 2%">&nbsp;</td>
                                    <td style="width: 49%">
                                        <table border="1" style="width: 100%">
                                            <tr>
                                                <td colspan="4">
                                                    <table border="1" style="width: 100%;">
                                                        <tr>
                                                            <td style="width: 20%">
                                                                <img style="vertical-align: middle;" src="./assets/imgs/logo_vtcards_140x67.jpg" width="100" />
                                                            </td>
                                                            <td style="width: 60%">
                                                                <strong>Empresa:</strong> '.$value->nome_razao.'<br>
                                                                <strong>Endereço:</strong> '.implode(", ", $endereco_empr).'<br>
                                                                <strong>CNPJ:</strong> '.$value->cnpj.'
                                                            </td>
                                                            <td style="width: 20%; text-align: center">
                                                               <strong>Pedido</strong><br> '.$value->id_pedido_pk.'
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 30px;">
                                                    <table border="1" style="width: 100%;">
                                                        <tr>
                                                            <td style="height: 30px;">
                                                                <strong>Nome:</strong> '.$value->nome.'
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 30px;">
                                                    <table border="1" style="width: 100%">
                                                        <tr>
                                                            <td style="width: 20%; height: 30px;">
                                                                <strong>Turno:</strong> '.$value->turno.'
                                                            </td>
                                                            <td style="width: 80%; height: 30px;">
                                                                <strong>Departamento:</strong> '.$value->departamento.'
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <table border="1" style="width: 100%">
                                                        <tr>
                                                            <td style="width: 10%; text-align: center">
                                                                <strong>Código</strong>
                                                            </td>
                                                            <td style="width: 50%">
                                                                <strong>Descrição</strong>
                                                            </td>
                                                            <td style="width: 20%; text-align: center">
                                                                <strong>Quantidade</strong>
                                                            </td>
                                                            <td style="width: 20%; text-align: center">
                                                                <strong>Valor</strong>
                                                            </td>
                                                        </tr>';
                                                        $vl_total = 0;
                                                        foreach ($value->beneficios as $benef):
                                                            $beneficio = isset($benef->vl_unitario) && $benef->vl_unitario != "" ? "R\$ ".number_format($benef->vl_unitario, 2, ',', '.') : "R$ 0,00";
                                                            $vl_total += ($benef->vl_unitario*$benef->qtd_diaria);
                                                            $html .= ' 
                                                             <tr>
                                                                 <td style="text-align: center">
                                                                     '.$benef->id_item_beneficio_fk.'
                                                                 </td>
                                                                 <td>
                                                                    '.$benef->descricao.'
                                                                 </td>
                                                                 <td style="text-align: center">
                                                                    '.$benef->qtd_diaria.'
                                                                 </td>
                                                                 <td style="text-align: center">
                                                                    '.$beneficio.'
                                                                 </td>
                                                             </tr>';                                                            
                                                        endforeach;
                                                       
                                                       $html .= '<tr>
                                                            <td colspan="2" style="height: 40px;">
                                                                <p id="txt_periodo">Período de Utilização: '.$value->dt_ini_beneficio.' a '.$value->dt_fin_beneficio.'</p>
                                                            </td>
                                                            <td style="text-align: center">
                                                                <strong>Total</strong>
                                                            </td>
                                                            <td style="text-align: center">
                                                                <strong>'."R\$ ".number_format($vl_total, 2, ',', '.').'</strong>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="height: 40px;">
                                                    <table border="0" style="width: 100%;">
                                                        <tr>
                                                            <td style="width: 30%"><strong>Data:</strong> ____/____/________</td>
                                                            <td style="width: 70%"><strong>Assinatura:</strong> ____________________________________________________</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table><br><br>';
            endforeach;
        endif;

        $stylesheet = file_get_contents('./assets/css/mpdfstyletables.css');

        $mpdf->WriteHTML($stylesheet, 1); // The parameter 1 tells that this is css/style only and no body/html/text
        $mpdf->WriteHTML($html,2);

        $mpdf->Output("relatorio_funcionario_$id_pedido.pdf", \Mpdf\Output\Destination::DOWNLOAD);

        #  New portrait section
        /* $section = $phpWord->addSection();

        # Header
        $header = $section->createHeader();
        $imageStyle = array('width'=> 150, 'height'=> 60, 'alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT);
        $header->addImage('assets/imgs/logo_vtcards_170x81.jpg', $imageStyle);

        # Footer
        $style_footer = array('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => '0');
        $footer = $section->createFooter();
        $footer->addPreserveText(utf8_decode('Rua Voluntários da Pátria, 654, Sala 302'), null, $style_footer);
        $footer->addPreserveText(utf8_decode('CEP 02010-000 - Santana - São Paulo - SP'), null, $style_footer);
        $footer->addPreserveText('www.vtcards.com.br', null, $style_footer);
        $footer->addPreserveText('Tel: (11) 2389-6905', null, $style_footer);

        if (!empty($rows)):
            $cont = count($rows);
            $i    = 0;
            foreach ($rows as $value):
                $section->addTextBreak();
                $phpWord->addTitleStyle('title', array('bold' => true, 'size' => 13), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
                $section->addTitle(utf8_decode('Relatório de Funcionário'), 'title');
                $section->addTextBreak(2);
                $section->addText(utf8_decode("Pedido: $value->id_pedido_pk"), array('bold' => true, 'size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
                $section->addText(utf8_decode("Período de Utilização: $value->dt_ini_beneficio a $value->dt_fin_beneficio"), array('bold' => true, 'size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
                $section->addTextBreak(1);
                $section->addText(utf8_decode("Nome do Funcionário: $value->nome"), array('size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
                $section->addText(utf8_decode("Matrícula: $value->matricula"), array('size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
                $section->addText(utf8_decode("Código do Benefício: $value->id_item_beneficio_fk"), array('size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
                $section->addText(utf8_decode("Descrição: $value->descricao"), array('size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
                $vl_unit = isset($value->vl_unitario) ? "R$ ".number_format($value->vl_unitario, 2, ',', '.') : "R$ 0,00";
                $section->addText(utf8_decode("Valor Unitário: $vl_unit"), array('size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
                $section->addText(utf8_decode("Status: $value->status"), array('size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
                $section->addText(utf8_decode("Quantidade Unitária: $value->qtd_diaria"), array('size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
                $vl_total = isset($value->qtd_diaria) ? "R$ ".number_format(($value->vl_unitario*$value->qtd_diaria), 2, ',', '.') : "R$ 0,00";
                $section->addText(utf8_decode("Total de Recarga: $vl_total"), array('size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
                $section->addTextBreak(2);
                $section->addText("_________________, ___/___/_____        _________________________________", array('size' => 12));
                $section->addText("                      Local e Data                                      Assinatura do Funcionário   ", array('size' => 12));
                $section->addTextBreak(2);
                $i++;
                if (($i%2) == 0) {
                    $section->addPageBreak();
                } else {
                    if ($i < $cont):
                        $section->addText("___________________________________________________________________", array('bold' => true, 'size' => 12));
                    endif;
                    $section->addTextBreak(2);
                }
            endforeach;
        else:
            $section->addTextBreak();
            $phpWord->addTitleStyle('erro', array('bold' => true, 'size' => 12), array ('alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
            $section->addTitle(utf8_decode('Nenhum Benefício Encontrado'), 'erro');
        endif; */

        # Salvar Log
        $log['id_pedido_fk'] = $id_pedido;
        if ($this->session->userdata('id_vt')):
            $log['id_usuario_fk'] = $this->session->userdata('id_vt');
        else:
            if ($this->session->userdata('id_client')):
                $log['id_cliente_fk'] = $this->session->userdata('id_client');
            endif;
        endif;
        $log['id_tipo_rel_fk'] = 1;
        $log['dt_hr']          = mdate($timestamp, $data);
        $this->db->insert('tb_relatorio_log', $log);

        # Save File
        /* $filename = "relatorio_$id_pedido.docx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document; charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: max-age=0');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output'); */
    }
    
    /**
     * Método para realizar relatorio de descontos
     *
     * @method descontos
     * @access public
     * @return void
     */
    public function descontos()
    {
        # Titulo da pagina
        $header['titulo'] = "Relat&oacute;rio de Descontos de VT";

        # Pedido
        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $data['pedidos'] = $this->db->get('tb_pedido')->result();

        $this->load->view('header', $header);
        $this->load->view('relatorio/relatorio_descontos', $data);
        $this->load->view('footer');
    }
    
    /**
     * Método para realizar relatorio de descontos VT
     *
     * @method descontos_vt
     * @access public
     * @return void
     */
    public function descontos_vt()
    {
        # Titulo da pagina
        $header['titulo'] = "Relat&oacute;rio de Descontos de VT";

        # Empresa
        $this->db->select("DISTINCT(e.id_empresa_pk), e.cnpj, e.nome_razao", FALSE);
        $this->db->from('tb_empresa e');
        $this->db->join('tb_pedido p', 'e.id_empresa_pk = p.id_empresa_fk', 'inner');
        $this->db->order_by('e.nome_razao', 'ASC');
        $data['clientes'] = $this->db->get()->result();

        $this->load->view('header', $header);
        $this->load->view('relatorio/relatorio_descontos_vt', $data);
        $this->load->view('footer');
    }

    /**
     * Método de busca dos dados dos Descontos de VT para Exportação
     *
     * @method exportDescontosXls
     * @access public
     * @return obj Lista de funcionarios
     */
    public function exportDescontosXls()
    {
        # Var
        $id_pedido = $this->input->post('id');

        # Instanciar modelo
        $resposta = $this->Relatorio_model->getDescontosVtExport($id_pedido);

        print json_encode($resposta);
    }
    
}

/* End of file Relatorio.php */
/* Location: ./application/controllers/Relatorio.php */
