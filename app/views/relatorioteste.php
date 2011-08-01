<?php
require_once '../../jqgrid/tabs.php';

?>
<html>
    <head>
        <title>{TITULO}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" media="screen" href="../../jqgrid/themes/redmond/jquery-ui-1.8.2.custom.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../../jqgrid/themes/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../../jqgrid/themes/ui.multiselect.css" />

        <link href="{CSSDIR}/main.css" rel="stylesheet" type="text/css" />
        <link href="{CSSDIR}/relatorios.css" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="{JSDIR}/jquery-1.6.1.min.js"></script>
        <script type="text/javascript" src="{JSDIR}/jquery.tools.min.js?select=full&debug=true"></script>
        <script type="text/javascript" src="{JSDIR}/fonte.js" ></script> 
        <script type="text/javascript" src="{JSDIR}/configuracoesJS.js"></script>

        <script src="../../jqgrid/js/jquery.js" type="text/javascript"></script>
        <script src="../../jqgrid/js/i18n/grid.locale-pt-br.js" type="text/javascript"></script>
        <script type="text/javascript">
            $.jgrid.no_legacy_api = true;
            $.jgrid.useJSON = true;
        </script>
        <script src="../../jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
        <script src="../../jqgrid/js/jquery-ui-custom.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="{JSDIR}/{GRID}"></script>
    </head>
    <body>
        <div>
            <?php include 'relatoriousuariosgrid.php'?>
        </div>
    </body>
</html>

