/** 
SCRIPT DE LISTAGEM DE PROJETOS NO GRID

@author: Anderson Rodrigues
@date: 04/08/2011
*/
$(document).ready(function(){

    // Craeate the grid manually
    $("#grid").jqGrid({
        "colModel":[
        {
            "name":"cd_projeto",
            "index":"cd_projeto",
            "label":"ID",
            "width":50, 
            "key":true
        },

        {
            "name":"nome_projeto",
            "index":"nome_projeto",
            "label":"PROJETO",
            "width":200, 
            editable: true
        },

        {
            "name":"ds_rprojeto",
            "index":"ds_recurso",
            "label":"DESCRICAO",
            "width":180, 
            editable: true
        },

        {
            "name":"custo",
            "index":"custo",
            "label":"CUSTO",
            "width":100, 
            formatter:'currency', 
            formatoptions:{
                decimalSeparator:",", 
                thousandsSeparator: ",", 
                decimalPlaces: 2, 
                prefix: "R$ "
            },
            editable: true
        },

        {
            "name":"nome_statusrecurso",
            "index":"nome_statusrecurso",
            "label":"STATUS",
            "width":120, 
            editable: true
        }
        ],
        "url":"../controllers/Relatorio.php?relatorio=recurso",
        //        "url":"recursosgrid.php?relatorio=recurso",
        "datatype":"json",
        "jsonReader":{
            repeatitems:false
        },
        'rowNum':'10',
        'rowList':[10,20,30], 
        //                    'pager': jQuery('#pager')
        "pager":"#pager"
    // in this case the same url
       
    });

    //});
    // Set navigator with search enabled.
    $("#grid").jqGrid('navGrid','#pager',{
        add:false,
        edit:false,
        del:false
    //        pdf:true
    })
//    .jqGrid('navButtonAdd','#pager',{
//        caption:"pdf", 
//        onClickButton : function () { 
//                        $("#grid").excelExport();;
////            alert('pdf');
//        } 
//    })
    ;

});