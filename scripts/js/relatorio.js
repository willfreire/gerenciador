Relatorio = {

    /*!
     * @description Chamada dos principais métodos
     **/
    main: function () {

        var currentLocation = window.location;
        var parser          = document.createElement('a');
            parser.href     = currentLocation;
        var pathname = parser.pathname;
        var pathproj = pathname.split('/')[1];

        // Botao voltar
        $('#btn_back').click(function(){
            Relatorio.redirect('/'+pathproj+'/');
        });

        // Calendario Periodo
        /* moment.locale('pt-br');
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
        }); */

        // Relatorio Funcionario
        $('#frm_rel_func').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                id_pedido: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>PEDIDO</strong>'
			}
		    }
		}
                /* periodo: {
                    trigger: 'blur',
		    validators: {
                        stringLength: {
			    min: 23,
			    max: 23,
			    message: 'Informe um <strong>PER&Iacute;ODO DE UTILIZA&Ccedil;&Atilde;O</strong> v&aacute;lido!'
			}
		    }
		} */
            }
        }).on('success.form.bv', function (e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            var frm = $form.serialize();
            var url = '/'+pathproj+'/relatorio/relFuncionario/'+Relatorio.base64_encode(frm);

            $("#btn_rel_func").removeAttr("disabled");

            Relatorio.openWindow(url, '_blank');
        });

        // Relatorio Pedido
        $('#frm_rel_ped').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                id_pedido: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>PEDIDO</strong>'
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

            // Atribuir valores
            var currentLocation = window.location;
            var parser          = document.createElement('a');
                parser.href     = currentLocation;
            var hostname        = parser.hostname;
            var pathname        = parser.pathname;
            var pathproj        = pathname.split('/')[1];
            var link            = "https://"+hostname+"/"+pathproj+"/relatorio/exportPedidoXls";
            var table           = '';
            var name            = '';
            var id_pedido       = $("#id_pedido").val();

            // Msg de exportação
            Relatorio.modalMsg("Exportar Excel", "Aguarde, Processando...");

            $.post(link, {id: id_pedido}, function(data){

                if (data.status === true) {
                    name = "Pedido Solicitado";

                    table += '<table border="1" bordercolor="000" cellspacing="0" cellpadding="0">';
                    table +=    '<tr bgcolor="#CCCCCC">';
                    table +=        '<td align="center">';
                    table +=            '<strong>Número do Pedido</strong>';
                    table +=        '</td>';
                    table +=        '<td>';
                    table +=            '<strong>Razão Social</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>CNPJ</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Matrícula</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>CPF</strong>';
                    table +=        '</td>';
                    table +=        '<td>';
                    table +=            '<strong>Nome do Funcionário</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Código do Benefício</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Valor Unitário</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Quantidade Diária</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Valor Total</strong>';
                    table +=        '</td>';
                    table +=        '<td>';
                    table +=            '<strong>Descrição do Benefício</strong>';
                    table +=        '</td>';
                    table +=    '</tr>';
                    $.each(data.dados, function (key, value) {
                        table += '<tr>';
                        table +=    '<td align="center"> ';
                        table +=        (value.id_pedido) ? value.id_pedido : '';
                        table +=    '</td>';
                        table +=    '<td>';
                        table +=        (value.nome_razao) ? value.nome_razao : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.cnpj) ? value.cnpj : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.matricula) ? value.matricula : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.cpf) ? value.cpf : '';
                        table +=    '</td>';
                        table +=    '<td>';
                        table +=        (value.nome) ? value.nome : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.id_item) ? value.id_item : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.vl_unitario) ? value.vl_unitario : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.qtde_diaria) ? value.qtde_diaria : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.vl_total) ? value.vl_total : '';
                        table +=    '</td>';
                        table +=    '<td>';
                        table +=        (value.descricao) ? value.descricao : '';
                        table +=    '</td>';
                        table += '</tr>';
                    });
                    table += '</table>';

                    // Fecha modal
                    $('#msg_modal').modal('hide');
                    $("#btn_rel_ped").removeAttr("disabled");

                    // Gerar excel
                    Relatorio.createExcel(name, table);
                } else {
                    Relatorio.boxMsg("ATEN&Ccedil;&Atilde;O", data.msg, null, null);
                }

            }, 'json');

        });

        // Relatorio Inconsistencia
        $('#frm_rel_incons').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                id_pedido: {
		    validators: {
			notEmpty: {
			    message: '&Eacute; obrigat&oacute;rio a sele&ccedil;&atilde;o do campo <strong>PEDIDO</strong>'
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

            // Atribuir valores
            var currentLocation = window.location;
            var parser          = document.createElement('a');
                parser.href     = currentLocation;
            var hostname        = parser.hostname;
            var pathname        = parser.pathname;
            var pathproj        = pathname.split('/')[1];
            var link            = "https://"+hostname+"/"+pathproj+"/relatorio/exportInconsXls";
            var table           = '';
            var name            = '';
            var id_pedido       = $("#id_pedido").val();

            // Msg de exportação
            Relatorio.modalMsg("Exportar Excel", "Aguarde, Processando...");

            $.post(link, {id: id_pedido}, function(data){

                if (data.status === true) {
                    name = "Pedido Inconsistência";

                    table += '<table border="1" bordercolor="000" cellspacing="0" cellpadding="0">';
                    table +=    '<tr bgcolor="#CCCCCC">';
                    table +=        '<td align="center">';
                    table +=            '<strong>Número do Pedido</strong>';
                    table +=        '</td>';
                    table +=        '<td>';
                    table +=            '<strong>Razão Social</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>CNPJ</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Matrícula</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>CPF</strong>';
                    table +=        '</td>';
                    table +=        '<td>';
                    table +=            '<strong>Nome do Funcionário</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Código do Benefício</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Valor Unitário</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Quantidade Diária</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Valor Total</strong>';
                    table +=        '</td>';
                    table +=        '<td align="center">';
                    table +=            '<strong>Status da Recarga</strong>';
                    table +=        '</td>';
                    table +=        '<td>';
                    table +=            '<strong>Descrição do Benefício</strong>';
                    table +=        '</td>';
                    table +=    '</tr>';
                    $.each(data.dados, function (key, value) {
                        table += '<tr>';
                        table +=    '<td align="center"> ';
                        table +=        (value.id_pedido) ? value.id_pedido : '';
                        table +=    '</td>';
                        table +=    '<td>';
                        table +=        (value.nome_razao) ? value.nome_razao : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.cnpj) ? value.cnpj : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.matricula) ? value.matricula : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.cpf) ? value.cpf : '';
                        table +=    '</td>';
                        table +=    '<td>';
                        table +=        (value.nome) ? value.nome : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.id_item) ? value.id_item : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.vl_unitario) ? value.vl_unitario : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.qtde_diaria) ? value.qtde_diaria : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        (value.vl_total) ? value.vl_total : '';
                        table +=    '</td>';
                        table +=    '<td align="center">';
                        table +=        'Recarga Lberada no Cartão';
                        table +=    '</td>';
                        table +=    '<td>';
                        table +=        (value.descricao) ? value.descricao : '';
                        table +=    '</td>';
                        table += '</tr>';
                    });
                    table += '</table>';

                    // Fecha modal
                    $('#msg_modal').modal('hide');
                    $("#btn_rel_incons").removeAttr("disabled");

                    // Gerar excel
                    Relatorio.createExcel(name, table);
                } else {
                    Relatorio.boxMsg("ATEN&Ccedil;&Atilde;O", data.msg, null, null);
                }

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
		Relatorio.setFocus(focus);
		e.preventDefault();
	    });
	}

	if (redirect) {
	    $("#msg_modal").on('hidden.bs.modal', function (e) {
		Relatorio.redirect(redirect);
		e.preventDefault();
	    });
	}

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
                    return Relatorio.base64_encode(s);
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
    base64_encode: function(data) {
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
    },

    /*!
     * @description Decoding to base64
     **/
    base64_decode: function(data) {
        var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
        var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
          ac = 0,
          dec = "",
          tmp_arr = [];

        if (!data) {
          return data;
        }

        data += '';

        do { // unpack four hexets into three octets using index points in b64
          h1 = b64.indexOf(data.charAt(i++));
          h2 = b64.indexOf(data.charAt(i++));
          h3 = b64.indexOf(data.charAt(i++));
          h4 = b64.indexOf(data.charAt(i++));

          bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

          o1 = bits >> 16 & 0xff;
          o2 = bits >> 8 & 0xff;
          o3 = bits & 0xff;

          if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1);
          } else if (h4 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1, o2);
          } else {
            tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
          }
        } while (i < data.length);

        dec = tmp_arr.join('');

        return dec;
    }

};

$(document).ready(function () {
    Relatorio.main();
});