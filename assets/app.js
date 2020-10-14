/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import $ from 'jquery';
import 'bootstrap';
import 'summernote';


/**
 * Summernote
 */

$('#app_form_description').summernote({
    height: 300,
    shortcuts: false,
    toolbar: [
        ['style', ['bold', 'italic', 'underlined', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],

        ['fontname', ['fontname', 'fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['media', ['link']],
        ['height', ['codeview', 'undo', 'redo']]
    ]
});

$('#comment_form_text').summernote({
    toolbar: [
        ['style', ['bold', 'italic', 'underlined', 'clear']],
        ['media', ['link']]
    ]
});


/**
 * Application platform choice
 */
function _(id) {
    return document.getElementById(id);
}

function onWindowsChange() {
    let windows = _('app_form_windows');
    if (windows)
        _('form-windows').hidden = !windows.checked;
}

function onLinuxChange() {
    let linux = _('app_form_linux');
    if (linux)
        _('form-linux').hidden = !linux.checked;
}

function onMacChange() {
    let mac = _('app_form_mac');
    if (mac)
        _('form-mac').hidden = !mac.checked;
}

function onAndroidChange() {
    let android = _('app_form_android');
    if (android)
        _('form-android').hidden = !android.checked;
}

onWindowsChange();
onLinuxChange();
onMacChange();
onAndroidChange();


$(document).on('change', '#app_form_windows', onWindowsChange);
$(document).on('change', '#app_form_linux', onLinuxChange);
$(document).on('change', '#app_form_mac', onMacChange);
$(document).on('change', '#app_form_android', onAndroidChange);

/**
 * Application Genre Choice
 */

$(document).on('change', '#app_form_classification', function () {
    let $field = $(this);
    let $form = $field.closest('form');
    let data = {};
    let $classificationField = $('#app_form_classification');
    data[$classificationField.attr('name')] = $classificationField.val();
    data [$field.attr('name')] = $field.val();

    $.post($form.attr('action'), data,).then(function (data) {
        let $input = $(data).find('#app_form_genre');
        $('#app_form_genre').replaceWith($input);

    })
});


console.log('Hello Webpack Encore! Edit me in assets/app.js');

