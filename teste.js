setInterval("jaca()", 5000);
function jaca(){
    var jaq;
    $.ajax({

        url: '../Notificacoes.php',

        success: function(data){            
            //$('#lista').html(data);
            escreverNoti(data);
        }        

    });   
}

function escreverNoti(resposta){    
    if(resposta == 0){        
        document.getElementById('menu23').innerHTML = "Não ha nenhuma notificação";
        return;
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

