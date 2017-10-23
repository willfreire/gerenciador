<?php

defined('BASEPATH') OR exit('No direct script access allowed');

# Class ForceUTF8
use ForceUTF8\Encoding;

class Importacao extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        # Sessao
        if (!$this->session->userdata('user_client')) {
            redirect(base_url('./'));
        }

        # Carregar modelo
        $this->load->model('Importacao_model');

    }

    /**
     * Método para realizar importacao geral
     *
     * @method index
     * @access public
     * @return void
     */
    public function index()
    {
        # Titulo da pagina
        $header['titulo'] = "Importa&ccedil;&atilde;o Geral";

        $this->load->view('header', $header);
        $this->load->view('importacao/importacao_geral');
        $this->load->view('footer');
    }

    /**
     * Método para realizar importacao geral
     *
     * @method geral
     * @access public
     * @return void
     */
    public function geral()
    {
        # Titulo da pagina
        $header['titulo'] = "Importa&ccedil;&atilde;o Geral";

        $this->load->view('header', $header);
        $this->load->view('importacao/importacao_geral');
        $this->load->view('footer');
    }

    /**
     * Método lista importações realizadas
     *
     * @method historico
     * @access public
     * @return void
     */
    public function historico()
    {
        # Titulo da pagina
        $header['titulo'] = "Hist&oacute;rico de Importa&ccedil;&atilde;o";

        $this->db->where('id_empresa_fk', $this->session->userdata('id_client'));
        $this->db->order_by('dt_hr_importacao', 'DESC');
        $data['arqs'] = $this->db->get('tb_importacao')->result();

        $this->load->view('header', $header);
        $this->load->view('importacao/importacao_historico', $data);
        $this->load->view('footer');
    }

    /**
     * Método de subir e importar dados
     *
     * @method upload
     * @access public
     * @return obj Status da ação
     */
    public function upload()
    {

        # Vars
        $path_proj   = PATH_PROJ;
        $import      = array();
        $dados       = array();
        $dados_end   = array();
        $dados_func  = array();
        $dados_prof  = array();
        $dados_ben   = array();
        $dados_state = array();
        $dados_city  = array();
        $dados_dpto  = array();

        # Verificar se há envio de arquivos
        if (isset($_FILES)) {

            # Obj
            $ret = new stdClass();

            # Diretorio
            if (isset($_FILES['arq_import'])) {
                $output_dir = $path_proj."/assets/uploads/importacao/";
            }

            # Msg Error
            if (isset($_FILES['arq_import']["error"])) {
                $error = $_FILES["arq_import"]["error"];
            }

            # File Temp
            if (isset($_FILES['arq_import']["tmp_name"])) {
                $file_tmp = $_FILES["arq_import"]["tmp_name"];
            }

            # File name
            if (isset($_FILES['arq_import']["name"])) {
                $file_name = $_FILES["arq_import"]["name"];
            }

            # Verificar Sistema Operacional
            $so = filter_input(INPUT_SERVER, 'SERVER_SIGNATURE');

            if (!is_array($file_name)) {

                if (strpos($so, "Win")):
                    $fileName = time()."_".iconv("UTF-8", "CP1252", $file_name);
                else:
                    $fileName = time()."_".$file_name;
                endif;

                if (move_uploaded_file($file_tmp, $output_dir.$fileName)) {
                    # Salvar Log
                    $import_log                     = array();
                    $import_log['id_empresa_fk']    = $this->session->userdata('id_client');
                    $import_log['arquivo']          = $fileName;
                    $import_log['dt_hr_importacao'] = date("Y-m-d H:i");
                    $this->db->insert('tb_importacao', $import_log);

                    # Iniciar a Importacao
                    $handle = fopen($output_dir.$fileName,'r');
                    while ($csv_lines = fgetcsv($handle, 1024, ';')):
                        $import[] = $csv_lines;
                    endwhile;
                    fclose($handle);

                    $rows = count($import);
                    $cols = count($import[0]);
                    $j    = 0;
                    for ($i=1; $i<$rows; $i++):
                        $dados[$j]['cnpj']                 = trim($import[$i][0]);
                        $dados[$j]['id_tipo_endereco_fk']  = Encoding::toUTF8($import[$i][1]);
                        $dados[$j]['cep']                  = trim($import[$i][2]);
                        $dados[$j]['logradouro']           = Encoding::toUTF8($import[$i][3]);
                        $dados[$j]['numero']               = trim($import[$i][4]);
                        $dados[$j]['complemento']          = Encoding::toUTF8($import[$i][5]);
                        $dados[$j]['bairro']               = Encoding::toUTF8($import[$i][6]);
                        $dados[$j]['id_cidade_fk']         = Encoding::toUTF8($import[$i][7]);
                        $dados[$j]['id_estado_fk']         = Encoding::toUTF8($import[$i][8]);
                        $dados[$j]['resp_recebimento']     = Encoding::toUTF8($import[$i][9]);
                        $dados[$j]['matricula']            = Encoding::toUTF8($import[$i][10]);
                        $dados[$j]['nome']                 = Encoding::toUTF8($import[$i][11]);
                        $dados[$j]['sexo']                 = Encoding::toUTF8($import[$i][12]);
                        $dados[$j]['cpf']                  = trim($import[$i][13]);
                        $dados[$j]['rg']                   = trim($import[$i][14]);
                        $dados[$j]['dt_nasc']              = trim($import[$i][15]);
                        $dados[$j]['nome_mae']             = Encoding::toUTF8($import[$i][16]);
                        $dados[$j]['id_departamento_fk']   = Encoding::toUTF8($import[$i][17]);
                        $dados[$j]['id_grupo_fk']          = Encoding::toUTF8($import[$i][18]);
                        $dados[$j]['id_item_beneficio_fk'] = Encoding::toUTF8($import[$i][19]);
                        $dados[$j]['vl_unitario']          = trim(str_replace("R$", null, $import[$i][20]));
                        $dados[$j]['qtd_diaria']           = trim($import[$i][21]);
                        $j++;
                    endfor;

                    foreach ($dados as $value):
                        # Vars Endereco
                        $cnpj             = $value['cnpj'];
                        $id_tipo_endereco = isset($value['id_tipo_endereco_fk']) && $value['id_tipo_endereco_fk'] == "Faturamento" ? 2 : 1;
                        $cep              = isset($value['cep']) && $value['cep'] != "" ?  $value['cep'] : "00000-000";
                        $logradouro       = isset($value['logradouro']) && $value['logradouro'] != "" ?  $value['logradouro'] : "N&atilde;o Informado";
                        $numero           = isset($value['numero']) && $value['numero'] != "" ?  $value['numero'] : "0";
                        $complemento      = isset($value['complemento']) && $value['complemento'] != "" ?  $value['complemento'] : NULL;
                        $bairro           = isset($value['bairro']) && $value['bairro'] != "" ?  $value['bairro'] : "N&atilde;o Informado";
                        $id_estado        = 26;
                        if (isset($value['id_estado_fk']) && $value['id_estado_fk'] != "") {
                            # Verifcar se Estado existe
                            $this->db->select('id_estado_pk');
                            $this->db->from('tb_estado');
                            $this->db->where("estado = '{$value['id_estado_fk']}' OR sigla = '{$value['id_estado_fk']}'");
                            $row_state = $this->db->get()->result();

                            if (!empty($row_state)) {
                                $id_estado = $row_state[0]->id_estado_pk;
                            } else {
                                # Grava Nova Cidade
                                $dados_state['id_pais_fk'] = 1;
                                $dados_state['estado']     = $this->db->escape_str($value['id_estado_fk']);
                                $dados_state['sigla']      = "NI";
                                $this->db->insert('tb_estado', $dados_state);
                                $id_estado = $this->db->insert_id();
                            }
                        }
                        $id_cidade        = 5346;
                        if (isset($value['id_cidade_fk']) && $value['id_cidade_fk'] != "") {
                            # Verifcar se Cidade existe
                            $this->db->select('id_cidade_pk');
                            $this->db->from('tb_cidade');
                            $this->db->where(array('cidade' => $value['id_cidade_fk'], 'id_estado_fk' => $id_estado));
                            $row_city = $this->db->get()->result();

                            if (!empty($row_city)) {
                                $id_cidade = $row_city[0]->id_cidade_pk;
                            } else {
                                # Grava Nova Cidade
                                $dados_city['id_estado_fk'] = $id_estado;
                                $dados_city['cidade']       = $this->db->escape_str($value['id_cidade_fk']);
                                $this->db->insert('tb_cidade', $dados_city);
                                $id_cidade = $this->db->insert_id();
                            }
                        }
                        $resp_recebimento   = isset($value['resp_recebimento']) && $value['resp_recebimento'] != "" ?  $value['resp_recebimento'] : "N&atilde;o Informado";

                        # Verificar se Empresa existe
                        $this->db->select('id_empresa_pk');
                        $this->db->from('tb_empresa');
                        $this->db->where('cnpj', $cnpj);
                        $row_emp = $this->db->get()->result();

                        if (!empty($row_emp)) {
                            $id_empresa = $row_emp[0]->id_empresa_pk;

                            # Atualizar / cadastrar endereço da empresa
                            $this->db->select('id_endereco_empresa_pk');
                            $this->db->from('tb_endereco_empresa');
                            $this->db->where(array('id_empresa_fk' => $id_empresa, 'id_tipo_endereco_fk' => $id_tipo_endereco));
                            $row_endereco = $this->db->get()->result();

                            # Dados do endereco
                            $dados_end['id_empresa_fk']       = $this->db->escape_str($id_empresa);
                            $dados_end['id_tipo_endereco_fk'] = $this->db->escape_str($id_tipo_endereco);
                            $dados_end['cep']                 = $this->db->escape_str($cep);
                            $dados_end['logradouro']          = $this->db->escape_str($logradouro);
                            $dados_end['numero']              = $this->db->escape_str($numero);
                            $dados_end['complemento']         = $this->db->escape_str($complemento);
                            $dados_end['bairro']              = $this->db->escape_str($bairro);
                            $dados_end['id_cidade_fk']        = $this->db->escape_str($id_cidade);
                            $dados_end['id_estado_fk']        = $this->db->escape_str($id_estado);
                            $dados_end['resp_recebimento']    = $this->db->escape_str($resp_recebimento);

                            if (!empty($row_endereco)) {
                                # Atualiza Endereco
                                $this->db->where('id_endereco_empresa_pk', $row_endereco[0]->id_endereco_empresa_pk);
                                $this->db->update('tb_endereco_empresa', $dados_end);
                                $id_endereco_empresa = $row_endereco[0]->id_endereco_empresa_pk;
                            } else {
                                # Grava Endereco
                                $this->db->insert('tb_endereco_empresa', $dados_end);
                                $id_endereco_empresa = $this->db->insert_id();
                            }

                            # Vars Funcionario
                            $nome     = isset($value['nome']) && $value['nome'] != "" ? $value['nome'] : "N&atilde;o Informado";
                            $sexo     = isset($value['sexo']) && $value['sexo'] == "Feminino" ? 'f' : "m";
                            $cpf      = isset($value['cpf']) && $value['cpf'] != "" ? $value['cpf'] : "000.000.000-00";
                            $rg       = isset($value['rg']) && $value['rg'] != "" ? $value['rg'] : "00.000.000-0";
                            $dt_nasc  = isset($value['dt_nasc']) && $value['dt_nasc'] != "" ? explode("/", $value['dt_nasc']) : "2000-01-01";
                            $nome_mae = isset($value['nome_mae']) && $value['nome_mae'] != "" ? $value['nome_mae'] : "N&atilde;o Informado";

                            # Atualizar / cadastrar funcionario
                            $this->db->select('id_funcionario_pk');
                            $this->db->from('tb_funcionario');
                            $this->db->where('cpf', $cpf);
                            $row_func = $this->db->get()->result();

                            # Dados do funcionario
                            $dados_func['id_empresa_fk']          = $this->db->escape_str($id_empresa);
                            $dados_func['cpf']                    = $this->db->escape_str($cpf);
                            $dados_func['nome']                   = $this->db->escape_str($nome);
                            $dados_func['dt_nasc']                = is_array($dt_nasc) ? str_pad($dt_nasc[2], 2, "0", STR_PAD_LEFT).'-'.str_pad($dt_nasc[1], 2, "0", STR_PAD_LEFT).'-'.$dt_nasc[0] : $dt_nasc;
                            $dados_func['sexo']                   = $this->db->escape_str($sexo);
                            $dados_func['id_estado_civil_fk']     = 4;
                            $dados_func['rg']                     = $this->db->escape_str($rg);
                            $dados_func['dt_expedicao']           = "2000-01-01";
                            $dados_func['orgao_expedidor']        = "SSP";
                            $dados_func['id_estado_expedidor_fk'] = 26;
                            $dados_func['nome_mae']               = $nome_mae;
                            $dados_func['id_status_fk']           = 1;

                            if (!empty($row_func)) {
                                # Atualiza Funcionario
                                $this->db->where('id_funcionario_pk', $row_func[0]->id_funcionario_pk);
                                $this->db->update('tb_funcionario', $dados_func);
                                $id_funcionario = $row_func[0]->id_funcionario_pk;
                            } else {
                                # Grava Funcionario
                                $this->db->insert('tb_funcionario', $dados_func);
                                $id_funcionario = $this->db->insert_id();
                            }

                            # Vars Dados Funcionario
                            $matricula       = isset($value['matricula']) && $value['matricula'] != "" ? $value['matricula'] : "0000";
                            $id_departamento = 20;
                            if (isset($value['id_departamento_fk']) && $value['id_departamento_fk'] != "") {
                                # Verificar se Departamento existe
                                $this->db->select('id_departamento_pk');
                                $this->db->from('tb_departamento');
                                $this->db->where('departamento', $this->db->escape_str($value['id_departamento_fk']));
                                $row_dpto = $this->db->get()->result();

                                if (!empty($row_dpto)) {
                                    $id_departamento = $row_dpto[0]->id_departamento_pk;
                                } else {
                                    # Grava Novo Departamento
                                    $dados_dpto['departamento'] = $this->db->escape_str($value['id_departamento_fk']);
                                    $this->db->insert('tb_departamento', $dados_dpto);
                                    $id_departamento = $this->db->insert_id();
                                }
                            }

                            # Atualizar / cadastrar dados funcionario
                            $this->db->select('id_dados_profissional_pk');
                            $this->db->from('tb_dados_profissional');
                            $this->db->where('id_funcionario_fk', $id_funcionario);
                            $row_prof = $this->db->get()->result();

                            # Dados profissionais do funcionario
                            $dados_prof['id_funcionario_fk']      = $id_funcionario;
                            $dados_prof['matricula']              = $this->db->escape_str($matricula);
                            $dados_prof['id_cargo_fk']            = 15;
                            $dados_prof['id_departamento_fk']     = $id_departamento;
                            $dados_prof['id_periodo_pk']          = 1;
                            $dados_prof['id_endereco_empresa_fk'] = $id_endereco_empresa;

                            if (!empty($row_prof)) {
                                # Atualiza Dados Funcionario
                                $this->db->where('id_dados_profissional_pk', $row_prof[0]->id_dados_profissional_pk);
                                $this->db->update('tb_dados_profissional', $dados_prof);
                            } else {
                                # Grava Dados Funcionario
                                $this->db->insert('tb_dados_profissional', $dados_prof);
                            }

                            # Vars Beneficios
                            $id_grupo_fk = 1;
                            if (isset($value['id_grupo_fk']) && $value['id_grupo_fk'] == "Transporte") {
                                $id_grupo_fk = 1;
                            } elseif (isset($value['id_grupo_fk']) && $value['id_grupo_fk'] == "Refeição") {
                                $id_grupo_fk = 2;
                            } elseif (isset($value['id_grupo_fk']) && $value['id_grupo_fk'] == "Alimentação") {
                                $id_grupo_fk = 3;
                            } elseif (isset($value['id_grupo_fk']) && $value['id_grupo_fk'] == "Combustível") {
                                $id_grupo_fk = 4;
                            }
                            $id_item_beneficio_fk = isset($value['id_item_beneficio_fk']) && $value['id_item_beneficio_fk'] != "" ? $value['id_item_beneficio_fk'] : NULL;
                            $vl_unitario          = isset($value['vl_unitario']) && $value['vl_unitario'] != "" ? $value['vl_unitario'] : "0.00";
                            $qtd_diaria           = isset($value['qtd_diaria']) && $value['qtd_diaria'] != "" ? $value['qtd_diaria'] : "1";

                            # Atualizar / cadastrar benefício
                            if ($id_item_beneficio_fk != NULL) {
                                $this->db->select('id_beneficio_pk');
                                $this->db->from('tb_beneficio');
                                $this->db->where(array(
                                                    'id_funcionario_fk'    => $id_funcionario,
                                                    'id_grupo_fk'          => $id_grupo_fk,
                                                    'id_item_beneficio_fk' => $id_item_beneficio_fk
                                                ));
                                $row_benef = $this->db->get()->result();

                                # Dados do Beneficio
                                $dados_ben['id_funcionario_fk']    = $id_funcionario;
                                $dados_ben['id_grupo_fk']          = $id_grupo_fk;
                                $dados_ben['id_item_beneficio_fk'] = $this->db->escape_str($id_item_beneficio_fk);
                                $dados_ben['vl_unitario']          = $this->db->escape_str($vl_unitario);
                                $dados_ben['qtd_diaria']           = $this->db->escape_str($qtd_diaria);

                                if (!empty($row_benef)) {
                                    # Atualiza Beneficio
                                    $this->db->where('id_beneficio_pk', $row_benef[0]->id_beneficio_pk);
                                    $this->db->update('tb_beneficio', $dados_ben);
                                } else {
                                    # Grava Beneficio
                                    $this->db->insert('tb_beneficio', $dados_ben);
                                }
                            }

                            $ret->status = TRUE;
                            $ret->msg    = "Importa&ccedil;&atilde;o realizada com sucesso!";

                        } else {
                            $ret->status = FALSE;
                            $ret->msg    = "Houve um erro na Importa&ccedil;&atilde;o! Empresa n&atilde;o localizada pelo <strong>CNPJ</strong> informado.";
                        }

                    endforeach;

                } else {
                    $ret->status = FALSE;
                    $ret->msg    = "Houve um erro ao Importar o arquivo! Tente novamente...";
                }

                # Arquivos
                $ret->file_name = $file_name;

            }

            echo json_encode($ret);
        }
    }

    /**
     * Método para remove formato moeda da string
     *
     * @method removeFormatMoney
     * @param string $strNumero Número
     * @access public
     * @return float Número no formato Float
     */
    public function removeFormatMoney($strNumero)
    {
        $strNumero = trim(str_replace("R$", null, $strNumero));

        $vetVirgula = explode(",", $strNumero);
        if (count($vetVirgula) == 1) {
            $acentos   = array(".");
            $resultado = str_replace($acentos, "", $strNumero);
            return $resultado;
        } else if (count($vetVirgula) != 2) {
            return $strNumero;
        }

        $strNumero  = $vetVirgula[0];
        $strDecimal = mb_substr($vetVirgula[1], 0, 2);

        $acentos   = array(".");
        $resultado = str_replace($acentos, "", $strNumero);
        $resultado = $resultado . "." . $strDecimal;

        return $resultado;
    }

}

/* End of file Importacao.php */
/* Location: ./application/controllers/Importacao.php */