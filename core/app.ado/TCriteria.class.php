<?php





     /* provъ uma interface utilizada


     * para definiчуo de critщrios


     */


     


     class TCriteria extends TExpression


     {


        private $expression; // armazena a lista de expressѕes


        private $operators;  // armazena a lista de operadores


        private $properties; // propriedades do critщrio


        


        /*


        * metodo add() adiciona uma expressуo ao critщrio


        * $expression = expressуo(objeto TExpression)


        * $operator = operador lѓgico de comparaчуo


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


        * retorna a expressуo final


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