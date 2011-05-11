<?php

        /* Prov� metodos em comum entre todas instru��es SQL
        * INSERT,UPDATE,DELETE e SELECT
        */
        
        abstract class TSqlInstruction
        {
                protected $sql; //armazena a instru��o
                protected $criteria; //armazena o objeto criterio
                
                /* SetEntity()
                * define a tabela manipulada pela instru��o
                */
                
                final public function setEntity($entity)
                {
                        $this->entity = $entity;
                }
                
                /* getEntity
                * retorna o nome da tabela
                */
                
                final public function getEntity()
                {
                        return $this->entity;
                }
                
                /* setCriteria
                * define um criterio de sele��o para os dados
                */
                
                public function setCriteria(TCriteria $criteria)
                {
                        $this->criteria = $criteria;
                }
                
                abstract function getInstruction();
                
        }
?>
