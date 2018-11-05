
var paginacao = 0;
var validar = 0;

setTimeout(function(){

    $(document).ready(function(){
        
        //$//("#pa").scrollTop($("#pa")[0].scrollHeight);
        $('#pa').scrollTop($("#pa")[0].scrollHeight);
        
        $('#pa').scroll(function(){
           if ($('#pa').scrollTop() == 0){
             
               // $('#loader').show();
         
           
               id = document.getElementById("IdDeba").value;
               paginacao--;
               //Simulate server delay;
               setTimeout(function(){
                

                $.ajax({
                    
                    url: '../PegarMensagem2.php',
                    type: "get",
                    data: "pagina="+paginacao+"&ID="+id,
                    success: function(data){        
                        if(data =="Maior"){ //Maior significa que não teve resultado para mostrar
                            validar = 1 //então nao vamos mais rodar o jaquinha, pois chegamos ao final de todas as reclamações
                            //alert("chegou no fim")     
                            alert("Ta no final desgrac");                      
                        }else{    
                            teste3(data);
                            scrollTop(50);
                        }    
                        //$('#lista').html(data);
                        //$("#pa").prepend(data); 
                        
                    }
                            
            
                }); 

                   $('#pa').scrollTop(30);
                   
                   
               },780); 
           }
        });
        
        })
        
        
},5000); 

function teste3(resposta){
    var arr1 = JSON.parse(resposta);   
    
    document.getElementById('ImgDeba').innerHTML = "<img  src='../Img/debate/"+arr1[0]['dadosDeba'][0]['img_deba']+"'>";   
    var contador;
    mensa2 = "";
    for(contador=0; contador < arr1[2]['debateQParticipa'].length; contador++){
        mensa2 += "<div class=contatinhos><a href='debate_mensagens.php?ID="+arr1[2]['debateQParticipa'][contador]['cod_deba']+"&pagina=ultima'><div class=img-debate><img src='../Img/debate/"+arr1[2]['debateQParticipa'][contador]['img_deba']+"' alt=debate></div></a><div class=status-debate><p>"+arr1[2]['debateQParticipa'][contador]['nome_deba']+"</p></div><div class=info-contatinho><div class=data_mensagem><p>"+arr1[2]['debateQParticipa'][contador]['dataHora_deba']+"</p></div>";
        if(arr1[2]['debateQParticipa'][contador]['quantidade'] > 0 ) {
            mensa2 +="<div class=qtd_mensagens><p>"+arr1[2]['debateQParticipa'][contador]['quantidade']+"</p></div>";
        }
        mensa2 += "</div></div>"
    }
    mensa = "";     
    for(contador=0; contador < arr1[3]['mensagens'].length; contador++){
        classe = arr1[3]['mensagens'][contador]['classe'];
        var msg_id = arr1[3]['mensagens'][contador]['cod_mensa'];

        

        mensa += "<div class=" + classe + ">";        
        if(classe == 'linha-mensagem_padrao'){
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
           // ultimo_id = msg_id;
            mensa += "<span>"+arr1[3]['mensagens'][contador]['hora']+"</span>"
        }else{
           // ultimo_id = msg_id;
            mensa += "<sub>"+arr1[3]['mensagens'][contador]['hora']+"</sub>";
        }
            mensa += "</span></div></div>";
           // alert(ultimo_id) 
        }
            
          
    
    
    //document.getElementsByClassName('mensagens').innerHTML = "";    
    if(mensa2 != ""){ // so vai ser executado se o user for comum
        document.getElementById('contatosJs').innerHTML = mensa2;
    }
    
   // document.getElementById('pa').innerHTML = mensa;
   $("#pa").prepend(mensa);
}
