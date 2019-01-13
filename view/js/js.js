jQuery(function($)
{
  function fechar(){
    $(".user-menu").css("width","0");
    $("body").css("overflow","auto");
  }
  $('#abrir-pesquisa').click(function(){
    //alert('jaca')
    $('#pesquisa').parent().toggleClass('pesquisando');
    //$('#pesquisa').parent().css('margin-bottom','70px');
    var classi = $('#pesquisa').parent().attr('class');
    //alert(classi)
     if(classi =='pesquisando'){
    $('#pesquisa').parents(':eq(1)').css('margin-bottom','70px');
     }else{
      $('#pesquisa').parents(':eq(1)').css('margin-bottom','0px');
     }
  })
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
    $("body").css("overflow","hidden");
  });
  $(".fechar").click(fechar);
  
  $("#deiLike").click(function(){
   var id = $("#IdPublis").val();
   var classe = $(this).find('i').attr("class");  
    
   var quantVoltar = $("#voltar").val();
   voltar = "";
   if(quantVoltar >= 0 && quantVoltar <= 5 ){
       for(i = 0; i < quantVoltar; i++){
           voltar += "../";
       }
   }   
  
    $.ajax({
      url: voltar +"CurtirPublicacao.php",
      type: "get",
      data: "ID="+id,
      success:function(result){
          if(result == 'NLogado'){ // Nao esta ogado, redirecionar pra fazer login
            location.href= voltar+"login";
            return false;
          }          
          if(classe =="icone-like-full"){
            $("#deiLike").find("i").attr("class","icone-like");
            //
            $("#qtd_likes").text(result);      
          }else{
            $("#deiLike").find("i").attr("class","icone-like-full"); 
            //        
            $("#qtd_likes").text(result);            
          }

      }
   });
   return false;
  });
 
});

jQuery(function($)
{
  
  var click = 0;
  $("#abrir-not").click(function(){
    
    
    $(".notificacoes").toggleClass('ativo');
    var banana= $(".notificacoes").attr("class");
    
    // if(banana=='notificacoes ativo'){
    // $("#abrir-not").css("background-color", "#009688");
    // $("#abrir-not").find("i").css('background-position-y','0px');
    // click++;
    // $("#not-fechado").html(' fechou ' + click + 'vezes');
    // $("body").css("overflow","auto");
    // $("body").css("overflow","hidden");
    // }else{
    // $("body").css("overflow","auto");
    // $("#abrir-not").css("background-color", "#004C41");
    // $("#abrir-not").find("i").css('background-position-y','-37.5px');
    // }
    return false;
    
  });
  
  $(window).resize(function(){
    $(".notificacoes").removeClass('ativo');
  });
  
});


jQuery(function($) {
  
  $(document).ready(function(){
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
      $this.parent().addClass('ativo').siblings().removeClass('ativo');// vai pegar o elemento pai do a que acabou de ser clicado e mandar a classe ativo para ele em seguida remover a classe ativo dos elementos que não estiver selecionado
      $linha
      .data('origLeft', $this.position().left) //armazena o valor da posição left elemento que esta sendo clicado
      .data('origWidth', $this.parent().width());//armazena o valor do width do elemento que esta sendo clicado
      //return false; // encerra
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
});


jQuery(function($){
  

  
  jQuery(document).on("click",".icone-3pontos", function(event){
    //alert("oi");
     var $this = $(this);
     $this.parents(':eq(2)').siblings().find('div.mini-menu-item').removeClass('mini-menu-item-ativo');
    $this.parent().toggleClass('mini-menu-item-ativo');
    
     //$('.mini-menu-item-ativo').siblings().find('.mini-menu-item-ativo').remove()
  });//$(this).siblings().find("td:nth-child(1) div").removeClass("mini-menu-adm-ativo");
});



//VERIFICAÇÃO DOS FORM
jQuery(function(){
  $(".formulario").submit(function(){
    
    var titulo = $("#titulo").val();
    
    if( titulo === ""){
      $("#titulo").parent().find('p').text("este campo não pode ser vazio");
      $("#titulo").parent().find('span').addClass('verificar');
      $("#titulo").css("background" , 'rgba(256,000,000,.1)' );
      return false;
    }else{
      $("#titulo").parent().find('p').text("");
      $("#titulo").parent().find('span').removeClass('verificar');
      $("#titulo").css("background" , 'white' );
    }
  });
  $(".formulario").submit(function(){
    
    var tema = $("#tema").val();
    
    if( tema === ""){
      $("#tema").parent().find('p').text("este campo não pode ser vazio ");
      $("#tema").parent().find('span').addClass('verificar');
      $("#tema").css("background" , 'rgba(256,000,000,.1)' );
      return false;
    }else{
      $("#tema").parent().find('p').text("");
      $("#tema").parent().find('span').removeClass('verificar');
      $("#tema").css("background" , 'white' );
    }
    
  });
  
  $(".formulario ele-nao").submit(function(){
    var imgDebate = $("#imagemDebateInput").val();
    
    if(imgDebate == ""){
      //$(".imagem").find('p:last-child').text("eae");
      return false;
    }
  });
  
  $(".formulario").submit(function(){
    $this = $(this);
    
    
    var id = $(this).attr('id');
    //alert(id);
    //return false
    if(id == "elenao"){
      
    }else{

      if($this.attr('action') == '../enviarPublicacao.php'){
        var imgDebate = $("#fotoReclamacao").val();
        if(imgDebate == ""){
          $(".imagem").find('p:last-child').text("uma imagem é obrigatoria");
          return false;
        }
      }else{
        var imgDebate = $("#imagemDebateInput").val();
        if(imgDebate == ""){
          $(".imagem").find('p:last-child').text("uma imagem é obrigatoria");
          return false;
        }
      }
      

    }
    
  });
  
  // $(document).on("change", "#imagemDebateInput", function(){
  //   var InputData = document.getElementById('imagemDebateInput');
  //   var caminhoImagem = InputData.value;
  //   // verificando a extensão
  //   var extensao = caminhoImagem.substring(
  //     caminhoImagem.lastIndexOf('.') + 1).toLowerCase();
  //     //verificando se é uma img
  //     if (extensao == "gif" || extensao == "png"  || extensao == "bmp"
  //     || extensao == "jpeg" || extensao == "jpg") {
  //       // vai mostrar no preview
  //       if (InputData.files && InputData.files[0]) {
  //         var reader = new FileReader();
  //         reader.onload = function(e) {
  //           $('#imgPreview').attr('src', e.target.result);
  //           $(".imagem").find('p:last-child').text("");
  //         }
  //         reader.readAsDataURL(InputData.files[0]);
  //       }
  //     } 
  //     //se não for uma imagem
  //     else {
  //       $('#imagemDebateInput').val("");
  //       $(".imagem").find('p:last-child').text("esse formato não é valido");
  //       return false;
  //     }
  //   })
  
  
  $(".formulario").submit(function(){
    
    var sobre = $("#sobre").val();
    
    if( sobre === ""){
      $("#sobre").parent().find('p').text("este campo não pode ser vazio ");
      $("#sobre").css("background" , 'rgba(256,000,000,.1)' );
      return false;
    }else{
      $("#sobre").parent().find('p').text("");
      $("#sobre").css("background" , 'white' );
      
    }
    
  });
  
  $(".reclamaForm").submit(function(){
    
    if($('input[name=categoria]:checked').length<=0)
    {
      $(".categorias").find('p').text("Escolha uma categoria");
      return false
    }else{
      $(".categorias").find('p').text("");
    }
    
  });
  
  
  $(".reclamaForm").submit(function(){
    
    //Nova variável "cep" somente com dígitos.
    var CEP = $("#cep").val().replace(/\D/g, '');
    
    
    if( CEP === ""){
      $("#cep").parent().find('p').text("O CEP é obrigatorio");
      $("#cep").parent().find('span').addClass('verificar');
      $("#cep").css("background" , 'rgba(256,000,000,.1)' );
      return false;
      
    }else{
      
      
      
      
      
      $("#cep").parent().find('p').text("");
      $("#cep").parent().find('span').removeClass('verificar');
      $("#cep").css("background" , 'white' );
      $("#cep").val(CEP.replace('-',''));
      
      
    }
    
  });
  

  
  $("#cep").blur(function(){
    
    function limpa_formulario_cep() {
      // Limpa valores do formulário de cep.
      $("#cep").val("")
      $("#local").val("");
      $("#bairro").val("");
      $("#input-disabled-local").val("");
      $("#input-disabled-bairro").val("");
    

    }
    
    //Nova variável "cep" somente com dígitos.
    var CEP = $("#cep").val().replace(/\D/g, '');
    //Nova variável "cep" somente com dígitos.
    var cep = CEP;
    
    //Verifica se campo cep possui valor informado.
    if (cep != "") {
      
      //Expressão regular para validar o CEP.
      var validacep = /^[0-9]{8}$/;
      
      //Valida o formato do CEP.
      if(validacep.test(cep)) {
        
        //Preenche os campos com "..." enquanto consulta webservice.
        $("#local").val("...");
        $("#bairro").val("...");
        
        
        //Consulta o webservice viacep.com.br/
        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
        
        if (!("erro" in dados)) {
          if(dados.localidade !='Barueri'){
            limpa_formulario_cep();
            $("#cep").parent().find('p').text("O CEP não é de Barueri");
            $("#cep").parent().find('span').addClass('verificar');
            $("#cep").css("background" , 'rgba(256,000,000,.1)' );

            $("#local").val('');
            $("#bairro").val('');
  
            $("#input-disabled-local").val('');
            $("#input-disabled-bairro").val('');

          }else{
          //Atualiza os campos com os valores da consulta.
          $("#cep").parent().find('span').removeClass('verificar');
          $("#cep").css("background" , 'white' );
          $("#cep").parent().find('p').text("");
          $("#local").val(dados.logradouro);
          $("#bairro").val(dados.bairro);

          $("#input-disabled-local").val(dados.logradouro);
          $("#input-disabled-bairro").val(dados.bairro);


          }

          
        } //end if.
        else {
          //CEP pesquisado não foi encontrado.
          limpa_formulario_cep();
          $("#cep").parent().find('p').text("CEP não encontrado");
          $("#cep").parent().find('span').addClass('verificar');
          $("#cep").css("background" , 'rgba(256,000,000,.1)' );
          
          // $("#bairro").parent().find('p').text("CEP não encontrado");
          // $("#bairro").parent().find('span').addClass('verificar');
          // $("#bairro").css("background" , 'rgba(256,000,000,.1)' );
          
          // $("#local").parent().find('p').text("CEP não encontrado");
          // $("#local").parent().find('span').addClass('verificar');
          // $("#local").css("background" , 'rgba(256,000,000,.1)' );
        }
      });
    } //end if.
    else {
      //cep é inválido.
      limpa_formulario_cep();
      $("#cep").parent().find('p').text(" o CEP é invalido");
      $("#cep").parent().find('span').addClass('verificar');
      $("#cep").css("background" , 'rgba(256,000,000,.1)' );
      
    }
  } //end if.
  
});

$(".reclamaForm").submit(function(){
  
  var CEPFora = $("#cep").val();
  //alert(CEPFora)
  if( CEPFora == ""){
    $("#cep").parent().find('p').text("Você precisa colocar um CEP");
    $("#cep").parent().find('span').addClass('verificar');
    $("#cep").css("background" , 'rgba(256,000,000,.1)' );
    //return false;
  }else if(CEPFora.length < 8){
    $("#cep").parent().find('p').text("Você precisa colocar um Válido");
    $("#cep").parent().find('span').addClass('verificar');
    $("#cep").css("background" , 'rgba(256,000,000,.1)' );
    return false;
  }else{
    $("#cep").parent().find('span').removeClass('verificar');
    $("#cep").css("background" , 'white' );
    $("#cep").parent().find('p').text("");
  }
  
});

$(".reclamaForm").submit(function(){
  
  var local = $("#local").val();
  
  if( local == ""){
    //$("#local").parent().find('p').text("jaca");
    //$("#local").parent().find('span').addClass('verificar');
    //$("#local").css("background" , 'rgba(256,000,000,.1)' );
    return false;
  }else{
   // $("#local").parent().find('p').text("");
   // $("#local").parent().find('span').removeClass('verificar');
    //$("#local").css("background" , 'white' );
    
  }
  
});

$(".reclamaForm").submit(function(){
  
  var bairro = $("#bairro").val();
  
  if( bairro == "" ){
    $("#bairro").parent().find('p').text("");
    //$("#bairro").parent().find('span').addClass('verificar');
    //$("#bairro").css("background" , 'rgba(256,000,000,.1)' );
    return false;
  }else{
   // $("#bairro").parent().find('p').text("");
   // $("#bairro").parent().find('span').removeClass('verificar');
    //$("#bairro").css("background" , 'white' );
    
  }
  
});

// $(".formulario").submit(function(){
  
// });

// $(document).on("change", "#fotoReclamacao", function(){
//   var InputData = document.getElementById('fotoReclamacao');
//   var caminhoImagem = InputData.value;
//   // verificando a extensão
//   var extensao = caminhoImagem.substring(
//     caminhoImagem.lastIndexOf('.') + 1).toLowerCase();
//     //verificando se é uma img
//     if (extensao == "gif" || extensao == "png"  || extensao == "bmp"
//     || extensao == "jpeg" || extensao == "jpg") {
//       // vai mostrar no preview
//       if (InputData.files && InputData.files[0]) {
//         var reader = new FileReader();
//         reader.onload = function(e) {
//           $('#imgPreview').attr('src', e.target.result);
//           $(".imagem").find('p:last-child').text("");
//         }
//         reader.readAsDataURL(InputData.files[0]);
//       }
//     } 
//     //se não for uma imagem
//     else {
//       $('#imagem').val("");
//       $(".imagem").find('p:last-child').text("esse formato não é valido");
//       return false;
//     }
//   })





});

jQuery(function($){
  $("#abrir-debate-info").click(function(){
    $(".usuarios-debate-info").addClass("usuarios-debate-info-ativo");
    $(".mini-menu-item").removeClass("mini-menu-item-ativo");
  });
  
  $("#fechar-debate-info").click(function(){
    $(".usuarios-debate-info").removeClass("usuarios-debate-info-ativo");
  });
});

jQuery(function($){
  $("#abrir-contatos").click(function(){
    $(".contatos").addClass("contatos-ativo");
    $(".mini-menu-item").removeClass("mini-menu-item-ativo");
  });
  $("#fechar-contatos").click(function(){
    $(".contatos").removeClass("contatos-ativo");
  });
});

jQuery(function($){
  $(".icone-filtro").click(function(){
    $(this).parent().find("form").addClass("filtro-ativo");
  });
  $("#fechar-filtro").click(function(){
    $(this).parent().removeClass("filtro-ativo");
  });
});


jQuery(function($){

  jQuery(document).on("click",".tabelinha-linha", function(event){
  //$(".tabelinha-linha").click(function(){
    var $thisMenu = $(this);
    var classe = $thisMenu.attr('class');
    var motivo = $thisMenu.find('div.motivo').attr("class");
    
   
    var estilo = $(this).find("td:nth-child(1)").find("div").attr('class');
    //alert(estilo);

    if(estilo =='mini-menu-adm'){
      $('body').css('overflow','hidden');
    }else{
      $('body').css('overflow','auto');
    }
    
    
    /*criar uma rotina para remover os outros menu aberto */
    
    if(motivo == "motivo motivo-ativo"){ /* verificar de o motivo ta ativo, se for verdade ele não abre o mini menu */
    }else{
      if(classe == "mini-menu-adm"){/* se não se, se a classe or igual a: execulta */
        
        $(this).find("td:nth-child(1)").find("div.mini-menu-adm").toggleClass("mini-menu-adm-ativo"); //fecha
      }else{ /* se não isso */
        $(this).siblings().find("td:nth-child(1) div").removeClass("mini-menu-adm-ativo"); /* pegar os elementos que não corresponde aesse que esta sendo clicado, e remover a class*/
        $(this).find("td:nth-child(1) div").toggleClass("mini-menu-adm-ativo"); /*  */
        
        
      }
    }
    
    
  });

  jQuery(document).on("click",".mini-menu-adm", function(event){
    $('body').css('overflow','auto');
  //$(".mini-menu-adm").click(function(){
    $(this).find("td:nth-child(1)").find("div").removeClass("mini-menu-adm-ativo");
    
    
  });
});


jQuery(function($){
  
  /*ativar quando clicar e remover tag de ativar */
  jQuery(document).on("click",".motivo-ativar", function(event){
  //$(".motivo-ativar").click(function(){
    
    $(this).parents(":eq(3)").find("div.motivo").addClass("motivo-ativo");
    $(this).parents(":eq(4)").removeClass("tabelinha-linha");
    $(this).promise().then(function(){
      var $this = $(this);
      var alturatela = $this.parents(":eq(3)").find('div.motivo').height();
      var alturabox = $this.parents(":eq(3)").find('.motivo-box').height();
      //alert(alturabox + " " + alturatela)
      
      if( alturabox > alturatela){
        
        $this.parents(":eq(3)").find('div.motivo .motivo-box').css({"top":"0%","transform":"translateX(-50%) translateY(-0%)"});
      }else{
        $this.parents(":eq(3)").find('div.motivo .motivo-box').css({"top":"50%","transform":"translateX(-50%) translateY(-50%)"});
      }
    });
    $("body").css("overflow","hidden");
  });
  
  
  /*fechar quando clicar e colocar de novo tag de ativar*/
  jQuery(document).on("click",".fechar-motivo", function(event){
  //$(".fechar-motivo").click(function(){
    $(this).parents(":eq(2)").removeClass("motivo-ativo");
    $(this).parents(":eq(4)").addClass("tabelinha-linha");
    
    $("body").css("overflow","auto");
  });
  /*fechar quando clicar fora e adicionar class de ativar */
  jQuery(document).on("click",".motivo-fundo", function(event){
  //$(".motivo-fundo").click(function(){
    $(this).parent().removeClass("motivo-ativo");
    $(this).parents(":eq(2)").addClass("tabelinha-linha");
    $("body").css("overflow","auto");
  });
});
//ajustando altura do motivo




/* modal desativar */

jQuery(function($){
  
  $(".desativar-btn").click(function(){
    $(".modal-desativar").addClass("modal-desativar-ativo");
    $("body").css("overflow","hidden");
  });
  /* fechar quando clicar fora*/
  $(".modal-desativar-fundo").click(function(){
    $(this).parent().removeClass("modal-desativar-ativo");
    $("body").css("overflow","auto");
  });
  /* fechar quando clicar no X*/
  $(".fechar-desativar").click(function(){
    $(this).parents(":eq(2)").removeClass("modal-desativar-ativo");
    $("body").css("overflow","auto");
  });
});

// modal add user
jQuery(function($){
  
  $(".cad-adm").click(function(){
    
    $(".modal-adicionar-user").addClass("modal-adicionar-user-ativo");
    $("body").css("overflow","hidden");
  });
  /* fechar quando clicar fora*/
  $(".modal-adicionar-user-fundo").click(function(){
    $(this).parent().removeClass("modal-adicionar-user-ativo");
    $("body").css("overflow","auto");
  });
  /* fechar quando clicar no X*/
  $(".fechar-adicionar-user").click(function(){
    $(this).parents(":eq(2)").removeClass("modal-adicionar-user-ativo");
    $("body").css("overflow","auto");
  });
});

/* modal erro php */

jQuery(function($){
  
  /* fechar quando clicar fora*/
  jQuery(document).on("click",".modal-erro-fundo", function(event){
  //$(".modal-erro-fundo").click(function(){
    $(this).parent().remove();
  });
  /* fechar quando clicar no X*/
  jQuery(document).on("click",".fechar-erro", function(event){
 // $(".fechar-erro").click(function(){
    $(this).parents(":eq(2)").remove();
  });
});

/* alterar capa */

jQuery(function($){
  /* abrir quando clicar */
  $("#trocar-capa").click(function(){
    $("body").css("overflow","hidden");
    $(".modal-troca-foto").addClass("modal-troca-foto-ativo");
    $(document).on("change", "#fotoCapa", function(){
      var InputData = document.getElementById('fotoCapa');
      var caminhoImagem = InputData.value;
      // verificando a extensão
      var extensao = caminhoImagem.substring(
        caminhoImagem.lastIndexOf('.') + 1).toLowerCase();
        //verificando se é uma img
        if (extensao == "gif" || extensao == "png"  || extensao == "bmp"  || extensao == "jpeg" || extensao == "jpg") {
          $(".box-troca-foto").find(".aviso-form-inicial").css("display","none");
          // vai mostrar no preview
          if (InputData.files && InputData.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              // $('.img-capa-corta').attr('src', e.target.result);
              var caminhoprev = $(".img-capa-corta").attr('src');
              //$(".imagem").find('p:last-child').text("");
              //trocar toda vez que uma nova foto for colocada
              $uploadCrop.croppie('bind', {
                url: e.target.result
              }).then(function(){
                console.log('jQuery bind complete');
              });
            };
            reader.readAsDataURL(InputData.files[0]);
          }  
        } 
        //se não for uma imagem
        else {
          $('#fotoCapa').val("");
          $uploadCrop.croppie('destroy');
          $uploadCrop.croppie({             
            enableExif: true,
            enforceBoundary:true,
            enableOrientation:true,
            enableResize:false,
            viewport: {
              width: 320,
              height: 150,
              
            },
            boundary: {
              width: tela,
              height: 200
            },
          });
          
          
          $(".box-troca-foto").find(".aviso-form-inicial").css("display","block");
          $(".box-troca-foto").find(".aviso-form-inicial").find("p").text("Isso não é uma imagem");
          
          return false;
        }
      });
    });
    /* fechar quando clicar fora*/
    $(".modal-troca-foto-fundo").click(function(){
      $("body").css("overflow","auto");
      $(this).parent().removeClass("modal-troca-foto-ativo");
    });
    /* fechar quando clicar no X*/
    $(".fechar-troca-foto").click(function(){
      $("body").css("overflow","auto");
      $(this).parents(":eq(2)").removeClass("modal-troca-foto-ativo");
    });
    
    $("#cortar").click(function (){
      var InputData = document.getElementById('fotoCapa');
      var caminhoImagem = InputData.value;
      if(caminhoImagem == ""){
        $(".box-troca-foto").find(".aviso-form-inicial").css("display","block");
        $(".box-troca-foto").find(".aviso-form-inicial").find("p").text("Selecione uma imagem");
      }else{
        cortar();
      }
    });
    
    function cortar(){
      
      $(".modal-troca-foto").css("opacity", "0");
      
      $('.img-capa-corta').croppie('result', { type: 'html', size: 'original', format: 'jpeg' }).then(function (result) {
        
        
        $('.img-capa-corta').croppie('result', { type: 'canvas', size: { width: 720, height: 350 }, format: 'jpeg' }).then(function (result) {
          $(".modal-troca-foto-previa").addClass("modal-troca-foto-previa-ativo");
          $('.previewCapa').attr('src', result);
          
        });
      });
      
    }
    jQuery(function($){
      /* fechar quando clicar fora*/
      $(".modal-troca-foto-previa-fundo").click(function(){
        $(this).parent().removeClass("modal-troca-foto-previa-ativo");
        $(".modal-troca-foto").css("opacity", "1");
      });
      /* fechar quando clicar no X*/
      $(".fechar-troca-foto-previa").click(function(){
        
        $(".modal-troca-foto-previa").removeClass("modal-troca-foto-previa-ativo");
        $(".modal-troca-foto").css("opacity", "1");
      });
      //fechar quando escolher outra capa
      $(".outra-capa").click(function(){
        $(".modal-troca-foto").css("opacity", "1");
        $(".modal-troca-foto-previa").removeClass("modal-troca-foto-previa-ativo");
      });
    });
  });
  jQuery(function($){
    $(".alterar-capa").click(function (){
      $('.img-capa-corta').croppie('result', { type: 'canvas', size: { width: 1000, height: 467 }, format: 'jpeg' }).then(function (result) {
      
        $("#base64FotoCapa").val(result);
        $(".perfil").find("img").attr("src",result);
        $(".mini-perfil").find("img:last").attr("src",result);
        //alert("blzCAPA")
         $(".modal-troca-foto").removeClass("modal-troca-foto-ativo");
          
         $(".modal-troca-foto-previa").removeClass("modal-troca-foto-previa-ativo");
         $(".modal-troca-foto").css("opacity", "1");
          $("body").css("overflow","auto");
         $("#trocarcapa").submit();
      });

      $("#trocarcapa").submit(function(){
        
        var img = $("#base64FotoCapa").val();  
        idUsu = $("#IDPefil").val(); 
        indVirgula = idUsu.lastIndexOf(','); // na virgula mostra o numero de pasta q tenho q voltar 
        quantVoltar = idUsu.substr(idUsu.lastIndexOf(',') + 1);
        voltar = ""; // por padrao nao volta nenhuma
        if(quantVoltar > 0){ // se existir alguma virgula         
             voltar = '../';              
        }             

        $.ajax({
          url: voltar + "UpdateImagem.php",
          type: "post",
          data: "tipo=capa"+"&imagem="+img,
          success:function(result){
           // alert(result);
            
          }
       });
      // alert("dasdasadsdas");       
        return false;
        
      });
      
    });
  });
  
  //trocar foto perfil
  
  jQuery(function($){
    /* abrir quando clicar */
    $("#trocar-perfil").click(function(){
      $("body").css("overflow","hidden");
      $(".modal-troca-foto-perfil").addClass("modal-troca-foto-perfil-ativo");
      $(document).on("change", "#fotoPerfil", function(){
        var InputData = document.getElementById('fotoPerfil');
        var caminhoImagem = InputData.value;
        // verificando a extensão
        var extensao = caminhoImagem.substring(
          caminhoImagem.lastIndexOf('.') + 1).toLowerCase();
          //verificando se é uma img
          if (extensao == "gif" || extensao == "png"  || extensao == "bmp" || extensao == "jpeg" || extensao == "jpg") {
            $(".box-troca-foto-perfil").find(".aviso-form-inicial").css("display","none");
            // vai mostrar no preview
            if (InputData.files && InputData.files[0]) {
              var reader = new FileReader();
              reader.onload = function(e) {
                // $('.img-capa-corta').attr('src', e.target.result);
                var caminhoprev = $(".img-perfil-corta").attr('src');
                //$(".imagem").find('p:last-child').text("");
                //trocar toda vez que uma nova foto for colocada
                $uploadCropPerfil.croppie('bind', {
                  url: e.target.result
                }).then(function(){
                  console.log('jQuery bind complete');
                });
              };
              reader.readAsDataURL(InputData.files[0]);
            }  
          } 
          //se não for uma imagem
          else {
            $('#fotoPerfil').val("");
            $uploadCropPerfil.croppie('destroy');
            $uploadCropPerfil.croppie({             
              enableExif: true,
              enforceBoundary:true,
              enableOrientation:true,
              enableResize:false,
              viewport: {
                width: 200,
                height: 200,
                type: 'circle'
                
              },
              boundary: {
                width: tela,
                height: 300
              },
            });
            $(".box-troca-foto-perfil").find(".aviso-form-inicial").css("display","block");
            $(".box-troca-foto-perfil").find(".aviso-form-inicial").find("p").text("Isso não é uma imagem");
            
            return false;
          }
        });
      });
      /* fechar quando clicar fora*/
      $(".modal-troca-foto-perfil-fundo").click(function(){
        $("body").css("overflow","auto");
        $(this).parent().removeClass("modal-troca-foto-perfil-ativo");
        
      });
      /* fechar quando clicar no X*/
      $(".fechar-troca-foto-perfil").click(function(){
        $("body").css("overflow","auto");
        $(this).parents(":eq(2)").removeClass("modal-troca-foto-perfil-ativo");
      });
      
      $("#cortarPerfil").click(function (){
        var InputData = document.getElementById('fotoPerfil');
        var caminhoImagem = InputData.value;
        if(caminhoImagem == ""){
          $(".box-troca-foto-perfil").find(".aviso-form-inicial").css("display","block");
          $(".box-troca-foto-perfil").find(".aviso-form-inicial").find("p").text("Selecione uma imagem");
        }else{
          cortarP();
        }
      });
      
      function cortarP(){
        
        $(".modal-troca-foto-perfil").css("opacity", "0");
        
        $('.img-perfil-corta').croppie('result', { type: 'html', size: 'original', format: 'jpeg' }).then(function (result) {
          
          
          $('.img-perfil-corta').croppie('result', { type: 'canvas', size: { width: 180, height: 180 }, format: 'jpeg' }).then(function (result) {
            $(".modal-troca-foto-perfil-previa").addClass("modal-troca-foto-perfil-previa-ativo");
            $('.previewPerfil').attr('src', result);
            
          });
        });
        
      }
      jQuery(function($){
        /* fechar quando clicar fora*/
        $(".modal-troca-foto-perfil-previa-fundo").click(function(){
          
          $(".modal-troca-foto-perfil modal-troca-foto-perfil-ativo").css("opacity", "0");
          $(this).parent().removeClass("modal-troca-foto-previa-perfil-ativo");
        });
        /* fechar quando clicar no X*/
        $(".fechar-troca-foto-perfil-previa").click(function(){
          
          
          $(".modal-troca-foto-perfil-previa").removeClass("modal-troca-foto-perfil-previa-ativo");
          $(".modal-troca-foto-perfil").css("opacity", "1");
        });
        //fechar quando escolher outra foto
        $(".outra-perfil").click(function(){
          
          
          $(".modal-troca-foto-perfil-previa").removeClass("modal-troca-foto-perfil-previa-ativo");
          $(".modal-troca-foto-perfil").css("opacity", "1");
        });
      });
    });
    jQuery(function($){
      $(".alterar-perfil").click(function (){
        $('.img-perfil-corta').croppie('result', { type: 'canvas', size: { width: 200, height: 200 }, format: 'jpeg', circle:false }).then(function (result) {
          $("#base64FotoPerfil").val(result);
         
          
            
             $(".modal-troca-foto-perfil").removeClass("modal-troca-foto-perfil-ativo");
             $(".modal-troca-foto-perfil-previa").removeClass("modal-troca-foto-perfil-previa-ativo");
             $(".modal-troca-foto-perfil").css("opacity", "1");
             $("body").css("overflow","auto");
           

             $("#trocarperfil").submit();
      $("#baconP").click(function(){
        //alert($("#base64FotoPerfil").val());
        
        
      });

    
      });
      

    
  });

  $("#trocarperfil").submit(function(){
    var tipoPerfil =$(".ativo").find("a").text();
    var img = $("#base64FotoPerfil").val();

      idUsu = $("#IDPefil").val(); 
      indVirgula = idUsu.lastIndexOf(','); // na virgula mostra o numero de pasta q tenho q voltar 
      quantVoltar = idUsu.substr(idUsu.lastIndexOf(',') + 1);
      voltar = ""; // por padrao nao volta nenhuma
      if(quantVoltar > 0){ // se existir alguma virgula         
            voltar = '../';              
      }     

   // alert('asa');
    $.ajax({
      
      url:voltar+"UpdateImagem.php",
      type: "post",
      data: "tipo=perfil"+"&imagem="+img,
      success:function(result){

      
        $(".perfil-info").find("img").attr("src",img);
        
        $(".mini-perfil").find("img:first-child").attr("src",img);
        if(tipoPerfil == "Reclamação" || tipoPerfil == "Debate"){
         // alert("comum")
          $(".item-topo").find("img").attr("src",img);
        }else{
          //alert("pref")
        }
       // alert("asas");
      }
    });
    
    

  //alert("blza")
  return false;
  });
    });
    //trocar foto reclamacao
    
    jQuery(function($){
      function recriarReclama (){
        $uploadCropReclamacao.croppie('destroy');
        $uploadCropReclamacao.croppie({             
          enableExif: true,
          enforceBoundary:true,
          enableOrientation:true,
          enableResize:false,
          viewport: {
              width: 280,
              height: 190,
              
          },
          boundary: {
              width: tela,
              height: 300
          },
        });
      }
      /* abrir quando clicar */
      $("#colocar-foto-reclamacao").click(function(){
        $("body").css("overflow","hidden");
        $(".modal-troca-foto-reclamacao").addClass("modal-troca-foto-reclamacao-ativo");
        $(document).on("change", "#fotoReclamacao", function(){
          var InputData = document.getElementById('fotoReclamacao');
          var caminhoImagem = InputData.value;
          // verificando a extensão
          var extensao = caminhoImagem.substring(
            caminhoImagem.lastIndexOf('.') + 1).toLowerCase();
            //verificando se é uma img
            if (extensao == "gif" || extensao == "png"  || extensao == "bmp"|| extensao == "jpeg" || extensao == "jpg") {
              $(".box-troca-foto-reclamacao").find(".aviso-form-inicial").css("display","none");
              // vai mostrar no preview
              if (InputData.files && InputData.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                  // $('.img-capa-corta').attr('src', e.target.result);
                  var caminhoprev = $(".img-reclamacao-corta").attr('src');
                  //$(".imagem").find('p:last-child').text("");
                  //trocar toda vez que uma nova foto for colocada
                  $uploadCropReclamacao.croppie('bind', {
                    url: e.target.result
                  }).then(function(){
                    console.log('jQuery bind complete');
                  });
                };
                reader.readAsDataURL(InputData.files[0]);
              }  
            } 
            //se não for uma imagem
            else {
              $('#fotoReclamacao').val("");
              recriarReclama();
              $(".box-troca-foto-reclamacao").find(".aviso-form-inicial").css("display","block");
              $(".box-troca-foto-reclamacao").find(".aviso-form-inicial").find("p").text("Isso não é uma imagem");
              
              return false;
            }
          });
        });
        /* fechar quando clicar fora*/
        $(".modal-troca-foto-reclamacao-fundo").click(function(){
          $("body").css("overflow","auto");
          $(this).parent().removeClass("modal-troca-foto-reclamacao-ativo");
          $('#fotoReclamacao').val("");
          recriarReclama();
        });
        /* fechar quando clicar no X*/
        $(".fechar-troca-foto-reclamacao").click(function(){
          $("body").css("overflow","auto");
          $(this).parents(":eq(2)").removeClass("modal-troca-foto-reclamacao-ativo");
          $('#fotoReclamacao').val("");
          recriarReclama();
        });
        
        $("#cortarReclamacao").click(function (){
          var InputData = document.getElementById('fotoReclamacao');
          var caminhoImagem = InputData.value;
          if(caminhoImagem == ""){
            $(".box-troca-foto-reclamacao").find(".aviso-form-inicial").css("display","block");
            $(".box-troca-foto-reclamacao").find(".aviso-form-inicial").find("p").text("Selecione uma imagem");
          }else{
            cortarR();
          }
        });
        
        function cortarR(){
          
          $(".modal-troca-foto-reclamacao").css("opacity", "0");
          
          $('.img-reclamacao-corta').croppie('result', { type: 'html', size: 'original', format: 'jpeg' }).then(function (result) {
            
            
            $('.img-reclamacao-corta').croppie('result', { type: 'canvas', size: { width: 500, height: 350 }, format: 'jpeg' }).then(function (result) {
              $(".modal-troca-foto-reclamacao-previa").addClass("modal-troca-foto-reclamacao-previa-ativo");
              $('.previewReclamacao').attr('src', result);
              
            });
          });
          
        }
        jQuery(function($){
          /* fechar quando clicar fora*/
          $(".modal-troca-foto-reclamacao-previa-fundo").click(function(){
            
            $(".modal-troca-foto-reclamacao modal-troca-foto-reclamacao-ativo").css("opacity", "0");
            $(this).parent().removeClass("modal-troca-foto-previa-reclamacao-ativo");
          });
          /* fechar quando clicar no X*/
          $(".fechar-troca-foto-reclamacao-previa").click(function(){
            
            
            $(".modal-troca-foto-reclamacao-previa").removeClass("modal-troca-foto-reclamacao-previa-ativo");
            $(".modal-troca-foto-reclamacao").css("opacity", "1");
          });
          //fechar quando escolher outra foto
          $(".outra-reclamacao").click(function(){
            
            
            $(".modal-troca-foto-reclamacao-previa").removeClass("modal-troca-foto-reclamacao-previa-ativo");
            $(".modal-troca-foto-reclamacao").css("opacity", "1");
          });
        });
      });
      jQuery(function($){
        $(".alterar-reclamacao").click(function (){
          $('.img-reclamacao-corta').croppie('result', { type: 'canvas', size: { width: 500, height: 350 }, format: 'jpeg' }).then(function (result) {
            //$("#fotoReclamacao").attr("value", result)
            $("#base64").val(result);
            $('#imgPreview').attr('src',result);
            $(".imagem").find('p:last-child').text("");
            $(".modal-troca-foto-reclamacao-previa").removeClass("modal-troca-foto-reclamacao-previa-ativo");
            $(".modal-troca-foto-reclamacao").css("opacity", "1");
            $(".modal-troca-foto-reclamacao").removeClass("modal-troca-foto-reclamacao-ativo");
            $("body").css("overflow","auto");
          });
          
        });
        
        jQuery(function($){
          
          
         // $("#bacon").click(function(){
          //  alert($("#base64").val());
            
            
          //})
        });
      });
      
      //trocar foto debate
      
      jQuery(function($){
        function recriaDb(){
          $uploadCropReclamacao.croppie('destroy');
          $uploadCropReclamacao.croppie({             
                
            enableExif: true,
            enforceBoundary:true,
            enableOrientation:true,
            enableResize:false,
            viewport: {
                width: 280,
                height: 190,
                
            },
            boundary: {
                width: tela,
                height: 300
            },
          });
        }
        
        /* abrir quando clicar */
        $("#abrir-cortar").click(function(){
          $("body").css("overflow","hidden");
          $(".modal-troca-foto-reclamacao").addClass("modal-troca-foto-reclamacao-ativo");
          $(document).on("change", "#imagemDebateInput", function(){
            var InputData = document.getElementById('imagemDebateInput');
            var caminhoImagem = InputData.value;
            // verificando a extensão
            var extensao = caminhoImagem.substring(
              caminhoImagem.lastIndexOf('.') + 1).toLowerCase();
              //verificando se é uma img
              if (extensao == "gif" || extensao == "png"  || extensao == "bmp" || extensao == "jpeg" || extensao == "jpg") {
                $(".box-troca-foto-reclamacao").find(".aviso-form-inicial").css("display","none");
                // vai mostrar no preview
                if (InputData.files && InputData.files[0]) {
                  var reader = new FileReader();
                  reader.onload = function(e) {
                    // $('.img-capa-corta').attr('src', e.target.result);
                    var caminhoprev = $(".img-reclamacao-corta").attr('src');
                    //$(".imagem").find('p:last-child').text("");
                    //trocar toda vez que uma nova foto for colocada
                    $uploadCropReclamacao.croppie('bind', {
                      url: e.target.result
                    }).then(function(){
                      console.log('jQuery bind complete');
                    });
                  };
                  reader.readAsDataURL(InputData.files[0]);
                }  
              } 
              //se não for uma imagem
              else {
                $('#imagemDebateInput').val("");
                recriaDb();
                $(".box-troca-foto-reclamacao").find(".aviso-form-inicial").css("display","block");
                $(".box-troca-foto-reclamacao").find(".aviso-form-inicial").find("p").text("Isso não é uma imagem");
                
                return false;
              }
            });
          });
          /* fechar quando clicar fora*/
          $(".modal-troca-foto-reclamacao-fundo").click(function(){
            $("body").css("overflow","auto");
            $(this).parent().removeClass("modal-troca-foto-reclamacao-ativo");
            
          });
          /* fechar quando clicar no X*/
          $(".fechar-troca-foto-reclamacao").click(function(){
            $("body").css("overflow","auto");
            $(this).parents(":eq(2)").removeClass("modal-troca-foto-reclamacao-ativo");
          });
          
          $("#cortarDebate").click(function (){
            var InputData = document.getElementById('imagemDebateInput');
            var caminhoImagem = InputData.value;
            if(caminhoImagem == ""){
              $(".box-troca-foto-reclamacao").find(".aviso-form-inicial").css("display","block");
              $(".box-troca-foto-reclamacao").find(".aviso-form-inicial").find("p").text("Selecione uma imagem");
            }else{
              cortarD();
            }
          });
          
          function cortarD(){
            
            $(".modal-troca-foto-reclamacao").css("opacity", "0");
            
            $('.img-reclamacao-corta').croppie('result', { type: 'html', size: 'original', format: 'jpeg' }).then(function (result) {
              
              
              $('.img-reclamacao-corta').croppie('result', { type: 'canvas', size: { width: 500, height: 350 }, format: 'jpeg' }).then(function (result) {
                $(".modal-troca-foto-reclamacao-previa").addClass("modal-troca-foto-reclamacao-previa-ativo");
                $('.previewReclamacao').attr('src', result);
                
              });
            });
            
          }
          jQuery(function($){
            /* fechar quando clicar fora*/
            $(".modal-troca-foto-reclamacao-previa-fundo").click(function(){
              
              $(".modal-troca-foto-reclamacao modal-troca-foto-reclamacao-ativo").css("opacity", "0");
              $(this).parent().removeClass("modal-troca-foto-previa-reclamacao-ativo");
            });
            /* fechar quando clicar no X*/
            $(".fechar-troca-foto-reclamacao-previa").click(function(){
              
              
              $(".modal-troca-foto-reclamacao-previa").removeClass("modal-troca-foto-reclamacao-previa-ativo");
              $(".modal-troca-foto-reclamacao").css("opacity", "1");
            });
            //fechar quando escolher outra foto
            $(".outra-reclamacao").click(function(){
              
              
              $(".modal-troca-foto-reclamacao-previa").removeClass("modal-troca-foto-reclamacao-previa-ativo");
              $(".modal-troca-foto-reclamacao").css("opacity", "1");
            });
          });
        });
        jQuery(function($){
          $(".alterar-reclamacao").click(function (){
            $('.img-reclamacao-corta').croppie('result', { type: 'canvas', size: { width: 500, height: 350 }, format: 'jpeg' }).then(function (result) {
              $("#base64").val(result);
              $('#imagemDebateInput').attr('src',result);
              //alert(result)
              $(".imagem").find('p:last-child').text("");
              $(".modal-troca-foto-reclamacao-previa").removeClass("modal-troca-foto-reclamacao-previa-ativo");
              $(".modal-troca-foto-reclamacao").css("opacity", "1");
              $(".modal-troca-foto-reclamacao").removeClass("modal-troca-foto-reclamacao-ativo");
              $("body").css("overflow","auto");
            });
            
          });
          
        });
        
        
        
        
        
        /* verificação login */
        
        jQuery(function($){
          $("#login").submit(function(){
            var senha = $("#senha").val();
            if( senha === ""){
              $("#senha").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#senha").css("border-color" , 'rgba(256,000,000)');
              $("#senha").focus();
              return false;
            }else{
              $("#senha").parent().find("label").css("background-color" , 'dodgerblue' );
              $("#senha").css("border-color" , 'dodgerblue');
            }
          });
          
          $("#login").submit(function(){
            var email = $("#email").val();
            if( email === ""){
              $("#email").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#email").css("border-color" , 'rgba(256,000,000)');
              $("#email").focus();
              return false;
            }else{
              $("#email").parent().find("label").css("background-color" , 'dodgerblue' );
              $("#email").css("border-color" , 'dodgerblue');
            }
          });
          
          
          $("#login").submit(function(){
            var email = $("#email").val();
            var senha = $("#senha").val();
            
            if( email === "" && senha === ""){
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("O email e a senha então vazios");
              return false;
            }else if( senha === ""){
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("você precisa digitar um senha");
              return false;
            }else if(email === ""){
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("você precisa digitar uma E-mail");
              return false;
            }else{ // se tudo estiver preenchido executa o ajax      
              /* AJAX DE FAZER LOGIN */           
              $(".aviso-form-inicial").hide();                          
                $.ajax({
                    url:"Login.php",
                    type: "post",
                    data: "email="+email+"&senha="+senha,
                    success:function(result){
                        if(result=="1"){
                            location.href="perfil_reclamacao";
                        }else{                            
                            $(".aviso-form-inicial").show();
                            $(".aviso-form-inicial").find("p").text(result);
                        }
                    }  
              });
              return false;
            }
          });      
        });      
    
        
        /* verificação cadastro */
        
        jQuery(function($){
          
          
          $("#cadastro").submit(function(){
            var senhaC = $("#senhaC").val();
            if( senhaC === ""){
              $("#senhaC").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#senhaC").css("border-color" , 'rgba(256,000,000)');
              $("#senhaC").focus();
              return false;
            }else{
              $("#senhaC").parent().find("label").css("background-color" , 'dodgerblue' );
              $("#senhaC").css("border-color" , 'dodgerblue');
            }
          });
          $("#cadastro").submit(function(){
            var senha = $("#senha").val();
            if( senha === ""){
              $("#senha").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#senha").css("border-color" , 'rgba(256,000,000)');
              $("#senha").focus();
              return false;
            }else{
              $("#senha").parent().find("label").css("background-color" , 'dodgerblue' );
              $("#senha").css("border-color" , 'dodgerblue');
            }
          });
          $("#cadastro").submit(function(){
            var email = $("#email").val();
            if( email === ""){
              $("#email").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#email").css("border-color" , 'rgba(256,000,000)');
              $("#email").focus();
              return false;
            }else{
              $("#email").parent().find("label").css("background-color" , 'dodgerblue' );
              $("#email").css("border-color" , 'dodgerblue');
            }
          });
          $("#cadastro").submit(function(){
            var user = $("#user").val();
            if( user === ""){
              $("#user").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#user").css("border-color" , 'rgba(256,000,000)');
              $("#user").focus();
              return false;
            }else{
              $("#user").parent().find("label").css("background-color" , 'dodgerblue' );
              $("#user").css("border-color" , 'dodgerblue');
            }
          });
          $("#cadastro").submit(function(){
            var user = $("#user").val();
            var email = $("#email").val();
            var senha = $("#senha").val();
            var senhaC = $("#senhaC").val();
            if(senhaC !== senha && senhaC !==""){
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("confirmar senha não esta igual a senha, tente de novo");
              return false;
            }else{
              if( user === ""){
                $(".aviso-form-inicial").show();
                $(".aviso-form-inicial").find("p").text("você precisa preencher o nome de usuário");
              }else if( email === ""){
                $(".aviso-form-inicial").show();
                $(".aviso-form-inicial").find("p").text("você precisa digitar um E-mail");
              }else if( senha === ""){
                $(".aviso-form-inicial").show();
                $(".aviso-form-inicial").find("p").text("você precisa digitar um senha");
              }else if(senhaC === ""){
                $(".aviso-form-inicial").show();
                $(".aviso-form-inicial").find("p").text("você precisa comfirmar a senha");
              }else{ // AJAX CADASTRAR
                /* AJAX CADASTRAR */
                $(".aviso-form-inicial").hide();
                $.ajax({
                  url:"CadastrarUser.php",
                  type: "post",
                  data: "email="+email+"&senha="+senha+"&nome="+user,
                  success:function(result){
                      if(result=="1"){
                          location.href="Pagina-agradecimento";
                      }else{
                        $("#email").parent().find("label").css("background-color" , 'rgba(256,000,000)');
                        $("#email").css("border-color" , 'rgba(256,000,000)');
                        $("#email").focus();
                        $(".aviso-form-inicial").show();
                        $(".aviso-form-inicial").find("p").text(result);
                      }
                  }  
                });
                  return false;
              }
              
            }
          });
        });
        
        jQuery(function($){
          $(".item-participante").click(function(){
            
            var $this = $(this);
            $this.find(".mini-menu-item").toggleClass("mini-menu-item-ativo");
            
          });
        });
        
        // verficação add user
        
        /* verificação login */
        
        jQuery(function($){
          
          $("#add-user-form").submit(function(){
            
            if($('input[name=tipo]:checked').length<=0)
            {              
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("Escolha um tipo de usuário");
              return false;
            }else{
              //$(".aviso-form-inicial").show();
              //$(".aviso-form-inicial").find("p").text("")    
            }
            
          });
          

          
          $("#add-user-form").submit(function(){
            var senha = $("#senha").val();
            if( senha === ""){
              $("#senha").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#senha").css("border-color" , 'rgba(256,000,000)');
              $("#senha").focus();
              return false;
            }else{
              $("#senha").parent().find("label").css("background-color" , 'dodgerblue' );
              $("#senha").css("border-color" , 'dodgerblue');
            }
          });
          
          $("#add-user-form").submit(function(){
            var email = $("#email").val();
            if( email === ""){
              $("#email").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#email").css("border-color" , 'rgba(256,000,000)');
              $("#email").focus();
              return false;
            }else{
              $("#email").parent().find("label").css("background-color" , 'dodgerblue' );
              $("#email").css("border-color" , 'dodgerblue');
            }
          });

          $("#add-user-form").submit(function(){
            var user = $("#user").val();
            if( user === ""){
              $("#user").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#user").css("border-color" , 'rgba(256,000,000)');
              $("#user").focus();
              return false;
            }else{
              $("#user").parent().find("label").css("background-color" , 'dodgerblue' );
              $("#user").css("border-color" , 'dodgerblue');
            }
          });
          
          
          $("#add-user-form").submit(function(){
            var user = $("#user").val();
            var email = $("#email").val();
            var senha = $("#senha").val();
            var tipo = $('input[name=tipo]:checked').val();
            if( email === "" && senha === "" && user === ""){
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("campos obrigatorios");
            }else if(email === ""){
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("você precisa digitar uma E-mail");
            }else if( senha === ""){
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("você precisa digitar um senha");
            }else{
              $.ajax({
                url:"../CadastrarUser.php",
                type: "post",
                data: "email="+email+"&senha="+senha+"&nome="+user+"&tipo="+tipo,
                success:function(result){
                  //alert(result)
                  var retorno = result;
                  var id = retorno.substring(retorno.lastIndexOf('.') + 1, retorno.lastIndexOf(','));
                  var tipoCadastrador = retorno.substring(0 ,retorno.lastIndexOf('.'));
                  var data =  retorno.substring(retorno.lastIndexOf(',') + 1 );

               user = $("#user").val();
               email = $("#email").val();
                  

                  //alert(tipoCadastrador +'A'+ id+'A'+data)
                   // 1 = adm q realizou o cadastro
                   // 2 = prefeitura q realizou o cadastro
                    if(tipoCadastrador == "1" || tipoCadastrador == "2"){
                      if(tipoCadastrador == "2"){
                        tipo = email;
                      }
                      /* Fechar o modal do cadastro*/
                      $('.modal-adicionar-user').removeClass("modal-adicionar-user-ativo"); 
                      $("body").css("overflow","auto");
                     //alerta('Certo', 'Denuncia feita com sucesso');
                      /* aqui da pra abrir um modal pra falar q o cadastro deu certo */

                      $('<tr class="tabelinha-linha"><td>\
                      <div class="mini-menu-adm">\
                              <ul>\
                                  <li><a href="../ApagarUsuario.php?ID='+id+'" class="remover-usuario">Remover</a></li>\
                              </ul>\
                      </div>\
                      <p>'+user+'</p>\
                  </td><td>'+tipo+'</td><td>'+data+'</td></tr>').insertBefore('.tabelinha-linha:nth-child(3)');
                user = $("#user").val('');
                email = $("#email").val('');
                senha = $("#senha").val('');
                //tipo = $('input[name=tipo]').val('');
                alerta('Certo','Usuário adicionado')
                      /* Da um submit no formulario de filto de usuario */
        
                                       
                    }else{
                        $(".aviso-form-inicial").show();
                        $(".aviso-form-inicial").find("p").text(result);
                    }
                }  
              });
                return false;
            }
          });
        });


        /* VALIDACAO PRA QUANDO O USUARIO FIZER A MUDANCA DE NOME E EMAIL */

        jQuery(function($){
          var emailAntigo = $("#email").val();
          var nomeAntigo = $("#user").val();

          $("#FormUpdateNomeEmail").submit(function(){
            var email = $("#email").val();            
            if(email === ""){
              //$("#user").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#email").css("border-color" , 'rgba(256,000,000)');
              $("#email").focus();
              return false;
            }else{              
              $("#email").css("border-color" , 'none'); // tirar a cor da borda
            }
          });

          $("#FormUpdateNomeEmail").submit(function(){
              var nome = $("#user").val();
              if(nome === ""){
                //$("#user").parent().find("label").css("background-color" , 'rgba(256,000,000)');
                $("#user").css("border-color" , 'rgba(256,000,000)');
                $("#user").focus();
                return false;
              }else{
                $("#user").css("border-color" , 'none'); // tirar a cor da borda
              }
          });

          $("#FormUpdateNomeEmail").submit(function(){            
            var email = $("#email").val(); 
            var nome = $("#user").val();

            if(email === "" && nome === ""){
              $(".aviso-form-inicial").css("background-color", "red");
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("campos obrigatórios");
            }else if(email === ""){
              $(".aviso-form-inicial").css("background-color", "red");
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("você precisa digitar um E-mail");
            }else if(nome === ""){
              $(".aviso-form-inicial").css("background-color", "red");
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("você precisa digitar um nome");
            }else if(email === emailAntigo && nome === nomeAntigo){ // se nao houver nenhuma mudança
              $(".aviso-form-inicial").css("background-color", "red");
              $("#user").focus(); 
              $("#user").css("border" , '2px solid red');
              $("#email").css("border" , '2px solid red');
              $(".aviso-form-inicial").show();
              $(".aviso-form-inicial").find("p").text("não houve alterações");              
              return false;
            }else{              
              $.ajax({
                url:"updateNomeEmail.php",
                type: "post",
                data: "email="+email+"&nome="+nome,
                success:function(result){                  
                    if(result == "1"){ // alteracao realizada
                      $(".mini-perfil").find("p").text(nome);
                      $(".aviso-form-inicial").css("background-color", "green");
                      $("#user").css("border" , '2px solid green');
                      $("#email").css("border" , '2px solid green');                  
                      $(".aviso-form-inicial").show();
                      $(".aviso-form-inicial").find("p").text("Alteração realizada com sucesso");   
                      emailAntigo = email;
                      nomeAntigo = nome;
                    }else if(result === "emailExistente" ){ // email ja existente
                      $(".aviso-form-inicial").css("background-color", "red");
                        $(".aviso-form-inicial").show();
                        $(".aviso-form-inicial").find("p").text("Email ja existente");                        
                        $("#email").css("border" , '2px solid red');
                        $("#email").focus();                      
                    }else{
                      $(".aviso-form-inicial").show();
                      $(".aviso-form-inicial").find("p").text(result);  
                    }
                }  
              });              
                return false;
            }            
          });            
        });

       /* FIM VALIDACAO PARA EMAIL E NOME*/


       /* VALIDACAO UPDATE SENHA*/

       jQuery(function($){        

        $("#formUpdateSenha").submit(function(){
          var senhaAtual = $("#passAtual").val();            
          if(senhaAtual === ""){
            $("#passAtual").css("border" , '2px solid red');      
            return false;
          }else{              
            $("#passAtual").css("border-color" , 'none'); // tirar a cor da borda
          }
        });

        $("#formUpdateSenha").submit(function(){
            var novaSenha = $("#passNova").val();
            if(novaSenha === ""){
              //$("#user").parent().find("label").css("background-color" , 'rgba(256,000,000)');
              $("#passNova").css("border" , '2px solid red');          
              return false;
            }else{
              $("#passNova").css("border-color" , ''); // tirar a cor da borda
            }
        });

        $("#formUpdateSenha").submit(function(){
          var novaSenhaC = $("#passNovaRepete").val();
          if(novaSenhaC === ""){
            //$("#user").parent().find("label").css("background-color" , 'rgba(256,000,000)');
            $("#passNovaRepete").css("border" , '2px solid red');          
            return false;
          }else{
            $("#passNovaRepete").css("border-color" , ''); // tirar a cor da borda
          }
      });

        $("#formUpdateSenha").submit(function(){            
          var senhaAtual = $("#passAtual").val();
          var novaSenha = $("#passNova").val();
          var novaSenhaC = $("#passNovaRepete").val();

          if(senhaAtual === "" && novaSenha === "" && novaSenhaC == ""){
            $(".aviso-form-inicial").css("background-color", "red");
            $(".aviso-form-inicial").show();
            $(".aviso-form-inicial").find("p").text("campos obrigatórios");
            $("#passAtual").focus();
          }else if(senhaAtual === ""){
            $(".aviso-form-inicial").css("background-color", "red");
            $(".aviso-form-inicial").show();
            $(".aviso-form-inicial").find("p").text("você precisa digitar a senha atual");
            $("#passAtual").focus();
          }else if(novaSenha === ""){
            $(".aviso-form-inicial").css("background-color", "red");
            $(".aviso-form-inicial").show();
            $(".aviso-form-inicial").find("p").text("você precisa digitar a nova senha");
            $("#passNova").focus();
          }else if(novaSenhaC === ""){
            $(".aviso-form-inicial").css("background-color", "red");
            $(".aviso-form-inicial").show();
            $(".aviso-form-inicial").find("p").text("você precisa confirmar a nova senha");  
            $("#passNovaRepete").focus();
          }else if(novaSenha !== novaSenhaC){ // senhas nao sao iguais
            $(".aviso-form-inicial").css("background-color", "red");
            $(".aviso-form-inicial").show();
            $(".aviso-form-inicial").find("p").text("confirmar senha não esta igual a senha");  
            $("#passNovaRepete").css("border-color" , 'rgba(256,000,000)');
            $("#passNovaRepete").focus();
            return false;
          }else if(novaSenha === senhaAtual){ // nao houve alteracoes
            $(".aviso-form-inicial").css("background-color", "red");
            $(".aviso-form-inicial").show();
            $(".aviso-form-inicial").find("p").text("Não houve alterações");  
            $("#passNovaRepete").css("border" , '2px solid red');
            $("#passNova").css("border" , '2px solid red');      
            $("#passNova").focus();
            return false;
          }else{    // tudo certo          
            $.ajax({
              url:"updateSenha.php",
              type: "post",
              data: "senhaAntiga="+senhaAtual+"&novaSenha="+novaSenha,
              success:function(result){                  
                  if(result == "1"){ // alteracao realizada
                    $(".aviso-form-inicial").css("background-color", "green");
                    $("#passNovaRepete").css("border-color" , 'green');
                    $("#passNova").css("border-color" , 'green');    
                    $("#passAtual").css("border-color" , 'green');                      
                    $(".aviso-form-inicial").show();
                    $(".aviso-form-inicial").find("p").text("Alteração realizada com sucesso"); 
                  }else if(result == "5"){ // senha incorreta
                    $(".aviso-form-inicial").css("background-color", "red");
                    $(".aviso-form-inicial").show();
                    $(".aviso-form-inicial").find("p").text("Senha incorreta"); 
                    $("#passAtual").css("border-color" , 'rgba(256,000,000)'); 
                    $("#passAtual").focus();          
                  }else{
                    $(".aviso-form-inicial").show();
                    $(".aviso-form-inicial").find("p").text(result);
                  }
              }  
            });              
              return false;
          }            
        });            
      });


    /* FIM VALIDACAO UPDATE SENHA*/

  /* REMOVER PUBLICACAO */
  jQuery(function($){
    $(document).on("click", ".remover_publicacao",function(){
    var href = $(this).attr("href");
    var id = href.substring(href.lastIndexOf('ID') + 3);
    var tipo = href.substring(0,href.lastIndexOf('.'));
    //var tipoMensagem = tipo.substring(6)
    //alert(tipo)
    var $this = $(this);
    
     //AJAX
     //caso dê certo e tem que dar
    //pegar o id
     // var id = $(this).data("id")
      
     $.ajax({
      url:tipo+".php",
      type: "get",
      data: "ID="+id,
      success:function(result){
          if(result == 'NLogado'){ // Nao esta logado, redirecionar pra fazer login
            location.href="login.php";
            return false;
          }else{
            //alert("deu certo")
            alerta('Errado','removido');
            $this.parents(":eq(5)").remove();
            if($('.item-publicacao').length == '0'){
              jaquinha();
             }
            //alert(tipo);
            
            //alerta ('Errado', 'removido');
            
            if(tipo == '../ApagarComentario'){ // se for apagar comentario, vai ter um retorno da qtd de comentarios dessa publi             
              $("#qtd_comen").text(result); // ai altera
              if($('.comentario-user').length == 0){//$(document).

                if($('.icone-adm').length >= 1){

                }else{
              //     $('.comentarios').find('h3:first').html("<div class='empty-state' style='margin: 0 auto;'>\
              //     <div>\
              //         <div style='overflow: hidden; border-radius: 50%; width: 280px; height: 280px;'>\
              //            <img src='imagens/comentario-sem.png' style='width: 280px;'>\
              //         </div>\
              //         <div>\
              //             <p style='margin: 0 auto; width:90%'>Parece que ninguém deixou sua marca aqui, seja o primerio a fazer uma, deixe um comentário </p>\
              //             <a id='scrollcomentario' class='cta'> Comentar</a>\
              //         </div>\
              //     </div>\
              // </div>");
                }

              }
              verificarSeFazRolagem();
              
            }
          }          
          
      }
   });
     return false;
    });

  });
  /* FIM REMOVER PUBLICACAO */



  /* denuncia */
jQuery(function($){
  id = "";
  $this = "";
  final = "";
  id_certo ="";
  /* abrir quando */
    $(document).on("click", ".denunciar-item", function(){
      //pegar o id
    id=$(this).data("id");
    $this = $(this);
    final = id.substring(id.lastIndexOf('.')+1);
    id_certo = id.substring(0, id.lastIndexOf('.'));

    indVirgula = id.lastIndexOf(','); // na virgula mostra o numero de pasta q tenho q voltar 

    voltar = ""; // por padrao nao volta nenhuma
    if(indVirgula > 0){ // se existir alguma virgula
      final = id.substring(id.lastIndexOf('.')+1, id.lastIndexOf(',')); // pega até a virgula (Publicacao ou Debate ou Comentario)
      quantVoltar = id.substr(id.lastIndexOf(',') + 1); // pega a quantidade de pasta q tem q voltar
      for(i=0; i < quantVoltar; i++){
         voltar = voltar + "../";
      }      
    }      
   
    
    if(final == 'Publicacao'){
      final = voltar + "Denunciar"+final+".php";
    }else if(final == 'Debate'){
      final = voltar + "Denunciar"+final+".php";
    }else if(final == 'Comentario'){
      final = voltar + "Denunciar"+final+".php";
    }else{
      return false;
    }
    
    //mandar o id 
    $(".modal-denunciar").find("form input").val(id);
      $("div.modal-denunciar").addClass("modal-denunciar-ativo");
      $("body").css("overflow","hidden");
    });
    /* fechar quando clicar fora*/
    $(".modal-denunciar-fundo").click(function(){
      $(this).parent().removeClass("modal-denunciar-ativo");
      $("body").css("overflow","auto");
    });
    /* fechar quando clicar no X*/
    $(".fechar-denuncia").click(function(){
      $(this).parents(":eq(2)").removeClass("modal-denunciar-ativo");
      $("body").css("overflow","auto");
    });

  $("#formdenuncia").submit(function(){
  var txt = $("#motivo").val();

  if(txt ==""){
    $(".aviso-form-inicial").show();
    $(".aviso-form-inicial").find("p").text("você precisa digitar algo");
    return false;
  }else{
    $(".aviso-form-inicial").hide();
    
    //ajax aqui
    $.ajax({
      url:final,
      type: "post",
      data: "id="+id_certo+"&texto="+txt,
      success:function(result){
          if(result == 'NLogado'){ // Nao esta logado, redirecionar pra fazer login
            location.href= voltar + "login";
            return false;
          }else{
            //alert("deu certo");
            alerta('Certo', 'Denúncia realizada com sucesso');
           //Resetando VALORES do modal ao enviar o ajax
           $("div.modal-denunciar").removeClass("modal-denunciar-ativo");
           $this.attr('class','');
           $this.find('a').html('<li><i class="icone-bandeira"></i><span class="negrito">Denunciado</span></li>');
            $("#motivo").val("");
            $(".modal-denunciar").find("form input").val("");
            $("body").css("overflow","auto");
          }          
          
      }
   });
    return false;
  }

  });
});

jQuery(function($){
  $("#enviar_comentario").submit(function(){
    
  //var caminho = $(this).attr('action');

  
  var comentario = $("#comentarioTxt").val().replace(/(^\s*)|(\s*$)/gi,"");
  comentario = comentario.replace(/[ ]{2,}/gi," ");
  comentario = comentario.replace(/\n /,"\n");

  if(comentario == '' || comentario == ' '){
    
    $("#enviar_comentario").find(".aviso-form-inicial").show();
    $(".aviso-form-inicial").find("p").text("você não pode comentar só espaço");
    return false
  }else{
    comentario = comentario.replace(/<\/?[^>]+(>|$)/g, "");
  
    if(comentario == ''){
      $("#enviar_comentario").find(".aviso-form-inicial").show();
     
      $(".aviso-form-inicial").find("p").text("você não pode comentar com caracteres especiais");
      return false
    }else{
      $("#enviar_comentario").find(".aviso-form-inicial").hide();
    }
  }





  var idPubli = $("#idPubli").val();
  var nomePref = $("#nomePref").val();
  var img = $(".mini-perfil").find("img:first").attr("src");
  var nome = $(".mini-perfil").find("p").html();
  var hrefIDUsu = $("#idPerfilUsu").attr('href');
  var id_usu = hrefIDUsu.substring(hrefIDUsu.lastIndexOf('ID')+4); // pegar id do usuario

  var quantVoltar = $("#voltar").val();
  voltar = "";
  if(quantVoltar >= 0 && quantVoltar <= 5 ){
      for(i = 0; i < quantVoltar; i++){
          voltar += "../";
      }
  }   

  $.ajax({
    url: voltar +"Comentario.php",
    type: "post",
    data: "id="+idPubli+"&texto="+comentario,
    success:function(result){
        if(result == 'NLogado'){ // Nao esta logado, redirecionar pra fazer login
          location.href= voltar + "login";
          return false;
        }else{
          //alert(result);
          $("#comentarioTxt").val('');
          var usuario = result.substring(0, result.lastIndexOf('.'));
          var id_comentario = result.substring(result.lastIndexOf('.') + 1,result.lastIndexOf(','));
          var qtd = result.substring(result.lastIndexOf(',') + 1);          
          if(usuario =="Comum"){            
            alert(voltar + id_usu);
            $(".comentarios").prepend('<div class="comentario-user" style="display:flex; order:-1">\
            <div class="publicacao-topo-aberta">\
            <a href="'+voltar+id_usu+'">\
              <div>\
              <img src="'+ img +'">\
              </div>\
            </a>\
            <p>\
            <a href="'+voltar+id_usu+'">\
            <span class="negrito">'+nome+'</span>\
            </a>Enviado agora</p>\
            <div class="mini-menu-item ">\
            <i class="icone-3pontos"></i>\
            <div>\
            <ul style="z-index: 98">\
            <li>\
            <a class="remover_publicacao" href="'+voltar+'ApagarComentario.php?ID='+id_comentario+'">\<i class="icone-fechar"></i>Remover</a>\
            </li>\
            <li class="editar-comentario" data-id="'+id_comentario+'"><a href="#"><i class="icone-edit-full"></i>Alterar</a></li>\
            </ul>\
            </div>\
            </div>\
            </div>\
            <p>'+comentario+'</p></div>');
            $("#qtd_comen").text(qtd);
            $('#btn-reclama').attr('disabled','disabled');
            if($('.comentario-user').length == 1){
              //alert('oi')
              $('.comentarios').find('h3:first').text('Comentários')
            }
            
          }else{            
            $(".enviar-comentario-publicacao").remove();
            $('<section class="prefeitura-publicacao">\
            <div class="topo-prefeitura-publicacao">\
            <a href="'+voltar+id_usu+'">\
            <div>\
            <img src="'+img+'">\
            </div>\
            </a><p><a href="'+voltar+id_usu+'"><span class="negrito">'+nomePref+'</span></a><time>Enviado agora</time></p></div>\
            <div class="conteudo-resposta">\
            <span>'+comentario+'</span>\
            <div>\
            </section>').insertBefore('.barra-curtir-publicacao');
          }
         
        
        }          
        
    }
 });
    return false;
  });
});

jQuery(function($){
$(document).on('click','.salvar',function(){
  var tipo = $(this).data('tipo'); //data-tipo="remover"
  var href =$(this).attr('href');
  var $this = $(this);
  var idInteiro = href.substring(href.lastIndexOf('ID')+3);
  voltar = "";
  indVirgula = idInteiro.lastIndexOf(','); // na virgula mostra o numero de pasta q tenho q voltar 

  if(indVirgula > 0){
    var id = idInteiro.substr(0,idInteiro.lastIndexOf(',')); // id, pegar ate a vrigula
    var quantVoltar = idInteiro.substr(idInteiro.lastIndexOf(',') + 1);
    if(quantVoltar > 0 && quantVoltar <= 4){
      for(i = 0; i < quantVoltar; i++){
        voltar += "../";
      }
    } 
  }else{
    var id = href.substring(href.lastIndexOf('ID')+3);
    quantVoltar = 0;
  }
  
  $.ajax({
    url: voltar + 'SalvarPublicacao.php',
    type: "get",
    data: "ID="+id,
    success:function(result){
        if(result == 'NLogado'){ // Nao esta logado, redirecionar pra fazer login
          location.href= voltar+"login";
          return false;
        }else{
        if(tipo == 'remover'){
          $this.parents(':eq(5)').remove();
          alerta('Errado', 'removido dos salvos');
          //alert($('.item-publicacao').length)
          if($('.item-publicacao').length == '0'){
           jaquinha();
          }
        }else{
        var classe =  $this.find('i').attr('class');
        if(classe == 'icone-salvar'){
          $this.parent().html('<li><a class="salvar" href="'+href+'"><i class="icone-salvar-full"></i>Salvo</a></li>');
          alerta('Certo', 'adicionado aos salvos');
        }else if(classe == 'icone-salvar-full'){
          $this.parent().html('<li><a class="salvar" href="'+href+'"><i class="icone-salvar"></i>Salvar</a></li>');
          alerta('Errado', 'removido dos salvos');
        }
        }
        
        }          
        
    }
 });

  return false;
  
});

});





//AQUI DANIEL - UPDATECOEMNTARIO.PHP, PEGARCOMEN.JS, RECLAMACAO.PHP
/* modal editar comentario */
jQuery(function($){
  var $this;
  /* abrir quando */

  jQuery(document).on("click",".editar-comentario", function(event){
 // $(".editar-comentario").click(function(){

    $("div.modal-editar-comentario").addClass("modal-editar-comentario-ativo");
    $this = $(this);

    $this.parents(':eq(2)').removeClass('mini-menu-item-ativo');
    var id = $(this).data('id');
    $('#idEditar').val(id);
    var txtAntigo = $this.parents(':eq(4)').find('p:last').text();
    var txtAntigo = $this.parents(':eq(4)').find('p:last').text().replace(/(^\s*)|(\s*$)/gi,"");
    txtAntigo = txtAntigo.replace(/[ ]{2,}/gi," ");
    txtAntigo = txtAntigo.replace(/\n /,"\n");


    
    //alert(txtAntigo)
 
    $("#motivoT").remove();
    $('#editarComentario').prepend('<textarea placeholder="Escreva aqui?" id="motivoT" name="texto">'+txtAntigo+'</textarea>');

      
    
  });
  /* fechar quando clicar fora*/
  jQuery(document).on("click",".modal-editar-comentario-fundo", function(event){
//$(".modal-editar-comentario-fundo").click(function(){
    $(this).parent().removeClass("modal-editar-comentario-ativo");
    $this.parents(':eq(2)').addClass('mini-menu-item-ativo');
  });
  /* fechar quando clicar no X*/
  jQuery(document).on("click",".fechar-editar-comentario", function(event){
  //$(".fechar-editar-comentario").click(function(){
    $(this).parents(":eq(2)").removeClass("modal-editar-comentario-ativo");
    $this.parents(':eq(2)').addClass('mini-menu-item-ativo');
  });

  $("#editarComentario").submit(function(){
    var txt =$("#motivoT").val();
    var id = $("#idEditar").val();
    var txtAntigo = $this.parents(':eq(4)').find('p:last').text();
  if(txtAntigo == txt){
    $(".aviso-form-inicial").show();
    $(".aviso-form-inicial").find("p").text("você precisa alterar o texto");
    return false
  }
    if(txt == ''){
      $("#editarComentario").find(".aviso-form-inicial").show();
      $(".aviso-form-inicial").find("p").text("você precisa digitar algo");
      return false;


    }else{
      txt.replace(/(^\s*)|(\s*$)/gi,"");
      txt = txt.replace(/[ ]{2,}/gi," ");
      txt = txt.replace(/\n /,"\n");

      if(txt == '' || txt == ' '){
    //alert('leandro')
        $("#editarComentario").find(".aviso-form-inicial").show();
        $(".aviso-form-inicial").find("p").text("você não pode comentar só espaço");
        return false
      }else{
        txt = txt.replace(/<\/?[^>]+(>|$)/g, "");
      
        if(txt == '' || txt ==' '){
          //alert('leandro branco')
          $("#editarComentario").find(".aviso-form-inicial").show();
         
          $(".aviso-form-inicial").find("p").text("você não pode comentar com caracteres especiais");
          return false
        }else{
          $("#editarComentario").find(".aviso-form-inicial").hide();
          
        }

    }
        var quantVoltar = $("#voltar").val();
        voltar = "";
        if(quantVoltar >= 0 && quantVoltar <= 5 ){
            for(i = 0; i < quantVoltar; i++){
                voltar += "../";
            }
        }   
    //ajax
    $.ajax({
      url: voltar + "UpdateComentario.php",
      type: "post",
      data: "id="+id+"&texto="+txt,
      success:function(result){
        //alert($this.parents(':eq(4)').find('p:last').text());
        $this.parents(':eq(4)').find('p:last').text(txt);
        $('.modal-editar-comentario').removeClass("modal-editar-comentario-ativo");
        //$("#motivoT").val('');
        txtAntigo ='';
        $("#motivoT").html('');
        $(".aviso-form-inicial").hide();
        $this.parents(':eq(2)').addClass('mini-menu-item-ativo');
        alerta('Certo', 'Comentário editado');

      }
   });
  }
    return false;
  });
});

/* INICIO AJAX APAGAR USUARIO ADMIN*/
jQuery(function($){
  $(document).on('click','.remover-usuario',function(){
    $this = $(this);
    var href =$(this).attr('href');
    var id = href.substring(href.lastIndexOf('ID')+3);   

    $.ajax({
      url:'../ApagarUsuario.php',
      type: "get",
      data: "ID="+id,
      success:function(result){
          if(result == 'NLogado'){ // Nao esta logado, redirecionar pra fazer login
            location.href="login.php";
            return false;
          }else{
              $this.parents(':eq(4)').remove();
              alerta('Errado', 'usuário removido');           
          }   
      }
   });
    return false;

  });
});
/* FIM AJAX APAGAR USUARIO ADMIN*/


$(document).on('keyup', '#comentarioTxt', function(){
  $this = $(this);
  //alert($this.val().length)
  if($this.val().length < 1 ){
    //alert('jaca')
    $('#btn-reclama').attr('disabled' , 'disabled')
  }else{
    //alert($this.val().length)
    $('#btn-reclama').removeAttr('disabled')
  }
  
})




$(document).on('keyup', '#texto', function(){
  $this = $(this);
  //alert($this.val().length)
  if($this.val().length < 1 ){
    //alert('jaca')
    $('#btn-debate').attr('disabled' , 'disabled')
  }else{
    //alert($this.val().length)
    $('#btn-debate').removeAttr('disabled')
  }
})



function alerta(tipo, mensagem){


if(tipo == 'Errado'){
var bola ='bola bolaErro';

}else if(tipo=='Certo'){
  var bola ='bola';
}

var estruturaDeAlerta = '<div class="alerta deu'+tipo+'">\
<div class="'+bola+'">\
    <span class="'+tipo+'"></span>\
</div>\
<p>'+mensagem+'</p>\
</div>'

// return estruturaDeAlerta
$('body').append(estruturaDeAlerta);

}

// $('.linha-mensagem_padrao').each(function(){
//   $this = $(this);
//   var idAtual = $this.data('id-user')
//   var idDoProximo = $this.next().find('div.usuario-msg-foto').data('id-user');

//   if( idAtual == idDoProximo){
//     $this.find('div.usuario-msg-foto').html('');
//     $this.find('div.mensagem_padrao span.nome').remove();

//   }else{

//   }
// })

jQuery(function($){
  $(document).on("click","#scrollcomentario",function(){
    $('html, body').animate({scrollTop: $('#comentarioTxt').offset().top - 100}, 'slow');
    $('#comentarioTxt').focus();
  })
 
})