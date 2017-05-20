Funcionario = {

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
            Funcionario.redirect('../gerenciar');
        });

        // Mascara
        $("#cep").mask('99999-999');
        Funcionario.onlyNumber('cpf');
        $("#cpf").mask('999.999.999-99');
        $("#tel").mask("(99) 9999-99990");
        $("#dt_nasc").mask("99/99/9999");
        $("#dt_exped").mask("99/99/9999");
        Funcionario.onlyNumber('tel');
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
                $.post('/'+pathproj+'/funcionario/getCities', {
                    id : id_estado
                }, function(data){
                    if (data.status === true) {
                        // Funcionario.modalMsg("MENSAGEM", data.msg, false, false);
                        var option = "<option value=''>Selecione</option>";
                        $.each(data.cities, function(key, value){
                            option += "<option value='"+value.id_cidade_pk+"'>"+value.cidade+"</option>";
                        });
                        $("#cidade").html(option);
                    } else {
                        Funcionario.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                        var option = "<option value=''>"+data.msg+"</option>";
                        $("#cidade").html(option);
                    }
                }, 'json');
            }
        });

        // Funcionario Cadastrar
        $('#frm_cad_func').bootstrapValidator({
            excluded: [':disabled'],
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
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
                dt_nasc: {
		    validators: {
                        stringLength: {
			    min: 10,
			    max: 10,
			    message: 'Informe uma <strong>DATA DE NASCIMENTO</strong> v&aacute;lida'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DATA DE NASCIMENTO</strong>'
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
                estado_civil: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>ESTADO CIVIL</strong>'
			}
		    }
		},
                rg: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>RG</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 15,
                            message: 'O campo <strong>RG</strong> deve ter entre <strong>4</strong> e <strong>15</strong> caracteres'
                        }
                    }
                },
                dt_exped: {
		    validators: {
                        stringLength: {
			    min: 10,
			    max: 10,
			    message: 'Informe uma <strong>DATA DE EXPEDI&Ccedil;&Atilde;O</strong> v&aacute;lida'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DATA DE DE EXPEDI&Ccedil;&Atilde;O</strong>'
			}
		    }
		},
                orgao_exped: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>&Oacute;RG&Atilde;O EXPEDIDOR</strong>'
			}
		    }
		},
                uf_exped: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>UF</strong>'
			}
		    }
		},
                nome_mae: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>NOME DA M&Atilde;E</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>NOME DA M&Atilde;E</strong> deve ter entre <strong>2</strong> e <strong>250</strong> caracteres'
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
                matricula: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>MATR&Iacute;CULA</strong>'
                        },
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
                periodo: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>PER&Iacute;ODO</strong>'
			}
		    }
		},
                email_func: {
                    validators: {
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
                        }
                    }
                },
                ender_empresa: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>ENDERE&Ccedil;O DA EMPRESA</strong>'
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
                    Funcionario.modalMsg("MENSAGEM", data.msg, false, './gerenciar');
                } else {
                    Funcionario.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_func').removeAttr('disabled');
            }, 'json');

        });

        // Funcionario Editar
        $('#frm_edit_func').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
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
                dt_nasc: {
		    validators: {
                        stringLength: {
			    min: 10,
			    max: 10,
			    message: 'Informe uma <strong>DATA DE NASCIMENTO</strong> v&aacute;lida'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DATA DE NASCIMENTO</strong>'
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
                estado_civil: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>ESTADO CIVIL</strong>'
			}
		    }
		},
                rg: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>RG</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 15,
                            message: 'O campo <strong>RG</strong> deve ter entre <strong>4</strong> e <strong>15</strong> caracteres'
                        }
                    }
                },
                dt_exped: {
		    validators: {
                        stringLength: {
			    min: 10,
			    max: 10,
			    message: 'Informe uma <strong>DATA DE EXPEDI&Ccedil;&Atilde;O</strong> v&aacute;lida'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DATA DE NASCIMENTO</strong>'
			}
		    }
		},
                orgao_exped: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>&Oacute;RG&Atilde;O EXPEDIDOR</strong>'
			}
		    }
		},
                uf_exped: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>UF</strong>'
			}
		    }
		},
                nome_mae: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>NOME DA M&Atilde;E</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>NOME DA M&Atilde;E</strong> deve ter entre <strong>2</strong> e <strong>250</strong> caracteres'
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
                matricula: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>MATR&Iacute;CULA</strong>'
                        },
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
                periodo: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>PER&Iacute;ODO</strong>'
			}
		    }
		},
                email_func: {
                    validators: {
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
                        }
                    }
                },
                ender_empresa: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>ENDERE&Ccedil;O DA EMPRESA</strong>'
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
                    Funcionario.modalMsg("MENSAGEM", data.msg, false, '../gerenciar');
                } else {
                    Funcionario.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_edit_func').removeAttr('disabled');
            }, 'json');

        });

        // Gerar senha
        $('#gen_pwd').pGenerator({
            'bind'            : 'click',
            'passwordElement' : '#senha_funcionario',
            'displayElement'  : '#senha_funcionario',
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
		Funcionario.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Funcionario.redirect(redirect);
		e.preventDefault();
	    });
	}

    },

    /*!
     * @description Método para exclusao de um registro
     **/
    del: function(id) {
        bootbox.dialog({
            message: "<i class='fa fa-exclamation-triangle'></i> Deseja realmente <strong>Excluir</strong> esse Funcion&aacute;rio?",
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
                                Funcionario.modalMsg("MENSAGEM", data.msg, false, false);
                                // Reload grid
                                $('#tbl_func').DataTable().ajax.reload();
                            } else {
                                Funcionario.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
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
    Funcionario.main();
});