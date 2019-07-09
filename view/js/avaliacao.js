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
       
        $.ajax({
            url: voltar + "a",
            type: "post",
            data: $('.modal-avaliacao form').serialize(),
            success:function(result){
                alerta('Certo', 'Avaliação efetuada com sucesso');
                //
            }
         });
    })


    });






