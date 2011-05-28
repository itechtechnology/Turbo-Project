var box;
var http = getHTTPObject();
var errosForm;

function getHTTPObject() 
{
  var xmlhttp;
   
  if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
    try {
      xmlhttp = new XMLHttpRequest();
    } catch (e) {
      xmlhttp = false;
    }
  }
  return xmlhttp;
}

function handleHttpResponse()
{
  if (http.readyState == 4) {
	document.getElementById(box).innerHTML = http.responseText;
  }
}

function executaAjax(parametro, valor, idlocal)
{
	if(parametro == 0)
	  return false;
	http = getHTTPObject();
	box = idlocal;
	http.open("GET", valor, true);

	http.onreadystatechange = handleHttpResponse;
	 
	http.send(null);
}

function apagarCliente(idCliente)
{
    if(window.confirm('Deseja Realmente Apagar Esse Cliente ?'))
    {
        window.location.href = '../controllers/cliente.php?acao=del&codCliente='+idCliente;
    } else
    {
        return false;
    }
}

 


function validaObrigatorio(nome,campo,form)
{
	objeto = eval("window.document."+form+"."+campo);
	
	if(objeto.value == "" || objeto.value == 0)
	{ 
		errosForm = errosForm + nome+" é obrigatório\n";
		objeto.style.background = "FFFFCC";
		objeto.focus();
		 
		return false;
	}
	else
	{
		return true;
	}
}

function SomenteNumero(e)
{
  var tecla=(window.event)?event.keyCode:e.which;
  if((tecla > 47 && tecla < 58)) return true;
  else{
    if (tecla != 8) return false;
      else return true;
    }
}

function mascaraData(id)
 {
	 var data = document.getElementById(id).value;
	 
	 if(data.length == 2 || data.length == 5)
	 {
		 document.getElementById(id).value = data + '/';
	 }  
 }
 
 function mascaraCEP(id)
 {
     var cep = document.getElementById(id).value;
	 
	 if(cep.length == 5)
	 {
	    document.getElementById(id).value = cep + '-';
	 }
 }
 
 function mascaraTelefone(id)
 {
	var telefone = document.getElementById(id).value;
	
	if(telefone.length == 1)
	{
	   document.getElementById(id).value = '(' + telefone;
	}else if(telefone.length == 3)
	{
		document.getElementById(id).value = telefone + ') ';
	} else if(telefone.length == 9)
	{
		document.getElementById(id).value = telefone + '-';
	}
 }
 
 function mascaraCpf(cpf,id)
 {
	if(cpf.length == 3)
	{
	   cpf = cpf + '.';
	} else if(cpf.length == 7)
	{
	   cpf = cpf + '.';
	} else if(cpf.length == 11)
	{
	   cpf = cpf + '-';
	}
	
	document.getElementById(id).value = cpf;
 }
 
 function mascaraCnpj(cnpj,id)
 {
     if(cnpj.length == 2 || cnpj.length == 6)
	 {
	    cnpj = cnpj + '.';
	 } else if(cnpj.length == 10)
	 {
	    cnpj = cnpj + '/';
	 } else if(cnpj.length == 15)
	 {
	    cnpj = cnpj + '-';
	 }
	 
	 document.getElementById(id).value = cnpj;
 }
 
 function validaCliente()
 { 
	status = true;
	errosForm = "";
	
	status = validaObrigatorio('Nome','nome','form1');
	status = validaObrigatorio('Telefone','telefone','form1');
	status = validaObrigatorio('CPF / CNPJ','cpfCnpj','form1');
	  
	if(errosForm != "" )
	{
		window.alert(errosForm);
		return false;
	} else
	{
		if(document.getElementById('email').value == "")
		{
			return true;
		} else if(!validaEmail('email'))
		{
			alert('O ENDEREÇO DE EMAIL INFORMADO É INVÁLIDO !');
			return false;
		} else
		{
			return true;
		}
	}		
  }
 
  
 function calculaCorrecoes()
 { 
	var subtotal = document.getElementById('subtotal').value;
	var juros = document.getElementById('juros').value;
	var multa = document.getElementById('multa').value;
	 
	subtotal = subtotal.replace(',', '.');
	subtotal = parseFloat(subtotal);
	
	juros = juros.replace('.','');
	juros = juros.replace(',','.');
	
	multa = multa.replace('.','');
	multa = multa.replace(',','.');
		
	if(juros != "")
	{
		subtotal = subtotal + parseFloat(juros);
	}
	
	if(multa != "")
	{
		subtotal = subtotal + parseFloat(multa);
	}
	
	document.getElementById('total').value = subtotal.toFixed(2);
 }
 
 function validaEmail(id)
 {
	var email = document.getElementById(id).value;
	var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);

	if(typeof(email) == "string")
	{
    	if(er.test(email))
		{ 
			return true;
		}
    }else
	{
		if(typeof(email) == "object")
		{
         	if(er.test(email.value))
			{ 
            	return true; 
            }
        }else
		{
        	return false;
        }
	}
 } 
 
 function validaMudancaSenha(tamanho)
 {
	status = true;
	errosForm = "";
	
	status = validaObrigatorio('Senha Atual','senhaAtual','form1');
	status = validaObrigatorio('Nova Senha','novaSenha','form1');
	status = validaObrigatorio('Confirmação da Senha','confirmacaoSenha','form1');
		  
	if(errosForm != "" )
	{
		window.alert(errosForm);
		return false;
	} else
	{ 
		if(document.getElementById('novaSenha').value.length >= tamanho && document.getElementById('confirmacaoSenha').value.length >= tamanho)
		{
			return true;
		} else
		{
			alert('A SENHA DE POSSUIR UM NÚMERO MÍNIMO DE '+tamanho+' CARACTERES !');
			return false;
		}
	}
 }
 
 function move(MenuOrigem, MenuDestino)
 {
   var arrMenuOrigem = new Array();
   var arrMenuDestino = new Array();
   var arrLookup = new Array();
   var i;

   for (i = 0; i 