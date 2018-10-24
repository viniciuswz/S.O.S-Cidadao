


setTimeout(function(){

    $(document).ready(function(){
    


        //$//("#pa").scrollTop($("#pa")[0].scrollHeight);
        $('#pa').scrollTop($("#pa")[0].scrollHeight);
        // Assign scroll function to chatBox DIV
        $('#pa').scroll(function(){
           if ($('#pa').scrollTop() == 0){
             
               // $('#loader').show();
         
           
        
              
               //Simulate server delay;
               setTimeout(function(){
                   // Hide loader on success
                   //$('#loader').hide();
                   // Reset scroll
                   $('#pa').scrollTop(30);
                   alert("ta no topo")
               },780); 
           }
        });
        
        }) 
},1000); 