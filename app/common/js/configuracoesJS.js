/*
 * Menu lateral
 **/
$(document).ready (function(){

        $('h2').click(function(){

          $(this).siblings().slideToggle(200);
          $(this).parents('li').siblings().find('ul').slideUp(200);

        });

});
/*
 * Fim menu lateral
 **/



/*
 * inicia a tooltip
 **/
$("#box_tooltip img[title]").tooltip({

   // definie a posição da imagem de dicas
   offset: [200, 0],

   effect: 'slide'

}).dynamic({ bottom: { direction: 'down', bounce: true } });
/*
 * fim da tooltip
 **/




 /*
  * inicio abas
  **/
$(function() {
        $("ul.tabs").tabs("div.panes > div");
});
/*
  * fim abas
  **/



 /*
  * Inicio Data
  **/

    $.tools.dateinput.localize("br",  {
       months       : 'janeiro,fevereiro,mar&ccedil;o,abril,maio,junho,julho,agosto,setembro,outubro,novembro,dezembro',
       shortMonths  : 'jan,fev,mar,abr,mai,jun,jul,ago,set,out,nov,dez',
       days         : 'domingo,segunda-feira,ter&ccedil;a-feira,quarta-feira,quinta-feira,sexta-feira,s&aacute;bado',
       shortDays    : 'dom,seg,ter,qua,qui,sex,sab'
    });

    $(":date").dateinput({
        lang        : 'br',
        format      : 'dd/mm/yyyy',
        //formato por extenso
        //format    : 'dddd dd, mmmm yyyy',
        //min         : 0, //dias antes de hoje
        //max         : 0, //dias apos hoje padrão todos
        selectors   : true,
        offset      : [5, 0],
        speed       : 'fast',
        yearRange  	: [-100, 25]
    });

 /*
  * Fim data
  **/




  /*
  * inicio valida��o jquery
  **/

// get handle to the info box
var info = $("#info");


// Regular Expression to test whether the value is valid
$.tools.validator.fn("[type=time]", {br: "informe um hora v&aacute;lida"}, function(input, value) {
        return /^\d\d:\d\d$/.test(value);
});

$.tools.validator.fn("[data-equals]", {br: "Valor n&atilde;o confere com o campo $1"}, function(input) {
        var name = input.attr("data-equals"),
                 field = this.getInputs().filter("[name=" + name + "]");
        return input.val() == field.val() ? true : [name];
});

$.tools.validator.fn("[minlength]", function(input, value) {
        var min = input.attr("minlength");

        return value.length >= min ? true : {
                en: "Please provide at least " +min+ " character" + (min > 1 ? "s" : ""),
                br: "informe ao menos " +min+ " caractere" + (min > 1 ? "s" : "")
        };
});

// supply the language
$.tools.validator.localize("br", {
        '*'             : 'Este campo &eacute; obrigatório',
        ':email'        : 'e-mail inv&aacute;lido',
        ':number'       : 'informe um valor num&eacute;rico',
        ':url'          : 'informe uma url v&aacute;lida',
        '[max]'         : 'informe um valor inferior a $1',
        '[min]'         : 'informe um valor superior a $1',
        '[required]'    : 'Por favor verifique este campo'
});

$(".form").validator({ lang: 'br' });
$(".form").validator({
        onBeforeValidate: function(e, els)  {
                info.empty();
                showEvent("onBeforeValidate", els);
        }

// use jQuery's bind method
}).bind("onBeforeFail", function(e, els)  {
        showEvent("onBeforeFail", els);

// another listener with bind
}).bind("onFail", function(e, els)  {
        showEvent("onFail", els.length + " inputs");
});


// get handle to the Validator API
var api = $(".form").data("validator");

// use API to assign an event listener
//api.onSuccess(function(e, els) {
//        showEvent("onSuccess", els);
//
//        // form submitted.
//        return true;
//});

// event handler just for a single field
$(":email").oninvalid(function(e, message) {
        showEvent("oninvalid", $(this));
});

// this function is used to show error on the info box
window.showEvent = function(eventName, input) {
        var inputName = input.jquery ? input.attr("name") : input;
        info.append("<p><strong>" + eventName + "</strong>: " + inputName  + "</p>").fadeIn();
};
/*
  * fim validação jquery
  **/