
var paginacao = 1;
var validar = 0 // se for 0 roda o jaquinha se for outro valor não roda
var teste = false;
    function jaquinha(){
        var jaq;
        var id = document.getElementById("IDPefil").value;
        
        $.ajax({
            url: '../PegarPubliPerfil.php',
            type: "get",
            data: "pagina="+paginacao+"&ID="+id,
            success: function(data){
                if(data =="Maior"){ //Maior significa que não teve resultado para mostrar
                    validar = 1 //então nao vamos mais rodar o jaquinha, pois chegamos ao final de todas as reclamações
                    //alert("chegou no fim")
                   
                }else{//caso o resultado for outro roda normal e adiciona na paginação
                    paginacao++ 
                    $("#pa").append("<div style=' display:flex; justify-content:center; width:100%'>\
                    <img src='imagens/gif2.gif' id='loader'></div>"); // adicionar a estrutura do gif no final da ultima publicação do momento no html
                    $(window).scrollTop($(document).height()); // descer o scroll pro final
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
                                            mensa += '<li class="denunciar-item"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                        }

                                        if(arr1[contador]["LinkApagar"] != false && arr1[contador]["LinkUpdate"]){ // Denuncioou
                                            mensa += '<li><a href='+arr1[contador]["LinkApagar"]+'><i class="icone-fechar"></i></i>Remover</a></li>';                                            
                                            mensa += '<li><a href='+arr1[contador]["LinkUpdate"]+'><i class="icone-edit-full"></i></i>Alterar</a></li>';
                                        }

                                        if(arr1[contador]["TextoLinkSalvar"] == "Salvo"){
                                            mensa += '<li><a href='+arr1[contador]["LinkSalvar"]+'><i class="icone-salvar-full"></i>Salvo</a></li>';
                                        }else{
                                            mensa += '<li><a href='+arr1[contador]["LinkSalvar"]+'><i class="icone-salvar"></i>Salvar</a></li>';
                                        }                                                                     
                            mensa +=   '</ul>\
                                    </div>';
                                    if(arr1[contador]["indCarregarModalDenun"] == true){ // so quero q carregue em alguns casos?>
                                        mensa += '<div class="modal-denunciar">\
                                            <div class="modal-denunciar-fundo"></div>\
                                            <div class="box-denunciar">\
                                                <div>\
                                                    <h1>Qual o motivo da denuncia?</h1>\
                                                    <span class="fechar-denuncia">&times;</span>\
                                                </div>';                                                
                                        mensa +=  '<form method="post" action="../DenunciarPublicacao.php">\
                                                    <textarea placeholder="Qual o motivo?" id="motivo" name="texto"></textarea>\
                                                    <input type="hidden" name="id_publi" value="'+ arr1[contador]['cod_publi']+'">';             
                                        mensa +=  '<button type="submit"> Denunciar</button>\
                                                </form>';
                                                                                   
                                        mensa += ' </div>\
                                        </div>';                                    
                                    } 
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


    //document.getElementById("pa").innerHTML = mensa;
    $("#pa").append(mensa);
    teste = true;
}

