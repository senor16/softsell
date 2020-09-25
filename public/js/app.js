
$(document).on('change', '#app_form_classification', function () {
    let $field = $(this)
    let $form = $field.closest('form')
    let data = {}
    let $classificationField = $('#app_form_classification')
    data[$classificationField.attr('name')] = $classificationField.val()
    data [$field.attr('name')] = $field.val()

    $.post($form.attr('action'), data,).then(function (data) {
        let $input = $(data).find('#app_form_genre')
        $('#app_form_genre').replaceWith($input)

    })
})