
var paginacao = 1;
var validar = 0 // se for 0 roda o jaquinha se for outro valor não roda
var teste = false;
function verificarSeFazRolagem(){ // rodar isso dentro do jaquinha
    var rolagem =   document.body.scrollHeight - window.innerHeight  ;
   if(rolagem < 0 ){
       rolagem = 0;
   }
// $(window).scrollTop() + window.innerHeight >= document.body.scrollHeight ) { 
    //alert(ultima_pub)
    if(rolagem < ultima_pub){
        jaquinha();

    }else{

    }
}
    function jaquinha(){
        var jaq;
        teste = true;
    
        $.ajax({
            url: '../PegarPublicacoes.php',
            type: "get",
            data: "pagina="+paginacao,
            success: function(data){
                if(data =="Maior"){ //Maior significa que não teve resultado para mostrar
                    validar = 1 //então nao vamos mais rodar o jaquinha, pois chegamos ao final de todas as reclamações
                    //alert("chegou no fim")
                   
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
                        ultima_pub = Math.abs($('.item-publicacao:last').offset().top -  window.innerHeight + ($('.item-publicacao:last').innerHeight() / 2));
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
         ultima_pub = Math.abs($('.item-publicacao:last').offset().top -  window.innerHeight + ($('.item-publicacao:last').innerHeight() / 2));
    //     var tamanho = $(window).scrollTop();
    //    var tamanhon = $(window).scrollTop() ;//+ window.innerHeight
    //     var diferenca = $(document).height() - $(window).height();
    //    var diferencan=    document.body.scrollHeight;
    //    $("#tamanho").text(' nova:'+ tamanhon);
    //    $("#diferenca").text(' nova:'+ diferencan);
    //    $('#ultima').text(ultima_pub )
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
    
    var mensa = "";
    for(contador = 0; contador < arr1.length; contador++){
                mensa += '<div class="item-publicacao">\
                            <div class="item-topo">\
                                <a href="perfil_reclamacao.php?ID='+ arr1[contador]['cod_usu'] +'">\
                                <div>\
                                    <img src="../Img/perfil/' + arr1[contador]['img_perfil_usu'] +'">\
                                </div>\
                                <p><span class="negrito">'+arr1[contador]['nome_usu']+'</a></span><time>'+arr1[contador]['dataHora_publi']+'</time></p>\
                                <div class="mini-menu-item">\
                                    <i class="icone-3pontos"></i>\
                                    <div>\
                                        <ul>';
                                        if(arr1[contador]["indDenun"] == true){
                                            mensa += '<li><i class="icone-bandeira"></i><span class="negrito">Denunciado</span></li>';
                                        }else if(arr1[contador]["indDenun"] == false){ // nao denunciou\
                                            mensa += '<li class="denunciar-item" data-id="'+arr1[contador]['cod_publi']+'.Publicacao"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                        }

                                        if(arr1[contador]["LinkApagar"] != false && arr1[contador]["LinkUpdate"]){ // Denuncioou
                                            mensa += '<li><a class="remover_publicacao" href='+arr1[contador]["LinkApagar"]+'><i class="icone-fechar"></i></i>Remover</a></li>';                                            
                                            mensa += '<li><a href='+arr1[contador]["LinkUpdate"]+'><i class="icone-edit-full"></i></i>Alterar</a></li>';
                                        }

                                        if(arr1[contador]["TextoLinkSalvar"] == "Salvo"){
                                            mensa += '<li><a class="salvar" href='+arr1[contador]["LinkSalvar"]+'><i class="icone-salvar-full"></i>Salvo</a></li>';
                                        }else{
                                            mensa += '<li><a class="salvar" href='+arr1[contador]["LinkSalvar"]+'><i class="icone-salvar"></i>Salvar</a></li>';
                                        }                                                                     
                            mensa +=   '</ul>\
                                    </div>';                                 
                                mensa +='</div>\
                            </div>\
                            <a href="reclamacao.php?ID='+arr1[contador]['cod_publi']+'">';                          
                            if(arr1[contador]['img_publi'] != ""){                            
                                mensa += '<figure>\
                                <img src=../Img/publicacao/'+arr1[contador]['img_publi']+'> \
                                </figure>';
                            }
                         
                            mensa +=    '<p>'+arr1[contador]['titulo_publi']+'</p>\
                                </a>\
                                <div class="item-baixo">\
                                    <i class="icone-local"></i><p>'+ arr1[contador]['endereco_organizado_fechado']+ '</p>\
                                    <div>';    
                            mensa +='<span>'+ arr1[contador]['quantidade_curtidas']+'</span><i class="icone-like"></i>\
                                        <span>'+arr1[contador]['quantidade_comen']+'</span><i class="icone-comentario"></i>\
                                    </div>\
                                </div>\
                        </div>';
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
    //       })
    //   });
    //document.getElementById("pa").innerHTML = mensa;
    $("#pa").append(mensa);
    teste = true;
}

