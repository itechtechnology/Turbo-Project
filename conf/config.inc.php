<?php

/*
**********************************************
***********CONFIGURAÇÕES DO SISTEMA***********
**********************************************
*/

    /*
     * BLOQUEIO DE SISTEMA
    */
    #define('SYSTEMBLOCKED', true);
    define('SYSTEMBLOCKED', false);

    /*
     * IDIOMA
    */    
    define('LANGUAGE', 'pt-BR');
    #define('LANGUAGE', 'en-US');

    /*
     * MODO DE AUTENTICAÇÃO
     * Atenção: Os tipos de autenticação 'LDAP' e 'BOTH' podem ser utilizados somente se o servidor de dominio estiver na mesma rede.
     * Caso o método de autenticação utilizado seja 'LDAP' ou 'BOTH', as constantes 'LDAPSERVER' e 'LDAPDOMAIN' devem estar devidamente configuradas.
     * Em casos em que o servidor de dominio não existe ou não está na mesma rede utiliza-se somente o método de autenticação 'SYSTEM'.
     * Caso os usuários sejam autenticados diretamente via banco de dados a opção ativa deve ser 'DATABASE'.
    */
    #define('AUTHTYPE', 'BOTH');
    #define('AUTHTYPE', 'LDAP'); //loga via servidor de dominio
        #define('LDAPSERVER', '');
        #define('LDAPDOMAIN', '');
    #define('AUTHTYPE', 'SYSTEM');
    define('AUTHTYPE', 'DATABASE');

    /*
     * TEMPO PARA EXPIRAR COOKIE DE SESSÃO
     * Tempo em segundos
     * Ex.: 1800 segundos. Que equivale a 30 minutos.
    */
    define('COOKIETIMEAWAY', 1800);

    /*
     * IMAGEM FAVICON
     * Internet explorer na sua versão atual(IE8) não suporta icones animados, portanto caso deseje usar ícones
     * animados deve-se ter um estático para uso no IE.
    */
    define('FAVICON', 'favicon.ico');
    define('ANIMATEDFAVICON', 'favicon_animated.ico');

    /*
     * E-MAIL PADRÃO PARA ENVIO DE EMAILS ATRAVES DO SISTEMA
     */
    define('DEFAULTEMAILHOST', 'ssl://smtp.itech10.com');
    define('DEFAULTEMAILPORT', 465);
    define('DEFAULTEMAIL', 'turboproject@itech10.com');
    define('DEFAULTPASS', 'turbo123');

    /*
     * E-MAILS PADRÕES PARA RECEBIMENTO DE SOLICITAÇÕES
     * Caso venha a ter mais emails basta adicionar seguindo o padrão 'EMAILALGUMACOISA'.
    */
    define('EMAILCONTATO', 'contato@itech10.com');

    /*
    * URL E DOMINIO PADRÃO
    */
    #define('DEFAULTURL', 'http://www.itech10.com');
    #define('DOMAIN', 'itech10.com');

    /*
     * TÍTULO DO SITE
     */
    define('SITETITLE', 'itech10! Gestão Inteligente de projetos');


/*
**********************************************
***********DIRETÓRIOS DO SISTEMA**************
**********************************************
*/  
    define('APPMODELDIR', 'app/models');
    define('APPCONTROLLERDIR', 'app/controllers');
    define('APPVIEWDIR', 'app/views');
    define('APPTPLDIR', '../tpl');
    define('APPIMAGEDIR', '../common/images');
    define('APPCSSDIR', '../common/css');
    define('APPJSDIR', '../common/js');   
    define('APPWEBROOT', '../../web');
     define('APPLANGDIR', 'conf/language/'.LANGUAGE);
    
    define('WEBTPLDIR', 'tpl');
    define('WEBIMAGEDIR', 'common/images');
    define('WEBCSSDIR', 'common/css');
    define('WEBJSDIR', 'common/js');
    define('WEBLANGDIR', 'conf/language/'.LANGUAGE);


/*
**********************************************
***********BANCO DE DADOS*********************
**********************************************
*/    
    define('DBNAME', 'turbo');
    define('DBPASS', 'itechuesc123');
    define('DBHOST', 'localhost');
    define('DBUSER', 'postgres');
    define('DBSGBD', 'pgsql');


/*
**********************************************
***********UPLOAD*****************************
**********************************************
*/    
    define('FTPHOST', '');
    define('FTPUSER', '');
    define('FTPPASS', '');
    define('FTPFOLDER', '/');
    define('FTPPORT', 21);
    define('FTPTIMEOUT', 36000);

    /*
     * LARGURA E ALTURA MINIMA E MAXIMA PARA UPLOAD DE IMAGENS
    */
    define('MAXIMGWIDTH', 1024);
    define('MAXIMGHEIGHT', 768);
    define('MIMIMGWIDTH', 350);
    define('MIMIMGHEIGHT', 240);

    /*
    * TAMANHO MÁXIMO PARA ENVIO DE UPLOAD
    * 2 MBytes = 2048 KBytes
    * 2048 KBytes = 2097152 Bytes
    * Para calcular corretamente favor utilizar http://www.wilkinsonpc.com.co/free/articulos/calculadorabytes.html
    */
    define('MAXUPLOAD', 2097152);


/*
**********************************************
***********NOTÍCIAS E ENQUETE*****************
**********************************************
*/

    /*
     * QUANTIDADE MÁXIMA DE CARACTERES NO TÍTULO E SUBTÍTULO DAS NOTÍCIAS
    */
    define('MAXNOTICIACARACTERESTITULO', 30);
    define('MAXNOTICIACARACTERESSUBTITULO', 40);

    /*
     * QUANTIDADE MÁXIMA DE OPÇÕES EM ENQUETES
    */
    define('MAXENQUETEOPCOES', 10);

?>