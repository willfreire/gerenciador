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
        $(".select2").select2();

        // Calendario
        $('.datepicker').datepicker({
            orientation: 'bottom',
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            startDate: new Date(),
            endDate: '+1m',
            clearBtn: true
        });

        // Calendario Periodo
        moment.locale('pt-br');
        $('#periodo').daterangepicker({
            drops: 'up',
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

        // Pedido - Selecionar Cliente
        $('#frm_cad_selcliente').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                id_empresa: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>ID - CNPJ - RAZ&Atilde;O SOCIAL</strong>'
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
            var url = "./selCliente";

            // Use Ajax to submit form data
            $.post(url, frm, function (data) {
                if (data.status === true) {
                    // Pedido.modalMsg("MENSAGEM", data.msg, false, './gerenciar');
                    Pedido.redirect('./solicitar');
                } else {
                    Pedido.modalMsg("Aten&ccedil;&atilde;o", data.msg);
                }
                $('#btn_cad_pedido').removeAttr('disabled');
            }, 'json');

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
			    message: 'Informe um <strong>PER&Iacute;ODO DE UTILIZA&Ccedil;&Atilde;O</strong> v&aacute;lido!'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>PER&Iacute;ODO DE UTILIZA&Ccedil;&Atilde;O</strong>'
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
			    message: 'Informe um <strong>PER&Iacute;ODO DE UTILIZA&Ccedil;&Atilde;O</strong> v&aacute;lido!'
			},
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio o preenchimento do campo <strong>PER&Iacute;ODO DE UTILIZA&Ccedil;&Atilde;O</strong>'
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
                    var url_boleto = 'http://'+hostname+'/'+pathproj+'/pedido/gerarboleto/'+data.id_pedido+'';
                    Pedido.modalMsg("MENSAGEM", data.msg, false, url_boleto);
                    // Pedido.openWindow('http://'+hostname+'/'+pathproj+'/pedido/gerarboleto/'+data.id_pedido, '_blank');
                } else {
                    Pedido.modalMsg("Aten&ccedil;&atilde;o", data.msg, false, data.url);
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
     * @description Ver Boleto
     **/
    verBoleto: function (id_pedido) {
        var currentLocation = window.location;
        var parser          = document.createElement('a');
        parser.href         = currentLocation;
        var hostname        = parser.hostname;
        var pathname        = parser.pathname;
        var pathproj        = pathname.split('/')[1];
        var url_boleto      = "http://"+hostname+"/"+pathproj+"/pedido/remitirboletohtml/"+id_pedido;
        //var url_boleto      = "http://"+hostname+"/"+pathproj+"/assets/boletos/"+nome;
        Pedido.openWindow(url_boleto, "_blank");
    },

    /*!
     * @description Método para exclusao de um registro
     **/
    exportPedido: function(id_pedido) {
        // Atribuir valores
        var currentLocation = window.location;
        var parser          = document.createElement('a');
            parser.href     = currentLocation;
        var hostname        = parser.hostname;
        var pathname        = parser.pathname;
        var pathproj        = pathname.split('/')[1];
        var link            = "http://"+hostname+"/"+pathproj+"/pedido/exportPedidoXls";
        var table           = '';
        var name            = '';

        // Msg de exportação
        Pedido.modalMsg("Exportar Excel", "Aguarde, Processando...");

        $.post(link, {id: id_pedido}, function(data){

            if (data.status === true) {
                name = "Pedido Solicitado";

                table += '<table border="1" bordercolor="000" cellspacing="0" cellpadding="0">';
                table +=    '<tr bgcolor="#CCCCCC">';
                table +=        '<td align="center">';
                table +=            '<strong>Número do Pedido</strong>';
                table +=        '</td>';
                table +=        '<td align="center">';
                table +=            '<strong>CNPJ</strong>';
                table +=        '</td>';
                table +=	'<td>';
                table +=            '<strong>Nome da Empresa</strong>';
                table +=	'</td>';
                table +=        '<td align="center">';
                table +=            '<strong>CPF</strong>';
                table +=        '</td>';
                table +=	'<td align="center">';
                table +=            '<strong>RG</strong>';
                table +=	'</td>';
                table +=	'<td>';
                table +=            '<strong>Nome do Funcionário</strong>';
                table +=        '</td>';
                table +=	'<td align="center">';
                table +=            '<strong>Código do Benefício</strong>';
                table +=        '</td>';
                table +=	'<td>';
                table +=            '<strong>Descrição do Benefício</strong>';
                table +=        '</td>';
                table +=	'<td align="center">';
                table +=            '<strong>Valor Unitário</strong>';
                table +=        '</td>';
                table +=	'<td align="center">';
                table +=            '<strong>Quantidade Diária</strong>';
                table +=        '</td>';
                table +=	'<td align="center">';
                table +=            '<strong>Valor Total</strong>';
                table +=        '</td>';
                table +=	'<td align="center">';
                table +=            '<strong>Número do Cartão</strong>';
                table +=        '</td>';
                table +=    '</tr>';
                $.each(data.dados, function (key, value) {
                    table += '<tr>';
                    table +=    '<td align="center"> ';
                    table +=        (value.id_pedido) ? value.id_pedido : '';
                    table +=    '</td>';
                    table +=    '<td align="center">';
                    table +=        (value.cnpj) ? value.cnpj : '';
                    table +=    '</td>';
                    table +=	'<td>';
                    table +=        (value.nome_razao) ? value.nome_razao : '';
                    table +=	'</td>';
                    table +=    '<td align="center">';
                    table +=        (value.cpf) ? value.cpf : '';
                    table +=    '</td>';
                    table +=	'<td align="center">';
                    table +=        (value.rg) ? value.rg : '';
                    table +=	'</td>';
                    table +=	'<td>';
                    table +=        (value.nome) ? value.nome : '';
                    table +=    '</td>';
                    table +=	'<td align="center">';
                    table +=        (value.id_item) ? value.id_item : '';
                    table +=    '</td>';
                    table +=	'<td>';
                    table +=        (value.descricao) ? value.descricao : '';
                    table +=    '</td>';
                    table +=	'<td align="center">';
                    table +=        (value.vl_unitario) ? value.vl_unitario : '';
                    table +=    '</td>';
                    table +=	'<td align="center">';
                    table +=        (value.qtde_diaria) ? value.qtde_diaria : '';
                    table +=    '</td>';
                    table +=    '<td align="center">';
                    table +=        (value.vl_total) ? value.vl_total : '';
                    table +=    '</td>';
                    table +=	'<td align="center">';
                    table +=        (value.num_cartao) ? value.num_cartao : '';
                    table +=    '</td>';
                    table += '</tr>';
                });
                table += '</table>';

                // Fecha modal
                $('#msg_modal').modal('hide');

                // Gerar excel
                Pedido.createExcel(name, table);
            } else {
                Pedido.boxMsg("ATEN&Ccedil;&Atilde;O", data.msg, null, null);
            }

        }, 'json');

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
	    if (!((e.keyCode == 46) || (e.keyCode == 8) || (e.keyCode == 9) // DEL, Backspace e Tab
                    || (e.keyCode == 17) || (e.keyCode == 91) || (e.keyCode == 86) || (e.keyCode == 67) // Ctrl+C / Ctrl+V
		    || ((e.keyCode >= 35) && (e.keyCode <= 40)) // HOME, END, Setas
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
     * @description Método para validar credito
     **/
    validaCredito: function(id_pedido)
    {
        // Buscar Itens Beneficios
        $.post('./itemBenPedido', {
            id: id_pedido
        }, function(data){
            if (data.status === true){
                var link_valida = '(<a href="javascript:void()" onclick="Pedido.validaAllCredit(\'2\', \''+id_pedido+'\')">Habilitados</a> | <a href="javascript:void()" onclick="Pedido.validaAllCredit(\'3\', \''+id_pedido+'\')">Cancelados</a>)';
                $("#link_valida").html(link_valida);
                var html = '';
                $.each(data.dados, function(key, value){
                    html += '<tr>';
                    html +=     '<td>'+value.cpf+'</td>';
                    html +=     '<td>'+value.nome+'</td>';
                    html +=     '<td>'+value.descricao+'</td>';
                    html +=     '<td>'+value.st_benef+'</td>';
                    html += '</tr>';
                });
                $("#lst_benef").html(html);
                $("#modal_credito").modal('show');
            } else {
                Pedido.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
            }
        }, 'json');
    },

    /*!
     * @description Método para alterar Status do Credito do Beneficio
     **/
    setValBen: function(status, id_benef, id_pedido)
    {
        if (status !== "" && id_benef !== "") {
            $.post('./valCredBen', {
                st: status,
                id: id_benef
            }, function(data){
                if (data.status === true) {
                    Pedido.modalMsg("MENSAGEM", data.msg, false, false);
                    Pedido.validaCredito(id_pedido);
                } else {
                    Pedido.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
                }
            }, 'json');
        } else {
            Pedido.modalMsg("ATEN&Ccedil;&Atilde;O", "Houve um erro na Valida&ccedil;&atilde;o dos Cr&eacute;ditos! Favor recarregar a p&aacute;gina.");
        }
    },

    /*!
     * @description Método para alterar todos status do Credito do Beneficio por Pedido
     **/
    validaAllCredit: function(status, id_pedido)
    {
        if (status !== "" && id_pedido !== "") {
            $.post('./valAllCredBen', {
                st: status,
                id: id_pedido
            }, function(data){
                if (data.status === true) {
                    Pedido.modalMsg("MENSAGEM", data.msg, false, false);
                    Pedido.validaCredito(id_pedido);
                } else {
                    Pedido.modalMsg("ATEN&Ccedil;&Atilde;O", data.msg, false, false);
                }
            }, 'json');
        } else {
            Pedido.modalMsg("ATEN&Ccedil;&Atilde;O", "Houve um erro na Valida&ccedil;&atilde;o dos Cr&eacute;ditos! Favor recarregar a p&aacute;gina.");
        }
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

    /*!
     * @description Metodo responsavel por gerar arquivo excel
     **/
    createExcel: function (txt_name, html_table)
    {
        // Iniciar variaveis
        var name = txt_name;
        var table = html_table;

        var uri = 'data:application/vnd.ms-excel;base64,',
                template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>{table}</body></html>',
                base64 = function (s) {
                    return Pedido.base64_encode(s);
                },
                format = function (s, c) {
                    return s.replace(/{(\w+)}/g, function (m, p) {
                        return c[p];
                    });
                };

        var ctx = {worksheet: name || 'Worksheet', table: table};
        window.location.href = uri + base64(format(template, ctx));
    },

    /*!
     * @description Encoding to base64
     **/
    base64_encode: function (data)
    {
        var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
        var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
                ac = 0,
                enc = "",
                tmp_arr = [];

        if (!data) {
            return data;
        }

        do { // pack three octets into four hexets
            o1 = data.charCodeAt(i++);
            o2 = data.charCodeAt(i++);
            o3 = data.charCodeAt(i++);

            bits = o1 << 16 | o2 << 8 | o3;

            h1 = bits >> 18 & 0x3f;
            h2 = bits >> 12 & 0x3f;
            h3 = bits >> 6 & 0x3f;
            h4 = bits & 0x3f;

            // use hexets to index into b64, and append result to encoded string
            tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
        } while (i < data.length);

        enc = tmp_arr.join('');

        var r = data.length % 3;

        return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
    }

};

$(document).ready(function () {
    Pedido.main();
});
