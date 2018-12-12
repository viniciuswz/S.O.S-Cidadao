$(document).ready(function(){
    // Assign scroll function to chatBox DIV
    $(window).scroll(function() {
        if($(window).scrollTop() == $(document).height() - $(window).height()) {
            // Display AJAX loader animation
           // $('#loader').show();
            
            // Youd do Something like this here
            // Query the server and paginate results
            // Then prepend
            /*  $.ajax({
                url:'getmessages.php',
                dataType:'html',
                success:function(data){
                    $('.inner').prepend(data);
                };
            });*/
            //BUT FOR EXAMPLE PURPOSES......
            // We'll just simulate generation on server
            
            
            //Simulate server delay;
            setTimeout(function(){
                // Simulate retrieving 4 messages
               // for(var i=0;i<4;i++){
                   // $('.mensagens').prepend('<div class="linha-mensagem_padrao"><div class="usuario-msg-foto"><img src="imagens/perfil.jpg"></div><div class="mensagem_padrao"><span class="nome"><a href="#">Péricles alexandre santoaaaaaaaaaaaaaaaaaaaaaaaaaaas</a></span><span >teseeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee<sub>16:55</sub></span></div></div>');
               // }
                // Hide loader on success
              //  $('#loader').hide();
                // Reset scroll
                alert("topo")
               
            },780); 
        }
    });
    
}) 


