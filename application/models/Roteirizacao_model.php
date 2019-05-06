<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Roteirizacao_model extends CI_Model {

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
     * Método responsável por cadastrar / editar um roteirizacao
     *
     * @method setRoteirizacao
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setRoteirizacao($valores)
    {
        # Atribuir vars
        $retorno  = new stdClass();
        $dados    = array();
        $end_func = array();

        $dados['id_status_roteiriza_fk'] = 1;
        $dados['id_endereco_empresa_fk'] = $valores->id_end_empresa;
        $dados['cpf']                    = $valores->cpf;
        $dados['nome']                   = $valores->nome_func;
        $dados['cep']                    = $valores->cep;
        $dados['logradouro']             = $valores->endereco;
        $dados['numero']                 = $valores->numero;
        $dados['complemento']            = $valores->complemento;
        $dados['bairro']                 = $valores->bairro;
        $dados['id_estado_fk']           = $valores->id_estado;
        $dados['id_cidade_fk']           = $valores->id_cidade;
        $dados['vl_solicitado']          = str_replace(',', '.', str_replace('.', '', $valores->vl_solic));
        $dados['id_cliente_fk']          = $this->session->userdata('id_client');
        $dados['dt_hr']                  = date("Y-m-d H:i");

        if (isset($valores->id) && $valores->id != ""):
            # Atualiza roteirizacao
            $this->db->where('id_roteirizacao_pk', $valores->id);
            $this->db->update('tb_roteirizacao', $dados);

            if ($this->db->affected_rows() >= 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }
        else:
            # Grava roteirizacao
            $this->db->insert('tb_roteirizacao', $dados);

            if ($this->db->affected_rows() > 0) {
                $retorno->status = TRUE;
                $retorno->msg    = "<strong>SUA ROTEIRIZA&Ccedil;&Atilde;O ENCONTRA-SE NA FILA DE ESPERA, EM BREVE VOC&Ecirc;
                                    PODER&Aacute; CONSULTAR SEU RESULTADO EM \"CONSULTAR NO MENU ROTEIRIZA&Ccedil;&Atilde;O\"
                                    <br><br><span class='text-danger'>Obs: O prazo para resposta desta Roteiriza&ccedil;&atilde;o
                                    ser&aacute; de at&eacute; 24 horas</span></strong>";

                # Endereco Funcionario
                if ($valores->id_funcionario != ""):
                    $end_func['id_funcionario_fk'] = $valores->id_funcionario;
                    $end_func['cep']               = $valores->cep;
                    $end_func['logradouro']        = $valores->endereco;
                    $end_func['numero']            = $valores->numero;
                    $end_func['complemento']       = $valores->complemento;
                    $end_func['bairro']            = $valores->bairro;
                    $end_func['id_cidade_fk']      = $valores->id_cidade;
                    $end_func['id_estado_fk']      = $valores->id_estado;
                    # Grava Endereco
                    $this->db->insert('tb_endereco_funcionario', $end_func);
                endif;
            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao Processar! Tente novamente...";
            }
        endif;

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por pesquisar e consulta roteirizacoes
     *
     * @method getConsultaRoteiriza
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de roteirizacoes por cliente
     */
    public function getConsultaRoteiriza($search)
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
        $this->db->select('COUNT(r.id_roteirizacao_pk) AS total');
        $this->db->from('tb_roteirizacao r');
        $this->db->join('tb_status_roteiriza s', 's.id_status_roteiriza_pk = r.id_status_roteiriza_fk');
        $this->db->where('r.id_cliente_fk', $this->session->userdata('id_client'));
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

        # Consultar roteirizacoes
        $this->db->select("r.id_roteirizacao_pk, r.cpf, DATE_FORMAT(dt_hr, '%d/%m/%Y') AS dt_hr, s.status_roteiriza, r.arquivo", FALSE);
        $this->db->from('tb_roteirizacao r');
        $this->db->join('tb_status_roteiriza s', 's.id_status_roteiriza_pk = r.id_status_roteiriza_fk');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->where('r.id_cliente_fk', $this->session->userdata('id_client'));
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $roteirizas = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                if ($value->arquivo != ""):
                    $url  = base_url('./assets/roteirizacao/'.$value->arquivo);
                    $acao = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Visualizar Resultado' onclick='Roteirizacao.redirect(\"$url\")'>Visualizar Resultado</button>";
                else:
                    $acao = "<button type='button' class='btn btn-danger btn-xs btn-acao' title='N&atilde;o Processada' disabled>N&atilde;o Processada</button>";
                endif;

                $roteiriza                     = new stdClass();
                $roteiriza->id_roteirizacao_pk = $value->id_roteirizacao_pk;
                $roteiriza->cpf                = $value->cpf;
                $roteiriza->dt_hr              = $value->dt_hr;
                $roteiriza->status_roteiriza   = $value->status_roteiriza;
                $roteiriza->acao               = $acao;
                $roteirizas[]                  = $roteiriza;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $roteirizas;

        return $dados;
    }

    /**
     * Método responsável por pesquisar as roteirizacoes solicitadas
     *
     * @method getSolicitadaRoteiriza
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de roteirizacoes solicitadas
     */
    public function getSolicitadaRoteiriza($search)
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
        $this->db->select('COUNT(r.id_roteirizacao_pk) AS total');
        $this->db->from('tb_roteirizacao r');
        $this->db->join('tb_status_roteiriza s', 's.id_status_roteiriza_pk = r.id_status_roteiriza_fk');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->where('r.id_status_roteiriza_fk != ', 3);
        $query            = $this->db->get();
        $respRecordsTotal = $query->result();
        if (!empty($respRecordsTotal)):
            $this->recordsTotal = $respRecordsTotal[0]->total;
        else:
            $this->recordsTotal = 0;
        endif;

        # Consultar roteirizacoes
        $this->db->select("r.id_roteirizacao_pk, e.cnpj, e.nome_razao, r.id_status_roteiriza_fk, DATE_FORMAT(dt_hr, '%d/%m/%Y') AS dt_hr,
                           DATE_FORMAT(dt_hr_usuario, '%d/%m/%Y') AS dt_hr_usuario, s.status_roteiriza, r.arquivo", FALSE);
        $this->db->from('tb_roteirizacao r');
        $this->db->join('tb_empresa e', 'e.id_empresa_pk = r.id_cliente_fk');
        $this->db->join('tb_status_roteiriza s', 's.id_status_roteiriza_pk = r.id_status_roteiriza_fk');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->where('r.id_status_roteiriza_fk != ', 3);
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $roteirizas = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_roteiriza = $value->id_roteirizacao_pk;
                $id_status    = $value->id_status_roteiriza_fk;
                $url_view     = base_url('./roteirizacao/ver/'.$id_roteiriza);
                $acao         = "<button type='button' class='btn btn-warning btn-xs btn-acao' title='Editar Status' onclick='Roteirizacao.modalStatus(\"$id_roteiriza\", \"$id_status\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao        .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Solicita&ccedil;&atilde;o' onclick='Roteirizacao.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";

                $roteiriza                     = new stdClass();
                $roteiriza->id_roteirizacao_pk = $id_roteiriza;
                $roteiriza->cnpj               = $value->cnpj;
                $roteiriza->nome_razao         = $value->nome_razao;
                $roteiriza->dt_hr              = $value->dt_hr;
                $roteiriza->dt_hr_usuario      = $value->dt_hr_usuario;
                $roteiriza->status_roteiriza   = $value->status_roteiriza;
                $roteiriza->acao               = $acao;
                $roteirizas[]                  = $roteiriza;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $roteirizas;

        return $dados;
    }

    /**
     * Método para alteracao de status da Roteirizacao
     *
     * @method setStatus
     * @access public
     * @param obj $valores Dados para edicao
     * @return obj Status da ação
     */
    public function setStatus($valores)
    {
        # Atribuir vars
        $retorno  = new stdClass();
        $dados    = array();

        $dados['id_status_roteiriza_fk'] = $valores->id_status;
        $dados['id_usuario_fk']          = $this->session->userdata('id_vt');
        if ($valores->anexo != ""):
            $dados['arquivo'] = $valores->anexo;
        endif;
        $dados['dt_hr_usuario'] = date("Y-m-d H:i");

        # Atualiza status da roteirizacao
        $this->db->where('id_roteirizacao_pk', $valores->id_roteiriza);
        $this->db->update('tb_roteirizacao', $dados);

        if ($this->db->affected_rows() >= 0) {
            $retorno->status = TRUE;
            $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
        } else {
            $retorno->status = FALSE;
            $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
        }

        return $retorno;
    }

    /**
     * Método responsável por pesquisar historicos de roteirizacoes
     *
     * @method getHistoricoRoteiriza
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de roteirizacoes
     */
    public function getHistoricoRoteiriza($search)
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
        $this->db->select('COUNT(r.id_roteirizacao_pk) AS total');
        $this->db->from('tb_roteirizacao r');
        $this->db->join('tb_status_roteiriza s', 's.id_status_roteiriza_pk = r.id_status_roteiriza_fk');
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

        # Consultar roteirizacoes
        $this->db->select("r.id_roteirizacao_pk, e.cnpj, e.nome_razao, r.id_status_roteiriza_fk, DATE_FORMAT(dt_hr, '%d/%m/%Y') AS dt_hr,
                           DATE_FORMAT(dt_hr_usuario, '%d/%m/%Y') AS dt_hr_usuario, s.status_roteiriza, r.arquivo", FALSE);
        $this->db->from('tb_roteirizacao r');
        $this->db->join('tb_empresa e', 'e.id_empresa_pk = r.id_cliente_fk');
        $this->db->join('tb_status_roteiriza s', 's.id_status_roteiriza_pk = r.id_status_roteiriza_fk');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where($where);
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $roteirizas = array();
        if (!empty($resp_dados)):

            foreach ($resp_dados as $value):
                # Botao
                $id_roteiriza = $value->id_roteirizacao_pk;
                $url_view     = base_url('./roteirizacao/ver/'.$id_roteiriza);
                $acao         = "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Solicita&ccedil;&atilde;o' onclick='Roteirizacao.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                if ($value->arquivo != ""):
                    $url   = base_url('./assets/roteirizacao/'.$value->arquivo);
                    $acao .= "<button type='button' class='btn btn-success btn-xs btn-acao' title='Visualizar Anexo' onclick='Roteirizacao.openWindow(\"$url\", \"_blank\")'><i class='glyphicon glyphicon-save-file' aria-hidden='true'></i></button>";
                else:
                    $acao .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Sem Anexo' disabled><i class='glyphicon glyphicon-ban-circle' aria-hidden='true'></i></button>";
                endif;

                $roteiriza                     = new stdClass();
                $roteiriza->id_roteirizacao_pk = $id_roteiriza;
                $roteiriza->cnpj               = $value->cnpj;
                $roteiriza->nome_razao         = $value->nome_razao;
                $roteiriza->dt_hr              = $value->dt_hr;
                $roteiriza->dt_hr_usuario      = $value->dt_hr_usuario;
                $roteiriza->status_roteiriza   = $value->status_roteiriza;
                $roteiriza->acao               = $acao;
                $roteirizas[]                  = $roteiriza;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $roteirizas;

        return $dados;
    }

}

/* End of file roteirizacao_model.php */
/* Location: ./application/models/roteirizacao_model.php */