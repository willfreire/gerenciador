<!DOCTYPE html5>

<html>

    <head>
        <title>:: VT CARDS - SISTEMA :: <?=isset($titulo) ? $titulo." ::" : ''?></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="robots" content="noindex, nofollow">
        <meta name="googlebot" content="noindex, nofollow">

        <!-- Logo Icon -->
        <?php # link_tag('assets/imgs/logo-vertical.png', 'shortcut icon', 'image/png') ?>

        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?=base_url('scripts/lib/bootstrap/css/bootstrap.min.css')?>">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?=base_url('assets/css/font-awesome.min.css')?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?=base_url('assets/css/ionicons.min.css')?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?=base_url('assets/dist/css/AdminLTE.min.css')?>">
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?=base_url('assets/dist/css/skins/_all-skins.min.css')?>">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?=base_url('scripts/plugins/iCheck/square/blue.css')?>">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?=base_url('scripts/plugins/datatables/dataTables.bootstrap.css')?>">
        <!-- Datepicker -->
        <link rel="stylesheet" href="<?=base_url('scripts/plugins/datepicker/datepicker3.css')?>">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?=base_url('scripts/plugins/daterangepicker/daterangepicker.css')?>">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?=base_url('scripts/plugins/select2/select2.min.css')?>">
        <!-- Selectr -->
        <link rel="stylesheet" href="<?=base_url('scripts/plugins/selectr/css/selectr.css')?>">

        <!-- JavaScripts -->
        <!-- jQuery 2.2.3 -->
        <script src="<?=base_url('scripts/plugins/jQuery/jquery-2.2.3.min.js')?>"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="<?=base_url('scripts/lib/bootstrap/js/bootstrap.min.js')?>"></script>
        
        <!-- Bootstrap Validator -->
        <link rel="stylesheet" type="text/css" href="<?=base_url('scripts/plugins/bootstrap_validator/css/bootstrapValidator.min.css')?>">
        <script src="<?=base_url('scripts/plugins/bootstrap_validator/js/bootstrapValidator.min.js')?>"></script>
        <script src="<?=base_url('scripts/plugins/bootstrap_validator/js/language/pt_BR.js')?>"></script>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        
        <script>
            // Pegar caminho em Javascript
            var currentLocation = window.location;
            var parser          = document.createElement('a');
                parser.href = currentLocation;

            var protocol = parser.protocol;
            var host     = parser.host;
            var hostname = parser.hostname;
            var port     = parser.port;
            var pathname = parser.pathname;
            var pathproj = pathname.split('/')[1];
            var hash     = parser.hash;
            var search   = parser.search;
            var origin   = parser.origin;
        </script>

    </head>
