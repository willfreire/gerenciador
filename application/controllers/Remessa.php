<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Remessa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_vt')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Remessa_model');

        # Loads helpers
        $this->load->helper('download');
    }

    /**
     * Método para carregar a tela para gerar Remessa
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerar Remessa";

        $this->load->view('header', $header);
        $this->load->view('financeiro/remessa_gerar');
        $this->load->view('footer');
    }

    /**
     * Método para carregar a visualizacao de boletos
     *
     * @method boleto
     * @access public
     * @return void
     */
    public function gerar()
    {
        # Titulo da pagina
        $header['titulo'] = "Gerar Remessa";

        # Cod. Carteira
        $this->db->where("cod_cart_rem != ''");
        $data['cod_cart'] = $this->db->get('tb_cod_carteira')->result();

        # Cod. Ocorrencia Mov
        $data['cod_ocorrencia'] = $this->db->get('tb_cod_ocorrencia_mov')->result();

        # Especie Doc
        $data['especie_doc'] = $this->db->get('tb_especie_doc')->result();

        # Instrucao
        $data['inst_cobranca'] = $this->db->get('tb_inst_cobranca')->result();

        $this->load->view('header', $header);
        $this->load->view('financeiro/remessa_gerar', $data);
        $this->load->view('footer');
    }

    /**
     * Método de cadastro da header da remessa
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

        $pedido->ids              = $this->input->post('ids_boleto');
        $pedido->cod_carteira     = $this->input->post('cod_carteira');
        $pedido->cod_ocorrencia   = $this->input->post('cod_ocorrencia');
        $pedido->especie_doc      = $this->input->post('especie_doc');
        $pedido->f_instr_cobranca = $this->input->post('1_instr_cobranca');
        $pedido->s_instr_cobranca = $this->input->post('2_instr_cobranca');

        if (!empty($pedido->ids) && is_array($pedido->ids) && $pedido->cod_carteira != NULL && $pedido->cod_ocorrencia != NULL &&
            $pedido->especie_doc != NULL && $pedido->f_instr_cobranca != NULL) {
            $resposta = $this->Remessa_model->setRemessa($pedido);
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Gerar Remessa! Tente novamente...";
            $resposta        = $retorno;
        }

        # retornar resultado
        print json_encode($resposta);
    }

    /**
     * Método de busca geral dos boletos gerados
     *
     * @method getBoletos
     * @access public
     * @return obj Lista de Boletos
     */
    public function getBoletos()
    {
        # SQL
        $this->db->select('id_pedido_fk, pagador_cnpj_cpf, pagador_nome, valor');
        $this->db->from('tb_boleto');
        $this->db->order_by('id_pedido_fk', 'ASC');
        $retorno = $this->db->get()->result();

        $valor = array();

        if ($retorno):

            foreach ($retorno as $value):
                $vl      = isset($value->valor) && $value->valor != "0.00" ? "R\$ " . number_format($value->valor, 2, ',', '.') : "R\$ 0,00";
                $valor[] = $value->id_pedido_fk . " / " . $value->pagador_cnpj_cpf . " / " . $value->pagador_nome . " / $vl";
            endforeach;

        endif;

        print json_encode($valor);
    }

    /**
     * Método para gerar o arquivo de Remessa
     *
     * @method createRemessa
     * @access public
     * @param integer $id_remessa Id da Remessa
     * @return obj Status da geraçao
     */
    public function createRemessa($id_remessa = null)
    {

        # Vars
        $name_rem = $this->Remessa_model->removeAcento("25.533.823/0001-03")."_".  time();
        $ext_file = ".REM";

        # Verificar se Arquivo ja Existe
        $this->db->where("id_remessa_pk", $id_remessa);
        $rem = $this->db->get('tb_remessa')->result();

        if (!empty($rem)):
            $file = $rem[0]->arquivo;

            if ($file === NULL):
                # Buscar Header
                $this->db->where("id_remessa_fk", $id_remessa);
                $head = $this->db->get('tb_remessa_header')->result();
                if (empty($head)) {
                    redirect(base_url('./remessa/ver_envio'));
                }

                $cod_reg_head = $head[0]->cod_registro;
                $cod_rem_head = $head[0]->cod_remessa;
                $trasmissao   = $this->Remessa_model->picturex($head[0]->trasmissao, 7);
                $cod_servico  = $this->Remessa_model->picture9($head[0]->cod_servico, 2);
                $servico      = $this->Remessa_model->picturex($head[0]->servico, 15);
                $cod_trans_h  = $this->Remessa_model->picture9($head[0]->cod_transmissao, 20);
                $nome_cedente = $this->Remessa_model->picturex($head[0]->nome_cedente, 30);
                $cod_banco    = $this->Remessa_model->picture9($head[0]->cod_banco, 3);
                $nome_banco   = $this->Remessa_model->picturex($head[0]->nome_banco, 15);
                $dt_gravacao  = $this->Remessa_model->picture9($head[0]->dt_gravacao, 6);
                $col_h11      = $this->Remessa_model->completeReg(16, "zeros");
                $col_h12      = $this->Remessa_model->completeReg(274, "brancos");
                $num_ver_rem  = $this->Remessa_model->picture9($head[0]->num_versao_rem, 3);
                $num_reg_arq  = $this->Remessa_model->picture9($head[0]->num_reg_arq, 6);

                $header = $cod_reg_head.$cod_rem_head.$trasmissao.$cod_servico.$servico.$cod_trans_h.$nome_cedente.$cod_banco.$nome_banco.$dt_gravacao.$col_h11.$col_h12.$num_ver_rem.$num_reg_arq.chr(13);

                # Buscar Movimentacao
                $this->db->where("id_remessa_fk", $id_remessa);
                $mov = $this->db->get('tb_remessa_mov')->result();
                if (empty($mov)) {
                    redirect(base_url('./remessa/ver_envio'));
                }

                $movimenta = NULL;
                foreach ($mov as $vl_mov) {
                    $cod_reg_mov           = $vl_mov->cod_registro;
                    $tipo_cedente          = $this->Remessa_model->picture9($vl_mov->tipo_cedente, 2);
                    $cgc_cpf               = $this->Remessa_model->picture9($vl_mov->cgc_cpf, 14);
                    $cod_transmissao       = $this->Remessa_model->picture9($vl_mov->cod_transmissao, 20);
                    $num_control_part      = $this->Remessa_model->picturex($vl_mov->num_control_part, 25);
                    $nosso_numero          = $this->Remessa_model->picture9($vl_mov->nosso_numero, 8);
                    $dt_seg_desconto       = $this->Remessa_model->picture9($vl_mov->dt_seg_desconto, 6);
                    $col_m8                = $this->Remessa_model->completeReg(1, "brancos");
                    $info_multa            = $this->Remessa_model->picture9($vl_mov->info_multa, 1);
                    $perc_multa            = $this->Remessa_model->picture9($vl_mov->perc_multa, 4);
                    $unid_vl_moeda         = $this->Remessa_model->picture9($vl_mov->unid_vl_moeda, 2);
                    $vl_tit_outra_unid     = $this->Remessa_model->picture9($vl_mov->vl_tit_outra_unid, 13);
                    $col_m13               = $this->Remessa_model->completeReg(4, "brancos");
                    $dt_cobranca_multa     = $this->Remessa_model->picture9($vl_mov->dt_cobranca_multa, 6);
                    $id_cod_carteira_fk    = $this->Remessa_model->picture9($vl_mov->id_cod_carteira_fk, 1);
                    $cod_ocorrencia_fk     = $this->Remessa_model->picture9($vl_mov->cod_ocorrencia_fk, 2);
                    $seu_numero            = $this->Remessa_model->picturex($vl_mov->seu_numero, 10);
                    $dt_venc_titulo        = $this->Remessa_model->picture9($vl_mov->dt_venc_titulo, 6);
                    $vl_titulo             = $this->Remessa_model->picture9($vl_mov->vl_titulo, 13);
                    $num_banco_cobrador    = $this->Remessa_model->picture9($vl_mov->num_banco_cobrador, 3);
                    $cod_agencia_cobradora = $this->Remessa_model->picture9($vl_mov->cod_agencia_cobradora, 5);
                    $especie_doc           = $this->Remessa_model->picture9($vl_mov->especie_doc, 2);
                    $tipo_aceite           = $this->Remessa_model->picturex($vl_mov->tipo_aceite, 1);
                    $dt_emissao_titulo     = $this->Remessa_model->picture9($vl_mov->dt_emissao_titulo, 6);
                    $prim_inst_cobranca    = $this->Remessa_model->picture9($vl_mov->prim_inst_cobranca, 2);
                    $seg_inst_cobranca     = $this->Remessa_model->picture9($vl_mov->seg_inst_cobranca, 2);
                    $vl_mora_dia           = $this->Remessa_model->picture9($vl_mov->vl_mora_dia, 13);
                    $dt_limite_desconto    = $this->Remessa_model->picture9($vl_mov->dt_limite_desconto, 6);
                    $vl_desconto_concedido = $this->Remessa_model->picture9($vl_mov->vl_desconto_concedido, 13);
                    $vl_iof_nota_seguro    = $this->Remessa_model->picture9($vl_mov->vl_iof_nota_seguro, 13);
                    $vl_abatimento         = $this->Remessa_model->picture9($vl_mov->vl_abatimento, 11);
                    $tipo_insc_sacado      = $this->Remessa_model->picture9($vl_mov->tipo_insc_sacado, 2);
                    $cgc_cpf_sacado        = $this->Remessa_model->picture9($vl_mov->cgc_cpf_sacado, 14);
                    $nome_sacado           = $this->Remessa_model->picturex($vl_mov->nome_sacado, 40);
                    $endereco_sacado       = $this->Remessa_model->picturex($vl_mov->endereco_sacado, 40);
                    $bairro_sacado         = $this->Remessa_model->picturex($vl_mov->bairro_sacado, 12);
                    $cep_sacado            = $this->Remessa_model->picture9($vl_mov->cep_sacado, 5);
                    $cep_compl_sacado      = $this->Remessa_model->picture9($vl_mov->cep_compl_sacado, 3);
                    $cidade_sacado         = $this->Remessa_model->picturex($vl_mov->cidade_sacado, 15);
                    $uf_sacado             = $this->Remessa_model->picturex($vl_mov->uf_sacado, 2);
                    $nome_sacador          = $this->Remessa_model->picturex($vl_mov->nome_sacador, 30);
                    $col_m42               = $this->Remessa_model->completeReg(1, "brancos");
                    $id_complemento        = $this->Remessa_model->picturex($vl_mov->id_complemento, 1);
                    $complemento           = $this->Remessa_model->picture9($vl_mov->complemento, 2);
                    $col_m45               = $this->Remessa_model->completeReg(6, "brancos");
                    $num_dias_protesto     = $this->Remessa_model->picture9($vl_mov->num_dias_protesto, 2);
                    $col_m47               = $this->Remessa_model->completeReg(1, "brancos");
                    $num_reg_arq_mov       = $this->Remessa_model->picture9($vl_mov->num_reg_arq, 6);

                    $movimenta .= $cod_reg_mov.$tipo_cedente.$cgc_cpf.$cod_transmissao.$num_control_part.$nosso_numero.$dt_seg_desconto.$col_m8.$info_multa.$perc_multa.$unid_vl_moeda.
                                  $vl_tit_outra_unid.$col_m13.$dt_cobranca_multa.$id_cod_carteira_fk.$cod_ocorrencia_fk.$seu_numero.$dt_venc_titulo.$vl_titulo.$num_banco_cobrador.
                                  $cod_agencia_cobradora.$especie_doc.$tipo_aceite.$dt_emissao_titulo.$prim_inst_cobranca.$seg_inst_cobranca.$vl_mora_dia.$dt_limite_desconto.
                                  $vl_desconto_concedido.$vl_iof_nota_seguro.$vl_abatimento.$tipo_insc_sacado.$cgc_cpf_sacado.$nome_sacado.$endereco_sacado.$bairro_sacado.$cep_sacado.
                                  $cep_compl_sacado.$cidade_sacado.$uf_sacado.$nome_sacador.$col_m42.$id_complemento.$complemento.$col_m45.$num_dias_protesto.$col_m47.$num_reg_arq_mov.
                                  chr(13).chr(10);
                }

                # Buscar Trailler
                $this->db->where("id_remessa_fk", $id_remessa);
                $trail = $this->db->get('tb_remessa_trailler')->result();
                if (empty($trail)) {
                    redirect(base_url('./remessa/ver_envio'));
                }

                $cod_reg_trail     = $trail[0]->cod_registro;
                $qtde_linha_arq    = $this->Remessa_model->picture9($trail[0]->qtde_linha_arq, 6);
                $vl_total_titulo   = $this->Remessa_model->picture9($trail[0]->vl_total_titulo, 13);
                $col_t4            = $this->Remessa_model->completeReg(374, "zeros");
                $num_reg_arq_trail = $this->Remessa_model->picture9($trail[0]->num_reg_arq, 6);

                $trailler = $cod_reg_trail.$qtde_linha_arq.$vl_total_titulo.$col_t4.$num_reg_arq_trail;

                # Juntar dados
                $remessa_compl = $header.$movimenta.$trailler;

                # Salvar no dir
                if (!$handle = fopen(PATH_REM.$name_rem.$ext_file, 'w+')) {
                   echo "<br>Não foi possível abrir o arquivo ($name_rem.$ext_file)";
                }

                // Escreve $conteudo no nosso arquivo aberto.
                if (fwrite($handle, "$remessa_compl") === FALSE) {
                    echo "<br>Não foi possível escrever no arquivo ($name_rem.$ext_file)";
                }
                fclose($handle);

                # Atualizar nome do arquivo
                $file['arquivo'] = $name_rem.$ext_file;
                $this->db->where('id_remessa_pk', $id_remessa);
                $this->db->update('tb_remessa', $file);

                force_download($name_rem.".REM", $remessa_compl);
                
            else:
                force_download(PATH_REM.$file, NULL);
            endif;

        else:
            redirect(base_url('./remessa/ver_envio'));
        endif;
    }

    /**
     * Método para carregar a visualizacao de envio de remessa
     *
     * @method ver_envio
     * @access public
     * @return void
     */
    public function ver_envio()
    {
        # Titulo da pagina
        $header['titulo'] = "Visualiza&ccedil;&atilde;o de Envio de Remessa";

        $this->load->view('header', $header);
        $this->load->view('financeiro/remessa_envio_ver');
        $this->load->view('footer');
    }
    
    /**
     * Método para popular grid de gerenciamento de remessa de envio
     *
     * @method buscarRemEnvio
     * @access public
     * @return obj Lista de Remessa de Envio
     */
    public function buscarRemEnvio()
    {
        # Recebe dados
        $search                     = new stdClass();
        $search->draw               = $this->input->post('draw');
        $search->orderByColumnIndex = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['column'] : 0;
        $search->orderBy            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'][$search->orderByColumnIndex]['data'] : "dt_emissao";
        $search->orderType          = !empty($_POST['order']) && is_array($_POST['order']) ? $_POST['order'][0]['dir'] : "DESC";
        $search->start              = $this->input->post('start');
        $search->length             = $this->input->post('length');
        $search->filter             = !empty($_POST['search']['value']) ? $_POST['search']['value'] : NULL;
        $search->columns            = !empty($_POST['columns']) && is_array($_POST['columns']) ? $_POST['columns'] : NULL;

        # Instanciar modelo
        $resposta = $this->Remessa_model->getRemEnvio($search);

        print json_encode($resposta);
    }

    /**
     * Método para boletos por remessa
     *
     * @method getBoletoRemessa
     * @access public
     * @return obj Lista de Boletos
     */
    public function getBoletoRemessa()
    {
        # Var
        $id_rem   = $this->input->post('id_remessa');
        $retorno  = new stdClass();
        $resposta = "";

        if ($id_rem != NULL):
            $resposta = $this->Remessa_model->buscarBoletoRem($id_rem);
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Nenhum Boleto Localizado!";
            $resposta        = $retorno;
        endif;
        
        print json_encode($resposta);
    }
}

/* End of file Remessa.php */
/* Location: ./application/controllers/Remessa.php */