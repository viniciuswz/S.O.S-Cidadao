
 function doregister(){
    var username=trim("meuboga12315342");
    var email=trim("pobitu@topikt.com");
    var password1=trim("12345678");
    var password2=trim("12345678");
    var fio=trim("5126");
    var birthday=trim("15.07.2018");
    var location=trim("ruajabiraca");
    var phone=trim(document.mainf.phone.value);
    var secpic=trim(document.mainf.secpic.value);
    var uid="1fedafb087962274bf8ac7cfe56c543b";
  
    if (username==""){
     alert("Please enter your username");
     document.mainf.username.focus();
     return;
    }
    if (email==""){
     alert("Please enter your email");
     document.mainf.email.focus();
     return;
    }
    if (password1==""){
     alert("Please enter your password");
     document.mainf.password1.focus();
     return;
    }
    if (password2==""){
     alert("Please enter your password again");
     document.mainf.password2.focus();
     return;
    }
    if (password1!=password2){
     alert("'Password' and 'Repeat password' dont match");
     document.mainf.password1.focus();
     return;
    }
    if (secpic==""){
     alert("Enter the Number in the picture please\n(If you do not see, reload the page)");
     document.mainf.secpic.focus();
     return;
    }
  
  
    var rstr=Math.random();
    $.post("doregister.php?rstr="+rstr, {
     "username":username,"email":email,"password":password1,"fio":fio,"birthday":birthday,"location":location,"phone":phone,"secpic":secpic
     },function(xml){
      //alert(xml);
      lstatus=getxval(xml,"stat");
      lerr=getxval(xml,"err");
      if (lstatus=="err"){
       alert("Error !\n"+lerr);
      }
      if (lstatus=="ok"){
       alert("You are successfully registered and can start working");
       document.location="userarea.php";
      }
     });
   }