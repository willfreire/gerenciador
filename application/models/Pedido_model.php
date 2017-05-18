<?php

defined('BASEPATH') OR exit('No direct script access allowed');

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

    public function __construct()
    {
        parent::__construct();
    }

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
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();
        $error_ben = 0;

        # Gravar Item Beneficios
        if (!empty($valores->id_func) && is_array($valores->id_func)):
            $i = 0;
            foreach ($valores->id_func as $value):
                $this->db->select('id_beneficio_pk, vl_unitario, qtd_diaria');
                $this->db->from('tb_beneficio');
                $this->db->where('id_funcionario_fk', $value);
                $resp = $this->db->get()->result();

                if (!empty($resp)):
                    foreach ($resp as $vl):
                        $benef['id_beneficio_pk'][$i] = $vl->id_beneficio_pk;
                        $benef['vl_unitario'][$i]     = $vl->vl_unitario;
                        $benef['qtd_diaria'][$i]      = $vl->qtd_diaria;
                        $benef['vl_total'][$i]        = ($vl->vl_unitario*$vl->qtd_diaria);

                        # Salvar Itens Beneficio
                        $item['id_pedido_fk']    = $valores->id;
                        $item['id_beneficio_fk'] = $vl->id_beneficio_pk;
                        $this->db->insert('tb_item_pedido', $item);
                        $i++;
                    endforeach;
                else:
                    $error_ben = 1;
                    $retorno->status    = FALSE;
                    $retorno->msg       = "Houve um erro ao Finalizar! Obrigat&oacute;rio cadastrar primeiro o(s) Benef&iacute;cio(s) do(s) Funcion&aacute;rio(s).";
                    $retorno->url       = base_url("beneficiocartao/cadastrar");
                    $retorno->id_pedido = NULL;
                endif;
            endforeach;
        endif;

        if ($error_ben !== 1):
            # Calcular Taxas
            $vl_itens = array_sum($benef['vl_total']);
            $vl_taxa  = (round($vl_itens*($valores->taxa_adm/100), 2)+$valores->taxa_entrega);
            $vl_total = ($vl_itens+$vl_taxa);

            # Beneficio
            $periodo_ini = is_array($valores->periodo) && $valores->periodo[0] != NULL ? explode('/', $valores->periodo[0]) : NULL;
            $periodo_fin = is_array($valores->periodo) && $valores->periodo[1] != NULL ? explode('/', $valores->periodo[1]) : NULL;

            $dados['dt_pgto']           = is_array($valores->dt_pgto) ? $valores->dt_pgto[2].'-'.$valores->dt_pgto[1].'-'.$valores->dt_pgto[0] : NULL;
            $dados['dt_ini_beneficio']  = is_array($periodo_ini) ? $periodo_ini[2].'-'.$periodo_ini[1].'-'.$periodo_ini[0] : NULL;
            $dados['dt_fin_beneficio']  = is_array($periodo_fin) ? $periodo_fin[2].'-'.$periodo_fin[1].'-'.$periodo_fin[0] : NULL;
            $dados['vl_itens']          = $vl_itens;
            $dados['vl_taxa']           = $vl_taxa;
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
                           p.dt_pgto, CONCAT(DATE_FORMAT(p.dt_ini_beneficio, '%d/%m/%Y'), ' a ', DATE_FORMAT(p.dt_fin_beneficio, '%d/%m/%Y')) AS periodo,
                           p.vl_itens, p.vl_taxa, p.vl_total, p.id_status_pedido_fk, s.status_pedido, p.boleto_gerado, p.dt_hr_solicitacao, b.nome_boleto", FALSE);
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_status_pedido s', 'p.id_status_pedido_fk = s.id_status_pedido_pk', 'inner');
        $this->db->join('tb_boleto b', 'p.id_pedido_pk = b.id_pedido_fk', 'left');
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
                # Botao
                $id_pedido  = $value->id_pedido_pk;
                $nome_boleto = $value->nome_boleto;
                # $url_boleto = base_url('./pedido/gerarboleto/'.base64_encode($id_pedido));
                $url_view   = base_url('./pedido/ver/'.$id_pedido);
                $acao       = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Remitir Boleto' onclick='Pedido.verBoleto(\"$nome_boleto\")'><i class='glyphicon glyphicon-barcode' aria-hidden='true'></i></button>";
                $acao      .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Pedido' onclick='Pedido.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                # $acao      .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Per&iacute;odo' onclick='Pedido.del(\"$id_period\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                $pedido                = new stdClass();
                $pedido->id_pedido_pk  = $id_pedido;
                $pedido->cnpj          = $value->cnpj;
                $pedido->nome_razao    = $value->nome_razao;
                $pedido->dt_pgto       = date('d/m/Y', strtotime($value->dt_pgto));
                $pedido->periodo       = $value->periodo;
                $pedido->vl_itens      = "R\$ ".number_format($value->vl_itens, 2, ',', '.');
                $pedido->vl_taxa       = "R\$ ".number_format($value->vl_taxa, 2, ',', '.');
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
                           p.dt_pgto, CONCAT(DATE_FORMAT(p.dt_ini_beneficio, '%d/%m/%Y'), ' a ', DATE_FORMAT(p.dt_fin_beneficio, '%d/%m/%Y')) AS periodo,
                           p.vl_itens, p.vl_taxa, p.vl_total, p.id_status_pedido_fk, s.status_pedido, p.boleto_gerado, p.dt_hr_solicitacao, b.nome_boleto", FALSE);
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_status_pedido s', 'p.id_status_pedido_fk = s.id_status_pedido_pk', 'inner');
        $this->db->join('tb_boleto b', 'p.id_pedido_pk = b.id_pedido_fk', 'left');
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
                # Botao
                $id_pedido   = $value->id_pedido_pk;
                $id_status   = $value->id_status_pedido_fk;
                $nome_boleto = $value->nome_boleto;
                # $url_boleto  = base_url('./pedido/gerarboleto/'.base64_encode($id_pedido));
                $url_view    = base_url('./pedido/ver/'.$id_pedido);
                $acao        = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Remitir Boleto' onclick='Pedido.verBoleto(\"$nome_boleto\")'><i class='glyphicon glyphicon-barcode' aria-hidden='true'></i></button>";
                $acao       .= "<button type='button' class='btn btn-warning btn-xs btn-acao' title='Editar Status do Pedido' onclick='Pedido.alterStatus(\"$id_pedido\", \"$id_status\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao       .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Pedido' onclick='Pedido.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
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
                $pedido->vl_taxa       = "R\$ ".number_format($value->vl_taxa, 2, ',', '.');
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
    public function alterStPedido($status) {
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

}

/* End of file pedido_model.php */
/* Location: ./application/models/pedido_model.php */