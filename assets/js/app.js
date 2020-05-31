/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

const inputEmail = document.getElementById('inputEmail');
const inputPassword = document.getElementById('inputPassword');

let textarea = $('textarea');

let formMain = $('input');

let valid = true;

$('#submit').click(function() {

    if ($(inputEmail).val() === "") {
        valid = false
        $(inputEmail).next(".error-message").fadeIn(1000).text("Veuillez entrer un mail").css({
            borderColor : 'red',
            color : 'red'
            // on rend le champ rouge
        });
        return valid;
    }
    else {
        $(this).css({ // si tout est bon, on le rend vert
            borderColor : 'green',
            color : 'green'
        });
    }

    if ($(inputPassword).val() === "") {
        valid = false
        console.log("dsd");
        $(inputEmail).next(".error-message").fadeIn(1000).text("Veuillez entrer un mot de passe").css(
        {
            borderColor : 'red',color : 'red'
            // on rend le champ vers
        });
        return valid;
    } else {
        $(this).css(
        { // si tout est bon, on le rend vert
            borderColor : 'green',
            color : 'green'
        });
    }
});

$(formMain).keyup(function() {
    if($(this).val().length < 1) { // si la longueur est inférieur
        $(this).css({ borderColor : 'red', color : 'red'});
    } else {
        $(this).css({ borderColor : 'green', color : 'green'});
    }
});


$(textarea).keyup(function() {
    if($(this).val().length < 5) { // si la longueur est inférieur
        $(this).css({ borderColor : 'red', color : 'red'});
    } else {
        $(this).css({ borderColor : 'green', color : 'green'});
    }
});


$('.continue').click(function (event) {
    $(formMain).each(function () {
        for (let i = 0; i < formMain.length; i++) {
            if ($(this).val() === "") {
                // on rend le champ rouge
                $('.error-message').show(100).text("Tous les champs doivent être rempli *");
                $(this).css({borderColor : 'red', color : 'red'});
                event.preventDefault();
            }
            else if (textarea.val() === "") {
                // on rend le champ rouge
                $('.error-message').show(100).text("Tous les champs doivent être rempli *");
                $(textarea).css({borderColor : 'red', color : 'red'});
                event.preventDefault();
            } else {
                // si tout est bon, on le rend vert
                $(this).css({borderColor : 'green', color : 'green'});
                event.isDefaultPrevented = function () {
                }
                return
            }
        }
    })
});


$('#resetMdp').submit(function (event) {
        if ($('#confirmNewPassword').val() !== $('#newPassword').val()) {
            $('#confirmPasswordCheck').html('** Les mot de passe ne correspondent pas **').css('color','red');
            event.preventDefault();
            return false;
        } else {
            $('#confirmPasswordCheck').html('');
        }
});

/*$('#comment').submit(function(e) {
    e.preventDefault();
        $.ajax({
            method      : "POST",
            url         : "/account/",
            data        : "{'slug':comment.author.slug}",
            dataType    :"json",
        })
});*/

