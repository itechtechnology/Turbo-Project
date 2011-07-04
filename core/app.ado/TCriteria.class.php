<?php





     /* prov� uma interface utilizada


     * para defini��o de crit�rios


     */


     


     class TCriteria extends TExpression


     {


        private $expression; // armazena a lista de express�es


        private $operators;  // armazena a lista de operadores


        private $properties; // propriedades do crit�rio


        


        /*


        * metodo add() adiciona uma express�o ao crit�rio


        * $expression = express�o(objeto TExpression)


        * $operator = operador l�gico de compara��o


        */


        


        public function add(TExpression $expression, $operator = self::AND_OPERATOR)


        {


          if(empty($this->expressions))


          {


             unset($operator);


          }


          


          $this->expressions[] = $expression;


          $this->operators[] = $operator;


        }


        


        /* metodo dump()


        * retorna a express�o final


        */


        


        public function dump()


        {


           if(is_array($this->expressions))


           {


              foreach ($this->expressions as $i=> $expression)


              {


                 $operator = $this->operators[$i];





                 $result.= $operator. $expression->dump() . ' ';


              }


              $result = trim($result);


              return "({$result})";


           }


        }


        


        /* metodo SetProperty()


        * define o valor de uma propriedade


        */


        


        public function setProperty($property,$value)


        {


           $this->properties[$property] = $value;


        }


        


        /* Metodo getProperty


        * retorna o valor de uma propriedade


        */


        


        public function getProperty($property)


        {


           return $this->properties[$property];


        }


     }


?>