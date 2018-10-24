


    
    var id = $("#IdPublis").val();
    
    


setInterval("like()",10000);

function like(){
    //alert(id);
    
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



