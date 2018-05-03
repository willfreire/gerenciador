<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Funcionario_model extends CI_Model {

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
     * Método responsável por cadastrar / editar um funcionario
     *
     * @method setFuncionario
     * @param obj $valores Dados para cadastro / edicao
     * @access public
     * @return obj Status de ação
     */
    public function setFuncionario($valores)
    {
        # Atribuir vars
        $retorno     = new stdClass();
        $funcionario = array();
        # $end_func    = array();
        $dados_pro   = array();

        $funcionario['id_empresa_fk']          = $this->session->userdata('id_client');
        $funcionario['cpf']                    = $valores->cpf;
        $funcionario['nome']                   = $valores->nome_func;
        $funcionario['dt_nasc']                = is_array($valores->dt_nasc) ? $valores->dt_nasc[2].'-'.$valores->dt_nasc[1].'-'.$valores->dt_nasc[0] : NULL;
        $funcionario['sexo']                   = $valores->sexo;
        $funcionario['id_estado_civil_fk']     = $valores->estado_civil;
        $funcionario['rg']                     = $valores->rg;
        $funcionario['dt_expedicao']           = is_array($valores->dt_exped) ? $valores->dt_exped[2].'-'.$valores->dt_exped[1].'-'.$valores->dt_exped[0] : NULL;
        $funcionario['orgao_expedidor']        = $valores->orgao_exped;
        $funcionario['id_estado_expedidor_fk'] = $valores->uf_exped;
        $funcionario['nome_pai']               = $valores->nome_pai;
        $funcionario['nome_mae']               = $valores->nome_mae;
        $funcionario['id_status_fk']           = $valores->status;

        if (isset($valores->id) && $valores->id != ""):

            # Atualiza tb_funcionario
            $this->db->where('id_funcionario_pk', $valores->id);
            $this->db->update('tb_funcionario', $funcionario);

            if ($this->db->affected_rows() >= 0) {

                # Id Funcionario
                $id_func = $valores->id;

                try {
                    # Endereco Funcionario
                    /* $end_func['cep']          = $valores->cep;
                    $end_func['logradouro']   = $valores->endereco;
                    $end_func['numero']       = $valores->numero;
                    $end_func['complemento']  = $valores->complemento;
                    $end_func['bairro']       = $valores->bairro;
                    $end_func['id_cidade_fk'] = $valores->cidade;
                    $end_func['id_estado_fk'] = $valores->estado;
                    # Atualiza Endereco
                    $this->db->where('id_funcionario_fk', $id_func);
                    $this->db->update('tb_endereco_funcionario', $end_func); */

                    # Dados Profissionais
                    $dados_pro['matricula']              = $valores->matricula;
                    $dados_pro['id_cargo_fk']            = $valores->cargo;
                    $dados_pro['id_departamento_fk']     = $valores->depto;
                    $dados_pro['id_periodo_pk']          = $valores->periodo;
                    $dados_pro['email']                  = $valores->email;
                    $dados_pro['id_endereco_empresa_fk'] = $valores->ender_empresa;

                    # Update Dados Profissionais
                    $this->db->where('id_funcionario_fk', $id_func);
                    $this->db->update('tb_dados_profissional', $dados_pro);

                    $retorno->status = TRUE;
                    $retorno->msg    = "Edi&ccedil;&atilde;o realizada com Sucesso!";
                } catch(Exception $e) {
                    # logging_function($e->getMessage());
                    $retorno->status = FALSE;
                    $retorno->msg    = "Houve um erro ao editar!";
                }

            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao editar! Tente novamente...";
            }

        else:

            # Grava Empresa
            $this->db->insert('tb_funcionario', $funcionario);

            if ($this->db->affected_rows() > 0) {

                # Id Funcionario
                $id_func = $this->db->insert_id();

                try {
                    # Endereco Empresa
                    /* $end_func['id_funcionario_fk'] = $id_func;
                    $end_func['cep']               = $valores->cep;
                    $end_func['logradouro']        = $valores->endereco;
                    $end_func['numero']            = $valores->numero;
                    $end_func['complemento']       = $valores->complemento;
                    $end_func['bairro']            = $valores->bairro;
                    $end_func['id_cidade_fk']      = $valores->cidade;
                    $end_func['id_estado_fk']      = $valores->estado;
                    # Grava Endereco
                    $this->db->insert('tb_endereco_funcionario', $end_func); */

                    # Dados Profissionais
                    $dados_pro['id_funcionario_fk']      = $id_func;
                    $dados_pro['matricula']              = $valores->matricula;
                    $dados_pro['id_cargo_fk']            = $valores->cargo;
                    $dados_pro['id_departamento_fk']     = $valores->depto;
                    $dados_pro['id_periodo_pk']          = $valores->periodo;
                    $dados_pro['email']                  = $valores->email;
                    $dados_pro['id_endereco_empresa_fk'] = $valores->ender_empresa;
                    # Grava Dados Profissionais
                    $this->db->insert('tb_dados_profissional', $dados_pro);

                    # Beneficio / Cartao do TMP
                    $this->db->select('id_beneficio_tmp_pk, num_tmp, id_grupo_fk, id_item_beneficio_fk, vl_unitario, qtd_diaria, cartao, num_cartao, id_status_cartao_fk');
                    $this->db->from('tb_beneficio_tmp');
                    $this->db->where('num_tmp', $id_func);
                    $row_benef = $this->db->get()->result();

                    if (!empty($row_benef)):
                        foreach ($row_benef as $vl):
                            $benef = array();
                            $card  = array();

                            # Beneficio
                            $benef['id_funcionario_fk']    = $id_func;
                            $benef['id_grupo_fk']          = $vl->id_grupo_fk;
                            $benef['id_item_beneficio_fk'] = $vl->id_item_beneficio_fk;
                            $benef['vl_unitario']          = $vl->vl_unitario;
                            $benef['qtd_diaria']           = $vl->qtd_diaria;
                            # Grava Beneficio
                            $this->db->insert('tb_beneficio', $benef);

                            if ($vl->cartao === "1"):
                                # Cartao
                                $id_benef                    = $this->db->insert_id();
                                $card['id_funcionario_fk']   = $id_func;
                                $card['id_beneficio_fk']     = $id_benef;
                                $card['num_cartao']          = $vl->num_cartao;
                                $card['id_status_cartao_fk'] = $vl->id_status_cartao_fk;
                                # Grava Cartao
                                $this->db->insert('tb_cartao', $card);
                            endif;
                        endforeach;
                        # Excluir Beneficio tabela TMP
                        $this->db->where('num_tmp', $id_func);
                        $this->db->delete('tb_beneficio_tmp');
                    endif;

                    $retorno->status = TRUE;
                    $retorno->msg    = "Cadastro realizado com Sucesso!";
                } catch(Exception $e) {
                    # logging_function($e->getMessage());
                    $retorno->status = FALSE;
                    $retorno->msg    = "Houve um erro ao cadastrar!";
                }

            } else {
                $retorno->status = FALSE;
                $retorno->msg    = "Houve um erro ao cadastrar! Tente novamente...";
            }

        endif;

        # retornar
        return $retorno;
    }

    /**
     * Método responsável por pesquisar e buscar funcionarios
     *
     * @method getFuncionarios
     * @param obj $search Conjuntos de dados para realizar a pesquisa
     * @access public
     * @return obj Lista de funcionarios
     */
    public function getFuncionarios($search)
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
        $this->db->select('COUNT(id_funcionario_pk) AS total');
        $this->db->from('vw_funcionario');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where("(".$where.")");
            $this->db->where("id_empresa_fk = '{$this->session->userdata('id_client')}'");
        else:
            $this->db->where("id_empresa_fk = '{$this->session->userdata('id_client')}'");
        endif;
        $query            = $this->db->get();
        $respRecordsTotal = $query->result();
        if (!empty($respRecordsTotal)):
            $this->recordsTotal = $respRecordsTotal[0]->total;
        else:
            $this->recordsTotal = 0;
        endif;

        # Consultar funcionarios
        $this->db->select('id_funcionario_pk, cpf, nome, rg, matricula, id_periodo_pk, status');
        $this->db->from('vw_funcionario');
        if (!empty($filter)):
            $where = implode(" OR ", $filter);
            $this->db->where("(".$where.")");
            $this->db->where("id_empresa_fk = '{$this->session->userdata('id_client')}'");
        else:
            $this->db->where("id_empresa_fk = '{$this->session->userdata('id_client')}'");
        endif;
        $this->db->order_by($this->orderBy, $this->orderType);
        $this->db->limit($this->length, $this->start);
        $query_dados = $this->db->get();
        $resp_dados  = $query_dados->result();

        # Criar classe predefinida
        $funcionarios = array();
        if (!empty($resp_dados)):

            # Consultar Periodo
            $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
            $this->db->order_by('periodo');
            $periodo = $this->db->get('tb_periodo')->result();

            foreach ($resp_dados as $value):
                # Botao
                $id_func = $value->id_funcionario_pk;
                $url_edit  = base_url('./funcionario/editar/'.$id_func);
                $url_view  = base_url('./funcionario/ver/'.$id_func);
                $acao      = "<button type='button' class='btn btn-success btn-xs btn-acao' title='Editar Funcion&aacute;rio' onclick='Funcionario.redirect(\"$url_edit\")'><i class='glyphicon glyphicon-edit' aria-hidden='true'></i></button>";
                $acao     .= "<button type='button' class='btn btn-primary btn-xs btn-acao' title='Visualizar Funcion&aacute;rio' onclick='Funcionario.redirect(\"$url_view\")'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i></button>";
                $acao     .= "<button type='button' class='btn btn-danger btn-xs btn-acao' title='Excluir Funcion&aacute;rio' onclick='Funcionario.del(\"$id_func\")'><i class='glyphicon glyphicon-remove' aria-hidden='true'></i></button>";

                # Montar Periodo
                $opt = "<select class='form-control' name='periodo_func' id='periodo_func' onchange='Funcionario.mudaPeriodo(\"$id_func\", this)'>";
                if (!empty($periodo)):
                    $opt .= "<option value=''>Selecione</option>";
                    foreach ($periodo as $period):
                        $sel = ($period->id_periodo_pk == $value->id_periodo_pk) ? 'selected="selected"' : '';
                        $opt .= "<option value='{$period->id_periodo_pk}' {$sel}>{$period->periodo} - {$period->qtd_dia}</option>";
                    endforeach;
                else:
                    $opt .= "<option value=''>Sem Per&iacute;odo</option>";
                endif;
                $opt .= "</select>";

                # Check Ativar / Inativar
                $st_func = isset($value->status) && $value->status === "Ativo" ? "checked" : "";
                $check = '<div class="checkbox">
                            <label>
                                <input type="checkbox" name="at_in[]" id="at_in_'.$id_func.'" value="'.$id_func.'" onclick="Funcionario.statusFunc(\''.$id_func.'\');" '.$st_func.'>
                            </label>
                          </div>';

                $funcionario            = new stdClass();
                $funcionario->at_in     = $check;
                $funcionario->cpf       = $value->cpf;
                $funcionario->nome      = $value->nome;
                $funcionario->rg        = $value->rg;
                $funcionario->matricula = $value->matricula;
                $funcionario->periodo   = $opt;
                $funcionario->status    = $value->status;
                $funcionario->acao      = $acao;
                $funcionarios[]         = $funcionario;
            endforeach;

        endif;

        $dados['draw']            = intval($this->draw);
        $dados['recordsTotal']    = $this->recordsTotal;
        $dados['recordsFiltered'] = $this->recordsTotal;
        $dados['data']            = $funcionarios;

        return $dados;
    }

    /**
     * Método de exclusão de um Funcionario
     *
     * @method delFuncionario
     * @access public
     * @param integer $id Id do registro a ser excluído
     * @return obj Status da ação
     */
    public function delFuncionario($id)
    {
        # Atribuir vars
        $retorno = new stdClass();

        # SQL
        $this->db->where('id_funcionario_pk', $id);
        $this->db->delete('tb_funcionario');

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
}

/* End of file funcionario_model.php */
/* Location: ./application/models/funcionario_model.php */