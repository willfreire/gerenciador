Bencard = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        // Document Location
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
            Bencard.redirect('../gerenciar');
        });

        // Mascara
        Bencard.onlyNumber('qtd_dia');
        $("#vl_unitario").maskMoney({
            thousands : '.',
            decimal   : ','
        });
        $(".select2").select2();

        // Show / Hide Cartao
        $('input[type=radio][name=cartao]').click(function(){
            var vl_card = $('input[type=radio][name=cartao]:checked').val() ;
            if (vl_card === "1"){
                $("#div_cartao").removeClass('hidden');
            } else {
                $("#div_cartao").addClass('hidden');
                $("#num_cartao").val('');
                $("#status_card").val('');
            }
        });

        // Buscar Qtde dias
        $('#func').change(function(){
           var id_func = $(this).val();
           if (id_func !== ""){
                $.post('/'+pathproj+'/beneficiocartao/getQtdeDias', {
                    id : id_func
                }, function(data){
                    if (data.status === true) {
                        // Bencard.modalMsg("MENSAGEM", data.msg, false, false);
                        $("#qtd_dia").val(data.dados[0].qtd_dia);
                    } else {
                        $("#qtd_dia").val('');
                    }
                }, 'json');
           }
        });

        // Buscar Valor Unitario
        $('#beneficio').change(function(){
           var id_func = $(this).val();
           if (id_func !== ""){
                $.post('/'+pathproj+'/beneficiocartao/getVlUnit', {
                    id : id_func
                }, function(data){
                    if (data.status === true) {
                        // Bencard.modalMsg("MENSAGEM", data.msg, false, false);
                        var vl_unit = data.dados[0].vl_unitario;
                        $("#vl_unitario").val(Bencard.formatMoneyBr(vl_unit, 2, ',', '.'));
                    } else {
                        $("#vl_unitario").val('');
                    }
                }, 'json');
           }
        });

        // Buscar Beneficios por Grupo
        $('#grp').change(function(){
           var id_grp = $(this).val();
           if (id_grp !== ""){
                $.post('/'+pathproj+'/beneficiocartao/getBeneficioGrp', {
                    id : id_grp
                }, function(data){
                    if (data.status === true) {
                        // Bencard.modalMsg("MENSAGEM", data.msg, false, false);
                        var option = "<option value=''>Selecione</option>";
                        $.each(data.dados, function(key, value){
                            option += "<option value='"+value.id_item_beneficio_pk+"'>"+value.id_item_beneficio_pk+" - "+value.descricao+"</option>";
                        });
                    } else {
                        option += "<option value=''>Nenhum Benefício Encontrado</option>";
                    }
                    $("#beneficio").html(option);
                }, 'json');
           }
        });

        // Bencard Cadastrar
        $('#frm_cad_bencard').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                func: {
                    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>FUNCION&Aacute;RIO</strong>'
			}
		    }
		},
                grupo: {
                    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>GRUPO</strong>'
			}
		    }
		},
                beneficio: {
                    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>BENEF&Iacute;CIO</strong>'
			}
		    }
		},
                vl_unitario: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>VALOR UNIT&Aacute;RIO</strong>'
                        },
                    }
                },
                qtd_dia: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>QUANTIDADE DE DIAS</strong>'
                        }
                    }
                },
                num_cartao: {
                    validators: {
			callback: {
			    callback: function (value, validator, $field) {
				var card = $('input[type=radio][name=cartao]:checked').val();
				if (card === "1" && value === "") {
				    return {
					valid: false,
					message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>N&ordm; DO CART&Atilde;O</strong>'
				    };
				}
				return true;
			    }
			}
                    }
                },
                status_card: {
                    validators: {
			callback: {
			    callback: function (value, validator, $field) {
				var card = $('input[type=radio][name=cartao]:checked').val();
				if (card === "1" && value === "") {
				    return {
					valid: false,
					message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>STATUS DO CART&Atilde;O</strong>'
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
            var url = "./create";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    Bencard.modalMsg("MENSAGEM", data.msg, false, './gerenciar');
                } else {
                    Bencard.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_bencard').removeAttr('disabled');
            }, 'json');

        });

        // Bencard Editar
        $('#frm_edit_bencard').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nome_bencardo: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>PER&Iacute;ODO</strong>'
                        },
                        stringLength: {
                            min: 2,
                            max: 20,
                            message: 'O campo <strong>PER&Iacute;ODO</strong> deve ter entre <strong>2</strong> e <strong>20</strong> caracteres'
                        }
                    }
                },
                qtd_dia: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>QUANTIDADE DE DIAS</strong>'
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
                    Bencard.modalMsg("MENSAGEM", data.msg, false, '../gerenciar');
                } else {
                    Bencard.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_edit_bencard').removeAttr('disabled');
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
		Bencard.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Bencard.redirect(redirect);
		e.preventDefault();
	    });
	}

    },

    /*!
     * @description Método para exclusao de um registro
     **/
    del: function(id) {
        bootbox.dialog({
            message: "<i class='fa fa-exclamation-triangle'></i> Deseja realmente <strong>Excluir</strong> esse Benef&iacute;cio?",
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
                                Bencard.modalMsg("MENSAGEM", data.msg, false, false);
                                // Reload grid
                                $('#tbl_benefcard').DataTable().ajax.reload();
                            } else {
                                Bencard.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
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
    },

    /*!
     * @description Função para converter no formato dinheiro BR
     **/
    formatMoneyBr: function (valor, casas, separdor_decimal, separador_milhar) {

        var valor_total = parseInt(valor * (Math.pow(10, casas)));
        var inteiros    = parseInt(parseInt(valor * (Math.pow(10, casas))) / parseFloat(Math.pow(10, casas)));
        var centavos    = parseInt(parseInt(valor * (Math.pow(10, casas))) % parseFloat(Math.pow(10, casas)));

        if (centavos % 10 == 0 && centavos + "".length < 2) {
            centavos = centavos + "0";
        } else if (centavos < 10) {
            centavos = "0" + centavos;
        }

        var milhares = parseInt(inteiros / 1000);
        inteiros = inteiros % 1000;

        var retorno = "";

        if (milhares > 0) {
            retorno = milhares + "" + separador_milhar + "" + retorno
            if (inteiros == 0) {
                inteiros = "000";
            } else if (inteiros < 10) {
                inteiros = "00" + inteiros;
            } else if (inteiros < 100) {
                inteiros = "0" + inteiros;
            }
        }

        retorno += inteiros + "" + separdor_decimal + "" + centavos;

        return retorno;
    }

};

$(document).ready(function () {
    Bencard.main();
});