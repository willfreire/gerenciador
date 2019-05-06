<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Recarga_model extends CI_Model {

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
     * Método responsável por pesquisar e buscar status das recargas
     *
     * @method getRecargaStatus
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de status das recargas
     */
    public function getRecargaStatus($search)
    {
        # Atribuir valores
        $this->draw      = $search->draw;
        $this->orderBy   = $search->orderBy;
        $this->orderType = $search->orderType;
        $this->start     = $search->start;
        $this->length    = $search->length;
        $this->filter    = $search->filter;
        $this->columns   = $search->columns;
        $id_pedido       = $search->id_pedido;
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
        $this->db->join('tb_relatorio r', 'p.id_pedido_pk = r.id_pedido_fk', 'inner');
        $this->db->join('tb_status_credito sc', 'r.id_status_credito_fk = sc.id_status_pk', 'inner');
        $this->db->join('tb_funcionario f', 'r.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->join('tb_dados_profissional dp', 'f.id_funcionario_pk = dp.id_funcionario_fk', 'inner');
        $this->db->join('tb_cartao c', 'r.id_beneficio_fk = c.id_beneficio_fk', 'left');
        $this->db->where("p.id_pedido_pk", $id_pedido);
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

        # Consultar
        $this->db->select('p.id_pedido_pk, f.cpf, f.nome, c.num_cartao, p.dt_ini_beneficio, p.dt_fin_beneficio, sc.status');
        $this->db->from('tb_pedido p');
        $this->db->join('tb_empresa e', 'p.id_empresa_fk = e.id_empresa_pk', 'inner');
        $this->db->join('tb_relatorio r', 'p.id_pedido_pk = r.id_pedido_fk', 'inner');
        $this->db->join('tb_status_credito sc', 'r.id_status_credito_fk = sc.id_status_pk', 'inner');
        $this->db->join('tb_funcionario f', 'r.id_funcionario_fk = f.id_funcionario_pk', 'inner');
        $this->db->join('tb_dados_profissional dp', 'f.id_funcionario_pk = dp.id_funcionario_fk', 'inner');
        $this->db->join('tb_cartao c', 'r.id_beneficio_fk = c.id_beneficio_fk', 'left');
        $this->db->where("p.id_pedido_pk", $id_pedido);
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $recargas = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                $beneficio = date("d/m/Y", strtotime($value->dt_ini_beneficio))." a ".date("d/m/Y", strtotime($value->dt_ini_beneficio));
                $recarga             = new stdClass();
                $recarga->cpf        = $value->cpf;
                $recarga->nome       = $value->nome;
                $recarga->num_cartao = $value->num_cartao;
                $recarga->periodo    = $beneficio;
                $recarga->status     = $value->status;
                $recargas[]          = $recarga;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $recargas;

        return $dados;
    }

}

/* End of file remessa_model.php */
/* Location: ./application/models/remessa_model.php */