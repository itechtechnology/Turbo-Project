<?php

        class DBManager extends ManipulaBanco
        {
                public function listarTabelas()
                {
                        $sql = "SELECT tablename AS tabela ,schemaname AS esquema FROM pg_tables WHERE tablename NOT LIKE 'pg%' AND tablename NOT LIKE 'sql\_%' ORDER BY tablename";
                               
                        $result = $this->executarPesquisa($sql);
                       
                        return $result;
                }
               
                public function listarCamposByTabela($tabela)
                {
                        $sql = "SELECT pg_attribute.attname AS campo,pg_type.typname as tipo,pg_attribute.attnotnull as notnull";
                        $sql .= " FROM pg_class,pg_attribute,pg_type WHERE pg_attribute.attnum > 0 AND pg_attribute.attrelid = pg_class.oid AND pg_attribute.atttypid = pg_type.oid";
                        $sql .= " AND pg_class.relname = '".$tabela."' ORDER BY pg_attribute.attname;";
                       
                        $result = $this->executarPesquisa($sql);
                       
                        return $result;
                }
               
                public function listarTamanhoBanco($banco = DBNAME)
                {
                        //TAMANHO EM BYTES
                        $sql = "SELECT pg_database_size('".$banco."') AS tamanho;";
                       
                        $result = $this->executarPesquisa($sql);
                       
                        return $result;
                }
               
                public function listarTamanhoTabela($tabela)
                {
                        //TAMANHO EM BYTES
                        $sql = "SELECT pg_relation_size('".$tabela."') AS tamanho";
                       
                        $result = $this->executarPesquisa($sql);
                       
                        return $result;
                }
               
                public function listarTamanhoIndice($indice)
                {
                        //TAMANHO EM BYTES
                        $sql = "SELECT pg_relation_size('".$indice."') AS tamanho";
                       
                        $result = $this->executarPesquisa($sql);
                       
                        return $result;
                }
               
                public function listarUsuariosConectados($banco = DBNAME)
                {
                        $sql = "SELECT usesysid as id, usename AS usuario,client_addr AS IP,current_query AS query,procpid AS pid FROM pg_stat_activity WHERE datname = '".$banco."'";
                       
                        $result = $this->executarPesquisa($sql);
                       
                        return $result;
                }
               
                public function abortarProcessos($pid)
                {
                        $sql = "SELECT pg_terminate_backend('".$pid."')";
                       
                        $result = $this->executar($sql);
                       
                        return $result;
                }
               
                public function listarVersaoBanco()
                {
                        $sql = "SELECT version() AS versao";
                       
                        $result = $this->executarPesquisa($sql);
                       
                        return $result;
                }
        }
?>

