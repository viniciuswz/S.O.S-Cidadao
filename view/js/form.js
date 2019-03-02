(function(){
    'use strict'

    
    jQuery(function(){
        var $inputs = document.querySelectorAll('form:nth-child(1) input');
        $('.formulario').submit(function(){
            Array.prototype.forEach.call($inputs,function($this){
                if($this.value == ''){
                    if($this.name == 'imagem'){
                        $this.parentElement.querySelector('p').innerHTML = 'img';
                    }
                    else if($this.type == 'submit'){
                        
                    }else{
                        $this.parentElement.firstElementChild.querySelector('p:last-child').innerHTML = 'oi';
                        
                    }
                    
                }                
            })
       
          return false
        })
        
    })
    


 })()