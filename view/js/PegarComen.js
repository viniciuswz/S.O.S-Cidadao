
var paginacao = 1;
var validar = 0 // se for 0 roda o jaquinha se for outro valor não roda
var teste = false;
    function jaquinha(){
        var jaq;
        var idPubli = document.getElementById("IdPublis").value;
        var idComen = document.getElementById("IdComen").value;
        
        $.ajax({
            url: '../PegarComentario.php',
            type: "get",
            data: "pagina="+paginacao+"&ID="+idPubli+"&IdComen="+idComen,
            success: function(data){
                if(data =="Maior"){ //Maior significa que não teve resultado para mostrar
                    validar = 1 //então nao vamos mais rodar o jaquinha, pois chegamos ao final de todas as reclamações
                    //alert("chegou no fim")
                   
                }else{//caso o resultado for outro roda normal e adiciona na paginação
                    paginacao++ 
                   $("#pa").append("<div style=' display:flex; justify-content:center; width:100%' id='loader'>\
                    <img src='imagens/gif2.gif' id='loader'></div>"); // adicionar a estrutura do gif no final da ultima publicação do momento no html
                   // $(window).scrollTop($(document).height()); // descer o scroll pro final
                    setTimeout(function(){ //simular delay de carregamento
                        $('#loader').remove();//remove a estrutura do gif do html
                        teste2(data); //manda ver na criação de conteudo
                    },1780); // tempo do delay
    
                   
                    setTimeout(function(){ //simular delay de carregamento
                        teste = false;
                    },2000);
                    teste = true;
                }            
                //$('#lista').html(data);
                
            }        
            

        });   
    }



$(document).ready(function(){
    $(window).scroll(function() {
        if($(window).scrollTop() == $(document).height() - $(window).height()) {
            if(validar == 0){ // valida se roda o jaquinha ou não baseado no valor da vaiavel validar
                if(teste == false){
                    jaquinha()
                }
                
            }else{
              
            }        

        }
        
    });
});


function teste2(resposta){
    var arr1 = JSON.parse(resposta);   
    var idPubli = document.getElementById("IdPublis").value;
    var mensa = "";
    for(contador = 0; contador < arr1.length; contador++){
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
                                    mensa += '<li class="editar-comentario"><a href="#"><i class="icone-edit-full"></i>Alterar</a></li>';
                                }else if(arr1[contador]["LinkApagar"] != false){ // carregar so o apagar pra adm
                                    mensa += '<li><a href='+arr1[contador]["LinkApagar"]+'><i class="icone-fechar"></i></i>Remover</a></li>';                                       
                                }                               
  
                            mensa += '</ul>\
                        </div>';                        
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
                    mensa += '</div>\
                </div>  \
                <p>\
                '+arr1[contador]['texto_comen']+'\
                </p></div>';
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

