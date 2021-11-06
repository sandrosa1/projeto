//----------------Mudar par o dominio

const urlCadastro = 'cars7.1/cadastro';
const urlLogin = 'cars7.1/controllers/controllerLogin';
//Pega o local 
function getRoot(url)
{
    var root = "http://"+document.location.hostname+"/"+url;
    return root;
}
//https://github.com/vanilla-masker/vanilla-masker
//Listen the input element masking it to format with pattern.
//Mascara de validação para campos númericos

$('#cpf , #dataNascimento, #phone').on('focus', function () {

    var id=$(this).attr("id");

    if(id == "cpf"){VMasker(document.querySelector("#cpf")).maskPattern("999.999.999-99");}

    if(id == "birthDate"){VMasker(document.querySelector("#dataNascimento")).maskPattern("99/99/9999")};

    if(id == "phone"){VMasker(document.querySelector("#phone")).maskPattern("(99)-999999999")};

});

//Coloca calendarios em portugues
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var options = {
        yearRange: 15,
        i18n:{
            months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            weekdaysAbbrev: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
            //Botões
            clear: 'Limpar',
            done:'Certo',
            cancel:'Cancelar',
        }, 
        // Formato da data em pt-BR
        format: 'dd/mm/yyyy',
     }
    var instances = M.Datepicker.init(elems, options);
  });


//Para ataques a senha do tipo força bruta
function getCaptcha()
{
    grecaptcha.ready(function() {
        grecaptcha.execute('6LfHswQdAAAAAPuerl_eJ6d2NPw7Ognc5OaIwNE4', {action: 'homepage'}).then(function(token) {
          const gRecaptchaResponse=document.querySelector("#g-recaptcha-response").value=token;
        });
    });
}
getCaptcha();


document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.tooltipped');
    var instances = M.Tooltip.init(elems, options);
  });

//Ajax do formulário de cadastro de clientes
$("#formCadastro").on("submit",function(event){
    event.preventDefault();
    var dados=$(this).serialize();

    $.ajax({
       url: getRoot(urlCadastro),
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function (response) {
            $('.retornoCad').empty();
            if(response.retorno == 'erro'){
                //getCaptcha();
                $.each(response.erros,function(key,value){
                    M.toast({   html: `<span class="lighten-2">${value}</span><button class="btn-flat toast-action"><i class="material-icons yellow-text">error_outline</i></button>`,
                                classes: 'rounded',
                                inDuration: 2000,
                                outDuration:2000,
                            });
                });
            }else{
                $.each(response.success,function(key,value){
                    M.toast({   html: `<span>${value}</span><button class="btn-flat toast-action"><i class="material-icons green-text">thumb_up</i></button>`,
                        classes: 'rounded',
                        inDuration: 2000,
                        outDuration:2000,
                    });
                });
                window.location.href = response.page
            }
        }
    });
});


//Ajax do formulário de login
// $("#formLogin").on("submit",function(event){
//     event.preventDefault();
//     var dados=$(this).serialize();

//     $.ajax({
//        url: getRoot(urlLogin),
//         type: 'post',
//         dataType: 'json',
//         data: dados,
//         success: function (response) {
//           if(response.retorno == 'success'){
//               window.location.href = response.page;
//           }else{
//             //   getCaptcha();
//               if(response.tentativas == true){
//                 $('.loginFormulario').hide();
//               }
//               $('.resultadoForm').empty();
//               $.each(response.erros, function(key, value){
//                   $('.resultadoForm').append(value + '<br>')
//               })
//             }

//         }
//     });
// });

//CapsLock
// $("#senha").keypress(function(e){
//     kc=e.keyCode?e.keyCode:e.which;
//     sk=e.shiftKey?e.shiftKey:((kc==16)?true:false);
//     if(((kc>=65 && kc<=90) && !sk)||(kc>=97 && kc<=122)&&sk){
//         $(".resultadoForm").html("Caps Lock Ligado");
//     }else{
//         $(".resultadoForm").empty();
//     }
// });


// document.addEventListener('DOMContentLoaded', function() {
//     var elems = document.querySelectorAll('.sidenav');
//     var instances = M.Sidenav.init(edge, 'left');
//   });