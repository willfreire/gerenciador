<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Remessa_model extends CI_Model {

    # Propriedades
    public $draw;
    public $orderBy;
    public $orderType;
    public $start;
    public $length;
    public $filter;
    public $columns;
    public $recordsTotal;
    public $recordsFiltered;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Método responsável pelo cadastro da Remessa
     *
     * @method setRemessa
     * @param obj $valores Ids dos pedidos
     * @access public
     * @return obj Status de ação
     */
    public function setRemessa($valores)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $dados   = array();
        $head    = array();
        $mov     = array();
        $trail   = array();

        # Dados
        $cod_transmissao  = "08330854414001300081";
        $cod_ag_benef     = "0833";
        $conta_mov_benef  = "01300081";
        $conta_cobr_benef = "01300081";
        $complemento      = "96";
        $cod_carteira     = $valores->cod_carteira;
        $cod_ocorrencia   = $valores->cod_ocorrencia;
        $especie_doc      = $valores->especie_doc;
        $f_instr_cobranca = isset($valores->f_instr_cobranca) ? $valores->f_instr_cobranca : "00";
        $s_instr_cobranca = isset($valores->s_instr_cobranca) ? $valores->s_instr_cobranca : "00";
        $vl_total         = 0;

        # Remessa
        $dados['id_usuario_fk'] = $this->session->userdata('id_vt');
        $dados['dt_emissao']    = date("Y-m-d");

        # Grava remessa
        $this->db->insert('tb_remessa', $dados);

        if ($this->db->affected_rows() > 0) {
            # Ultima ID
            $id_remessa = $this->db->insert_id();

            # Remessa
            $head['id_remessa_fk']     = $id_remessa;
            $head['cod_registro']      = "0";
            $head['cod_remessa']       = "1";
            $head['trasmissao']        = "REMESSA";
            $head['cod_servico']       = "01";
            $head['servico']           = "COBRANCA";
            $head['cod_transmissao']   = $this->picture9($cod_transmissao, 20);
            $head['nome_beneficiario'] = "VTCARDS COMERCIO E SERVICOS LTDA";
            $head['cod_banco']         = "033";
            $head['nome_banco']        = "SANTANDER";
            $head['dt_gravacao']       = date('dmy');
            $head['col_h11']           = $this->picture9(0, 16);
            $head['msg1']              = "b_47";
            $head['msg2']              = "b_47";
            $head['msg3']              = "b_47";
            $head['msg4']              = "b_47";
            $head['msg5']              = "b_47";
            $head['col_h17']           = "b_34";
            $head['col_h18']           = "b_6";
            $head['num_versao_rem']    = "000";
            $head['num_reg_arq']       = $this->picture9(1, 6);

            # Grava remessa header
            $this->db->insert('tb_remessa_header', $head);

            # Buscar boletos pelo Pedido
            $id_mov = 0;
            if (is_array($valores->ids)):

                foreach ($valores->ids as $vl):

                    $this->db->where('id_pedido_fk', $vl);
                    $boleto = $this->db->get('tb_boleto')->result();

                    if (!empty($boleto)) {

                        $id_mov++;

                        $id_boleto        = $boleto[0]->id_boleto_pk;
                        $id_pedido        = $boleto[0]->id_pedido_fk;
                        $pagador_nome     = $boleto[0]->pagador_nome;
                        $pagador_cnpj_cpf = $boleto[0]->pagador_cnpj_cpf;
                        $pagador_endereco = $boleto[0]->pagador_endereco;
                        $pagador_bairro   = $boleto[0]->pagador_bairro;
                        $pagador_cep      = explode("-", $boleto[0]->pagador_cep);
                        $pagador_cep_pre  = is_array($pagador_cep) ? $pagador_cep[0] : "0";
                        $pagador_cep_pos  = is_array($pagador_cep) ? $pagador_cep[1] : "0";
                        $pagador_cidade   = $boleto[0]->pagador_cidade;
                        $pagador_uf       = $boleto[0]->pagador_uf;
                        $benef_nome       = $boleto[0]->beneficiario_nome;
                        $benef_cnpj_cpf   = $boleto[0]->beneficiario_cnpj_cpf;
                        $benef_endereco   = $boleto[0]->beneficiario_endereco;
                        $benef_cep        = $boleto[0]->beneficiario_cep;
                        $benef_cidade     = $boleto[0]->beneficiario_cidade;
                        $benef_uf         = $boleto[0]->beneficiario_uf;
                        $dt_vencimento    = explode("-", $boleto[0]->dt_vencimento);
                        $dt_venc          = is_array($dt_vencimento) ? $dt_vencimento[1].$dt_vencimento[2].substr($dt_vencimento[0], -2) : date("dmy");
                        $valor            = $boleto[0]->valor;
                        $nosso_numero     = $boleto[0]->nosso_numero;
                        $carteira         = $boleto[0]->carteira;
                        $agencia          = $boleto[0]->agencia;
                        $agencia_dv       = $boleto[0]->agencia_dv;
                        $conta            = $boleto[0]->conta;
                        $conta_dv         = $boleto[0]->conta_dv;
                        $descr_demo       = $boleto[0]->descr_demostrativo;
                        $instrucao        = $boleto[0]->instrucao;
                        $dt_emissao       = explode("-", $boleto[0]->dt_emissao);
                        $dt_emi           = is_array($dt_emissao) ? $dt_emissao[1].$dt_emissao[2].substr($dt_emissao[0], -2) : date("dmy");

                        # Movimentar
                        $mov['id_remessa_fk']           = $id_remessa;
                        $mov['id_boleto_fk']            = $id_boleto;
                        $mov['cod_registro']            = 1;
                        $mov['tipo_beneficiario']       = $this->picture9("2", 2);
                        $mov['cnpj_cpf']                = $this->picture9($this->removeAcento($benef_cnpj_cpf), 14);
                        $mov['cod_ag_beneficiario']     = $this->picture9($cod_ag_benef, 4);
                        $mov['conta_mov_beneficiario']  = $this->picture9($conta_mov_benef, 8);
                        $mov['conta_cobr_beneficiario'] = $this->picture9($conta_cobr_benef, 8);
                        $mov['num_control_part']        = $this->picturex($nosso_numero, 25);
                        $mov['nosso_numero']            = $this->picture9($this->modulo11($nosso_numero), 8);
                        $mov['dt_seg_desconto']         = "000000";
                        $mov['col_m10']                 = "b_1";
                        $mov['info_multa']              = $this->picture9(0, 1);
                        $mov['porc_multa_atraso']       = $this->picture9(0, 4);
                        $mov['unid_vl_moeda']           = "00";
                        $mov['vl_tit_outra_unid']       = $this->picture9(0, 13);
                        $mov['col_m15']                 = "b_4";
                        $mov['dt_cobranca_multa']       = $this->picture9(0, 6);
                        $mov['id_cod_carteira_fk']      = $cod_carteira;
                        $mov['cod_ocorrencia']          = $this->picture9($cod_ocorrencia, 2);
                        $mov['seu_numero']              = $this->picturex($nosso_numero, 10);
                        $mov['dt_venc_titulo']          = $this->picture9($dt_venc, 6);
                        $mov['vl_titulo']               = $this->picture9($this->removeAcento($valor), 13);
                        $mov['num_banco_cobrador']      = "033";
                        $mov['cod_ag_cobradora']        = $cod_carteira == 4 ? $this->picture9("0833", 5) : $this->picture9("0", 5);
                        $mov['especie_doc']             = $this->picture9($especie_doc, 2);
                        $mov['tipo_aceite']             = "N";
                        $mov['dt_emissao_titulo']       = $this->picture9($dt_emi, 6);
                        $mov['prim_inst_cobranca']      = $this->picture9($f_instr_cobranca, 2);
                        $mov['seg_inst_cobranca']       = $this->picture9($s_instr_cobranca, 2);
                        $mov['vl_mora_dia']             = $this->picture9(0, 13);
                        $mov['dt_limite_desconto']      = $this->picture9(0, 6);
                        $mov['vl_desconto_concedido']   = $this->picture9(0, 13);
                        $mov['vl_iof']                  = $this->picture9(0, 13);
                        $mov['vl_abatimento']           = $this->picture9(0, 13);
                        $mov['tipo_insc_pagador']       = "02";
                        $mov['cnpj_cpf_pagador']        = $this->picture9($this->removeAcento($pagador_cnpj_cpf), 14);
                        $mov['nome_pagador']            = $this->picturex($this->removeAcento($pagador_nome), 40);
                        $mov['endereco_pagador']        = $this->picturex($this->removeAcento($pagador_endereco), 40);
                        $mov['bairro_pagador']          = $this->picturex($this->removeAcento($pagador_bairro), 12);
                        $mov['cep_pagador']             = $this->picture9($pagador_cep_pre, 5);
                        $mov['cep_compl_pagador']       = $this->picture9($pagador_cep_pos, 3);
                        $mov['cidade_pagador']          = $this->picturex($this->removeAcento($pagador_cidade), 15);
                        $mov['uf_pagador']              = $this->picturex($this->removeAcento($pagador_uf), 2);
                        $mov['nome_sacador']            = $this->picturex(" ", 30);
                        $mov['col_m44']                 = "b_1";
                        $mov['id_complemento']          = "I";
                        $mov['complemento']             = $this->picture9($complemento, 2);
                        $mov['col_m47']                 = "b_6";
                        $mov['num_dias_protesto']       = $this->picture9(0, 2);
                        $mov['col_m49']                 = "b_1";
                        $mov['num_reg_arq']             = $this->picture9($id_mov, 6);

                        # Count Vl
                        $vl_total += $this->picture9($this->removeAcento($valor), 13);
                    }

                    # Grava remessa movimento
                    $this->db->insert('tb_remessa_mov', $mov);

                endforeach;

            endif;

            # Trailler
            $trail['id_remessa_fk']   = $id_remessa;
            $trail['cod_registro']    = 9;
            $trail['qtde_linha_arq']  = $id_mov;
            $trail['vl_total_titulo'] = $this->picture9($vl_total, 13);
            $trail['col_t4']          = "b_374";
            $trail['num_reg_arq']     = $this->picture9(1, 6);

            # Grava remessa trailler
            $this->db->insert('tb_remessa_trailler', $trail);

            $retorno->status     = TRUE;
            $retorno->msg        = "Remessa Gerada com Sucesso! Deseja Baixar Agora o Arquivo de Remessa?";
            $retorno->id_remessa = $id_remessa;
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Gerar Remessa! Tente novamente...";
        }

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por pesquisar e buscar Boletos
     *
     * @method getBoletos
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de boletos
     */
    public function getBoletos($search)
    {
        # Atribuir valores
        $this->draw      = $search->draw;
        $this->orderBy   = $search->orderBy;
        $this->orderType = $search->orderType;
        $this->start     = $search->start;
        $this->length    = $search->length;
        $this->filter    = $search->filter;
        $this->columns   = $search->columns;
        $filter          = array();
        $where           = array();

        # Se houver busca pela grid
        if ($this->filter != NULL):
            for($i=0; $i<count($this->columns); $i++):
                if ($this->columns[$i]['searchable'] === "true"):
                    $column = $this->columns[$i]['data'];
                    $filter[]= "$column LIKE '%{$this->filter}%'";
                endif;
            endfor;
        endif;

        # Contar total de registros
        $this->db->select('COUNT(b.id_boleto_pk) AS total');
        $this->db->from('tb_boleto b');
        $this->db->join('tb_status_boleto sb', 'b.id_status_boleto_fk = sb.id_status_boleto_pk', 'inner');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $query            = $this->db->get();
        $respRecordsTotal = $query->result();
        if (!empty($respRecordsTotal)):
            $this->recordsTotal = $respRecordsTotal[0]->total;
        else:
            $this->recordsTotal = 0;
        endif;

        # Consultar Boleto
        $this->db->select("b.id_boleto_pk, b.id_pedido_fk, b.pagador_cnpj_cpf, b.pagador_nome, b.valor, b.dt_vencimento,
                           b.dt_pgto, b.id_status_boleto_fk, sb.status_boleto, b.nome_boleto");
        $this->db->from('tb_boleto b');
        $this->db->join('tb_status_boleto sb', 'b.id_status_boleto_fk = sb.id_status_boleto_pk', 'inner');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $boletos = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_boleto   = $value->id_boleto_pk;
                $nome_boleto = $value->nome_boleto;
                $ver         = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Visualizar Boleto' onclick='Remessa.verBoleto(\"$nome_boleto\")'><i class='glyphicon glyphicon-barcode' aria-hidden='true'></i></button>";
                $valor       = isset($value->valor) && $value->valor != "0.00" ? "R\$ ".number_format($value->valor, 2, ',', '.') : "R\$ 0,00";
                $dt_pgto     = isset($value->dt_pgto) ? date('d/m/Y', strtotime($value->dt_pgto)) : "Sem Data";

                $boleto                   = new stdClass();
                $boleto->id_pedido_fk     = $value->id_pedido_fk;
                $boleto->pagador_cnpj_cpf = $value->pagador_cnpj_cpf;
                $boleto->pagador_nome     = $value->pagador_nome;
                $boleto->valor            = $valor;
                $boleto->dt_vencimento    = date('d/m/Y', strtotime($value->dt_vencimento));
                $boleto->dt_pgto          = $dt_pgto;
                $boleto->status_boleto    = $value->status_boleto;
                $boleto->ver              = $ver;
                $boletos[]                = $boleto;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $boletos;

        return $dados;
    }

    /**
     * Método para montar o módulo 11
     *
     * @method modulo11
     * @access public
     * @param integer $num Nosso Numero
     * @return string Retorna Nosso Numero com Digito Verificador
     */
    public function modulo11($num)
    {
        $qtde_num = strlen($num);
        $numeros  = array();
        $parcial  = array();
        $fator    = 2;
        $base     = 9;
        $soma     = 0;
        $digito   = 0;

        # Multiplicar sequencia
        for ($i = $qtde_num; $i > 0; $i--):
            $numeros[$i] = substr($num, $i - 1, 1);
            $parcial[$i] = $numeros[$i] * $fator;
            $soma += $parcial[$i];
            if ($fator == $base):
                $fator = 1;
            endif;
            $fator++;
        endfor;

        # Modulo de 11
        $mod11 = $soma%11;

        if ($mod11 === 1 || $mod11 === 0):
            $digito = 0;
        elseif ($mod11 === 10):
            $digito = 1;
        else:
            $digito = 11-$mod11;
        endif;

        return $num.$digito;
    }

    /**
     * Método para remover acentos de uma string
     *
     * @method removeAcento
     * @access public
     * @param string $str Texto para remoção
     * @return string Texto sem acento
     */
    public function removeAcento($str)
    {
        $a = array(
                    'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß',
                    'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'A',
                    'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'Ð', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G',
                    'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L',
                    'l', '?', '?', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o', 'O', 'o', 'O', 'o', 'Œ', 'œ', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's',
                    'S', 's', 'Š', 'š', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Ÿ', 'Z', 'z', 'Z',
                    'z', 'Ž', 'ž', '?', 'ƒ', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?',
                    '?', 'ç', 'Ç', "'", ".", "/", "-", "º", "ª"
            );
        $b = array(
                    'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's',
                    'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A',
                    'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G',
                    'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L',
                    'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's',
                    'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z',
                    'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O',
                    'o', 'c', 'C', " ", "", "", "", " ", " ");
        return str_replace($a, $b, $str);
    }

    /**
     * Método para montar o Pic9
     *
     * @method picture9
     * @access public
     * @param string $palavra Texto de entrada
     * @param integer $limite Tamanho maximo da string
     * @return string Texto com zerofill
     */
    public function picture9($palavra, $limite)
    {
        $var = str_pad($palavra, $limite, "0", STR_PAD_LEFT);
        return $var;
    }

    /**
     * Método para montar o PicX
     *
     * @method picturex
     * @access public
     * @param string $palavra Texto de entrada
     * @param integer $limite Tamanho maximo da string
     * @return string Texto com espaço
     */
    public function picturex($palavra, $limite)
    {
        $var = str_pad($palavra, $limite, " ", STR_PAD_RIGHT);
        $var = $this->removeAcento($var);
        if (strlen($palavra) >= $limite) {
            $var = substr($palavra, 0, $limite);
        }
        $var = strtoupper($var);
        return $var;
    }

    /**
     * Método para completar uma sequencia de caracteres
     *
     * @method completeReg
     * @access public
     * @param integer $int Total para completar
     * @param string $tipo Tipo de complemento
     * @return string Texto com espaço
     */
    public function completeReg($int, $tipo)
    {

        if ($tipo == "zeros"):
            $space = '';
            for ($i = 1; $i <= $int; $i++):
                $space .= '0';
            endfor;
        elseif ($tipo == "brancos"):
            $space = '';
            for ($i = 1; $i <= $int; $i++):
                $space .= chr(32);
            endfor;
        endif;

        return $space;
    }

    /**
     * Método responsável por pesquisar e buscar remessa de envio
     *
     * @method getRemEnvio
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de remessas
     */
    public function getRemEnvio($search)
    {
        # Atribuir valores
        $this->draw      = $search->draw;
        $this->orderBy   = $search->orderBy;
        $this->orderType = $search->orderType;
        $this->start     = $search->start;
        $this->length    = $search->length;
        $this->filter    = $search->filter;
        $this->columns   = $search->columns;
        $filter          = array();
        $where           = array();

        # Se houver busca pela grid
        if ($this->filter != NULL):
            for($i=0; $i<count($this->columns); $i++):
                if ($this->columns[$i]['searchable'] === "true"):
                    $column = $this->columns[$i]['data'];
                    $filter[]= "$column LIKE '%{$this->filter}%'";
                endif;
            endfor;
        endif;

        # Contar total de registros
        $this->db->select('COUNT(r.id_remessa_pk) AS total');
        $this->db->from('tb_remessa r');
        $this->db->join('tb_remessa_trailler t', 'r.id_remessa_pk = t.id_remessa_fk', 'inner');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $query            = $this->db->get();
        $respRecordsTotal = $query->result();
        if (!empty($respRecordsTotal)):
            $this->recordsTotal = $respRecordsTotal[0]->total;
        else:
            $this->recordsTotal = 0;
        endif;

        # Consultar pedidos
        $this->db->select("r.id_remessa_pk, DATE_FORMAT(r.dt_emissao, '%d/%m/%Y') AS dt_emissao, r.arquivo, t.qtde_linha_arq, t.vl_total_titulo", FALSE);
        $this->db->from('tb_remessa r');
        $this->db->join('tb_remessa_trailler t', 'r.id_remessa_pk = t.id_remessa_fk', 'inner');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $remessas = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_remessa    = $value->id_remessa_pk;
                $vl_total_int  = substr($value->vl_total_titulo, 0, 11);
                $vl_total_cent = substr($value->vl_total_titulo, -2, 2);
                $vl_total      = $vl_total_int.'.'.$vl_total_cent;
                $url_remessa   = base_url('/remessa/createRemessa/'.$id_remessa);
                $acao          = '<button type="button" id="btn_remit_rem" class="btn btn-success btn-xs btn-acao" title="Remitir Remessa" onclick="Financeiro.openWindow(\''.$url_remessa.'\', \'_blank\')"><i class="glyphicon glyphicon-file" aria-hidden="true"></i></button>';
                $acao         .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Boletos Indexados' onclick='Financeiro.abrirRemessa(\"$id_remessa\")'><i class='glyphicon glyphicon-barcode' aria-hidden='true'></i></button>";

                $remessa                  = new stdClass();
                $remessa->id_remessa_pk   = $id_remessa;
                $remessa->dt_emissao      = $value->dt_emissao;
                $remessa->arquivo         = $value->arquivo;
                $remessa->qtde_linha_arq  = (int)$value->qtde_linha_arq;
                $remessa->vl_total_titulo = "R\$ ".number_format($vl_total, 2, ',', '.');
                $remessa->acao            = $acao;
                $remessas[]               = $remessa;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $remessas;

        return $dados;
    }

    /**
     * Método responsável por pesquisar boleto de um remessa
     *
     * @method buscarBoletoRem
     * @param integer $id_remessa Id da Remessa
     * @access public
     * @return obj Lista de boletos
     */
    public function buscarBoletoRem($id_remessa)
    {
        # Vars
        $retorno  = new stdClass();
        $remessas = array();

        # Consultar
        $this->db->select("b.id_pedido_fk, b.pagador_cnpj_cpf, b.pagador_nome, b.valor, DATE_FORMAT(b.dt_vencimento, '%d/%m/%Y') AS dt_vencimento, m.id_cod_carteira_fk,
                           m.cod_ocorrencia_fk, m.especie_doc, m.prim_inst_cobranca, m.seg_inst_cobranca, ca.cod_carteira, co.ocorrencia_mov, ed.especie_doc,
                           pic.inst_cobranca AS p_instrucao, sic.inst_cobranca AS s_instrucao", FALSE);
        $this->db->from('tb_boleto b');
        $this->db->join('tb_remessa_mov m', 'b.id_boleto_pk = m.id_boleto_fk', 'inner');
        $this->db->join('tb_cod_carteira ca', 'm.id_cod_carteira_fk = ca.id_cod_carteira_pk', 'inner');
        $this->db->join('tb_cod_ocorrencia_mov co', 'm.cod_ocorrencia_fk = co.cod_ocorrencia_mov', 'inner');
        $this->db->join('tb_especie_doc ed', 'm.especie_doc = ed.cod_especie_doc', 'inner');
        $this->db->join('tb_inst_cobranca pic', 'm.prim_inst_cobranca = pic.cod_inst_cobranca', 'inner');
        $this->db->join('tb_inst_cobranca sic', 'm.seg_inst_cobranca = sic.cod_inst_cobranca', 'left');
        $this->db->where('m.id_remessa_fk', $id_remessa);
        $rows = $this->db->get()->result();

        if (!empty($rows)):

            foreach ($rows as $value):
                $remessa                   = new stdClass();
                $remessa->id_pedido_fk     = $value->id_pedido_fk;
                $remessa->pagador_cnpj_cpf = $value->pagador_cnpj_cpf;
                $remessa->pagador_nome     = $value->pagador_nome;
                $remessa->valor            = "R\$ " . number_format($value->valor, 2, ',', '.');
                $remessa->dt_vencimento    = $value->dt_vencimento;
                $remessa->cod_carteira     = $value->cod_carteira;
                $remessa->ocorrencia_mov   = $value->ocorrencia_mov;
                $remessa->especie_doc      = $value->especie_doc;
                $remessa->p_instrucao      = $value->p_instrucao;
                $remessa->s_instrucao      = $value->s_instrucao;
                $remessas[]                = $remessa;
            endforeach;

            $retorno->status = TRUE;
            $retorno->msg    = "OK";
            $retorno->dados  = $remessas;
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Nenhum Boleto Encontrado!";
        endif;

        return $retorno;
    }

}

/* End of file remessa_model.php */
/* Location: ./application/models/remessa_model.php */