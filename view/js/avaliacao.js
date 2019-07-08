$('document').ready(function(){

        
    console.log('ok')
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
        $(`.modal-avaliacao .estrelas #estrela-${nota}`).attr('checked',true);
    }


    });






