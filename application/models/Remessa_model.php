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
     * Método responsável pelo cadastro da header da Remessa
     *
     * @method setRemessaHeader
     * @param obj $valores Ids dos pedidos
     * @access public
     * @return obj Status de ação
     */
    public function setRemessaHeader($valores)
    {
        # Atribuir vars
        $retorno = new stdClass();
        $dados   = array();
        $head    = array();

        # Remessa        
        $dados['id_usuario_fk'] = $this->session->userdata('id_vt');
        $dados['dt_emissao']    = date("Y-m-d");

        # Grava remessa
        $this->db->insert('tb_remessa', $dados);

        if ($this->db->affected_rows() > 0) {
            # Ultima ID
            $id_remessa = $this->db->insert_id();

            # Remessa        
            $head['id_remessa_fk']   = $id_remessa;
            $head['cod_registro']    = 1;
            $head['cod_remessa']     = $id_remessa;
            $head['trasmissao']      = $id_remessa;
            $head['cod_servico']     = $id_remessa;
            $head['servico']         = $id_remessa;
            $head['cod_transmissao'] = $id_remessa;
            $head['nome_cedente']    = $id_remessa;
            $head['cod_banco']       = $id_remessa;
            $head['nome_banco']      = $id_remessa;
            $head['dt_gravacao']     = $id_remessa;
            $head['col_h11']         = $id_remessa;
            $head['col_h12']         = $id_remessa;
            $head['num_versao_rem']  = $id_remessa;
            $head['num_reg_arq']     = $id_remessa;
            
            # Grava remessa header
            $this->db->insert('tb_remessa_header', $head);
            
            $retorno->status = TRUE;
            $retorno->msg    = "Prosseguir na Gera&ccedil;&atilde;o de Remessa!";
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

        # Consultar prospeccoes
        $this->db->select("b.id_boleto_pk, b.id_pedido_fk, b.sacado_cnpj_cpf, b.sacado_nome, b.valor, b.dt_vencimento, 
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
                
                $boleto                  = new stdClass();
                $boleto->id_pedido_fk    = $value->id_pedido_fk;
                $boleto->sacado_cnpj_cpf = $value->sacado_cnpj_cpf;
                $boleto->sacado_nome     = $value->sacado_nome;
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

/* End of file remessa_model.php */
/* Location: ./application/models/remessa_model.php */