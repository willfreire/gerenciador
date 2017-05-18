Cliente = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        // Vars path
        var currentLocation = window.location;
        var parser          = document.createElement('a');
        parser.href         = currentLocation;

        var protocol = parser.protocol;
        var host     = parser.host;
        var hostname = parser.hostname;
        var port     = parser.port;
        var pathname = parser.pathname;
        var pathproj = pathname.split('/')[1];
        var hash     = parser.hash;
        var search   = parser.search;
        var origin   = parser.origin;

        // Botao voltar
        $('#btn_back').click(function(){
            Cliente.redirect('../gerenciar');
        });

        // Habilitar campo senha
        $("#alt_senha").click(function(){
            if ($("#alt_senha:checked").val() === "1") {
                $("#senha_cliente").removeAttr('disabled');
                $("#gen_pwd").removeClass('hidden');
                Cliente.setFocus('senha_cliente');
            } else {
                $("#senha_cliente").val('');
                $("#senha_cliente").attr('disabled', 'disabled');
                $("#gen_pwd").addClass('hidden');
            }
        });

	// Habilitar/Ocultar Mailing
        $("input[name='importar_prospec']").change(function() {
            var vl = $("input[name='importar_prospec']:checked").val();
            if (vl === "1") {
                $("#div_prospec").removeClass("hidden");
                Cliente.setFocus('empr_prospec');
            } else {
                $("#div_prospec").addClass("hidden");
                $("#empr_prospec").val('');
            }
        });

        // Importar dados
        $("#empr_prospec").change(function(){
            var id_mail = $(this).val();
            if (id_mail !== "") {
                $.post('/'+pathproj+'/cliente/importMailing', {
                    id : id_mail
                }, function(data){
                    if (data.status === true) {
                        // Cliente.modalMsg("MENSAGEM", data.msg, false, false);
                        var cnpj      = (data.mail[0].cnpj) ? data.mail[0].cnpj : "";
                        $("#cnpj").val(cnpj);
                        var razao     = (data.mail[0].razao_social) ? data.mail[0].razao_social : "";
                        $("#razao_social").val(razao);
                        var endereco  = (data.mail[0].endereco) ? data.mail[0].endereco : "";
                        $("#endereco").val(endereco);
                        var numero    = (data.mail[0].numero) ? data.mail[0].numero : "";
                        $("#numero").val(numero);
                        var comple    = (data.mail[0].complemento) ? data.mail[0].complemento : "";
                        $("#complemento").val(comple);
                        var bairro    = (data.mail[0].bairro) ? data.mail[0].bairro : "";
                        $("#bairro").val(bairro);
                        var cep       = (data.mail[0].cep) ? data.mail[0].cep : "";
                        $("#cep").val(cep);
                        var id_cidade = (data.mail[0].id_cidade_fk) ? data.mail[0].id_cidade_fk : "";
                        $("#cidade").val(id_cidade);
                        var id_estado = (data.mail[0].id_estado_fk) ? data.mail[0].id_estado_fk : "";
                        $("#estado").val(id_estado);
                        var telefone  = (data.mail[0].telefone) ? data.mail[0].telefone : "";
                        $("#estado").val(id_estado);
                        var email     = (data.mail[0].email) ? data.mail[0].email : "";
                        $("#email").val(email);
                        var contato   = (data.mail[0].contato) ? data.mail[0].contato : "";
                        $("#nome_contato").val(contato);
                        var taxa      = (data.mail[0].taxa) ? data.mail[0].taxa : "";
                        $("#taxa_adm").val(taxa);
                    } else {
                        Cliente.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
                    }
                }, 'json');
            }
        });

	// Habilitar/Ocultar Empresa Matriz
        $("input[name='tp_empresa']").change(function() {
            var vl = $("input[name='tp_empresa']:checked").val();
            if (vl === "2") {
                $("#div_matriz").removeClass("hidden");
                Cliente.setFocus('matriz');
            } else {
                $("#div_matriz").addClass("hidden");
                $("#matriz").val('');
            }
        });

        // Mascara
        $("#cep").mask('99999-999');
        Cliente.onlyNumber('cnpj');
        $("#cnpj").mask('99.999.999/9999-99');
        $("#tel").mask("(00) 0000-00000");
        $("#dt_nasc").mask("99/99/9999");
        Cliente.onlyNumber('tel');
        $("#tel").blur(function(){
            var num_tel = $(this).val().length;
            if (num_tel > 14) {
                $("#tel").unmask();
                $("#tel").mask("(99) 99999-9999");
            } else {
                $("#tel").unmask();
                $("#tel").mask("(99) 9999-99990");
            }
        });
        $("#taxa_adm").maskMoney({
            allowNegative: true
        });
        $("#taxa_entrega").maskMoney({
            thousands     : '.',
            decimal       : ','
        });

        // Calendario
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            clearBtn: true
        });

        // Busca Cidade por Estado
        $("#estado").change(function(){
            var id_estado = $(this).val();
            if (id_estado !== "") {
                $.post('/'+pathproj+'/cliente/getCities', {
                    id : id_estado
                }, function(data){
                    if (data.status === true) {
                        // Cliente.modalMsg("MENSAGEM", data.msg, false, false);
                        var option = "<option value=''>Selecione</option>";
                        $.each(data.cities, function(key, value){
                            option += "<option value='"+value.id_cidade_pk+"'>"+value.cidade+"</option>";
                        });
                        $("#cidade").html(option);
                    } else {
                        Cliente.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                        var option = "<option value=''>"+data.msg+"</option>";
                        $("#cidade").html(option);
                    }
                }, 'json');
            }
        });

        // Cliente Cadastrar
        $('#frm_cad_client_vt').bootstrapValidator({
            excluded: [':disabled'],
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                importar_prospec: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>IMPORTAR DADOS</strong>'
			}
		    }
		},
                empr_prospec: {
		    validators: {
			callback: {
			    callback: function (value, validator, $field) {
				var import_pros = $('input[type=radio][name=importar_prospec]:checked').val();
				if (import_pros === "1" && value === "") {
				    return {
					valid   : false,
					message : '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>EMPRESA DA PROSPEC&Ccedil;&Atilde;O</strong>'
				    };
				}
				return true;
			    }
			}
		    }
		},
                tp_empresa: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>TIPO DE EMPRESA</strong>'
			}
		    }
		},
                cnpj: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>CNPJ</strong>'
                        },
			vat: {
			    country: 'BR',
			    message: 'Digite um <strong>CNPJ</strong> v&aacute;lido'
			}
                    }
                },
                razao_social: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>RAZ&Atilde;O SOCIAL</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>RAZ&Atilde;O SOCIAL</strong> deve ter entre <strong>2</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                atividade: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>RAMO DE ATIVIDADE</strong>'
			}
		    }
		},
                email: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>E-MAIL</strong>'
                        },
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
                        }
                    }
                },
                tel: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>TELEFONE</strong>'
                        },
                        stringLength: {
                            min: 14,
                            max: 15,
                            message: 'O campo <strong>TELEFONE</strong> deve ter entre <strong>10</strong> e <strong>11</strong> n&uacute;meros'
                        }
                    }
                },
                senha_cliente: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>SENHA</strong>'
                        },
                        stringLength: {
                            min: 8,
                            max: 50,
                            message: 'O campo <strong>SENHA</strong> deve ter entre <strong>8</strong> e <strong>50</strong> caracteres'
                        }
                    }
                },
                status: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>STATUS</strong>'
			}
		    }
		},
                tp_endereco: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>TIPO DE ENDERE&Ccedil;O</strong>'
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
                resp_receb: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>RESPONS&Aacute;VEL PELO RECEBIMENTO</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 250,
                            message: 'O campo <strong>RESPONS&Aacute;VEL PELO RECEBIMENTO</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                nome_contato: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>NOME DO CONTATO</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 250,
                            message: 'O campo <strong>NOME DO CONTATO</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                depto: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>DEPARTAMENTO</strong>'
			}
		    }
		},
                cargo: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>CARGO</strong>'
			}
		    }
		},
                sexo: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>SEXO</strong>'
			}
		    }
		},
                dt_nasc: {
		    validators: {
                        stringLength: {
			    min: 10,
			    max: 10,
			    message: 'Informe uma <strong>DATA DE NASCIMENTO</strong> v&aacute;lida!'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DATA DE NASCIMENTO</strong>'
			}
		    }
		},
                resp_compra: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>RESPONS&Aacute;VEL PELA COMPRA</strong>'
			}
		    }
		},
                email_pri_contato: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>E-MAIL PRINCIPAL</strong>'
                        },
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL PRINCIPAL</strong> v&aacute;lido'
                        }
                    }
                }
            }
        }).on('error.field.bv', function(e, data) {
            // data.element --> The field element

            var $tabPane = data.element.parents('.tab-pane'),
                tabId    = $tabPane.attr('id');

            $('a[href="#' + tabId + '"][data-toggle="tab"]')
                .parent()
                .find('i')
                .removeClass('fa-check')
                .addClass('fa-times');
        }).on('success.form.bv', function (e, data) {
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
                    Cliente.modalMsg("MENSAGEM", data.msg, false, './gerenciar');
                } else {
                    Cliente.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_client_vt').removeAttr('disabled');
            }, 'json');

        });

        // Cliente Editar
        $('#frm_edit_client_vt').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                tp_empresa: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>TIPO DE EMPRESA</strong>'
			}
		    }
		},
                cnpj: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>CNPJ</strong>'
                        },
			vat: {
			    country: 'BR',
			    message: 'Digite um <strong>CNPJ</strong> v&aacute;lido'
			}
                    }
                },
                razao_social: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>RAZ&Atilde;O SOCIAL</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>RAZ&Atilde;O SOCIAL</strong> deve ter entre <strong>2</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                atividade: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>RAMO DE ATIVIDADE</strong>'
			}
		    }
		},
                email: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>E-MAIL</strong>'
                        },
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
                        }
                    }
                },
                tel: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>TELEFONE</strong>'
                        },
                        stringLength: {
                            min: 14,
                            max: 15,
                            message: 'O campo <strong>TELEFONE</strong> deve ter entre <strong>10</strong> e <strong>11</strong> n&uacute;meros'
                        }
                    }
                },
                senha_cliente: {
                    validators: {
                        callback: {
                            callback: function (value, validator, $field) {
                                var alt_pwd = $('#alt_senha').is(':checked');
                                if (alt_pwd === true && value.length < 8) {
                                    return {
                                        valid   : false,
                                        message : 'O campo <strong>SENHA</strong> deve ter entre <strong>8</strong> e <strong>50</strong> caracteres'
                                    };
                                }
                                return true;
                            }
                        }
                    }
                },
                status: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>STATUS</strong>'
			}
		    }
		},
                tp_endereco: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>TIPO DE ENDERE&Ccedil;O</strong>'
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
                resp_receb: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>RESPONS&Aacute;VEL PELO RECEBIMENTO</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 250,
                            message: 'O campo <strong>RESPONS&Aacute;VEL PELO RECEBIMENTO</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                nome_contato: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>NOME DO CONTATO</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 250,
                            message: 'O campo <strong>NOME DO CONTATO</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                depto: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>DEPARTAMENTO</strong>'
			}
		    }
		},
                cargo: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>CARGO</strong>'
			}
		    }
		},
                sexo: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>SEXO</strong>'
			}
		    }
		},
                dt_nasc: {
		    validators: {
                        stringLength: {
			    min: 10,
			    max: 10,
			    message: 'Informe uma <strong>DATA DE NASCIMENTO</strong> v&aacute;lida!'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DATA DE NASCIMENTO</strong>'
			}
		    }
		},
                resp_compra: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>RESPONS&Aacute;VEL PELA COMPRA</strong>'
			}
		    }
		},
                email_pri_contato: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>E-MAIL PRINCIPAL</strong>'
                        },
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL PRINCIPAL</strong> v&aacute;lido'
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
            var url = "../update";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    Cliente.modalMsg("MENSAGEM", data.msg, false, '../gerenciar');
                } else {
                    Cliente.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_edit_client_vt').removeAttr('disabled');
            }, 'json');

        });

        // Gerar senha
        $('#gen_pwd').pGenerator({
            'bind'            : 'click',
            'passwordElement' : '#senha_cliente',
            'displayElement'  : '#senha_cliente',
            'passwordLength'  : 8,
            'uppercase'       : true,
            'lowercase'       : true,
            'numbers'         : true,
            'specialChars'    : false,
            /* 'onPasswordGenerated': function (generatedPassword) {
                alert('My new generated password is ' + generatedPassword);
            } */
        });
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
		Cliente.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Cliente.redirect(redirect);
		e.preventDefault();
	    });
	}

    },

    /*!
     * @description Método para exclusao de um registro
     **/
    del: function(id) {
        bootbox.dialog({
            message: "<i class='fa fa-exclamation-triangle'></i> Deseja realmente <strong>Excluir</strong> esse Cliente?",
            title: "ATEN&Ccedil;&Atilde;O",
            buttons: {
                success: {
                    label: "Cancelar",
                    className: "btn-primary"
                },
                danger: {
                    label: "Excluir",
                    className: "btn-danger",
                    callback: function() {
                        // Excluir registro
                        $.post('./delete', {
                            id: id
                        },function(data){
                            if (data.status === true) {
                                Cliente.modalMsg("MENSAGEM", data.msg, false, false);
                                // Reload grid
                                $('#tbl_client_vt').DataTable().ajax.reload();
                            } else {
                                Cliente.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
                            }
                        }, 'json');
                    }
                }
            }
        });
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
    Cliente.main();
});