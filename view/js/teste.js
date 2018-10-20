$(document).ready(function(){

var paginacao = 1;
$(window).scroll(function() {
    if($(window).scrollTop() == $(document).height() - $(window).height()) {

       // $('#loader').show();
       paginacao++
        setTimeout(function(){
            // Simulate retrieving 4 messages
            for(var i=0;i<4;i++){
            $('body').append('<div class="linha-mensagem_padrao"><div class="usuario-msg-foto"><img src="imagens/perfil.jpg"></div><div class="mensagem_padrao"><span class="nome"><a href="#">Péricles alexandre santoaaaaaaaaaaaaaaaaaaaaaaaaaaas</a></span><span >'+paginacao+'<sub>16:55</sub></span></div></div>');
                }
                // Hide loader on success
               // $('#loader').hide();
                // Reset scroll
               // $('body').scrollTop($(window).height());
            },780); 
    }
});
}) 


