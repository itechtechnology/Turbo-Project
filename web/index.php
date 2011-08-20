<?php

    require '../conf/lock.php';
    
    $usuario = new UsuariosRecord();
    
    if($usuario->verificaLogin()) header("location: ../app/views/");
    
    $tpl = new sistTemplate(WEBTPLDIR . '/index.tpl.html');
    $tpl->addFile('RODAPE', WEBTPLDIR . '/rodape.tpl.html');
//    $tpl->IMAGEDIR = 'app/common/images';
//    $tpl->CSSDIR = 'app/common/css';
//    $tpl->JSDIR = 'app/common/js';
    $tpl->IMAGEDIR = WEBIMAGEDIR;
    $tpl->CSSDIR = WEBCSSDIR;
    $tpl->JSDIR = WEBJSDIR;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;
//
    $tpl->TITULOTOOLTIP = 'Mobilidade e Confiabilidade!';
    $tpl->CONTEUDOTOOLTIP = 'Desenvolvido utilizando as tecnologias mais avançadas no que se diz respeito a aplicativos web.';
     

    //$tpl->DATARODAPE = date('Y');
    $tpl->show();

?>