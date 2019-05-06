Roteirizacao = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        // Botao voltar
        $('#btn_back').click(function () {
            Roteirizacao.redirect('../');
        });

        // Mascara
        $("#cep").mask('99999-999');
        Roteirizacao.onlyNumber('cpf');
        $("#cpf").mask('999.999.999-99');
        $("#vl_solicitado").maskMoney({
            thousands: '.',
            decimal: ','
        });

        // Buscar Dados do Funcionario Por CPF
        $("#cpf").blur(function () {
            let cpf = $(this).val();
            $.post("./getDadosFunc", {
                cpf: cpf
            }, function (data) {
                if (data.status === true) {
                    // Roteirizacao.modalMsg("MENSAGEM", data.msg, false, false);
                    let id_func = (data.dados[0].id_funcionario_pk) ? data.dados[0].id_funcionario_pk : "";
                    $("#id_funcionario").val(id_func);
                    let nome = (data.dados[0].nome) ? data.dados[0].nome : "";
                    $("#nome_func").val(nome);
                    $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'nome_func');
                    let cep = (data.dados[0].cep) ? data.dados[0].cep : "";
                    $("#cep").val(cep);
                    $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'cep');
                    let logradouro = (data.dados[0].logradouro) ? data.dados[0].logradouro : "";
                    $("#endereco").val(logradouro);
                    $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'endereco');
                    let numero = (data.dados[0].numero) ? data.dados[0].numero : "";
                    $("#numero").val(numero);
                    $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'numero');
                    let complemento = (data.dados[0].complemento) ? data.dados[0].complemento : "";
                    $("#complemento").val(complemento);
                    let bairro = (data.dados[0].bairro) ? data.dados[0].bairro : "";
                    $("#bairro").val(bairro);
                    $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'bairro');
                    if (data.dados[0].id_estado_fk !== null){
                        let estado = data.dados[0].id_estado_fk;
                        $("#estado").val(estado);
                    }
                    if (data.dados[0].id_cidade_fk !== null){
                        let cidade = data.dados[0].id_cidade_fk;
                        $("#cidade").val(cidade);
                    }
                }
            }, 'json');
        });

        // Buscar o CEP
        $("#cep").blur(function(){
            let cep = $(this).val().replace(/\D/g, '');
            if (cep !== "") {
                let validacep = /^[0-9]{8}$/;
                $("#endereco").val("Buscando...");
                $("#bairro").val("Buscando...");
                $("#cidade").val($('option:contains("Selecione")').val());
                if (validacep.test(cep)) {
                    $.getJSON("https://viacep.com.br/ws/"+cep+"/json/?callback=?", function(dados) {
                        if (!("erro" in dados)) {
                            $("#endereco").val(dados.logradouro);
                            $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'endereco');
                            $("#bairro").val(dados.bairro);
                            $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'bairro');
                            let resp_cidade = dados.localidade.replace(/\s{2,}/g, ' ');
                            Roteirizacao.getCidade(resp_cidade);
                            // $("#cidade").val($('option:contains("'+resp_cidade+'")').val());
                        } else {
                            Roteirizacao.modalMsg("MENSAGEM", "CEP N&atilde;o Encontrado!", false, false);
                            $("#endereco").val('');
                            $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'endereco');
                            $("#bairro").val('');
                            $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'bairro');
                        }
                    });
                }
            }
        });

        // Revalidar Valor Solicitado
        $("#vl_solicitado").blur(function(){
           $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'vl_solicitado');
        });

        // Roteirizacao Cadastrar
        $('#frm_cad_roteiriza').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                endereco_empresa: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>LOCAL DE TRABALHO</strong>'
                        }
                    }
                },
                cpf: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>CPF</strong>'
                        },
                        id: {
			    country: 'BR',
			    message: 'Digite um <strong>CPF</strong> v&aacute;lido'
			}
                    }
                },
                nome_func: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>NOME</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>NOME</strong> deve ter entre <strong>2</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                cep: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>CEP</strong>'
                        },
                        stringLength: {
                            min: 9,
                            max: 9,
                            message: 'Digite um <strong>CEP</strong> v&aacute;lido'
                        }
                    }
                },
                endereco: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>ENDERE&Ccedil;O</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 250,
                            message: 'O campo <strong>ENDERE&Ccedil;O</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                numero: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>N&Uacute;MERO</strong>'
                        },
                        stringLength: {
                            min: 1,
                            max: 15,
                            message: 'O campo <strong>N&Uacute;MERO</strong> deve ter entre <strong>1</strong> e <strong>15</strong> caracteres'
                        }
                    }
                },
                bairro: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>BAIRRO</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 25,
                            message: 'O campo <strong>BAIRRO</strong> deve ter entre <strong>2</strong> e <strong>25</strong> caracteres'
                        }
                    }
                },
                estado: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>ESTADO</strong>'
			}
		    }
		},
                cidade: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>CIDADE</strong>'
			}
		    }
		},
                vl_solicitado: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>VALOR SOLICITADO POR DIA</strong>'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            var frm = $form.serialize();
            var url = "./create";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    Roteirizacao.modalMsg("MENSAGEM", data.msg, false, './consultar');
                } else {
                    Roteirizacao.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_roteiriza').removeAttr('disabled');
            }, 'json');

        });

        // Mostrar Campo Anexo
        $("#id_status").change(function(){
            let status = $(this).val();
            if (status === "3"){
                $("#div_anexo").show();
            } else {
                $("#anexo").val('');
                $("#div_anexo").hide();
            }
        });

        // Botao Cancelar Status
        $('#cancel_status').click(function(){
            $("#modal_status").modal('hide');
        });

        // Status Editar
        $('#frm_edit_status').bootstrapValidator({
            excluded: [':disabled'],
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                id_status: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>STATUS</strong>'
                        }
                    }
                },
                anexo: {
		    validators: {
                        file: {
                            extension : 'pdf',
                            type      : 'application/pdf',
                            maxSize   : 10 * 1024 * 1024,
                            message   : 'A <strong>CARTA DE ROTEIRIZA&Ccedil;&Atilde;O</strong> deve ser no formato <strong>.pdf</strong> e n&atilde;o deve exceder <strong>10MB</strong> em tamanho!'
                        },
                        callback: {
			    callback: function (value, validator, $field) {
				let status = $('#id_status').val();
				if (status === "3" && value === "") {
				    return {
					valid: false,
					message: '&Eacute; obrigat&oacute;rio anexar a <strong>CARTA DE ROTEIRIZA&Ccedil;&Atilde;O</strong>'
				    };
				}
				return true;
			    }
			}
		    }
		}
            }
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            var frm = $form.serialize();
            var url = "./alterStatus";

            // Use Ajax to submit form data
            $.ajax({
                url         : url,
                type        : 'POST',
                dataType    : 'json',
                data        : new FormData($($form)[0]),
                cache       : false,
                contentType : false,
                processData : false,
                success     : function(data) {
                    if (data.status === true) {
                        Roteirizacao.modalMsg("MENSAGEM", data.msg, false, false);
                        $("#modal_status").modal('hide');
                        // Reload grid
                        $('#tbl_roteiriza').DataTable().ajax.reload();
                    } else {
                        Roteirizacao.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                    }
                    $('#btn_edit_status').removeAttr('disabled');
                }
            });

        });

    },

    /*!
     * @description Método para buscar Cidade por Nome
     **/
    getCidade: function (str_city) {
        $.post('./getCidade', {city: str_city}, function(data){
            if (data.status === true) {
                $("#cidade").val(data.dados[0].id_cidade_pk);
                $("#frm_cad_roteiriza").bootstrapValidator('revalidateField', 'cidade');
            }
        }, 'json');
    },

    /*!
     * @description Método para abrir modal de mensagem
     **/
    modalMsg: function (title, msg, focus, redirect) {

        $("#title_modal").html(title);
        $("#mensagem_modal").html(msg);
        $("#msg_modal").modal('show');

        if (focus) {
            $("#msg_modal").on('hidden.bs.modal', function (e) {
                Roteirizacao.setFocus(focus);
                e.preventDefault();
            });
        }

        if (redirect) {
            $("#msg_modal").on('hidden.bs.modal', function (e) {
                Roteirizacao.redirect(redirect);
                e.preventDefault();
            });
        }

    },

    /*!
     * @description Método para abrir modal de edicao de Status
     **/
    modalStatus: function(id_roteiriza, id_status) {
        $("#modal_status").modal('show');
        $("#id_status").val(id_status);
        $("#id_roteiriza").val(id_roteiriza);
    },

    /*!
     * @description Método colocar focus em um campo
     **/
    setFocus: function (id_field) {
        $("#" + id_field).focus();
    },

    /*!
     * @description Método redirecionamento de link
     **/
    redirect: function (link) {
        window.location.href = link;
    },

    /*!
     * @description Método abrir janela
     **/
    openWindow: function (link, target) {
        window.open(link, target);
    },

    /*!
     * @description Metodo para permitir o input de apenas numeros
     **/
    onlyNumber: function (nameField) {
        $("input[name=" + nameField + "]").keydown(function (e) {
            if (e.shiftKey)
                e.preventDefault();
            if (!((e.keyCode == 46) || (e.keyCode == 8) || (e.keyCode == 9) // DEL, Backspace e Tab
                    || (e.keyCode == 17) || (e.keyCode == 91) || (e.keyCode == 86) || (e.keyCode == 67) // Ctrl+C / Ctrl+V
                    || ((e.keyCode >= 35) && (e.keyCode <= 40)) // HOME, END, Setas
                    || ((e.keyCode >= 96) && (e.keyCode <= 105)) // Númerod Pad
                    || ((e.keyCode >= 48) && (e.keyCode <= 57))))
                e.preventDefault(); // Números
        });
    }

};

$(document).ready(function () {
    Roteirizacao.main();
});