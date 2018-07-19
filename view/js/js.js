jQuery(function($)
{
    function fechar(){
        $(".user-menu").css("width","0");
    }
    
    $("#abrir").click(function()
    {
        var tela= $(document).width();
        if(tela<=480){
            $(".user-menu").css("width","100vw");
            $(window).resize(fechar);
        }else{
            $(".user-menu").css("width","450px");
            $(window).resize(fechar);
        }
    })
        $(".fechar").click(fechar);

     
})

jQuery(function($)
{

  
    $("#abrir-not").click(function(){
    
        $(".notificacoes").toggleClass('ativo');

    })

    $(window).resize(function(){
        $(".notificacoes").removeClass('ativo');
    })
        

     
})