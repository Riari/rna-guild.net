function path(path, source) {
    if (typeof(source) === 'undefined') {
        path = './bower_components/' + path;
    }
    if (source == 'assets') {
        path = './resources/assets/' + path;
    }
    return path;
}

var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix
        // Stylesheets
        .sass('trn.scss', 'public/css/', {
            includePaths: [
                path('font-awesome/scss'),
                path('Materialize/sass'),
                path('simplemde/src/css'),
                path('fullcalendar/dist'),
                path('datetimepicker'),
                path('css/vendor', 'assets')
            ]
        })

        // Scripts
        .scripts([
            path('jquery/dist/jquery.js'),
            path('Materialize/dist/js/materialize.js'),
            path('vue/dist/vue.js'),
            path('moment/min/moment-with-locales.js'),
            path('fullcalendar/dist/fullcalendar.js'),
            path('datetimepicker/build/jquery.datetimepicker.full.js'),
            path('js/vendor/materialize-tags.js', 'assets'),
            path('js/vendor/editor.js', 'assets'),
            path('js/vendor/marked.js', 'assets')
        ], 'public/js/trn.js', './')

        // Versioning
        .version(['js/trn.js', 'css/trn.css']);
});
