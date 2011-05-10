<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
//        phpinfo();
//        include_once 'modelos/Produto.class.php';
//        $prod = new Produto("notebook vostro");
//        echo $prod->getNome();
////        echo Produto::getId();
//        try {
//            $con = new PDO('mysql:dbname=loja;host=localhost', "root", "paavo123");
//            $result = $con->query("SELECT * FROM produtos");
//            if ($result) {
//                echo "<br/>" . 'lista' . "<br/>";
//                foreach ($result as $row) {
//                    echo $row['nome'] . "\n";
//                }
//                while ($row = $result->fetch(PDO::FETCH_OBJ)) {
//                    echo 'objeto' . $row->nome;
//                }
//            }
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//            die();
//        }
        include_once 'app.ado/TExpression.class.php';
        include_once 'app.ado/TCriteria.class.php';
        include_once 'app.ado/TFilter.class.php';

        $criterio = new TCriteria;
        $criterio->add(new TFilter('idade', '<', 16), TExpression::OR_OPERATOR);
        $criterio->add(new TFilter('idade', '>', 60), TExpression::OR_OPERATOR);
        echo $criterio->dump();
//        $filter = new TFilter('data', '=', 'dasd');
//        echo $filter->dump();
//        $con = mysql_connect("localhost", "root", "paavo123");
//        mysql_select_db("loja", $con);
//        mysql_query("INSERT INTO produtos(nome) values (\"VOSTRO\");", $con);
        ?>
    </body>
</html>
