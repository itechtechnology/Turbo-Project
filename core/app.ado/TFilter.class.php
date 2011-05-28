<?php

     /* Classe que prov� uma interface
     * para defini��o de filtros de sele��o
     */
     
     class TFilter extends TExpression
     {
        private $variable;  //variavel
        private $operator; //operador
        private $value;   //valor
        
        /* construtor...
        * instacia um novo filtro
        */
        
        public function __construct($variable,$operator,$value)
        {
           $this->variable = $variable;
           $this->operator = $operator;
           $this->value = $this->transform($value);
        }
        
        /* Metodo transform
        * modifica o valor para que ele possa ser entendido pelo DB, pode ser
        * String,array,integer, boolean
        */
        
        private function transform($value)
        {
           if(is_array($value))
           {
              foreach ($value as $x)
              {
                 if(is_integer($x))
                 {
                    $foo[]= $x;
                 }
                 else if (is_string($x))
                 {
                    // se for String ele adiciona aspas
                    
                    $foo[] = "'$x'";
                 }
              }
              //conver o array em string separada por ","
              
              $result = '(' . implode(',', $foo) . ')';
           }

           else if(is_string($value))
           {
              $result = "'$value'";
           }
           else if(is_null($value))
           {
              $result = 'NULL';
           }
           else if(is_bool($value))
           {
              //armazena true ou false
              $result = $value ? 'TRUE' : 'FALSE';
           }
           else
           {
              $result = $value;
           }
            return $result;
        }
        
        /* metodo dump()
        * retorna o filtro em forma de express�o
        */
        
        public function dump()
        {
           // concatena a express�o
           
           return "  {$this->variable}  {$this->operator}  {$this->value}";
        }
     }
     
?>
