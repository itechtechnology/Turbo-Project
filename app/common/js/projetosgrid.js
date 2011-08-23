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
            "name":"nome_tarefa",
            "index":"nome_tarefa",
            "label":"TAREFA",
            "width":180, 
            editable: true
        },

        

        {
            "name":"nome_status",
            "index":"nome_status",
            "label":"STATUS",
            "width":120, 
            editable: true
        }
        ],
        "url":"../controllers/Relatorio.php?relatorio=projetos",
        //        "url":"recursosgrid.php?relatorio=recurso",
        "datatype":"json",
        "jsonReader":{
            repeatitems:false
        },
        'rowNum':'10',
        'rowList':[10,20,30], 
        grouping:true, 
        groupingView : { 
            groupField : ['nome_projeto'],
            groupDataSorted : false 
        }, 
        caption: "Projetos", 
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