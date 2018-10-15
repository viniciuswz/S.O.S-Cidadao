
    document.addEventListener('keydown', function() {
        if (event.keyCode == 123) {
          alert("SAI DAQUI SEU LADRÃO");
          return false;
        } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
          alert("SAI DAQUI SEU LADRÃO");
          return false;
        } else if (event.ctrlKey && event.keyCode == 85) {
          alert("SAI DAQUI SEU LADRÃO");
          return false;
        }
      }, false);
      
      if (document.addEventListener) {
        document.addEventListener('contextmenu', function(e) {
          alert("SAI DAQUI SEU LADRÃO");
          e.preventDefault();
        }, false);
      } else {
        document.attachEvent('oncontextmenu', function() {
          alert("SAI DAQUI SEU LADRÃO");
          window.event.returnValue = false;
        });
      }


ou isso


  document.onkeydown = function(e) {
    if(event.keyCode == 123) {
       return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
       return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
       return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
       return false;
    }
    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
       return false;
    }if (document.addEventListener) {
        document.addEventListener('contextmenu', function(e) {
          alert("SAI DAQUI SEU LADRÃO");
          e.preventDefault();
        }, false);
      } else {
        document.attachEvent('oncontextmenu', function() {
          alert("SAI DAQUI SEU LADRÃO");
          window.event.returnValue = false;
        });
      }
  }
