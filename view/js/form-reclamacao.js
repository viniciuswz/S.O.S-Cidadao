$(document).ready(function(){
    /* erro*/

    /*fim erro */

    $("#formulario-reclamacao").submit(function(){
        var titulo = $("#titulo").val();
        var cep = $("#cep").val();
        var local = $("#local").val();
        var bairro = $("#bairro").val();
        var fotoReclamacao= $("#fotoReclamacao").val();
        var categoria1 = $("#categoria-1").val();
        var sobre = $("#sobre").val();
        $.ajax({
            url:"../formulario-reclamacao.php",
            type: "post",
            data: "titulo="+titulo+"&cep="+cep+"&local="+local+"&bairro="+bairro+"imagem="+fotoReclamacao+"&categoria="+categoria1+"&sobre="+sobre,
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