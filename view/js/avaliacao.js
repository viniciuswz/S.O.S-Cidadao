$('document').ready(function(){

        
    
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
                var arr = /(.+)\.(.+)\,(.+)\;(.+)/g.exec(result);
                let tipoUser = arr[1];
                let idComent = arr[2];
                let qtdCoemntarios = arr[3];
                let flagUltimaResposta = arr[4];
                
                //
            }
         });
    })


    });






