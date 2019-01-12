


    
    
    
    


setInterval("like()",10000);

function like(){
    //alert(id);
    var id = $("#IdPublis").val();
    var quantVoltar = $("#voltar").val();
    voltar = "";
    if(quantVoltar >= 0 && quantVoltar <= 5 ){
        for(i = 0; i < quantVoltar; i++){
            voltar += "../";
        }
    }      
    $.ajax({
        url: voltar + 'PegarQtdCurtir.php',
        type: "get",
        data: "ID="+id,
        success: function(data){            
            //$('#lista').html(data);
            $("#qtd_likes").text(data); 
        }
                

    });   
}



