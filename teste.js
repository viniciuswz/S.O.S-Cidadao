setInterval("jaca()", 5000);
function jaca(){
    var jaq;
    $.ajax({

        url: 'Notificacoes.php',

        success: function(data){            
            //$('#lista').html(data);
            escreverNoti(data);
        }        

    });   
}

function escreverNoti(resposta){    
    if(resposta == 0){        
        document.getElementById('menu23').innerHTML = "<div class='empty-state gamb' style='padding-bottom:50px;'>\
        <div>\
            <div>\
               <img src='view/imagens/notifica-sem.png' style='display:block; margin:0 auto; height:100%; width:50%;'>\
            </div>\
            <div>\
                <p>Você não tem nenhuma notificação, continue navegando, pode chegar uma mais tarde!</p>\
            </div>\
        </div>\
        </div>";
        return;
    }else{
        document.getElementById('menu23').innerHTML = "<div class='empty-state gamb' style='padding-bottom:50px;'>\
        <div>\
            <div>\
               <img src='view/imagens/notifica-sem.png' style='display:block; margin:0 auto; height:100%; width:50%;'>\
            </div>\
            <div>\
                <p>Você precisa fazer login para acessar as notificações</p>\
            </div>\
        </div>\
        </div>";
    }
    var arr1 = JSON.parse(resposta);
    document.getElementById('menu23').innerHTML = "";
    document.getElementById('noti').innerHTML = "";
    if(arr1.length > 0){
        document.getElementById('noti').innerHTML = "<span id='quantidade_de_not'>"+arr1.length+"</span>";
        for(i = 0; i < arr1.length; i++){            
            document.getElementById('menu23').innerHTML += "<li class='" + arr1[i]['classe'] + "'> <a href='"+arr1[i]['link']+".php?ID="+ arr1[i]['id_publi'] +"&com="+arr1[i]['indTipo']+"'><div><i class='"+arr1[i]['tipo']+"'></i></div><span class=''>" + arr1[i]['notificacao'] + "</span></a></li>";            
        }   
    }
    
      
}

