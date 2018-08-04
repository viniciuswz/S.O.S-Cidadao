setInterval("jaca()", 5000);
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
    document.getElementById('quantidade').innerHTML = "";
    if(arr1.length > 0){
        document.getElementById('quantidade').innerHTML = arr1.length;
        document.getElementById('header').innerHTML = "Você tem " + arr1.length + " notificações"; 
        for(i = 0; i < arr1.length; i++){
            document.getElementById('menu23').innerHTML += "<li><a href='VerPublicacaoTemplate.php?ID="+ arr1[i]['id_publi'] +"&com=notificacao'>" + arr1[i]['notificacao'] + "</a></li>";
        }   
    }else{
        document.getElementById('header').innerHTML = "Você nao tem nenhuma notificação";
    }
      
      
}

