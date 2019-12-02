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
   .sass('resources/assets/sass/app.scss', 'public/css').styles([
'public/webapp/vendor/jquery/custom/li-scroller.css',
'public/webapp/styles/custom1.css',
'public/webapp/vendor/animate.css/animate.css',
'public/webapp/styles/style.css',
'public/webapp/styles/scrollbar.css',
   	], 'public/webapp/styles/compiled.css').scripts([
'public/webapp/vendor/pacejs/pace.min.js',
'public/webapp/vendor/jquery/dist/jquery.min.js',
'public/webapp/vendor/bootstrap/js/bootstrap.min.js',
'public/webapp/vendor/datatables/datatables.min.js',
'public/webapp/vendor/select2/dist/js/select2.js',
'public/webapp/vendor/toastr/toastr.min.js',
'public/webapp/vendor/flot/jquery.flot.min.js',
'public/webapp/vendor/flot/jquery.flot.resize.min.js',
'public/webapp/vendor/flot/jquery.flot.spline.js',
'public/webapp/vendor/amcharts/amcharts.js',
'public/webapp/vendor/amcharts/pie.js',
'public/webapp/vendor/amcharts/chalk.js',
'public/webapp/vendor/amcharts/dark.js',
'public/webapp/vendor/chart.js/dist/Chart.min.js',
'public/webapp/vendor/jquery/custom/jquery.li-scroller.1.0.js',
'public/webapp/vendor/jquery/custom/jquery.bootstrap.newsbox.min.js',
'public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js',
'public/js/accounting.min.js',
'public/js/jquery.idle.js',
'public/js/jquery.rss.min.js'
   	],'public/assets/js/all.js');



   

