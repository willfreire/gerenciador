<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
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
        $retorno   = new stdClass();
        $dados     = array();
        $log       = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        # Consultar pedidos
        $this->db->select('p.id_pedido_pk, p.id_empresa_fk, e.cnpj, e.nome_razao, dp.matricula, c.num_cartao, f.cpf, f.nome,
                           ib.id_item_beneficio_pk, r.vl_unitario, r.qtd_unitaria AS qtd_diaria, ib.descricao, sc.status');
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_relatorio r', 'p.id_pedido_pk = r.id_pedido_fk', 'inner');
        $this->db->join('tb_status_credito sc', 'r.id_status_credito_fk = sc.id_status_pk', 'inner');
        $this->db->join('tb_item_beneficio ib', 'r.id_item_beneficio_fk = ib.id_item_beneficio_pk', 'inner');
        $this->db->join('tb_funcionario f', 'r.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->join('tb_dados_profissional dp', 'f.id_funcionario_pk = dp.id_funcionario_fk', 'inner');
        $this->db->join('tb_cartao c', 'r.id_beneficio_fk = c.id_beneficio_fk', 'left');
        $this->db->where('p.id_pedido_pk', $id_pedido);
        $rows = $this->db->get()->result();

        if (!empty($rows)):
            foreach ($rows as $valor):
                $vl_total = ($valor->vl_unitario*$valor->qtd_diaria);

                $dado               = new stdClass();
                $dado->id_pedido    = $valor->id_pedido_pk;
                $dado->cnpj         = $valor->cnpj;
                $dado->nome_razao   = $valor->nome_razao;
                $dado->matricula    = $valor->matricula;
                $dado->cpf          = $valor->cpf;
                $dado->nome         = $valor->nome;
                $dado->id_item      = $valor->id_item_beneficio_pk;
                $dado->descricao    = $valor->descricao;
                $dado->vl_unitario  = isset($valor->vl_unitario) && $valor->vl_unitario != "" ? "R\$ ".number_format($valor->vl_unitario, 2, ',', '.') : "R$ 0,00";
                $dado->qtde_diaria  = $valor->qtd_diaria;
                $dado->vl_total     = isset($vl_total) ? "R\$ ".number_format($vl_total, 2, ',', '.') : "R$ 0,00";
                $dado->num_cartao   = isset($valor->num_cartao) && $valor->num_cartao != "" ? $valor->num_cartao : "N&atilde;o Possui";
                $dados[]            = $dado;
            endforeach;

            # Salvar Log
            $log['id_pedido_fk'] = $id_pedido;
            if ($this->session->userdata('id_vt')):
                $log['id_usuario_fk'] = $this->session->userdata('id_vt');
            else:
                if ($this->session->userdata('id_client')):
                    $log['id_cliente_fk'] = $this->session->userdata('id_client');
                endif;
            endif;
            $log['id_tipo_rel_fk'] = 2;
            $log['dt_hr']          = mdate($timestamp, $data);
            $this->db->insert('tb_relatorio_log', $log);

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
     * Método responsável por consultar e exporta uma
     * lista de pedido com inconsistencia
     *
     * @method getInconsistenciaExport
     * @param integer $id_pedido Id do Pedido
     * @access public
     * @return obj Lista de pedidos
     */
    public function getInconsistenciaExport($id_pedido)
    {
        # Vars
        $retorno = new stdClass();
        $dados   = array();
        $log       = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        # Consultar pedidos
        $this->db->select('p.id_pedido_pk, p.id_empresa_fk, e.cnpj, e.nome_razao, dp.matricula, c.num_cartao, f.cpf,
                           f.nome, ib.id_item_beneficio_pk, r.vl_unitario, r.qtd_unitaria AS qtd_diaria, ib.descricao, sc.status');
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_relatorio r', 'p.id_pedido_pk = r.id_pedido_fk', 'inner');
        $this->db->join('tb_status_credito sc', 'r.id_status_credito_fk = sc.id_status_pk', 'inner');
        $this->db->join('tb_item_beneficio ib', 'r.id_item_beneficio_fk = ib.id_item_beneficio_pk', 'inner');
        $this->db->join('tb_funcionario f', 'r.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->join('tb_dados_profissional dp', 'f.id_funcionario_pk = dp.id_funcionario_fk', 'inner');
        $this->db->join('tb_cartao c', 'r.id_beneficio_fk = c.id_beneficio_fk', 'left');
        $this->db->where('p.id_pedido_pk', $id_pedido);
        $rows = $this->db->get()->result();

        if (!empty($rows)):
            foreach ($rows as $valor):
                $vl_total = ($valor->vl_unitario*$valor->qtd_diaria);

                $dado               = new stdClass();
                $dado->id_pedido    = $valor->id_pedido_pk;
                $dado->cnpj         = $valor->cnpj;
                $dado->nome_razao   = $valor->nome_razao;
                $dado->matricula    = $valor->matricula;
                $dado->cpf          = $valor->cpf;
                $dado->nome         = $valor->nome;
                $dado->id_item      = $valor->id_item_beneficio_pk;
                $dado->descricao    = $valor->descricao;
                $dado->vl_unitario  = isset($valor->vl_unitario) && $valor->vl_unitario != "" ? "R\$ ".number_format($valor->vl_unitario, 2, ',', '.') : "R$ 0,00";
                $dado->qtde_diaria  = $valor->qtd_diaria;
                $dado->vl_total     = isset($vl_total) ? "R\$ ".number_format($vl_total, 2, ',', '.') : "R$ 0,00";
                $dado->status_benef = $valor->status;
                $dado->num_cartao   = isset($valor->num_cartao) && $valor->num_cartao != "" ? $valor->num_cartao : "N&atilde;o Possui";
                $dados[]            = $dado;
            endforeach;

            # Salvar Log
            $log['id_pedido_fk'] = $id_pedido;
            if ($this->session->userdata('id_vt')):
                $log['id_usuario_fk'] = $this->session->userdata('id_vt');
            else:
                if ($this->session->userdata('id_client')):
                    $log['id_cliente_fk'] = $this->session->userdata('id_client');
                endif;
            endif;
            $log['id_tipo_rel_fk'] = 3;
            $log['dt_hr']          = mdate($timestamp, $data);
            $this->db->insert('tb_relatorio_log', $log);

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

}

/* End of file relatorio_model.php */
/* Location: ./application/models/relatorio_model.php */