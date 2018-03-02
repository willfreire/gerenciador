<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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
     * @return void
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
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        # Init
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
	date_default_timezone_set('America/Sao_Paulo');

        # vars
        $log       = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        # Busca
        $pedido    = base64_decode($busca); parse_str($pedido, $params);
        $id_pedido = $params['id_pedido'];
        /* $datas     = explode(" - ", $params['periodo']);
        $dt_ini    = !empty($datas) && $datas[0] != "" ? explode("/", $datas[0]) : NULL;
        $dt_fin    = !empty($datas) && $datas[1] != "" ? explode("/", $datas[1]) : NULL;
        $dt_ini_bd = !empty($dt_ini) ? $dt_ini[2]."-".$dt_ini[1]."-".$dt_ini[0] : NULL;
        $dt_fin_bd = !empty($dt_fin) ? $dt_fin[2]."-".$dt_fin[1]."-".$dt_fin[0] : NULL; */

        $this->db->select("p.id_pedido_pk, DATE_FORMAT(p.dt_ini_beneficio, '%d/%m/%Y') AS dt_ini_beneficio,
                           DATE_FORMAT(p.dt_fin_beneficio, '%d/%m/%Y') AS dt_fin_beneficio, f.nome, f.matricula,
                           r.id_item_beneficio_fk, ib.descricao, r.vl_unitario, r.qtd_unitaria AS qtd_diaria,
                           sc.status", FALSE);
        $this->db->from('tb_pedido p');
        $this->db->join('tb_relatorio r', 'p.id_pedido_pk = r.id_pedido_fk', 'inner');
        $this->db->join('vw_funcionario f', 'r.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->join('tb_item_beneficio ib', 'r.id_item_beneficio_fk = ib.id_item_beneficio_pk', 'inner');
        $this->db->join('tb_status_credito sc', 'r.id_status_credito_fk = sc.id_status_pk', 'inner');
        $this->db->where('p.id_pedido_pk', $id_pedido);
        $this->db->order_by('p.dt_ini_beneficio', 'ASC');
        $rows = $this->db->get()->result();

        #  New portrait section
        $section = $phpWord->addSection();

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
        endif;

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
        $filename = "relatorio_$id_pedido.docx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document; charset=utf-8');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: max-age=0');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
    }

}

/* End of file Relatorio.php */
/* Location: ./application/controllers/Relatorio.php */
