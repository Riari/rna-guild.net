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
        .sass('rna.scss', 'public/css/', {
            includePaths: [
                path('font-awesome/scss'),
                path('Materialize/sass'),
                path('fullcalendar/dist'),
                path('datetimepicker'),
                path('unslider/dist/css'),
                path('css/vendor', 'assets')
            ]
        })

        // Scripts
        .scripts([
            path('jquery/dist/jquery.js'),
            path('Materialize/dist/js/materialize.js'),
            path('moment/min/moment-with-locales.js'),
            path('fullcalendar/dist/fullcalendar.js'),
            path('datetimepicker/build/jquery.datetimepicker.full.js'),
            path('unslider/dist/js/unslider-min.js'),
            path('jquery-sortable/source/js/jquery-sortable-min.js'),
            path('marked/marked.min.js'),
            path('bootstrap-markdown/js/bootstrap-markdown.js'),
            path('js/vendor/materialize-tags.js', 'assets'),
            path('js/rna.js', 'assets')
        ], 'public/js/rna.js', './')

        // Versioning
        .version(['js/rna.js', 'css/rna.css']);
});
