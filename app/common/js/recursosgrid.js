$(document).ready(function(){

    // Craeate the grid manually
    $("#grid").jqGrid({
        "colModel":[
        {
            "name":"cd_recurso",
            "index":"cd_recurso",
            "label":"ID",
            "width":50, 
            "key":true
        },

        {
            "name":"nome_recurso",
            "index":"nome_recurso",
            "label":"RECURSO",
            "width":180, 
            editable: true,
            searchoptions:{sopt:['cn']}
        },

        {
            "name":"ds_recurso",
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
    .jqGrid('filterToolbar')
    .jqGrid('navButtonAdd','#pager',{
        caption:"Visualizar", 
        onClickButton : function () { 
                        alert("tarefa.php?tarefa=5");
//            alert('pdf');
        } 
    })
    
    ;

});