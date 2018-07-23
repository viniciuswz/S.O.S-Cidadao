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
        
    teste.data('batata', teste.position().left)
    var teste =  $("#teste");
   
})


$(function() {
 

 
 teste.click(function(){
  
    alert(teste.data('batata'))
  });


  /*ativar*/
  var leftPos, newWidth, $linha;

  $('.espacos').append("<li id='linha'></li>");//adiciona dentro das abas a seguinte tag
  $linha = $('#linha');
  $linha.width($('.ativo').width()) //pegar largura do elemento que esta ativo agora
    .css('left', $('.ativo a').position().left) // o valor da posição left vai ser o valor do a que esta ativo no nomento
    .data('origLeft', $linha.position().left)// armazenar os valores da position left do elemento que esta selecionado inicialmente
    .data('origWidth', $linha.width());// armazenar o valor da largura do elemento que esta selecionado inicialmente

  $('.espacos li a').click(function() {
    var $this = $(this); //o elemento que vai ser clicado
    $this.parent().addClass('ativo').siblings().removeClass('ativo');// vai pegar o elemento pai do a que acabu de ser clicado e mandar a classe ativo para ele em seguida remover a classe ativo dos elementos que não estiver selecionado
    $linha
      .data('origLeft', $this.position().left) //armazena o valor da posição left elemento que esta sendo clicado
      .data('origWidth', $this.parent().width());//armazena o valor do width do elemento que esta sendo clicado
    return false; // encerra
  });

  /*linha click transição*/

  $('.espacos li').find('a').click(function() {
    var $thisBar = $(this);
    leftPos = $thisBar.position().left;
    newWidth = $thisBar.parent().width();
    $linha.css({
      "left": leftPos,
      "width": newWidth
    });
  }, function() {
    $linha.css({
      "left": $linha.data('origLeft'),
      "width": $linha.data('origWidth')
    });
  });
});