//assets/js/register.js
$(document).ready(function(){
    
    $("#hideLogin").on("click", function(){
        $("#loginForm").hide();
        $("#registerForm").show();
    });
    
    $("#hideRegister").on("click", function(){
        $("#loginForm").show();
        $("#registerForm").hide();
    });
    

});



