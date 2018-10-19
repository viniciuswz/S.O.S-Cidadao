$(document).ready(function(){
    var paginacao = 0;
    $(window).scroll(function() {
        
        if($(window).scrollTop() == $(document).height() - $(window).height()) {
            setTimeout(function(){
                // simulação interna
               for(var i=0;i<2;i++){
                   
                $('body').append("<div style='height: 300px; width: 200px; background: navy; margin:10px; color:white'>"+ paginacao +"</div>")
               }
                // escodner lload
               //$('#loader').hide();
                
                //alert("topo")
                // subir scroll
           $(window).scrollTop(window.height);
            },1080); 
            paginacao++;
        }
    });
    
    
