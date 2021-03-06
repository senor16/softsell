import $ from "jquery";


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

// /**
//  * Image preview
//  * @param input
//  */
// function filePreview(input) {
//     if (input.files && input.files[0]) {
//         var reader = new FileReader();
//         reader.onload = function (e) {
//             $('#uploadForm + img').remove();
//             $('#uploadForm').after('<img src="'+e.target.result+'" width="450" height="300"/>');
//         };
//         reader.readAsDataURL(input.files[0]);
//     }
// }
//
// $("#file").change(function () {
//     filePreview(this);
// });