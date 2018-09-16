setInterval("jaca()", 10000);
function jaca(){
    var jaq;
    $.ajax({

        url: '../notificacoes.php',

        success: function(data){            
            //$('#lista').html(data);
            teste(data);
        }        

    });   
}

function teste(resposta){
    var arr1 = JSON.parse(resposta);
    document.getElementById('menu23').innerHTML = "";
    document.getElementById('noti').innerHTML = "";
    if(arr1.length > 0){
        document.getElementById('noti').innerHTML = "<span id='quantidade_de_not'>"+arr1.length+"</span>";
        for(i = 0; i < arr1.length; i++){            
            document.getElementById('menu23').innerHTML += "<li class='" + arr1[i]['classe'] + "'> <a href='reclamacao.php?ID="+ arr1[i]['id_publi'] +"&com=notificacao'><div><i class='"+arr1[i]['tipo']+"'></i></div><span class=''>" + arr1[i]['notificacao'] + "</span></a></li>";            
        }   
    }else{
        document.getElementById('header').innerHTML = "Você nao tem nenhuma notificação";
    }
    
      
}

