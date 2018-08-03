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


$(function() {
 
  /*ativar*/
  var leftPos, newWidth, $linha;

  $('.espacos').append("<li id='linha'></li>");//adiciona dentro das abas a seguinte tag
  $linha = $('#linha');
  $linha.width($('.ativo').width()) //pegar largura do elemento que esta ativo agora
    .css('left', $('.ativo a').position().left) // o valor da posição left vai ser o valor do a que esta ativo no nomento
    .data('origLeft', $linha.position().left)// armazenar os valores da position left do elemento que esta selecionado inicialmente
    .data('origWidth', $linha.width());// armazenar o valor da largura do elemento que esta selecionado inicialmente

    /* trocar cor do a ativo */
  $('.espacos li a').click(function() {
    var $this = $(this); //o elemento que vai ser clicado
    $this.parent().addClass('ativo').siblings().removeClass('ativo');// vai pegar o elemento pai do a que acabu de ser clicado e mandar a classe ativo para ele em seguida remover a classe ativo dos elementos que não estiver selecionado
    $linha
      .data('origLeft', $this.position().left) //armazena o valor da posição left elemento que esta sendo clicado
      .data('origWidth', $this.parent().width());//armazena o valor do width do elemento que esta sendo clicado
    return false; // encerra
  });

  /*mudar a linha para o ativo*/

  $('.espacos li').find('a').click(function() { //econtrar o a dentro do li que estamos clicando e execultar a função
    var $thisBar = $(this); //this se refere ao <a>  confirmo execultando isso, alert($thisBar.attr('href'))
    leftPos = $thisBar.position().left; // a posição do elemento a que clicamos
    newWidth = $thisBar.parent().width();// a largura do elemento...
    $linha.css({ // posicionar no css a linha
      "left": leftPos,// daqui para baixo já sabemos...
      "width": newWidth
    });
  }, function() {
    $linha.css({
      "left": $linha.data('origLeft'),
      "width": $linha.data('origWidth')
    });
  });
});


jQuery(function($){

  $(".icone-3pontos").click(function(){
    var $this = $(this);
    $this.parent().toggleClass('mini-menu-item-ativo')
  })
})


jQuery(function(){
    $(".formulario").submit(function(){
       
     var titulo = $("#titulo").val();
    
      if( titulo === ""){
        $("#titulo").parent().find('p').text("Escreve algua coisa");
        $("#titulo").parent().find('span').addClass('verificar');
        return false;
      }else{
        $("#titulo").parent().find('p').text("");
        $("#titulo").parent().find('span').removeClass('verificar');
      }
    });


    $(".formulario").submit(function(){
       
      var tema = $("#tema").val();
     
       if( tema === ""){
         $("#tema").parent().find('p').text("Tem que ter uma tema");
         $("#tema").parent().find('span').addClass('verificar');
         return false;
       }else{
        $("#tema").parent().find('p').text("");
        $("#tema").parent().find('span').removeClass('verificar');
      }

      
     });

     $(".formulario").submit(function(){
       var caminhoImagem = $("#imagemDebate").val();
       var extensao = caminhoImagem.substr(caminhoImagem.lastIndexOf(".") + 1).toLowerCase();

        if(extensao == "png" || extensao =="jpg" || extensao == "jpeg"){
          
          $(".imagem").find('p:last-child').text("Essa imagem é valida");
          
          $("#img").attr("src",caminhoImagem)
           
        }else if(caminhoImagem ===""){
           
          $(".imagem").find('p:last-child').text("é obrigatorio inserir uma imagem");
        }else{
          $('#imagemDebate').val("");

          $(".imagem").find('p:last-child').text("isso não é uma imagem");
        }
       
      
     });

     
})


