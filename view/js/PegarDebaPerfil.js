
var paginacao = 1;
var validar = 0 // se for 0 roda o jaquinha se for outro valor não roda
var teste = false;

function criarEmpty(emptyStateMensagem,emptyStateCta, voltar){
    $("#pa").append("<div class='empty-state' style='padding-bottom:50px; width: 100%;'>\
    <div>\
        <div>\
           <img src='"+voltar+"view/imagens/debate-sem.png'>\
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
        jaquinha();

    }else{

    }
}
    function jaquinha(){
        teste = true;
        var jaq;
        var idInteiro = document.getElementById("IDPefil").value; // exemplo = 204,0
        var id = idInteiro.substr(0,idInteiro.lastIndexOf(',')); // id, pegar ate a vrigula
        var quantVoltar = idInteiro.substr(idInteiro.lastIndexOf(',') + 1);
        
        voltar = "";
        if(quantVoltar > 0){
            voltar = "../";
        }


        $.ajax({
            url: voltar+'PegarDebatesPerfil.php',
            type: "get",
            data: "pagina="+paginacao+"&ID="+id+"&voltar="+quantVoltar,
            success: function(data){
                var tipoUsuPaginacao = data.substring(data.lastIndexOf('.') + 1, data.lastIndexOf(',') );
                var tipoPubPaginacao = data.substring(0, data.lastIndexOf('.'));
                var tipoDonoPaginacao = data.substring(data.lastIndexOf(',') + 1 );
                //alert(tipoDonoPaginacao +"  : "+ tipoPubPaginacao +"  "+ tipoUsuPaginacao )
                if(tipoPubPaginacao == "Maior" || tipoPubPaginacao =="Vazio" || data =="Maior" ){ //Maior significa que não teve resultado para mostrar
                     //então nao vamos mais rodar o jaquinha, pois chegamos ao final de todas as publicações
                    //alert("jaca")
                    validar = 1
                    if(tipoPubPaginacao =="Maior" || data =="Maior"){

                    }else{
                      //  $("body").css("background","white");
                    if(tipoUsuPaginacao == "Comum"){
                        //var emptyStateMensagem = "Descobrimos que você não tem nenhuma publicação, que tal postar uma ?";
                        //var emptyStateCta = 
                        if(tipoDonoPaginacao == "Dono"){
                            criarEmpty('Você não criou nenhuma discussão, sempre tem algo na cidade sobre o que discutir, crie uma e chame a galera!','<a href="'+voltar+'Formulario-debate" class="cta">Criar discussão</a>',voltar);
                        }else{
                            criarEmpty('Esse usuário não possui discussões criadas :(','',voltar);
                        }
                       
                    }else if(tipoUsuPaginacao == "Prefeitura"){

                        
                        if(tipoDonoPaginacao == "Dono"){
                            criarEmpty('Ora ora, não tem nenhuma publicação respondida, que tal responder uma?','<a href="'+voltar+'prefeitura-reclamacao" class="cta">responder</a>',voltar);
                        }else{
                            criarEmpty('Esse usuário não possui discussão criado :(','',voltar);
                        }
                    }else{

                        
                        if(tipoDonoPaginacao == "Dono"){
                            criarEmpty('Você não pode postar uma discussão, entre com sua conta de usuário comum!','<a href="'+voltar+'Sair.php" class="cta">Log out</a>',voltar);
                        }else{
                            criarEmpty('Esse usuário não possui discussões criadas :(','',voltar);
                        }
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
                        teste2(data, quantVoltar, voltar); //manda ver na criação de conteudo
                        //$(window).scrollTop($(window).scrollTop() + 1)
                    },1780); // tempo do delay
    
                   
                    setTimeout(function(){ //simular delay de carregamento

                        teste = false;
                        if($('.item-publicacao').length == "0"){

                        }else{
                            ultima_pub = Math.abs($('.item-publicacao:last').offset().top -  window.innerHeight + ($('.item-publicacao:last').innerHeight() / 2));
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
       // $("body").prepend('<div style="width: 300px; height:50px; background-color:pink;position:fixed;top:0;z-index:999"><span id="tamanho"></span>&nbsp;<span id="diferenca"></span>&nbsp;<span id="ultima"></span></div>')
    $(document.body).on('touchmove', rolagem);
    $(window).on('scroll', rolagem); 
        function rolagem() {
            if($('.item-publicacao').length == "0"){

            }else{
                ultima_pub = Math.abs($('.item-publicacao:last').offset().top -  window.innerHeight + ($('.item-publicacao:last').innerHeight() / 2));
            }
            //var tamanho = $(window).scrollTop();
           // var tamanhon = $(window).scrollTop() ;//+ window.innerHeight
            //var diferenca = $(document).height() - $(window).height();
            var diferencan=    document.body.scrollHeight;
          //  $("#tamanho").text(' nova:'+ tamanhon);
          //  $("#diferenca").text(' nova:'+ diferencan);
          //  $('#ultima').text(ultima_pub )
            if( $(window).scrollTop()  >= ultima_pub ) { //document.body.scrollHeight
    
    
                if(validar == 0){ // valida se roda o jaquinha ou não baseado no valor da vaiavel validar
                    if(teste == false){
                        jaquinha()
                    }
                    
                }        
    
            }
            
        };
    });
    


function teste2(resposta, quantVoltar, voltar){
    var arr1 = JSON.parse(resposta);   
    
    var mensa = "";
    for(contador = 0; contador < arr1.length; contador++){
                mensa += '<div class="item-publicacao">\
                <div class="item-topo">\
                    <a href="'+voltar+'perfil_debate/'+arr1[contador]['cod_usu']+'">\
                        <div>\
                            <img src="'+voltar+'Img/perfil/'+arr1[contador]['img_perfil_usu']+'">\
                        </div>\
                        <p><span class="negrito">'+arr1[contador]['nome_usu']+'</a></span><time>'+arr1[contador]['dataHora_deba']+'</time></p>\
                        <div class="mini-menu-item">\
                            <i class="icone-3pontos"></i>\
                            <div><!--DA PRA TIRAR A DIV-->\
                                <ul>';
                                if(arr1[contador]["indDenun"] == true){
                                    mensa += '<li><i class="icone-bandeira"></i><span class="negrito">Denunciado</span></li>';
                                }else if(arr1[contador]["indDenun"] == false){ // nao denunciou\
                                    mensa += '<li class="denunciar-item" data-id="'+arr1[contador]['cod_deba']+'.Debate,'+quantVoltar+'"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                }

                                if(arr1[contador]["LinkApagar"] != false && arr1[contador]["LinkUpdate"]){ // Denuncioou
                                    mensa += '<li><a class="remover_publicacao" href='+arr1[contador]["LinkApagar"]+'><i class="icone-fechar"></i></i>Remover</a></li>';                                            
                                    mensa += '<li><a href='+arr1[contador]["LinkUpdate"]+'><i class="icone-edit-full"></i></i>Alterar</a></li>';
                                }                                       
                            mensa+='</ul>\
                            </div>';                           
                    mensa+='</div>\
                    </div>\
                    <a href="'+voltar+'Pagina-debate/'+arr1[contador]['cod_deba']+'">\
                        <figure>\
                            <img src="'+voltar+'Img/debate/'+arr1[contador]['img_deba']+'">\
                        </figure>\
                        <div class="legenda">\
                            <p>'+arr1[contador]['nome_deba']+'</p><p>'+arr1[contador]['qtdParticipantes']+'</p><i class="icone-grupo"></i>\
                        </div>';                        
                    mensa += '</a>\
            </div>';
    }


    //document.getElementById("pa").innerHTML = mensa;
    $("#pa").append(mensa);
    teste = true;
}

