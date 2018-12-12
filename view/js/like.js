


    
    
    
    


setInterval("like()",10000);

function like(){
    //alert(id);
    var id = $("#IdPublis").val();
    $.ajax({
        url: '../PegarQtdCurtir.php',
        type: "get",
        data: "ID="+id,
        success: function(data){            
            //$('#lista').html(data);
            $("#qtd_likes").text(data); 
        }
                

    });   
}



