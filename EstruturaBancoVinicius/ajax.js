$(document).ready(function(){
    /* erro*/

    /*fim erro */

    $("#login").submit(function(){
        var email = $("#email").val();
        var senha = $("#senha").val();
        $.ajax({
            url:"../Login.php",
            type: "post",
            data: "email="+email+"&senha="+senha,
            success:function(result){
                if(result=="1"){
                    location.href="todasreclamacoes.php"
                }else{
                    $(".aviso-form-inicial").show();
                    $(".aviso-form-inicial").find("p").text(result)
                }
            }
        })
        return false;
    })
})
