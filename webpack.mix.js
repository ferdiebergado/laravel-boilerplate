let mix = require('laravel-mix');

/*
|--------------------------------------------------------------------------
| Mix Asset Management
|--------------------------------------------------------------------------
|
| Mix provides a clean, fluent API for defining some Webpack build steps
| for your Laravel application. By default, we are compiling the Sass
| file for the application as well as bundling up all the JS files.
|
*/

mix.js('resources/assets/js/app.js', 'public/js')
.copyDirectory('node_modules/admin-lte/dist/img', 'public/dist/img')
.scripts([
    'resources/assets/jquery-datatable/jquery.dataTables.js',
    'resources/assets/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js',
    'resources/assets/jquery-datatable/extensions/export/dataTables.buttons.min.js',
    'resources/assets/jquery-datatable/extensions/export/buttons.flash.min.js',
    'resources/assets/jquery-datatable/extensions/export/jszip.min.js',
    'resources/assets/jquery-datatable/extensions/export/pdfmake.min.js',
    'resources/assets/jquery-datatable/extensions/export/vfs_fonts.js',
    'resources/assets/jquery-datatable/extensions/export/buttons.html5.min.js',
    'resources/assets/jquery-datatable/extensions/export/buttons.print.min.js',
    'node_modules/jquery-highlight/jquery.highlight.js',
    'resources/assets/jquery-datatable/extensions/dataTables.searchHighlight.js',
    'resources/assets/jquery-datatable/extensions/datatable.ellipsis.js'
], 'public/js/plugins.js')
.scripts([
    'node_modules/select2/dist/js/select2.min.js',
    'node_modules/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js'
], 'public/js/tags.js')
.styles([
    'node_modules/select2/dist/css/select2.min.css',
    'node_modules/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css'
], 'public/css/tags.css')
.copy(
    'node_modules/bootstrap-duallistbox/dist/bootstrap-duallistbox.min.css',
    'public/css/bootstrap-duallistbox.min.css'
)
.copy(
    'node_modules/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js',
    'public/js/jquery.bootstrap-duallistbox.min.js'
)
.sass('resources/assets/sass/app.scss', 'public/css');
