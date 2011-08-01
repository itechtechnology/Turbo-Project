$(document).ready(function(){

    // Craeate the grid manually
    $("#grid").jqGrid({
        "colModel":[
        {
            "name":"cd_usuario",
            "index":"cd_usuario",
            "label":"ID",
            "width":50, 
            "key":true
        },

        {
            "name":"nome",
            "index":"nome",
            "width":250, 
            editable: true
        },

        {
            "name":"login",
            "index":"login"
        }
        ],
        "url":"../controllers/Relatorio.php?relatorio=usuarios",
        "datatype":"json",
        "jsonReader":{
            repeatitems:false
        },
        'rowNum':'10',
        'rowList':[10,20,30],
        grouping:true, 
        groupingView : { 
            groupField : ['cd_usuario'],
            groupDataSorted : false 
        }, 
        caption: "Usuarios", 
        //                    'pager': jQuery('#pager')
        "pager":"#pager",
        // in this case the same url
        "editurl": "../controllers/Relatorio.php?relatorio=usuarios",
        //                    edit : {
        //                      'closeafteredit' :true  
        //                    },
        // tell the grid to post the OrderID as primary key
                   
        "prmNames":{
            "id":"cd_usuario"
        },
        altRows :true
    });

    //});
    // Set navigator with search enabled.
    $("#grid").jqGrid('navGrid','#pager',{
        add:false,
        edit:true,
        del:false
    },{
        closeAfterEdit:true
    });

});