Bencard = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {
        // Botao voltar
        $('#btn_back').click(function(){
            Bencard.redirect('../gerenciar');
        });

        // Botao Cancelar Beneficio
        $('#cancel_benef').click(function(){
            $("#modal_benef").modal('hide');
        });

        // Botao Cancelar Beneficio em cadastro na Editar
        $('#cancel_benedit').click(function(){
            $("#modal_benedit").modal('hide');
        });

        // Botao Cancelar Beneficio em Editar
        $('#cancel_benedit_func').click(function(){
            $("#modal_benedit_func").modal('hide');
        });
        
        $('#modal_benedit_func').on('hidden.bs.modal', function(e) {
            $("#grp_edit").val('');
            $("#beneficio_edit").val('');
            $("#vl_unitario_edit").val('0,00');
            $("#qtd_dia_edit").val('');
            $("#cartao_edit").val('');
            $("#div_cartao_edit").addClass('hidden');
            $("#num_cartao_edit").val('');
            $("#status_card_edit").val('');
        });

        // Mascara
        Bencard.onlyNumber('qtd_dia');
        $("#vl_unitario").maskMoney({
            thousands : '.',
            decimal   : ','
        });
        Bencard.onlyNumber('qtd_dia_edit');
        $("#vl_unitario_edit").maskMoney({
            thousands : '.',
            decimal   : ','
        });
        // $(".select2").select2();

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

        // Show / Hide Cartao Editar
        $('#cartao_edit').change(function(){
            var vl_card = $(this).val() ;
            if (vl_card === "1"){
                $("#div_cartao_edit").removeClass('hidden');
            } else {
                $("#div_cartao_edit").addClass('hidden');
                $("#num_cartao_edit").val('');
                $("#status_card_edit").val('');
            }
        });

        // Buscar Valor Unitario
        $('#beneficio_edit').change(function(){
           var id_func = $(this).val();
           if (id_func !== ""){
                $.post('/'+pathproj+'/beneficiocartao/getVlUnit', {
                    id : id_func
                }, function(data){
                    if (data.status === true) {
                        // Bencard.modalMsg("MENSAGEM", data.msg, false, false);
                        var vl_unit = data.dados[0].vl_unitario;
                        $("#vl_unitario_edit").val(Bencard.formatMoneyBr(vl_unit, 2, ',', '.'));
                    } else {
                        $("#vl_unitario_edit").val('');
                    }
                }, 'json');
           }
        });

        // Buscar Beneficios por Grupo
        $('#grp_edit').change(function(){
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
                    $("#beneficio_edit").html(option);
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
                grp: {
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

        // Bencard Cadastrar TMP
        $('#frm_cad_bencard_func').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                grp: {
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
                        }
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
            var url = '/'+pathproj+'/beneficiocartao/createModal';

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    // Limpar Formulario
                    $('#frm_cad_bencard_func').each(function () {
                        this.reset();
                    });
                    $('#frm_cad_bencard_func').bootstrapValidator('resetForm', true);
                    Bencard.getBeneficioTmp();
                    Bencard.modalMsg("MENSAGEM", data.msg);
                    $("#modal_benef").modal('hide');
                } else {
                    Bencard.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_bencard').removeAttr('disabled');
            }, 'json');

        });

        // Bencard Cadastro pela Edicao do Funcionario
        $('#frm_cad_benfunc_edit').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                grp: {
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
            var url = '/'+pathproj+'/beneficiocartao/createModalEdit';

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    // Limpar Formulario
                    $('#frm_cad_benfunc_edit').each(function () {
                        this.reset();
                    });
                    $('#frm_cad_benfunc_edit').bootstrapValidator('resetForm', true);
                    Bencard.getBeneficio();
                    Bencard.modalMsg("MENSAGEM", data.msg);
                    $("#modal_benedit").modal('hide');
                } else {
                    Bencard.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_cad_bencard').removeAttr('disabled');
            }, 'json');

        });

        // Bencard Editar pela Edicao do Funcionario
        $('#frm_cad_benef_edit_func').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                grp_edit: {
                    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>GRUPO</strong>'
			}
		    }
		},
                beneficio_edit: {
                    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>BENEF&Iacute;CIO</strong>'
			}
		    }
		},
                vl_unitario_edit: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>VALOR UNIT&Aacute;RIO</strong>'
                        },
                    }
                },
                qtd_dia_edit: {
                    validators: {
                        notEmpty: {
                            message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>QUANTIDADE DE DIAS</strong>'
                        }
                    }
                },
                num_cartao_edit: {
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
                status_card_edit: {
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
            var url = '/'+pathproj+'/beneficiocartao/updateModalEdit';

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    // Limpar Formulario
                    $('#frm_cad_benef_edit_func').each(function () {
                        this.reset();
                    });
                    $('#frm_cad_benef_edit_func').bootstrapValidator('resetForm', true);
                    Bencard.getBeneficio();
                    Bencard.modalMsg("MENSAGEM", data.msg);
                    $("#modal_benedit_func").modal('hide');
                } else {
                    Bencard.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }

                $('#btn_edit_bencard').removeAttr('disabled');
            }, 'json');

        });
        
        // Listar Beneficios
        Bencard.getBeneficio();

    },

    /*!
     * @description Método para buscar Beneficio Temporarios
     **/
    getBeneficioTmp: function() {
        var id_func = $("#num_tmp").val();
        if (id_func) {
            $.post('/'+pathproj+'/beneficiocartao/buscarBenefTmp', {id_func: id_func}, function (data) {
                if (data.status === true) {
                    // Bencard.modalMsg("MENSAGEM", data.msg);
                    var html = '';
                    $.each(data.dados, function(key, value){
                        html += '<tr>';
                        html +=     '<td>'+value.descricao+'</td>';
                        html +=     '<td class="text-center">'+value.vl_unitario+'</td>';
                        html +=     '<td class="text-center">'+value.qtd_diaria+'</td>';
                        html +=     '<td class="text-center">'+value.acao+'</td>';
                        html += '</tr>';
                    });
                    $("#list_benef").html(html);
                } else {
                    var html = '';
                        html += '<tr>';
                        html +=     '<td colspan="4">Nenhum Benef&iacute;cio Adicionado</td>';
                        html += '</tr>';
                    $("#list_benef").html(html);
                }
            }, 'json');
        } else {
            var html = '';
                html += '<tr>';
                html +=     '<td colspan="4">Nenhum Benef&iacute;cio Adicionado</td>';
                html += '</tr>';
            $("#list_benef").html(html);
            // Bencard.modalMsg("Aten&ccedil;&atilde;o", "Houve um erro na listagem dos Benef&iacute;cios! Tente novamente...");
        }
    },

    /*!
     * @description Método para buscar Beneficio
     **/
    getBeneficio: function() {        
        var id_func = $("#id_func").val();
        if (id_func) {
            $.post('/'+pathproj+'/beneficiocartao/buscarBeneficios', {id_func: id_func}, function (data) {
                if (data.status === true) {
                    // Bencard.modalMsg("MENSAGEM", data.msg);
                    var html = '';
                    $.each(data.dados, function(key, value){
                        html += '<tr>';
                        html +=     '<td>'+value.descricao+'</td>';
                        html +=     '<td class="text-center">'+value.vl_unitario+'</td>';
                        html +=     '<td class="text-center">'+value.qtd_diaria+'</td>';
                        html +=     '<td class="text-center">'+value.acao+'</td>';
                        html += '</tr>';
                    });
                    $("#list_benef_edit").html(html);
                } else {
                    var html = '';
                        html += '<tr>';
                        html +=     '<td colspan="4">Nenhum Benef&iacute;cio Adicionado</td>';
                        html += '</tr>';
                    $("#list_benef_edit").html(html);
                }
            }, 'json');
        } else {
            var html = '';
                html += '<tr>';
                html +=     '<td colspan="4">Nenhum Benef&iacute;cio Adicionado</td>';
                html += '</tr>';
            $("#list_benef_edit").html(html);
            // Bencard.modalMsg("Aten&ccedil;&atilde;o", "Houve um erro na listagem dos Benef&iacute;cios! Tente novamente...");
        }
    },

    /*!
     * @description Método para abrir modal de edicao de Beneficio
     **/
    editBenef: function(id_benef) {
        $("#modal_benedit_func").modal('show');
        $("#id_benef").val(id_benef);
        $.post('/'+pathproj+'/beneficiocartao/getBenefId', {id_benef: id_benef}, function (data) {
            if (data.status === true) {
                // Bencard.modalMsg("MENSAGEM", data.msg);
                $("#grp_edit").val(data.dados[0].id_grupo);
                $("#beneficio_edit").val(data.dados[0].id_beneficio);
                $("#vl_unitario_edit").val(data.dados[0].vl_unitario);
                $("#qtd_dia_edit").val(data.dados[0].qtd_diaria);
                $("#cartao_edit").val(data.dados[0].cartao);
                if (data.dados[0].cartao === "1"){
                    $("#div_cartao_edit").removeClass('hidden');
                } else {
                    $("#div_cartao_edit").addClass('hidden');
                    $("#num_cartao_edit").val('');
                    $("#status_card_edit").val('');
                }
                $("#num_cartao_edit").val(data.dados[0].num_cartao);
                $("#status_card_edit").val(data.dados[0].id_st_card);
            } else {
                Bencard.modalMsg("Aten&ccedil;&atilde;o", data.msg);
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
        // Document Location
        var currentLocation = window.location;
        var parser          = document.createElement('a');
            parser.href     = currentLocation;
        var pathname        = parser.pathname;
        var pathproj        = pathname.split('/')[1];

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
                        $.post('/'+pathproj+'/beneficiocartao/delete', {
                            id: id
                        },function(data){
                            if (data.status === true) {
                                Bencard.modalMsg("MENSAGEM", data.msg, false, false);
                                // Reload grid
                                // $('#tbl_benefcard').DataTable().ajax.reload();
                                Bencard.getBeneficio();
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
     * @description Método para exclusao de um Beneficio pelo Modal
     **/
    delModal: function(id) {
        // Document Location
        var currentLocation = window.location;
        var parser          = document.createElement('a');
            parser.href     = currentLocation;
        var pathname        = parser.pathname;
        var pathproj        = pathname.split('/')[1];
        
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
                        $.post('/'+pathproj+'/beneficiocartao/deleteModal', {
                            id: id
                        },function(data){
                            if (data.status === true) {
                                Bencard.modalMsg("MENSAGEM", data.msg, false, false);
                                Bencard.getBeneficioTmp();
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