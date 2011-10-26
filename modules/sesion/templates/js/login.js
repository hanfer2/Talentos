
  validarLogin = function(){
    var login = $("input#iLogin").val();
    var clave = $("input#iclave").val();

    if (!/^([0-9])*$/.test(login)){
      jAlert("El valor "+ login + " NO es num&uacute;rico. \nRecuerde que el nombre de Usuario es su n&uacute;mero de identificaci&oacute;n.");
      return false;
    }else if(login == '' && clave == ''){
      jAlert("Recuerde que debe ingresar el nombre de usuario y la contrase&uacute;a");
      return false;
    }else if(login == ''){
      jAlert("Recuerde que debe ingresar el nombre de usuario");
      return false;
    }else if(clave == ''){
      jAlert("Recuerde que debe ingresar la contrase&uacute;a");
      return false
    } else
      $("form").submit();
    return true;
  }

