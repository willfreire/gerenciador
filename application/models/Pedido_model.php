<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido_model extends CI_Model {

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

    /**
     * Método responsável por solicitar um pedido
     *
     * @method setPedido
     * @param obj $valores Dados para solicitar
     * @access public
     * @return obj Status de ação
     */
    public function setPedido($valores)
    {
        # Atribuir vars
        $retorno   = new stdClass();
        $dados     = array();
        $resp      = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        # Beneficio
        $periodo_ini = is_array($valores->periodo) && $valores->periodo[0] != NULL ? explode('/', $valores->periodo[0]) : NULL;
        $periodo_fin = is_array($valores->periodo) && $valores->periodo[1] != NULL ? explode('/', $valores->periodo[1]) : NULL;

        $dados['id_empresa_fk']       = $valores->id_empresa;
        $dados['id_end_empresa_fk']   = $valores->id_endereco;
        $dados['dt_pgto']             = is_array($valores->dt_pgto) ? $valores->dt_pgto[2].'-'.$valores->dt_pgto[1].'-'.$valores->dt_pgto[0] : NULL;
        $dados['dt_ini_beneficio']    = is_array($periodo_ini) ? $periodo_ini[2].'-'.$periodo_ini[1].'-'.$periodo_ini[0] : NULL;
        $dados['dt_fin_beneficio']    = is_array($periodo_fin) ? $periodo_fin[2].'-'.$periodo_fin[1].'-'.$periodo_fin[0] : NULL;
        $dados['id_status_pedido_fk'] = 1;
        $dados['dt_hr_solicitacao']   = mdate($timestamp, $data);
        if ($this->session->userdata('id_vt')):
            $dados['id_usuario_fk'] = $this->session->userdata('id_vt');
        endif;

        # Grava pedido
        $this->db->insert('tb_pedido', $dados);

        if ($this->db->affected_rows() > 0) {
            # Ultima ID
            $id_pedido = $this->db->insert_id();

            # Atualiza Responsavel
            if ($valores->nome_resp != NULL):
                $resp['resp_recebimento'] = $valores->nome_resp;
                # Update
                $this->db->where('id_empresa_fk', $valores->id_empresa);
                $this->db->update('tb_endereco_empresa', $resp);
            endif;

            $retorno->status    = TRUE;
            $retorno->msg       = "Prosseguir Solicita&ccedil;&atilde;o!";
            $retorno->id_pedido = base64_encode($id_pedido);
        } else {
            $retorno->status    = FALSE;
            $retorno->msg       = "Houve um erro ao solicitar! Tente novamente...";
            $retorno->id_pedido = NULL;
        }

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por finalizar um pedido
     *
     * @method finalizaPedido
     * @param obj $valores Dados para finalizar
     * @access public
     * @return obj Status de ação
     */
    public function finalizaPedido($valores)
    {
        # Atribuir vars
        $retorno   = new stdClass();
        $dados     = array();
        $benef     = array();
        $item      = array();
        $rel       = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();
        $error_ben = 0;

        # Gravar Item Beneficios
        if (!empty($valores->id_func) && is_array($valores->id_func)):
            $i = 0;
            foreach ($valores->id_func as $value):
                $this->db->select('b.id_beneficio_pk, b.vl_unitario, b.qtd_diaria, b.id_grupo_fk, b.id_item_beneficio_fk, i.id_item_beneficio_pk, i.vl_rep_func, i.vl_repasse, pe.qtd_dia');
                $this->db->from('tb_beneficio b');
                $this->db->join('tb_item_beneficio i', 'b.id_item_beneficio_fk = i.id_item_beneficio_pk', 'inner');
                $this->db->join('tb_dados_profissional dp', 'dp.id_funcionario_fk = b.id_funcionario_fk', 'inner');
                $this->db->join('tb_periodo pe', 'pe.id_periodo_pk = dp.id_periodo_pk', 'inner');
                $this->db->where('b.id_funcionario_fk', $value);
                $resp = $this->db->get()->result();

                if (!empty($resp)):
                    foreach ($resp as $vl):
                        $benef['id_beneficio_pk'][$i] = $vl->id_beneficio_pk;
                        $benef['vl_unitario'][$i]     = $vl->vl_unitario;
                        $benef['qtd_diaria'][$i]      = $vl->qtd_dia;
                        if ($vl->id_grupo_fk == "3") {
                            $benef['vl_total'][$i] = ($vl->vl_unitario*$vl->qtd_diaria);
                        } else {
                            $benef['vl_total'][$i] = ($vl->vl_unitario*($vl->qtd_dia*$vl->qtd_diaria));
                        }
                        $benef['vl_repasse'][$i]      = isset($vl->vl_repasse) && $vl->vl_repasse != "" ? (($vl->vl_repasse*($vl->vl_unitario*($vl->qtd_dia*$vl->qtd_diaria)))/100) : 0;
                        $benef['vl_rep_func'][$i]     = isset($vl->vl_rep_func) && $vl->vl_rep_func != "" ? $vl->vl_rep_func : 0;

                        # Devidir Grupos para calcular taxas
                        # Grupo Vale Transporte
                        if ($vl->id_grupo_fk == "1") {
                            $benef['vl_total_vt'][$i] = ($vl->vl_unitario*($vl->qtd_dia*$vl->qtd_diaria));
                        } else {
                            $benef['vl_total_vt'][$i] = 0;
                        }

                        # Grupo Vale Refeição
                        if ($vl->id_grupo_fk == "2") {
                            $benef['vl_total_cr'][$i] = ($vl->vl_unitario*($vl->qtd_dia*$vl->qtd_diaria));
                        } else {
                            $benef['vl_total_cr'][$i] = 0;
                        }

                        # Grupo Vale Alimentação
                        if ($vl->id_grupo_fk == "3") {
                            $benef['vl_total_ca'][$i] = ($vl->vl_unitario*($vl->qtd_diaria));
                        } else {
                            $benef['vl_total_ca'][$i] = 0;
                        }

                        # Grupo Vale Combustivel
                        if ($vl->id_grupo_fk == "4") {
                            $benef['vl_total_cc'][$i] = ($vl->vl_unitario*($vl->qtd_dia*$vl->qtd_diaria));
                        } else {
                            $benef['vl_total_cc'][$i] = 0;
                        }

                        # Salvar Itens Pedido
                        $item['id_pedido_fk']    = $valores->id;
                        $item['id_beneficio_fk'] = $vl->id_beneficio_pk;
                        $item['vl_unitario']     = $vl->vl_unitario;
                        if ($vl->id_grupo_fk == "3") {
                            $item['qtd_unitaria'] = $vl->qtd_diaria;
                        } else {
                            $item['qtd_unitaria'] = ($vl->qtd_dia*$vl->qtd_diaria);
                        }
                        $this->db->insert('tb_item_pedido', $item);
                        $id_last_item_pedido = $this->db->insert_id();

                        # Salvar em tb_relatorio
                        $rel['id_pedido_fk']         = $valores->id;
                        $rel['id_empresa_fk']        = $valores->id_cliente;
                        $rel['id_funcionario_fk']    = $value;
                        $rel['id_status_credito_fk'] = 1;
                        $rel['id_item_beneficio_fk'] = $vl->id_item_beneficio_fk;
                        $rel['id_item_pedido_fk']    = $id_last_item_pedido;
                        $rel['id_beneficio_fk']      = $vl->id_beneficio_pk;
                        $rel['vl_unitario']          = $vl->vl_unitario;
                        if ($vl->id_grupo_fk == "3") {
                            $rel['qtd_unitaria'] = $vl->qtd_diaria;
                        } else {
                            $rel['qtd_unitaria'] = ($vl->qtd_dia*$vl->qtd_diaria);
                        }
                        $this->db->insert('tb_relatorio', $rel);
                        $i++;
                    endforeach;
                endif;
            endforeach;
        else:
            $error_ben          = 1;
            $retorno->status    = FALSE;
            $retorno->msg       = "Houve um erro ao Finalizar! Obrigat&oacute;rio cadastrar primeiro o(s) Benef&iacute;cio(s) do(s) Funcion&aacute;rio(s).";
            $retorno->url       = base_url("beneficiocartao/cadastrar");
            $retorno->id_pedido = NULL;
        endif;

        if ($error_ben !== 1):
            # Calcular Taxas
            $vl_itens       = array_sum($benef['vl_total']);
            $vl_itens_vt    = array_sum($benef['vl_total_vt']);
            $vl_itens_cr    = array_sum($benef['vl_total_cr']);
            $vl_itens_ca    = array_sum($benef['vl_total_ca']);
            $vl_itens_cc    = array_sum($benef['vl_total_cc']);
            $vl_taxa_adm_vt = $vl_itens_vt != 0 ? (round($vl_itens_vt*($valores->taxa_adm/100), 2)) : 0;
            $vl_taxa_fx_p   = $vl_itens_vt != 0 ? (round($vl_itens_vt*($valores->taxa_fx_perc/100), 2)) : 0;
            $vl_taxa_adm_cr = $vl_itens_cr != 0 ? (round($vl_itens_cr*($valores->taxa_adm_cr/100), 2)) : 0;
            $vl_taxa_adm_ca = $vl_itens_ca != 0 ? (round($vl_itens_ca*($valores->taxa_adm_ca/100), 2)) : 0;
            $vl_taxa_adm_cc = $vl_itens_cc != 0 ? (round($vl_itens_cc*($valores->taxa_adm_cc/100), 2)) : 0;
            $vl_taxa        = ($vl_taxa_adm_vt+$vl_taxa_fx_p+$valores->taxa_fx_real+$valores->taxa_entrega+$vl_taxa_adm_cr+$vl_taxa_adm_ca+$vl_taxa_adm_cc);
            $vl_repasse     = round(array_sum($benef['vl_repasse']), 2)+array_sum($benef['vl_rep_func']);
            $vl_total       = ($vl_itens+$vl_taxa+$vl_repasse);

            # Beneficio
            $periodo_ini = is_array($valores->periodo) && $valores->periodo[0] != NULL ? explode('/', $valores->periodo[0]) : NULL;
            $periodo_fin = is_array($valores->periodo) && $valores->periodo[1] != NULL ? explode('/', $valores->periodo[1]) : NULL;

            $dados['dt_pgto']           = is_array($valores->dt_pgto) ? $valores->dt_pgto[2].'-'.$valores->dt_pgto[1].'-'.$valores->dt_pgto[0] : NULL;
            $dados['dt_ini_beneficio']  = is_array($periodo_ini) ? $periodo_ini[2].'-'.$periodo_ini[1].'-'.$periodo_ini[0] : NULL;
            $dados['dt_fin_beneficio']  = is_array($periodo_fin) ? $periodo_fin[2].'-'.$periodo_fin[1].'-'.$periodo_fin[0] : NULL;
            $dados['vl_itens']          = $vl_itens;
            $dados['vl_taxa']           = $vl_taxa;
            $dados['vl_repasse']        = $vl_repasse;
            $dados['vl_total']          = $vl_total;
            $dados['dt_hr_solicitacao'] = mdate($timestamp, $data);

            # Update pedido
            $this->db->where('id_pedido_pk', $valores->id);
            $this->db->update('tb_pedido', $dados);

            if ($this->db->affected_rows() > 0) {
                $retorno->status    = TRUE;
                $retorno->msg       = "Pedido Solicitado com Sucesso!";
                $retorno->id_pedido = base64_encode($valores->id);
            } else {
                $retorno->status    = FALSE;
                $retorno->msg       = "Houve um erro ao Finalizar! Tente novamente...";
                $retorno->id_pedido = NULL;
            }
        else:
            # Deletar Pedido
            $this->delPedido($valores->id);
        endif;

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por exportar a visualizacao de um pedido
     *
     * @method exportVerPedido
     * @param obj $valores Dados do pedido
     * @access public
     * @return obj Itens do Pedido
     */
    public function exportVerPedido($valores)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $listas  = array();

        # Buscar Itens Beneficios
        if (!empty($valores->id_func) && is_array($valores->id_func)):
            foreach ($valores->id_func as $value):
                $this->db->select('b.id_beneficio_pk, b.vl_unitario, b.qtd_diaria, b.id_grupo_fk, b.id_item_beneficio_fk,
                                   i.descricao, i.vl_rep_func, i.vl_repasse, pe.qtd_dia, vwf.cnpj, vwf.nome_razao, vwf.cpf,
                                   vwf.rg, vwf.nome, c.num_cartao');
                $this->db->from('tb_beneficio b');
                $this->db->join('tb_item_beneficio i', 'b.id_item_beneficio_fk = i.id_item_beneficio_pk', 'inner');
                $this->db->join('vw_funcionario vwf', 'vwf.id_funcionario_pk = b.id_funcionario_fk', 'inner');
                $this->db->join('tb_periodo pe', 'pe.id_periodo_pk = vwf.id_periodo_pk', 'inner');
                $this->db->join('tb_cartao c', 'c.id_funcionario_fk = b.id_funcionario_fk AND c.id_beneficio_fk = b.id_beneficio_pk', 'left');
                $this->db->where('b.id_funcionario_fk', $value);
                $resp = $this->db->get()->result();

                if (!empty($resp)):
                    $vl_total     = 0;
                    $qtd_unitaria = 0;
                    foreach ($resp as $vl):
                        if ($vl->id_grupo_fk == "3") {
                            $vl_total     = ($vl->vl_unitario*$vl->qtd_diaria);
                            $qtd_unitaria = $vl->qtd_diaria;
                        } else {
                            $vl_total     = ($vl->vl_unitario*($vl->qtd_dia*$vl->qtd_diaria));
                            $qtd_unitaria = ($vl->qtd_dia*$vl->qtd_diaria);
                        }

                        $lista                = new stdClass();
                        $lista->cnpj          = $vl->cnpj;
                        $lista->nome_razao    = $vl->nome_razao;
                        $lista->cpf           = $vl->cpf;
                        $lista->rg            = $vl->rg;
                        $lista->nome          = $vl->nome;
                        $lista->cod_benefico  = $vl->id_item_beneficio_fk;
                        $lista->desc_benefico = $vl->descricao;
                        $lista->vl_unitario   = "R$ ".number_format($vl->vl_unitario, 2, ',', '.');
                        $lista->qtd_unitaria  = $qtd_unitaria;
                        $lista->vl_total      = "R$ ".number_format($vl_total, 2, ',', '.');
                        $lista->num_cartao    = $vl->num_cartao;
                        $listas[]             = $lista;
                    endforeach;
                endif;
            endforeach;
            $retorno->status = TRUE;
            $retorno->msg    = "Dados Gerados com Sucesso!";
            $retorno->dados  = $listas;
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Finalizar! Obrigat&oacute;rio cadastrar primeiro o(s) Benef&iacute;cio(s) do(s) Funcion&aacute;rio(s).";
            $retorno->dados  = NULL;
        endif;

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por pesquisar e buscar pedidos
     *
     * @method getPedidoAcompanha
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de pedidos
     */
    public function getPedidoAcompanha($search)
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
        $this->db->select('COUNT(p.id_pedido_pk) AS total');
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_status_pedido s', 'p.id_status_pedido_fk = s.id_status_pedido_pk', 'inner');
        $this->db->where('p.id_empresa_fk', $this->session->userdata('id_client'));
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
        $this->db->select("p.id_pedido_pk, p.id_empresa_fk, e.cnpj, e.nome_razao, p.id_end_empresa_fk,
                           p.dt_pgto, CONCAT(DATE_FORMAT(p.dt_ini_beneficio, '%d/%m/%Y'), ' a ', DATE_FORMAT(p.dt_fin_beneficio, '%d/%m/%Y')) AS periodo, p.vl_itens,
                           p.vl_taxa, p.vl_repasse, p.vl_total, p.id_status_pedido_fk, s.status_pedido, p.boleto_gerado, p.dt_hr_solicitacao", FALSE);
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_status_pedido s', 'p.id_status_pedido_fk = s.id_status_pedido_pk', 'inner');
        $this->db->where('p.id_empresa_fk', $this->session->userdata('id_client'));
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $pedidos = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Buscar Nome Boleto
                $this->db->select("nome_boleto");
                $this->db->from('tb_boleto');
                $this->db->where('id_pedido_fk', $value->id_pedido_pk);
                $row_boleto = $this->db->get()->result();

                $nome_boleto = NULL;
                if (!empty($row_boleto)):
                    $nome_boleto = $row_boleto[0]->nome_boleto;
                endif;

                # Botao
                $id_pedido       = $value->id_pedido_pk;
                $url_boleto_pdf  = PATH_PROJ.'/assets/boletos/'.$nome_boleto;
                $url_boleto_html = base_url('/pedido/remitirboletohtml/'.$id_pedido);
                if ($nome_boleto != "" && file_exists($url_boleto_pdf)):
                    $link_boleto = base_url('assets/boletos/'.$nome_boleto);
                else:
                    $link_boleto = $url_boleto_html;
                endif;

                # $url_boleto = base_url('./pedido/gerarboleto/'.base64_encode($id_pedido));
                # $url_view   = base_url('./pedido/ver/'.$id_pedido);
                $acao       = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Remitir Boleto' onclick='Pedido.verBoleto(\"$link_boleto\")'><i class='glyphicon glyphicon-barcode' aria-hidden='true'></i></button>";
                $acao      .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Pedido' onclick='Pedido.exportPedido(\"$id_pedido\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                # $acao      .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Per&iacute;odo' onclick='Pedido.del(\"$id_period\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $pedido                = new stdClass();
                $pedido->id_pedido_pk  = $id_pedido;
                $pedido->cnpj          = $value->cnpj;
                $pedido->nome_razao    = $value->nome_razao;
                $pedido->dt_pgto       = date('d/m/Y', strtotime($value->dt_pgto));
                $pedido->periodo       = $value->periodo;
                $pedido->vl_itens      = "R\$ ".number_format($value->vl_itens, 2, ',', '.');
                $pedido->vl_taxa       = isset($value->vl_taxa) && $value->vl_taxa != "" ? "R\$ ".number_format($value->vl_taxa, 2, ',', '.') : "R\$ 0,00";
                $pedido->vl_repasse    = isset($value->vl_repasse) && $value->vl_repasse != "" ? "R\$ ".number_format($value->vl_repasse, 2, ',', '.') : "R\$ 0,00";
                $pedido->vl_total      = "R\$ ".number_format($value->vl_total, 2, ',', '.');
                $pedido->status_pedido = $value->status_pedido;
                $pedido->acao          = $acao;
                $pedidos[]             = $pedido;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $pedidos;

        return $dados;
    }

    /**
     * Método responsável por pesquisar e buscar pedidos
     *
     * @method getPedido
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de pedidos
     */
    public function getPedido($search)
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
        $this->db->select('COUNT(p.id_pedido_pk) AS total');
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_status_pedido s', 'p.id_status_pedido_fk = s.id_status_pedido_pk', 'inner');
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
        $this->db->select("p.id_pedido_pk, p.id_empresa_fk, e.cnpj, e.nome_razao, p.id_end_empresa_fk,
                           p.dt_pgto, CONCAT(DATE_FORMAT(p.dt_ini_beneficio, '%d/%m/%Y'), ' a ', DATE_FORMAT(p.dt_fin_beneficio, '%d/%m/%Y')) AS periodo, p.vl_itens,
                           p.vl_repasse, p.vl_taxa, p.vl_total, p.id_status_pedido_fk, s.status_pedido, p.boleto_gerado, p.dt_hr_solicitacao", FALSE);
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_status_pedido s', 'p.id_status_pedido_fk = s.id_status_pedido_pk', 'inner');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $pedidos = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Buscar Nome Boleto
                $this->db->select("nome_boleto");
                $this->db->from('tb_boleto');
                $this->db->where('id_pedido_fk', $value->id_pedido_pk);
                $row_boleto = $this->db->get()->result();

                $nome_boleto = NULL;
                if (!empty($row_boleto)):
                    $nome_boleto = $row_boleto[0]->nome_boleto;
                endif;

                # Botao
                $id_pedido       = $value->id_pedido_pk;
                $id_status       = $value->id_status_pedido_fk;
                $url_boleto_pdf  = PATH_PROJ.'/assets/boletos/'.$nome_boleto;
                $url_boleto_html = base_url('/pedido/remitirboletohtml/'.$id_pedido);
                if ($nome_boleto != "" && file_exists($url_boleto_pdf)):
                    $link_boleto = base_url('assets/boletos/'.$nome_boleto);
                else:
                    $link_boleto = $url_boleto_html;
                endif;

                # $url_view    = base_url('./pedido/ver/'.$id_pedido);
                $acao        = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Remitir Boleto' onclick='Pedido.verBoleto(\"$link_boleto\")'><i class='glyphicon glyphicon-barcode' aria-hidden='true'></i></button>";
                $acao       .= "<button type='button' class='btn btn-warning btn-xs btn-acao' title='Editar Status do Pedido' onclick='Pedido.alterStatus(\"$id_pedido\", \"$id_status\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao       .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Pedido' onclick='Pedido.exportPedido(\"$id_pedido\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                $acao       .= "<button type='button' class='btn btn-success btn-xs btn-acao' title='Valida&ccedil;&atilde;o de Cr&eacute;dito' onclick='Pedido.validaCredito(\"$id_pedido\")'><i class='glyphicon glyphicon-credit-card' aria-hidden='true'></i></button>";
                if ($this->session->userdata('id_perfil_vt') == "1"):
                    $acao .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Pedido' onclick='Pedido.del(\"$id_pedido\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";
                endif;

                $pedido                = new stdClass();
                $pedido->id_pedido_pk  = $id_pedido;
                $pedido->cnpj          = $value->cnpj;
                $pedido->nome_razao    = $value->nome_razao;
                $pedido->dt_pgto       = date('d/m/Y', strtotime($value->dt_pgto));
                $pedido->periodo       = $value->periodo;
                $pedido->vl_itens      = "R\$ ".number_format($value->vl_itens, 2, ',', '.');
                $pedido->vl_taxa       = isset($value->vl_taxa) && $value->vl_taxa != "" ? "R\$ ".number_format($value->vl_taxa, 2, ',', '.') : "R\$ 0,00";
                $pedido->vl_repasse    = isset($value->vl_repasse) && $value->vl_repasse != "" ? "R\$ ".number_format($value->vl_repasse, 2, ',', '.') : "R\$ 0,00";
                $pedido->vl_total      = "R\$ ".number_format($value->vl_total, 2, ',', '.');
                $pedido->status_pedido = $value->status_pedido;
                $pedido->acao          = $acao;
                $pedidos[]             = $pedido;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $pedidos;

        return $dados;
    }

    /**
     * Método responsável por consultar e exporta uma lista de pedido
     *
     * @method getPedidoExport
     * @param integer $id_pedido Id do Pedido
     * @access public
     * @return obj Lista de pedidos
     */
    public function getPedidoExport($id_pedido)
    {
        # Vars
        $retorno = new stdClass();
        $dados   = array();

        # Consultar pedidos
        $this->db->select('p.id_pedido_pk, p.id_empresa_fk, e.cnpj, e.nome_razao, dp.matricula, c.num_cartao, f.cpf,
                           f.rg, f.nome, ib.id_item_beneficio_pk, i.vl_unitario, i.qtd_unitaria AS qtd_diaria, ib.descricao');
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_item_pedido i', 'p.id_pedido_pk = i.id_pedido_fk', 'inner');
        $this->db->join('tb_beneficio b', 'i.id_beneficio_fk = b.id_beneficio_pk', 'inner');
        $this->db->join('tb_item_beneficio ib', 'b.id_item_beneficio_fk = ib.id_item_beneficio_pk', 'inner');
        $this->db->join('tb_funcionario f', 'b.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->join('tb_dados_profissional dp', 'f.id_funcionario_pk = dp.id_funcionario_fk', 'inner');
        $this->db->join('tb_cartao c', 'i.id_beneficio_fk = c.id_beneficio_fk', 'left');
        $this->db->where('p.id_pedido_pk', $id_pedido);
        $rows = $this->db->get()->result();

        if (!empty($rows)):
            foreach ($rows as $valor):
                $vl_total = ($valor->vl_unitario*$valor->qtd_diaria);

                $dado               = new stdClass();
                $dado->id_pedido    = $valor->id_pedido_pk;
                $dado->cnpj         = $valor->cnpj;
                $dado->nome_razao   = $valor->nome_razao;
                $dado->cpf          = $valor->cpf;
                $dado->rg           = $valor->rg;
                $dado->nome         = $valor->nome;
                $dado->id_item      = $valor->id_item_beneficio_pk;
                $dado->descricao    = $valor->descricao;
                $dado->vl_unitario  = isset($valor->vl_unitario) && $valor->vl_unitario != "" ? "R\$ ".number_format($valor->vl_unitario, 2, ',', '.') : "R$ 0,00";
                $dado->qtde_diaria  = $valor->qtd_diaria;
                $dado->vl_total     = isset($vl_total) ? "R\$ ".number_format($vl_total, 2, ',', '.') : "R$ 0,00";
                $dado->num_cartao   = isset($valor->num_cartao) && $valor->num_cartao != "" ? $valor->num_cartao : "N&atilde;o Possui";
                $dados[]            = $dado;
            endforeach;

            $retorno->status = TRUE;
            $retorno->msg    = "Ok";
            $retorno->dados  = $dados;
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Falha na Exporta&ccedil;&atilde;o para Excel!";
            $retorno->dados  = NULL;
        endif;

        return $retorno;
    }

    /**
     * Método de exclusão de um Pedido
     *
     * @method delPedido
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delPedido($id)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $file    = NULL;

        # Verificar se boleto esta em Remessa
        $this->db->select("r.arquivo");
        $this->db->from("tb_boleto b");
        $this->db->join("tb_remessa_mov m", "m.id_boleto_fk = b.id_boleto_pk", "inner");
        $this->db->join("tb_remessa r", "r.id_remessa_pk = m.id_remessa_fk", "inner");
        $this->db->where("b.id_pedido_fk", $id);
        $rows = $this->db->get()->result();

        if (!empty($rows)):
            $file = $rows[0]->arquivo;
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao Excluir! Necess&aacute;rio excluir a Remessa <strong>{$file}</strong>";
        else:
            # SQL
            $this->db->where('id_pedido_pk', $id);
            $this->db->delete('tb_pedido');

            if ($this->db->affected_rows() > 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Exclus&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao Excluir! Tente novamente...";
            }
        endif;

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por alterar o status de um pedido
     *
     * @method alterStPedido
     * @access public
     * @param obj $status Dados para alteraçao
     * @return obj Status da Acao
     */
    public function alterStPedido($status)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $dados   = array();
        $pedido  = array();

        # Alterar Status no tb_pedido
        $pedido['id_status_pedido_fk'] = $status->id_status;
        $this->db->where('id_pedido_pk', $status->id_pedido);
        $this->db->update('tb_pedido', $pedido);

        if ($this->db->affected_rows() > 0) {
            # Timestamp
            $timestamp = "%Y-%m-%d %H:%i:%s";
            $data      = time();

            # Campos
            $dados['id_status_pedido_fk'] = $status->id_status;
            $dados['id_usuario_fk']       = $status->id_user;
            $dados['id_pedido_fk']        = $status->id_pedido;
            $dados['dt_hr']               = mdate($timestamp, $data);

            # Grava dados
            $this->db->insert('tb_status_pedido_log', $dados);

            $retorno->status = TRUE;
            $retorno->msg    = "Status Alterado com Sucesso!";
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Status n&atilde;o Alterado!";
        }

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por buscar os itens do pedido
     *
     * @method getItemBenPedido
     * @access public
     * @param integer $id_pedido Id do pedido
     * @return obj Dados do beneficios do pedido
     */
    public function getItemBenPedido($id_pedido)
    {
        # Vars
        $retorno = new stdClass();

        # Sql Itens dos Beneficiarios
        $this->db->select('ip.id_item_pedido_pk, ip.id_pedido_fk, ip.id_beneficio_fk, ip.id_status_fk AS status_benef,
                           b.id_funcionario_fk, b.id_item_beneficio_fk, ib.descricao, ip.vl_unitario, f.cpf, f.nome');
        $this->db->from('tb_item_pedido ip');
        $this->db->join('tb_beneficio b', 'ip.id_beneficio_fk = b.id_beneficio_pk', 'inner');
        $this->db->join('tb_funcionario f', 'b.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->join('tb_item_beneficio ib', 'b.id_item_beneficio_fk = ib.id_item_beneficio_pk', 'inner');
        $this->db->where('ip.id_pedido_fk', $id_pedido);
        $this->db->order_by('f.nome', 'ASC');
        $rows = $this->db->get()->result();

        if (!empty($rows)):
            foreach($rows as $value):
                # valor
                $vl_un = isset($value->vl_unitario) ? number_format($value->vl_unitario, 2, ',', '.') : "0,00";

                # Acao
                $acao  = '<label class="radio-inline">';
                $acao .=    '<input type="radio" name="vl_ben_'.$value->id_item_pedido_pk.'" id="vl_ben_s_'.$value->id_item_pedido_pk.'" value="2" onclick="Pedido.setValBen(\'2\', \''.$value->id_item_pedido_pk.'\', \''.$id_pedido.'\')" '.($value->status_benef == "2" ? "checked" : "").' > <div class="radio-position">Habilitado</div>';
                $acao .= '</label>';
                $acao .= '<label class="radio-inline">';
                $acao .=    '<input type="radio" name="vl_ben_'.$value->id_item_pedido_pk.'" id="vl_ben_n_'.$value->id_item_pedido_pk.'" value="3" onclick="Pedido.setValBen(\'3\', \''.$value->id_item_pedido_pk.'\', \''.$id_pedido.'\')" '.($value->status_benef == "3" ? "checked" : "").'> <div class="radio-position">Cancelado</div>';
                $acao .= '</label>';

                $item            = new stdClass();
                $item->id        = $value->id_item_pedido_pk;
                $item->st_benef  = $acao;
                $item->cpf       = $value->cpf;
                $item->nome      = $value->nome;
                $item->descricao = $value->descricao." - <strong>R$ $vl_un</strong>";
                $itens[]         = $item;
            endforeach;

            $retorno->status = TRUE;
            $retorno->msg    = "Ok";
            $retorno->dados  = $itens;
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Nenhum benef&iacute;cio encontrado para este Pedido!";
        endif;

        return $retorno;
    }

    /**
     * Método responsável por validar credito de beneficio
     *
     * @method setValCredBen
     * @access public
     * @param status $status Status do credito
     * @param integer $id_benef Id do beneficio
     * @return obj Status da ação
     */
    public function setValCredBen($status, $id_benef)
    {
        # Vars
        $retorno   = new stdClass();
        $dados     = array();
        $dados_rel = array();

        # Alterar Status
        $dados['id_status_fk'] = $status;
        $this->db->where('id_item_pedido_pk', $id_benef);
        $this->db->update('tb_item_pedido', $dados);

        if ($this->db->affected_rows() >= 0):
            # Alterar Status no tb_relatorio
            $dados_rel['id_status_credito_fk'] = $status;
            $this->db->where('id_item_pedido_fk', $id_benef);
            $this->db->update('tb_relatorio', $dados_rel);

            $retorno->status = TRUE;
            $retorno->msg    = "Status do Cr&eacute;dito alterado com Sucesso!";
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao alterar o Status do Cr&eacute;dito";
        endif;

        return $retorno;
    }

    /**
     * Método responsável por validar credito de todos itens do beneficio
     * por Id do Pedido
     *
     * @method setValAllCred
     * @access public
     * @param status $status Status do credito
     * @param integer $id_pedido Id do pedido
     * @return obj Status da ação
     */
    public function setValAllCred($status, $id_pedido)
    {
        # Vars
        $retorno   = new stdClass();
        $dados     = array();
        $dados_rel = array();

        # Alterar Status
        $dados['id_status_fk'] = $status;
        $this->db->where('id_pedido_fk', $id_pedido);
        $this->db->update('tb_item_pedido', $dados);

        if ($this->db->affected_rows() >= 0):
            # Alterar Status no tb_relatorio
            $dados_rel['id_status_credito_fk'] = $status;
            $this->db->where('id_pedido_fk', $id_pedido);
            $this->db->update('tb_relatorio', $dados_rel);

            $retorno->status = TRUE;
            $retorno->msg    = "Status dos Cr&eacute;ditos alterado com Sucesso!";
        else:
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao alterar o Status dos Cr&eacute;ditos";
        endif;

        return $retorno;
    }

}

/* End of file pedido_model.php */
/* Location: ./application/models/pedido_model.php */