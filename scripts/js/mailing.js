Mailing = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        var currentLocation = window.location;
        var parser          = document.createElement('a');
        // parser.href = "http://example.com:3000/pathname/?search=test#hash";
        parser.href = currentLocation;

        var protocol = parser.protocol; // => "http:"
        var host     = parser.host;     // => "example.com:3000"
        var hostname = parser.hostname; // => "example.com"
        var port     = parser.port;     // => "3000"
        var pathname = parser.pathname; // => "/pathname/"
        var pathproj = pathname.split('/')[1];
        var hash     = parser.hash;     // => "#hash"
        var search   = parser.search;   // => "?search=test"
        var origin   = parser.origin;   // => "http://example.com:3000"

        // Botao voltar
        $('#btn_back').click(function(){
            Mailing.redirect('../gerenciar');
        });

        // Mascara
        $("#cep").mask('99999-999');
        Mailing.onlyNumber('cnpj');
        $("#cnpj").mask('99.999.999/9999-99');
        $("#tel").mask("(99) 9999-99990");
        Mailing.onlyNumber('tel');
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
                $.post('/'+pathproj+'/mailing/getCities', {
                    id : id_estado
                }, function(data){
                    if (data.status === true) {
                        // Mailing.modalMsg("MENSAGEM", data.msg, false, false);
                        var option = "<option value=''>Selecione</option>";
                        $.each(data.cities, function(key, value){
                            option += "<option value='"+value.id_cidade_pk+"'>"+value.cidade+"</option>";
                        });
                        $("#cidade").html(option);
                    } else {
                        Mailing.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                        var option = "<option value=''>"+data.msg+"</option>";
                        $("#cidade").html(option);
                    }
                }, 'json');
            }
        });

        // Mailing Cadastrar
        $('#frm_cad_mail_vt').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
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
                email: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>E-MAIL</strong>'
                        },
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
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
                    Mailing.modalMsg("MENSAGEM", data.msg, false, './gerenciar');
                } else {
                    Mailing.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_mail_vt').removeAttr('disabled');
            }, 'json');

        });

        // Mailing Editar
        $('#frm_edit_mail_vt').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
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
                email: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>E-MAIL</strong>'
                        },
                        emailAddress: {
                            message: 'Digite um endere&ccedil;o de <strong>E-MAIL</strong> v&aacute;lido'
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
                    Mailing.modalMsg("MENSAGEM", data.msg, false, '../gerenciar');
                } else {
                    Mailing.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_edit_mail_vt').removeAttr('disabled');
            }, 'json');

        });

        /* Prospeccao */
	// Habilitar/Ocultar Muda Fornecedor
        $("input[name='muda_fornecedor']").change(function() {
            var vl = $("input[name='muda_fornecedor']:checked").val();
            if (vl === "4") {
                $("#row_muda_fornec").removeClass("hidden");
                Mailing.setFocus('muda_fornec_outro');
            } else {
                $("#row_muda_fornec").addClass("hidden");
                $("#muda_fornec_outro").val('');
            }
        });

	// Habilitar/Ocultar Não Interesse
        $("input[name='nao_interesse']").change(function() {
            var vl = $("input[name='nao_interesse']:checked").val();
            if (vl === "6") {
                $("#row_nao_interesse").removeClass("hidden");
                Mailing.setFocus('nao_interesse_outro');
            } else {
                $("#row_nao_interesse").addClass("hidden");
                $("#nao_interesse_outro").val('');
            }
        });

        // Limpar validacao
        $("#modal_prospec").on('hidden.bs.modal', function() {
            // Limpar Validacao
            $('#frm_cad_prospec_vt').bootstrapValidator('resetForm', true);
        });

        // Prospeccao
        $('#frm_cad_prospec_vt').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                mailing: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>EMPRESA</strong>'
			}
		    }
		},
                item_beneficio: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>BENEF&Iacute;CIOS</strong>'
			}
		    }
		},
                fornecedor: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>FORNECEDOR</strong>'
			}
		    }
		},
                meio_social: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>COMO CONHECEU A VTCARDS?</strong>'
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
                muda_fornec_outro: {
                    validators: {
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>OUTROS MOTIVOS PARA MUDAN&Ccedil;A</strong> deve ter entre <strong>2</strong> e <strong>250</strong> caracteres'
                        },
                        callback: {
                            callback: function (value, validator, $field) {
                                var muda = $('#muda_fornecedor_4').is(':checked');
                                if (muda === true && value === "") {
                                    return {
                                        valid: false,
                                        message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>OUTROS MOTIVOS PARA MUDAN&Ccedil;A</strong>'
                                    };
                                }
                                return true;
                            }
                        }
                    }
                },
                nao_interesse_outro: {
                    validators: {
                        stringLength: {
                            min: 2,
                            max: 250,
                            message: 'O campo <strong>OUTROS MOTIVOS DO N&Atilde;O INTERESSE</strong> deve ter entre <strong>2</strong> e <strong>250</strong> caracteres'
                        },
                        callback: {
                            callback: function (value, validator, $field) {
                                var interesse = $('#nao_interesse_6').is(':checked');
                                if (interesse === true && value === "") {
                                    return {
                                        valid: false,
                                        message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>OUTROS MOTIVOS DO N&Atilde;O INTERESSE</strong>'
                                    };
                                }
                                return true;
                            }
                        }
                    }
                },
                contato: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>CONTATO</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 250,
                            message: 'O campo <strong>Contato</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                aceitou_proposta: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>PROPOSTA ACEITA</strong>'
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
            var url = "../prospeccao/doProspec";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    Mailing.modalMsg("MENSAGEM", data.msg, false, './gerenciar');
                } else {
                    Mailing.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_prospec_vt').removeAttr('disabled');
            }, 'json');

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
		Mailing.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Mailing.redirect(redirect);
		e.preventDefault();
	    });
	}

    },

    /*!
     * @description Método para exclusao de um registro
     **/
    del: function(id) {
        bootbox.dialog({
            message: "<i class='fa fa-exclamation-triangle'></i> Deseja realmente <strong>Excluir</strong> esse Mailing?",
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
                                Mailing.modalMsg("MENSAGEM", data.msg, false, false);
                                // Reload grid
                                $('#tbl_mail_vt').DataTable().ajax.reload();
                            } else {
                                Mailing.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
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
	    if (!((e.keyCode == 46) || (e.keyCode == 8) || (e.keyCode == 9)     // DEL, Backspace e Tab
		    || ((e.keyCode >= 35) && (e.keyCode <= 40))  // HOME, END, Setas
		    || ((e.keyCode >= 96) && (e.keyCode <= 105)) // Númerod Pad
		    || ((e.keyCode >= 48) && (e.keyCode <= 57))))
		e.preventDefault(); // Números
	});
    },

    /*!
     * @description Método para abrir modal do status
     **/
    modalProspec: function(title)
    {
        $("#title_modal_prospec").html(title);
        $("#modal_prospec").modal('show');
        window.setTimeout(function(){
            $(".select2").select2({
                dropdownParent: $("#modal_prospec")
            });
        }, 2000);
    },

    /*!
     * @description Método para cadastrar Prospeccao
     **/
    abrirProspeccao: function(id_mailing, id_prospec)
    {
        // Abrir modal
        Mailing.modalProspec("Prospec&ccedil;&atilde;o");
        $("#mailing").val(id_mailing);
        $("#id_prospec").val(id_prospec);
        
        window.setTimeout(function(){
            if (id_prospec) {
            $.ajax({
                type     : "POST",
                url      : "./getProspec",
                async    : false,
                dataType : "json",
                data : {
                    id_prospec: id_prospec
                },
                success: function(data){
                    if (data.status === true) {
                        var item_benef = (data.dados[0].id_item_beneficio_fk) ? data.dados[0].id_item_beneficio_fk : '';
                        $('#item_beneficio').val(item_benef);
                        var id_fornec  = (data.dados[0].id_fornecedor_fk) ? data.dados[0].id_fornecedor_fk : '';
                        $('#fornecedor').val(id_fornec);
                        var meio_social  = (data.dados[0].id_meio_social_fk) ? data.dados[0].id_meio_social_fk : '';
                        $("input[type=radio][name=meio_social][value='"+meio_social+"']").attr('checked', 'checked');
                        var id_dist_benef = (data.dados[0].id_dist_beneficio_fk) ? data.dados[0].id_dist_beneficio_fk : '';
                        $('#dist_beneficio').val(id_dist_benef);
                        var id_atividade = (data.dados[0].id_ramo_atividade_fk) ? data.dados[0].id_ramo_atividade_fk : '';
                        $('#atividade').val(id_atividade);
                        var id_muda_fornec = (data.dados[0].id_muda_fornec_fk) ? data.dados[0].id_muda_fornec_fk : '';
                        $("input[type=radio][name=muda_fornecedor][value='"+id_muda_fornec+"']").attr('checked', 'checked');
                        var muda_fornec_outro = (data.dados[0].muda_fornec_outro) ? data.dados[0].muda_fornec_outro : '';
                        $('#muda_fornec_outro').val(muda_fornec_outro);
                        if (muda_fornec_outro) {
                            $("#row_muda_fornec").removeClass('hidden');
                        } else {
                            $("#row_muda_fornec").addClass('hidden');
                        }
                        var id_nao_interesse = (data.dados[0].id_nao_interesse_fk) ? data.dados[0].id_nao_interesse_fk : '';
                        $("input[type=radio][name=nao_interesse][value='"+id_nao_interesse+"']").attr('checked', 'checked');
                        var nao_interesse_outro = (data.dados[0].nao_interesse_outro) ? data.dados[0].nao_interesse_outro : '';
                        $('#nao_interesse_outro').val(nao_interesse_outro);
                        if (nao_interesse_outro) {
                            $("#row_nao_interesse").removeClass('hidden');
                        } else {
                            $("#row_nao_interesse").addClass('hidden');
                        }
                        var contato = (data.dados[0].contato) ? data.dados[0].contato : '';
                        $('#contato').val(contato);
                        var taxa = (data.dados[0].taxa) ? data.dados[0].taxa : '';
                        $('#taxa_adm').val(taxa);
                        var aceitou = (data.dados[0].aceitou_proposta) ? data.dados[0].aceitou_proposta : '';
                        $("input[type=radio][name=aceitou_proposta][value='"+aceitou+"']").attr('checked', 'checked');
                        var aceitou = (data.dados[0].dt_retorno) ? (data.dados[0].dt_retorno).split('-') : '';
                        $('#dt_retorno').val((aceitou) ? aceitou[2]+'/'+aceitou[1]+'/'+aceitou[0] : '');
                        var obs = (data.dados[0].observacao) ? data.dados[0].observacao : '';
                        $('#obs').val(obs);
                    } else {
                        $('#item_beneficio').val('');
                        $('#fornecedor').val('');
                        $("input[type=radio][name=meio_social]").removeAttr('checked');
                        $('#dist_beneficio').val('');
                        $('#atividade').val('');
                        $("input[type=radio][name=muda_fornecedor]").removeAttr('checked');
                        $('#muda_fornec_outro').val('');
                        $("#row_muda_fornec").addClass('hidden');
                        $("input[type=radio][name=nao_interesse]").removeAttr('checked');
                        $('#nao_interesse_outro').val('');
                        $("#row_nao_interesse").addClass('hidden');
                        $('#contato').val('');
                        $('#taxa').val('');
                        $("input[type=radio][name=aceitou_proposta]").removeAttr('checked');
                        $('#dt_retorno').val('');
                        $('#obs').val('');
                    }
                },
                error: function(){
                    $('#item_beneficio').val('');
                    $('#fornecedor').val('');
                    $("input[type=radio][name=meio_social]").removeAttr('checked');
                    $('#dist_beneficio').val('');
                    $('#atividade').val('');
                    $("input[type=radio][name=muda_fornecedor]").removeAttr('checked');
                    $('#muda_fornec_outro').val('');
                    $("#row_muda_fornec").addClass('hidden');
                    $("input[type=radio][name=nao_interesse]").removeAttr('checked');
                    $('#nao_interesse_outro').val('');
                    $("#row_nao_interesse").addClass('hidden');
                    $('#contato').val('');
                    $('#taxa').val('');
                    $("input[type=radio][name=aceitou_proposta]").removeAttr('checked');
                    $('#dt_retorno').val('');
                    $('#obs').val('');
                }
            });
            
            /* $.post('./getProspec', {
                id_prospec: id_prospec
            }, function(data){
                if (data.status === true) {
                    var item_benef = (data.dados[0].id_item_beneficio_fk) ? data.dados[0].id_item_beneficio_fk : '';
                    $('#item_beneficio').val(item_benef);
                    var id_fornec  = (data.dados[0].id_fornecedor_fk) ? data.dados[0].id_fornecedor_fk : '';
                    $('#fornecedor').val(id_fornec);
                    var meio_social  = (data.dados[0].id_meio_social_fk) ? data.dados[0].id_meio_social_fk : '';
                    $("input[type=radio][name=meio_social][value='"+meio_social+"']").attr('checked', 'checked');
                    var id_dist_benef = (data.dados[0].id_dist_beneficio_fk) ? data.dados[0].id_dist_beneficio_fk : '';
                    $('#dist_beneficio').val(id_dist_benef);
                    var id_atividade = (data.dados[0].id_ramo_atividade_fk) ? data.dados[0].id_ramo_atividade_fk : '';
                    $('#atividade').val(id_atividade);
                    var id_muda_fornec = (data.dados[0].id_muda_fornec_fk) ? data.dados[0].id_muda_fornec_fk : '';
                    $("input[type=radio][name=muda_fornecedor][value='"+id_muda_fornec+"']").attr('checked', 'checked');
                    var muda_fornec_outro = (data.dados[0].muda_fornec_outro) ? data.dados[0].muda_fornec_outro : '';
                    $('#muda_fornec_outro').val(muda_fornec_outro);
                    if (muda_fornec_outro) {
                        $("#row_muda_fornec").removeClass('hidden');
                    } else {
                        $("#row_muda_fornec").addClass('hidden');
                    }
                    var id_nao_interesse = (data.dados[0].id_nao_interesse_fk) ? data.dados[0].id_nao_interesse_fk : '';
                    $("input[type=radio][name=nao_interesse][value='"+id_nao_interesse+"']").attr('checked', 'checked');
                    var nao_interesse_outro = (data.dados[0].nao_interesse_outro) ? data.dados[0].nao_interesse_outro : '';
                    $('#nao_interesse_outro').val(nao_interesse_outro);
                    if (nao_interesse_outro) {
                        $("#row_nao_interesse").removeClass('hidden');
                    } else {
                        $("#row_nao_interesse").addClass('hidden');
                    }
                    var contato = (data.dados[0].contato) ? data.dados[0].contato : '';
                    $('#contato').val(contato);
                    var taxa = (data.dados[0].taxa) ? data.dados[0].taxa : '';
                    $('#taxa').val(taxa);
                    var aceitou = (data.dados[0].aceitou_proposta) ? data.dados[0].aceitou_proposta : '';
                    $("input[type=radio][name=aceitou_proposta][value='"+aceitou+"']").attr('checked', 'checked');
                    var aceitou = (data.dados[0].dt_retorno) ? (data.dados[0].dt_retorno).split('-') : '';
                    $('#dt_retorno').val((aceitou) ? aceitou[2]+'/'+aceitou[1]+'/'+aceitou[0] : '');
                    var obs = (data.dados[0].observacao) ? data.dados[0].observacao : '';
                    $('#obs').val(obs);
                }
            }, 'json'); */
            
        } else {
            $('#item_beneficio').val('');
            $('#fornecedor').val('');
            $("input[type=radio][name=meio_social]").removeAttr('checked');
            $('#dist_beneficio').val('');
            $('#atividade').val('');
            $("input[type=radio][name=muda_fornecedor]").removeAttr('checked');
            $('#muda_fornec_outro').val('');
            $("#row_muda_fornec").addClass('hidden');
            $("input[type=radio][name=nao_interesse]").removeAttr('checked');
            $('#nao_interesse_outro').val('');
            $("#row_nao_interesse").addClass('hidden');
            $('#contato').val('');
            $('#taxa').val('');
            $("input[type=radio][name=aceitou_proposta]").removeAttr('checked');
            $('#dt_retorno').val('');
            $('#obs').val('');
        }
        }, 1000);
    },

};

$(document).ready(function () {
    Mailing.main();
});