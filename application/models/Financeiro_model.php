<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Financeiro_model extends CI_Model {

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

        # Consultar
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
                # $ver         = "<button type='button' id='btn_ver_boleto' class='btn btn-success btn-xs btn-acao' title='Visualizar Boleto' onclick='Financeiro.verBoleto(\"$nome_boleto\")'><i class='glyphicon glyphicon-barcode' aria-hidden='true'></i></button>";
                $ver         = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Visualizar Boleto' onclick='Financeiro.verBoleto(\"$value->id_pedido_fk\")'><i class='glyphicon glyphicon-barcode' aria-hidden='true'></i></button>";
                $valor       = isset($value->valor) && $value->valor != "0.00" ? "R\$ ".number_format($value->valor, 2, ',', '.') : "R\$ 0,00";
                $dt_pgto     = isset($value->dt_pgto) ? date('d/m/Y', strtotime($value->dt_pgto)) : "Sem Data";
                
                $boleto                  = new stdClass();
                $boleto->id_pedido_fk    = $value->id_pedido_fk;
                $boleto->sacado_cnpj_cpf = $value->pagador_cnpj_cpf;
                $boleto->sacado_nome     = $value->pagador_nome;
                $boleto->valor           = $valor;
                $boleto->dt_vencimento   = date('d/m/Y', strtotime($value->dt_vencimento));
                $boleto->dt_pgto         = $dt_pgto;
                $boleto->status_boleto   = $value->status_boleto;
                $boleto->ver             = $ver;
                $boletos[]               = $boleto;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $boletos;

        return $dados;
    }

}

/* End of file financeiro_model.php */
/* Location: ./application/models/financeiro_model.php */