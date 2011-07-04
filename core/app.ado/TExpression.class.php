<?php


     /* Classe abstrata para


     * gerenciar expressões


     */


     


     abstract class TExpression


     {


        //operadores logicos


        


        const AND_OPERATOR = 'AND';


        const OR_OPERATOR = 'OR';


        


        abstract public function dump();


     }


?>