$(document).ready(function(){
    /* erro*/

    /*fim erro */

    $("#cadastro").submit(function(){
        var user = $("#user").val();
        var email = $("#email").val();
        var senha = $("#senha").val();
        var senhaC = $("#senhac").val();
        $.ajax({
            url:"../Cadastro.php",
            type: "post",
            data: "user="+user+"&email="+email+"&senha="+senha+"&senhaC="+senhaC,
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