<?php

    require '../conf/lock.php';
    
    $tpl = new sistTemplate(WEBTPLDIR.'/index.tpl.html');
    $tpl->addFile('RODAPE', WEBTPLDIR.'/rodape.tpl.html');
    $tpl->IMAGEDIR = WEBIMAGEDIR;
    $tpl->CSSDIR = WEBCSSDIR;
    $tpl->JSDIR = WEBJSDIR;
    $tpl->SITETITLE = SITETITLE;
    $tpl->FAVICON = FAVICON;
    $tpl->ANIMATEDFAVICON = ANIMATEDFAVICON;

    $tpl->TITULOTOOLTIP = 'Mobilidade e Confiabilidade!';
    $tpl->CONTEUDOTOOLTIP = 'Desenvolvido utilizando as tecnologias mais avançadas no que se diz Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sollicitudin ultrices erat vitae sodales. Duis pretium mollis risus, sed pellentesque diam accumsan et. Vivamus sapien lorem, ullamcorper in auctor non, lacinia et arcu. Maecenas condimentum tincidunt massa. Sed nulla ante, consectetur sit amet porta non, adipiscing vitae urna. Quisque malesuada lobortis lacus ut laoreet.';


    $tpl->DATARODAPE = date('Y');
    $tpl->show();

?>