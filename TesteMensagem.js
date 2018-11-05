var ultimo_id= 0;
var ultimo_usu= 0;

setInterval("jaquinha()",5000);

function jaquinha(){
    var jaq;
    id = document.getElementById("IdDeba").value;
    $.ajax({
        url: '../PegarMensagens.php',
        type: "get",
        data: "ID="+id,
        success: function(data){            
            //$('#lista').html(data);
            teste2(data);
        }        

    });   
}

$(document).ready(function(){
    
    jaquinha();
    paginacao--;

    $.ajax({                    
    url: '../PegarMensagem2.php',
    type: "get",
    data: "pagina="+paginacao+"&ID="+id,
    success: function(data){        
        if(data =="Maior"){ //Maior significa que não teve resultado para mostrar
            validar = 1 //então nao vamos mais rodar o jaquinha, pois chegamos ao final de todas as reclamações
            //alert("chegou no fim")     
            //alert("Ta no final desgrac");                      
        }else{    
            teste3(data);
            
            $('#pa').scrollTop($("#pa")[0].scrollHeight);
            //alert("rolha")
        }    
        //$('#lista').html(data);
        //$("#pa").prepend(data); 
        
    }
            

}); 
});

function teste2(resposta){
    var arr1 = JSON.parse(resposta);   
    
    document.getElementById('ImgDeba').innerHTML = "<img  src='../Img/debate/"+arr1[0]['dadosDeba'][0]['img_deba']+"'>";   
    var contador;
    mensa2 = "";
    if(arr1[2]['debateQParticipa'] != ""){
        for(contador=0; contador < arr1[2]['debateQParticipa'].length; contador++){
            mensa2 += "<a class=contatinhos href='debate_mensagens.php?ID="+arr1[2]['debateQParticipa'][contador]['cod_deba']+"&pagina=ultima'><div class=img-debate><img src='../Img/debate/"+arr1[2]['debateQParticipa'][contador]['img_deba']+"' alt=debate></div><div class=status-debate><p>"+arr1[2]['debateQParticipa'][contador]['nome_deba']+"</p></div><div class=info-contatinho><div class=data_mensagem><p>"+arr1[2]['debateQParticipa'][contador]['dataHora_deba']+"</p></div>";
            if(arr1[2]['debateQParticipa'][contador]['quantidade'] > 0 ) {
                mensa2 +="<div class=qtd_mensagens><p>"+arr1[2]['debateQParticipa'][contador]['quantidade']+"</p></div>";
            }
            mensa2 += "</div></a>"
        }
         
    }
    mensa = "";
    
    for(contador=0; contador < arr1[3]['mensagens'].length; contador++){
        classe = arr1[3]['mensagens'][contador]['classe'];
        var msg_id = arr1[3]['mensagens'][contador]['cod_mensa'];
        //var user_id = arr1[3]['mensagens'][contador]['cod_usu'];
        if(( msg_id !='visu' && ultimo_id < msg_id )|| msg_id == 'visu'){
            mensa += "<div class=" + classe + ">";
        
        if(classe == 'linha-mensagem_padrao'){
            ultimo_id = msg_id;

           
           
           if(ultimo_usu == arr1[3]['mensagens'][contador]['cod_usu']){
                //alert(arr1[3]['mensagens'][contador]['cod_usu']);
                mensa += "<div class=usuario-msg-foto data-id-user="+ultimo_usu+"></div><div class=mensagem_padrao><span class=nome><a href=perfil_reclamacao.php?ID="+arr1[3]['mensagens'][contador]['cod_usu']+">"+arr1[3]['mensagens'][contador]['nome_usu']+"</a></span>";
           }else{                
                mensa += "<div class=usuario-msg-foto><img src='../Img/perfil/"+arr1[3]['mensagens'][contador]['img_perfil_usu']+"'></div><div class=mensagem_padrao><span class=nome><a href=perfil_reclamacao.php?ID="+arr1[3]['mensagens'][contador]['cod_usu']+">"+arr1[3]['mensagens'][contador]['nome_usu']+"</a></span>";
                ultimo_usu = arr1[3]['mensagens'][contador]['cod_usu']
           }
           
        }else{
            mensa += "<div>";
        }
            mensa += "<span>"+arr1[3]['mensagens'][contador]['texto_mensa'];
        if(classe == 'linha-mensagem_sistema') { 
            if(msg_id == 'visu'){ // aqui entra quando for mensagem da quantidade nao visualizadas
                $(".qtdNVisu").parent().parent().parent().remove();// remove
                mensa+= "<span class='qtdNVisu'></span>"; // adiciona
            }else{
                ultimo_id = msg_id;
            }            
            mensa += "<span>"+arr1[3]['mensagens'][contador]['hora']+"</span>";
        }else{
            ultimo_id = msg_id;
            mensa += "<sub>"+arr1[3]['mensagens'][contador]['hora']+"</sub>";
        }
            mensa += "</span></div></div>";
        }else{
         
        }       
    }   
    
    //document.getElementsByClassName('mensagens').innerHTML = "";    
    if(mensa2 != ""){
document.getElementById('contatosJs').innerHTML = mensa2;
    }
    
   // document.getElementById('pa').innerHTML = mensa;
   $("#pa").append(mensa);
}

jQuery(function(){
    $("#formDebaMen").submit(function(){
        id = document.getElementById("IdDeba").value;
        texto = document.getElementById("texto").value;
        $.ajax({
            url: '../enviarMensagem.php',
            type: "POST",
            data: "ID="+id+"&texto="+texto,
            success: function(data){            
                //$('#lista').html(data);
                $(".qtdNVisu").parent().parent().parent().remove();// remove
                jaquinha();
                $('#btn-debate').attr('disabled','disabled')
            }        
    
        });           
        document.getElementById("texto").value = "";
        return false;
    })
});
