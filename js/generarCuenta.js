 $( document ).ready(function() {
 	$("#btIniciar").click(function(e){
 		$(".errorNegocio").removeClass("show");
 		$(".errorCelular").removeClass("show");
 		$(".errorEmail").removeClass("show");
		$(".errorPassword").removeClass("show");
		$(".errorPassword2").removeClass("show");
		$("#errorGeneral").removeClass("show");


    	if($.trim($("#txNegocio").val())==''){
    		$(".errorNegocio").addClass("show");
    		$("#txNegocio").focus();
    		return false;
    	}
    	
    	if($.trim($("#txCelular").val()).length!=10){
    		$(".errorCelular").addClass("show");
    		$("#txCelular").focus();
    		return false;
    	}

    	if($.trim($("#txCorreo").val())=="" || !validaEMail($("#txCorreo").val())) {
    		$(".errorEmail").addClass("show");
    		$("#txCorreo").focus();
    		return false;
    	}            

    	if($.trim($("#txPassword").val())=="") {
    		$(".errorPassword").addClass("show");
    		$("#txPassword").focus();
    		return false;
    	}

    	if($("#txPassword").val()!=$("#txPassword2").val()) {
    		$(".errorPassword2").addClass("show");
    		$("#txPassword2").focus();
    		return false;
    	}

    	$(".exito").addClass("show").css("display","block");
    	$(".error2").removeClass("show").css("display","none");
    	$("#btIniciar").css("display","none");
		$.ajax({
		    url:"api/generacuenta.php",
		    data:"negocio="+$("#txNegocio").val()+"&celular="+$("#txCelular").val()+"&correo="+$("#txCorreo").val()+"&password="+$("#txPassword").val()+"&token="+$("#g-recaptcha-response").val(),
		    type:'get',
		    complete:function(datos){
		    	console.log(datos);
		        datos=$.parseJSON(datos.responseText);
		        if(datos.status==1){
		        	window.location.href="exito.html?negocio="+datos.negocio+"&usuario="+datos.usuario;
		        }else{
		        	$(".exito").removeClass("show");
		        	$(".error2").addClass("show").css("display","block").html(datos.mensaje);
		        	$("#btIniciar").css("display","inline-block");
		        	grecaptcha.execute('6Le04I4UAAAAAAy3Ash-X4OqjO5RzPnjxO1Bmb65', {action: 'homepage'}).then(function(token) {
		        		console.log(token);
				         $('#g-recaptcha-response').val(token);
				      });
		        }
		    },
		    error:function(datos){
		        console.log(datos);
		    }
		});


    });

    function validaEMail(email){
    	var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    	if (caract.test(email) == false){
	        return false;
	    }else{
	        return true;
	    }
    }
	
	
 });
			