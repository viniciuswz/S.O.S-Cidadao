
var paginacao = 1;
var validar = 0 // se for 0 roda o jaquinha se for outro valor não roda
var teste = false;

function criarEmpty(emptyStateMensagem,emptyStateCta){
    $('.comentarios').find('h3:first').html("<div class='empty-state' style='padding-bottom:50px; width: 100%;'>\
    <div>\
    <div style='overflow: hidden; border-radius: 50%; width: 280px; height: 280px;'>\
    <img src='imagens/comentario-sem.png' style='width: 280px;'>\
 </div>\
        <div>\
        <p style='margin: 0 auto; width:90%; max-width:500px'>"+emptyStateMensagem+"</p>"+emptyStateCta+"\
        </div>\
    </div>\
    </div>")
    }

function verificarSeFazRolagem(){ // rodar isso dentro do jaquinha
    var rolagem =   document.body.scrollHeight - window.innerHeight  ;
   if(rolagem < 0 ){
       rolagem = 0;
   }
// $(window).scrollTop() + window.innerHeight >= document.body.scrollHeight ) { 
    //alert(ultima_pub)
    if(rolagem < ultima_pub){
       
        if($('.comentario-user').length == 0){

        }else{
            ultima_pub = Math.abs($('.comentario-user:last').offset().top -  window.innerHeight + $('.comentario-user:last').innerHeight());
        }
   

    }else{

    }
}
    function jaquinha(){
        var jaq;
        teste = true;
        var idPubli = document.getElementById("IdPublis").value;
        var idComen = document.getElementById("IdComen").value;
        
        $.ajax({
            url: '../PegarComentario.php',
            type: "get",
            data: "pagina="+paginacao+"&ID="+idPubli+"&IdComen="+idComen,
            success: function(data){
                var tipoPubPaginacao = data.substring(0, data.lastIndexOf('.'));
                var tipoUsuPaginacao = data.substring(data.lastIndexOf('.') + 1 );
               
                //alert(tipoUsuPaginacao)
                if(tipoPubPaginacao =="Maior" || tipoPubPaginacao == "Vazio" || data =="Maior"){ //Maior significa que não teve resultado para mostrar
                    validar = 1; //então nao vamos mais rodar o jaquinha, pois chegamos ao final de todas as reclamações
                    //alert("chegou no fim")
                    if(tipoPubPaginacao =="Maior" || data == "Maior"){
                        //alert('jaca')
                    }else{
                        if(tipoUsuPaginacao == "Comum"){
                            //var emptyStateMensagem = "Descobrimos que você não tem nenhuma publicação, que tal postar uma reclamação?";
                            //var emptyStateCta = 
                            // Moderador Adm
                            criarEmpty('Parece que ninguém deixou sua marca aqui, seja o primerio a fazer uma, deixe um comentário ','<a id=scrollcomentario class=cta> Comentar</a>');
                        }else if(tipoUsuPaginacao == "Prefeitura" || tipoUsuPaginacao == "Moderador" || tipoUsuPaginacao == "Adm" ){
                            criarEmpty('Parece que ninguém deixou sua marca aqui, deixe uma fazendo um comentário com sua conta de usuário comum','<a href="../Sair.php" class="cta">Log out</a>');
                        }else{

                            criarEmpty('Parece que ninguém deixou sua marca aqui, deixe uma fazendo um comentário com sua conta','<a href="login.php" class="cta">Login</a>');
                        }
                    }
                   
                }else{//caso o resultado for outro roda normal e adiciona na paginação
                    paginacao++ 
                    $("#pa").append("<div style=' display:flex; justify-content:center; width:100%' id='loader'>\
                    <div class='lds-ring'><div></div><div></div><div></div><div></div></div>\
                     </div>"); // adicionar a estrutura do gif no final da ultima publicação do momento no html
                    //$(window).scrollTop($(document).height()); // descer o scroll pro final
                    setTimeout(function(){ //simular delay de carregamento
                        $('#loader').remove();//remove a estrutura do gif do html
                        teste2(data); //manda ver na criação de conteudo
                        //$(window).scrollTop($(window).scrollTop() + 1)
                    },1780); // tempo do delay
    
                   
                    setTimeout(function(){ //simular delay de carregamento

                        teste = false;

                        if($('.comentario-user').length == 0){

                        }else{
                            ultima_pub = Math.abs($('.comentario-user:last').offset().top -  window.innerHeight + $('.comentario-user:last').innerHeight());
                        }
                   
                
     
                        verificarSeFazRolagem()
                    },3000);
                    
                }            
                //$('#lista').html(data);
                
            }          
            

        });   
    }




    $(document).ready(function(){
        var ultima_pub;
        //$("body").prepend('<div style="width: 300px; height:50px; background-color:pink;position:fixed;top:0;z-index:999"><span id="tamanho"></span>&nbsp;<span id="diferenca"></span>&nbsp;<span id="ultima"></span></div>')
    $(document.body).on('touchmove', rolagem);
    $(window).on('scroll', rolagem); 
        function rolagem() {
           
            if($('.comentario-user').length == 0){

            }else{
                ultima_pub = Math.abs($('.comentario-user:last').offset().top -  window.innerHeight + $('.comentario-user:last').innerHeight());
            }
       
            //var tamanho = $(window).scrollTop();
            //var tamanhon = $(window).scrollTop() ;//+ window.innerHeight
            //var diferenca = $(document).height() - $(window).height();
           // var diferencan=    document.body.scrollHeight;
           // $("#tamanho").text(' nova:'+ tamanhon);
           // $("#diferenca").text(' nova:'+ diferencan);
           // $('#ultima').text(ultima_pub )
            if( $(window).scrollTop()  >= ultima_pub ) { //document.body.scrollHeight
    
    
                if(validar == 0){ // valida se roda o jaquinha ou não baseado no valor da vaiavel validar
                    if(teste == false){
                        jaquinha()
                    }
                    
                }   
    
            }
            
        };
    });
    

    



function teste2(resposta){
    var arr1 = JSON.parse(resposta);   
    var idPubli = document.getElementById("IdPublis").value;
    var mensa = "";
    var txt = '';
    for(contador = 0; contador < arr1.length; contador++){
        txt = arr1[contador]['texto_comen'];

       
            mensa +=  '<div class="comentario-user">\
                <div class="publicacao-topo-aberta">\
                    <a href="perfil_reclamacao.php?ID='+arr1[contador]['cod_usu']+'">\
                    <div>\
                        <img src="../Img/perfil/'+arr1[contador]['img_perfil_usu']+'">\
                    </div>\
                    <p><span class="negrito">'+arr1[contador]['nome_usu']+'</span></a>'+arr1[contador]['dataHora_comen']+'</p>\
                    <div class="mini-menu-item ">\
                        <i class="icone-3pontos"></i>\
                        <div>\
                        <ul style="z-index: 98">'
                                
                                if(arr1[contador]["indDenun"] == true){
                                    mensa += '<li><i class="icone-bandeira"></i><span class="negrito">Denunciado</span></li>';
                                }else if(arr1[contador]["indDenun"] == false){ // nao denunciou\
                                    mensa += '<li class="denunciar-item" data-id="'+arr1[contador]['cod_comen']+'.Comentario"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                }

                                if(arr1[contador]["LinkApagar"] != false && arr1[contador]["LinkUpdate"] != false){ // Denuncioou
                                    mensa += '<li><a class="remover_publicacao" href='+arr1[contador]["LinkApagar"]+'><i class="icone-fechar"></i></i>Remover</a></li>';                                            
                                    mensa += '<li class="editar-comentario" data-id="'+arr1[contador]['cod_comen']+'"><a href="#"><i class="icone-edit-full"></i>Alterar</a></li>';
                                }else if(arr1[contador]["LinkApagar"] != false){ // carregar so o apagar pra adm
                                    mensa += '<li><a class="remover_publicacao" href='+arr1[contador]["LinkApagar"]+'><i class="icone-fechar"></i></i>Remover</a></li>';                                       
                                }                               
  
                            mensa += '</ul>\
                        </div>'; 
                        /*                       
                        if(arr1[contador]["indCarregarModalEditar"] == true){ // so quero q carregue em alguns casos?>
                            mensa += '<div class="modal-editar-comentario">\
                            <div class="modal-editar-comentario-fundo"></div>\
                            <div class="box-editar-comentario">\
                                <div>\
                                    <h1>Editar comentario</h1>\
                                    <span class="fechar-editar-comentario">&times;</span>\
                                </div>';                           
                            mensa +=  '<form action="../UpdateComentario.php" method="post">\
                                    <textarea placeholder="Qual o motivo?" id="motivo" name="texto">'+
                                        arr1[contador]['texto_comen']+
                                    '</textarea>\
                                    <input type="hidden" value="'+arr1[contador]['cod_comen'] +'" name="id">\
                                    <button type="submit"> editar</button>\
                                </form>\
                            </div>\
                        </div>';                               
                        }       
                        */                    
                    mensa += '</div>\
                </div>  \
                <p>'+txt+'\</p></div>';
    }

    // $(document).ready(function(){
    //     jQuery(function($){
        
    //       $(".icone-3pontos").click(function(){
    //         var $this = $(this);
    //         $this.parent().toggleClass('mini-menu-item-ativo')
    //       })
    //     });

    //     jQuery(function($){
    //         /* abrir quando */
    //         $(".denunciar-item").click(function(){
             
    //           $(this).parents(":eq(2)").find("div.modal-denunciar").addClass("modal-denunciar-ativo");
    //           $("body").css("overflow","hidden")
    //         })
    //         /* fechar quando clicar fora*/
    //         $(".modal-denunciar-fundo").click(function(){
    //           $(this).parent().removeClass("modal-denunciar-ativo");
    //           $("body").css("overflow","auto")
    //         })
    //         /* fechar quando clicar no X*/
    //         $(".fechar-denuncia").click(function(){
    //           $(this).parents(":eq(2)").removeClass("modal-denunciar-ativo");
    //           $("body").css("overflow","auto")
    //         })
    //       });

    //       jQuery(function($){
    //         /* abrir quando */
    //         $(".editar-comentario").click(function(){
    //           $(this).parents(":eq(2)").find("div.modal-editar-comentario").addClass("modal-editar-comentario-ativo");
    //         })
    //         /* fechar quando clicar fora*/
    //         $(".modal-editar-comentario-fundo").click(function(){
    //           $(this).parent().removeClass("modal-editar-comentario-ativo");
    //         })
    //         /* fechar quando clicar no X*/
    //         $(".fechar-editar-comentario").click(function(){
    //           $(this).parents(":eq(2)").removeClass("modal-editar-comentario-ativo");
    //         })
    //       })

          
    //   });
    //document.getElementById("pa").innerHTML = mensa;
    $("#pa").append(mensa);
    teste = true;
}

