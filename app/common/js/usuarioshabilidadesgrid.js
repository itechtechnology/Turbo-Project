$(document).ready(function(){

    // Craeate the grid manually
    $("#grid").jqGrid({
        "colModel":[
        {
            "name":"usuario",
            "index":"usuario",
            "label":"NOME USUARIO",
            "width":180,
            key :true
        },
        {
            "name":"habilidade",
            "index":"habilidade",
            "label":"NOME HABILIDADE",
            "width":180
        }
        ],
        "url":"../controllers/Relatorio.php?relatorio=usuarioshabilidades",
        "datatype":"json",
        "jsonReader":{
            repeatitems:false
        },
        'rowNum':'10',
        'rowList':[10,20,30],
        grouping:true, 
        groupingView : { 
            groupField : ['usuario'],
            groupDataSorted : false 
        }, 
        caption: "Usuarios Habilidades", 
        //                    'pager': jQuery('#pager')
        "pager":"#pager"
    });

    //});
    // Set navigator with search enabled.
    $("#grid").jqGrid('navGrid','#pager',{
        add:false,
        edit:false,
        del:false
    },
    {
        closeAfterSearch: true
        
    }
    );

});