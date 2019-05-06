<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorio_model extends CI_Model {

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

    /**
     * Método responsável por consultar e exporta uma lista dos Descontos de VT
     *
     * @method getDescontosVtExport
     * @param integer $id_pedido Id do Pedido
     * @access public
     * @return obj Lista de pedidos
     */
    public function getDescontosVtExport($id_pedido)
    {
        # Vars
        $retorno   = new stdClass();
        $dados     = array();
        $log       = array();
        $timestamp = "%Y-%m-%d %H:%i:%s";
        $data      = time();

        # Consultar pedidos
        $this->db->select('ip.id_item_pedido_pk, ip.id_beneficio_fk, ip.vl_unitario, ip.qtd_unitaria,
                           ip.id_pedido_fk, b.id_funcionario_fk, f.nome, f.salario, dp.matricula');
        $this->db->from('tb_item_pedido ip');
        $this->db->join('tb_beneficio b', 'b.id_beneficio_pk = ip.id_beneficio_fk', 'inner');
        $this->db->join('tb_funcionario f', 'f.id_funcionario_pk = b.id_funcionario_fk', 'inner');
        $this->db->join('tb_dados_profissional dp', 'dp.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->where(array(
            'ip.id_pedido_fk' => $id_pedido,
            'b.id_grupo_fk' => 1,
            'ip.id_status_fk' => 1
        ));
        $this->db->order_by('b.id_funcionario_fk', 'ASC');
        $rows = $this->db->get()->result();

        $funcs = array();
        if (!empty($rows)):
            foreach ($rows as $valor):
                $func                    = new stdClass();
                $func->id_beneficio_fk   = $valor->id_beneficio_fk;
                $func->vl_unitario       = $valor->vl_unitario;
                $func->qtd_unitaria      = $valor->qtd_unitaria;
                $func->id_pedido_fk      = $valor->id_pedido_fk;
                $func->id_funcionario_fk = $valor->id_funcionario_fk;
                $func->nome              = $valor->nome;
                $func->matricula         = $valor->matricula;
                $funcs[$valor->id_funcionario_fk][] = $func;


                /* $vl_total = ($valor->vl_unitario*$valor->qtd_diaria);

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
                $dados[]            = $dado; */
            endforeach;

            # Montar dados
            if (!empty($funcs)):
                foreach ($funcs as $key => $vl):
                    $this->db->select('f.nome, f.salario, dp.matricula');
                    $this->db->from('tb_funcionario f');
                    $this->db->join('tb_dados_profissional dp', 'dp.id_funcionario_fk = f.id_funcionario_pk', 'inner');
                    $this->db->where('f.id_funcionario_pk', $key);
                    $funcio = $this->db->get()->result();

                    $dado            = new stdClass();
                    $dado->nome      = $funcio[0]->nome;
                    $dado->matricula = $funcio[0]->matricula;
                    $dado->salario   = "R\$ ".number_format($funcio[0]->salario, 2, ',', '.');

                    $vl_vale = 0;
                    foreach ($vl as $value):
                        $vl_vale += $value->vl_unitario * $value->qtd_unitaria;
                    endforeach;
                    $dado->vl_transporte = "R\$ ".number_format($vl_vale, 2, ',', '.');

                    # Calcular Desconto 6%
                    $desconto          = ($funcio[0]->salario*6/100);
                    $vl_desconto       = $vl_vale > $desconto ? $desconto : $vl_vale;
                    $dado->vl_desconto = "R\$ ".number_format($vl_desconto, 2, ',', '.');
                    $dados[]           = $dado;
                endforeach;
            endif;

            # Salvar Log
            /* $log['id_pedido_fk'] = $id_pedido;
            if ($this->session->userdata('id_vt')):
                $log['id_usuario_fk'] = $this->session->userdata('id_vt');
            else:
                if ($this->session->userdata('id_client')):
                    $log['id_cliente_fk'] = $this->session->userdata('id_client');
                endif;
            endif;
            $log['id_tipo_rel_fk'] = 4;
            $log['dt_hr']          = mdate($timestamp, $data);
            $this->db->insert('tb_relatorio_log', $log); */

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