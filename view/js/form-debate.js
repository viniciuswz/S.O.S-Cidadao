$(document).ready(function(){
    /* erro*/

    /*fim erro */

    $("#elenao").submit(function(){
        var titulo = $("#titulo").val();
        var tema = $("#tema").val();
        var imagemDebateInput = $("#imagemDebateInput").val();
        var sobre = $("#sobre").val();
        $.ajax({
            url:"../formulario-debate.php",
            type: "post",
            data: "titulo="+titulo+"&tema="+tema+"&imagem="+imagemDebateInput+"&sobre="+sobre,
            success:function(result){
                if(result=="1"){
                    location.href="index.php"
                }else{
                    $(".aviso-form-inicial").show();
                    $(".aviso-form-inicial").find("p").text(result)
                }
            }
        })
        return false;
    })
})