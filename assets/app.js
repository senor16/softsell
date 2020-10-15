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
        ['style', ['style','bold', 'italic', 'underlined', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],

        ['fontname', ['fontname', 'fontsize']],
        ['color', ['color']],
        ['paragraph', ['ul', 'ol', 'paragraph']],
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



console.log('Hello Webpack Encore! Edit me in assets/app.js');

