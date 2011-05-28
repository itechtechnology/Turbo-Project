<?php

class sistUpload
{
    private $servidor;
    private $usuario;
    private $senha;
    private $conn;
    private $login;
    private $extensao;
    private $caminho;
    private $upload;
    private $pasta;

    function __construct($servidor = FTPHOST, $usuario = FTPUSER, $senha = FTPPASS, $pasta = FTPFOLDER, $porta = FTPPORT, $timeout = FTPTIMEOUT)
    {
        $this->servidor = $servidor;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->pasta = $pasta;
        $this->porta = $porta;
        $this->timeout = $timeout;
        $this->extensao = array('.ppt', '.pptx', '.txt', '.xlsx', '.xls', '.docx', '.doc', '.jpg', '.jpeg', '.png', '.gif', '.pdf', '.zip', '.rar');
    }

    function conectaFTP()
    {
        if ($this->conn = ftp_connect($this->servidor, $this->porta, $this->timeout))
        {
            $this->login = @ftp_login($this->conn, $this->usuario, $this->senha);

            if ($this->login)
            {
                return true;
            }
        }
        else
        {
            return false;
        }
    }

    function desconectaFTP()
    {
        if ($this->conn)
        {
            @ftp_close($this->conn);
            return true;
        }
        else
        {
            return false;
        }
    }

    function verificaExtensao($arquivo)
    {
            $ext = strrchr($arquivo, '.');
            if (in_array($ext, $this->extensao))
            {
                    return true;
            }
            else
            {
                    return false;
            }
    }
       
    function retornaExtensao($arquivo)
    {
        $ext = strrchr($arquivo, '.');
        if (in_array($ext, $this->extensao))
        {
            return $ext;
        }
        else
        {
            return false;
        }
    }
   
    function formataArquivo($arquivo)
    {
        $arq = explode (" ", $arquivo);
        $arq = implode("",$arq);
        $arq = strtr($arq, "???????¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ", "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy");
        $arq = str_replace("_", "", $arq);
        $arq = str_replace("+", "", $arq);
        $arq = str_replace("-", "", $arq);
        $arq = str_replace("%", "", $arq);
        $arq = strtolower($arq);
        return $arq;
    }

    function verificaExtensaoImagem($arquivo)
    {
        $mimetypesImagens = array("bmp" => "image/bmp",
                                  "gif" => "image/gif",
                                  "jpe" => "image/jpeg",
                                  "jpeg" => "image/jpeg",
                                  "jpg" => "image/jpeg",
                                  "png" => "image/png",
                                  "tif" => "image/tiff",
                                  "tiff" => "image/tiff");
        if(in_array($arquivo['type'], $mimetypesImagens))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function verificaTamanhoImagem($arquivo)
    {
            $tamanhos = getimagesize($arquivo['tmp_name']);
            if(($tamanhos[0] > MAXIMGWIDTH) or ($tamanhos[0] < MIMIMGWIDTH))
            {
                    return false;
            }
            elseif(($tamanhos[1] > MAXIMGHEIGHT) or ($tamanhos[1] < MIMIMGHEIGHT))
            {
                    return false;
            }
            else
            {
                    return true;
            }
    }

    function uploadArquivo ($arquivo, $temporario, $caminho = '/')
    {
        $arquivo = $this->formataArquivo($arquivo);
        if ($this->verificaExtensao($arquivo))
        {
            $arqfinal = "$caminho/$arquivo";
            $upload = @ftp_put($this->conn, $arqfinal, $temporario, FTP_BINARY);

            if ($upload)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    function uploadImagem($nome, $arquivo, $temporario, $caminho)
    {
        if ($this->verificaExtensaoImagem($arquivo))
        {
            $arqfinal = "$caminho/$nome";
            $upload = @ftp_put($this->conn, $arqfinal, $temporario, FTP_BINARY);
            if ($upload)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}
?>
