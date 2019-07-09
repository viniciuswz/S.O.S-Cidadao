$('document').ready(function(){
    var hrefIDUsu = $("#idPerfilUsu").attr('href');
    var id_usu = hrefIDUsu.substring(hrefIDUsu.lastIndexOf('ID')+4); // pegar id do usuario
    console.log(id_usu);

        
    
    var array = [...document.querySelectorAll('#pre-avaliacao input')]

    array.forEach((item)=>{
        item.addEventListener('click',(e)=>{
            let nota = e.target.value;
            openModal('modal-avaliacao',nota);
        })
    })
    
    
    function openModal(element,nota){
        $(`.${element}`).show();
        let close =  $(`.${element} span`);
        close.click(function(){
            $(`.${element}`).hide();
        });
        $(`.modal-avaliacao .estrelas #estrela-${nota}${nota}`).attr('checked',true);
    }

    $('.modal-avaliacao .btn').click(function(e){
        event.preventDefault();

        var quantVoltar = $("#voltar").val();
        voltar = "";
        if(quantVoltar >= 0 && quantVoltar <= 5 ){
            for(i = 0; i < quantVoltar; i++){
                voltar += "../";
            }
        }   
       
        $.ajax({
            url: voltar + "Comentario.php",
            type: "post",
            data: $('.modal-avaliacao form').serialize(),
            success:function(result){
                alerta('Certo', 'Avaliação efetuada com sucesso');
                $('.modal-avaliacao').hide();
                $('.reclamacao-avaliacao').remove();
                var arr = /(.+)\.(.+)\,(.+)\;(.+)/g.exec(result);
                let tipoUser = arr[1];
                let idComent = arr[2];
                let qtdCoemntarios = arr[3];
                let flagUltimaResposta = arr[4];
                let qtdEstrelas = /estrela=(\d+)/g.exec($('.modal-avaliacao form').serialize())[1];
                let comentario = $('.box-avaliacao textarea').val();
                let img = $(".mini-perfil").find("img:first").attr("src");
                let nome = $(".mini-perfil").find("p").html();


                $('.prefeitura-publicacao').append('\
                <div class="">\
                  <div class="topo-prefeitura-publicacao">\
                    <a href="'+voltar+id_usu+'">\
                    <div>\
                      <img src="'+img+'">\
                    </div>\
                    </a><p><a href="'+voltar+id_usu+'"><span class="negrito">'+nome+'</span></a><time>Enviado agora</time></p>\
                  </div>\
                  <div class="conteudo-resposta">\
                    <span>'+comentario+'</span>\
                    <span><strong>NOTA:</strong> '+qtdEstrelas+'</span>\
                  </div>\
                </div>');
            }
         });
    })


    });






