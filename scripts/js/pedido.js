Pedido = {

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
            Pedido.redirect('../acompanhar');
        });
        $('#btn_back_vt').click(function(){
            Pedido.redirect('../gerenciar');
        });

        // Mascara
        $("#dt_pgto").mask("99/99/9999");

        // Calendario
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            startDate: new Date(),
            endDate: '+1m',
            clearBtn: true
        });

        // Calendario Periodo
        moment.locale('pt-br');
        $('#periodo').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY',
                separator: " - ",
                applyLabel: "Ok",
                cancelLabel: "Cancelar",
                fromLabel: "De",
                toLabel: "a",
                customRangeLabel: "Custom",
                startDate: new Date()
            }
        });

        // Pedido Cadastrar
        $('#frm_cad_pedido').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                id_empresa: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>CNPJ - RAZ&Atilde;O SOCIAL</strong>'
			}
		    }
		},
                id_end_entrega: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>ENDERE&Ccedil;O PARA ENTREGA</strong>'
			}
		    }
		},
                nome_resp: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>NOME DO RESPONS&Aacute;VEL</strong>'
                        },
                        stringLength: {
                            min: 4,
                            max: 250,
                            message: 'O campo <strong>NOME DO RESPONS&Aacute;VEL</strong> deve ter entre <strong>4</strong> e <strong>250</strong> caracteres'
                        }
                    }
                },
                dt_pgto: {
                    trigger: 'blur',
		    validators: {
                        stringLength: {
			    min: 10,
			    max: 10,
			    message: 'Informe uma <strong>DATA DE PAGAMENTO</strong> v&aacute;lida!'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DATA DE PAGAMENTO</strong>'
			}
		    }
		},
                periodo: {
                    trigger: 'blur',
		    validators: {
                        stringLength: {
			    min: 23,
			    max: 23,
			    message: 'Informe um <strong>PER&Iacute;ODO DO BENEF&Iacute;CIO</strong> v&aacute;lido!'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>PER&Iacute;ODO DO BENEF&Iacute;CIO</strong>'
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
                    // Pedido.modalMsg("MENSAGEM", data.msg, false, './gerenciar');
                    Pedido.redirect('./finalizar/'+data.id_pedido);
                } else {
                    Pedido.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }
                $('#btn_cad_pedido').removeAttr('disabled');
            }, 'json');

        });

        // Pedido Editar
        $('#frm_edit_pedido').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                dt_pgto: {
                    trigger: 'blur',
		    validators: {
                        stringLength: {
			    min: 10,
			    max: 10,
			    message: 'Informe uma <strong>DATA DE PAGAMENTO</strong> v&aacute;lida!'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>DATA DE PAGAMENTO</strong>'
			}
		    }
		},
                periodo: {
                    trigger: 'blur',
		    validators: {
                        stringLength: {
			    min: 23,
			    max: 23,
			    message: 'Informe um <strong>PER&Iacute;ODO DO BENEF&Iacute;CIO</strong> v&aacute;lido!'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>PER&Iacute;ODO DO BENEF&Iacute;CIO</strong>'
			}
		    }
		},
                'id_funcionario[]': {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o de um ou mais <strong>Funcion&aacute;rio</strong> no campo <strong>LISTA DE BENEFICI&Aacute;RIOS</strong>'
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
                    Pedido.modalMsg("MENSAGEM", data.msg, false, '../acompanhar');
                    Pedido.openWindow('/'+pathproj+'/pedido/gerarboleto/'+data.id_pedido, '_blank');
                } else {
                    Pedido.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_edit_pedido').removeAttr('disabled');
            }, 'json');

        });

        // Limpar validacao
        $("#modal_status").on('hidden.bs.modal', function() {
            // Limpar Validacao
            $('#frm_alter_status').bootstrapValidator('resetForm', true);
        });
        
        // Validar formulario Status
        $('#frm_alter_status').bootstrapValidator({
            framework : 'bootstrap',
            excluded  : ':disabled',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                status: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>STATUS</strong>'
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
            var url = "./alterStatusPedido";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    // Msg
                    Pedido.modalMsg("MENSAGEM", data.msg, false, false);
                    // Fechar Modal
                    $('#modal_status').modal('hide');
                    // Limpar Formulario
                    $('#frm_alter_status').each(function () {
                        this.reset();
                    });
                    // Limpar Validacao
                    $('#frm_alter_status').bootstrapValidator('resetForm', true);
                    // Reload grid
                    $('#tbl_pedido').DataTable().ajax.reload();
                } else {
                    Pedido.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg);
                }
                $('#alt_status').removeAttr('disabled');
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
		Pedido.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Pedido.redirect(redirect);
		e.preventDefault();
	    });
	}

    },

    /*!
     * @description Método para exclusao de um registro
     **/
    delBtnCancel: function(id) {
        bootbox.dialog({
            message: "<i class='fa fa-exclamation-triangle'></i> Deseja realmente <strong>Excluir</strong> esse Pedido?",
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
                        $.post('../delete', {
                            id: id
                        },function(data){
                            if (data.status === true) {
                                Pedido.modalMsg("MENSAGEM", data.msg, false, './');
                            } else {
                                Pedido.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
                            }
                        }, 'json');
                    }
                }
            }
        });
    },

    /*!
     * @description Método para exclusao de um registro
     **/
    del: function(id) {
        bootbox.dialog({
            message: "<i class='fa fa-exclamation-triangle'></i> Deseja realmente <strong>Excluir</strong> esse Pedido?",
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
                                Pedido.modalMsg("MENSAGEM", data.msg, false, false);
                                // Reload grid
                                $('#tbl_pedido').DataTable().ajax.reload();
                            } else {
                                Pedido.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
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
    modalStatus: function(title)
    {
        $("#title_modal_status").html(title);
        $("#modal_status").modal('show');
    },
    
    /*!
     * @description Método para alterar Status
     **/
    alterStatus: function(id_pedido, id_status)
    {
        
        // Atribuir Dados
        $('#id_pedido_pk').val(id_pedido);

        var sel_status = '<option value="">Selecione</option>';

        if (id_status === "1") {
            sel_status += '<option value="1" selected="selected">Solicitado</option>';
        } else {
            sel_status += '<option value="1">Solicitado</option>';
        }

        if (id_status === "2") {
            sel_status += '<option value="2" selected="selected">Cancelado</option>';
        } else {
            sel_status += '<option value="2">Cancelado</option>';
        }

        if (id_status === "3") {
            sel_status += '<option value="3" selected="selected">Pendente</option>';
            $("#div_status_data").show();
        } else {
            sel_status += '<option value="3">Pendente</option>';
        }

        if (id_status === "4") {
            sel_status += '<option value="4" selected="selected">Pago</option>';
            $("#div_status_data").show();
        } else {
            sel_status += '<option value="4">Pago</option>';
        }

        $('#status').html(sel_status);

        // $("#status option[value="+id_status+"]").attr("selected", "selected");
        Pedido.modalStatus("Alterar Status do Pedido");

    },

};

$(document).ready(function () {
    Pedido.main();
});