
$(document).ready(function(){
  $('body').attr("id","ok");
  var isPlaying = false;
  function togglePlay(){
    if (isPlaying) {
      myAudio.play();
    } else {
      myAudio.play();
    }
    alert("PARA DE OLHAR CODIGO DOS OUTROS")
  };
  function verificar(){
    var id =  $('body').attr("id");
    if(id == 'ok'){
      $('body').attr("id","tentou");
      $('body').html("<audio id='myAudio' controls  loop style='display:block'><source src='grrr.wav' type='audio/mp4'></source></audio>");
      var myAudio = document.getElementById("myAudio");
      myAudio.currentTime = 0.1;
      togglePlay()
    }else{
      // myAudio.onplaying = function() {
      //   isPlaying = true;
      // };
      // myAudio.onpause = function() {
      //   isPlaying = false;
      // };
    }
  }
  // myAudio.onplaying = function() {
  //   isPlaying = true;
  // };
  // myAudio.onpause = function() {
  //   isPlaying = false;
  // };
  document.onkeydown = function(e) {
    if(event.keyCode == 123) {
      verificar();
      return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
      verificar();
      return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
      verificar();
      return false;
    }
    if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
      verificar();
      return false;
    }
    if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
      verificar();
      return false;
    }
  }
  
  if (document.addEventListener) {
    document.addEventListener('contextmenu', function(e) {
      verificar();
      //alert("SAI DAQUI SEU LADRÃO");
      e.preventDefault();
    }, false);
  } else {
    document.attachEvent('oncontextmenu', function() {
      // alert("SAI DAQUI SEU LADRÃO");
      verificar();
      window.event.returnValue = false;
    });
  }
  // var banana = document.getElementById("trolei");

})
