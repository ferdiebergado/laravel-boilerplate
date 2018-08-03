
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

//require('./bootstrap');

// window.Popper = require('popper.js').default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
    require('admin-lte');
    require('admin-lte/plugins/pace/pace.min.js');
    // require('admin-lte/dist/js/adminlte.min.js');
    require('slimscroll');
    require('fastclick');
    require('input-clear-icon');
    window.iCheck = require('admin-lte/plugins/iCheck/icheck');
    // require('datatables.net');
    // require('datatables.net-bs');
    // require('datatables.net-buttons');
    // require('../jquery-datatable/extensions/datatable.ellipsis');
    // require('../jquery-datatable/extensions/dataTables.searchHighlight');
} catch (e) {}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// register Focusable jQuery extension
jQuery.extend(jQuery.expr[':'], {
  focusable: function (el, index, selector) {
    return $(el).is('a, button, :input, [tabindex]');
  }
});

// Disable form submit on pressing Enter key
$('form').on('keypress', 'input,select', function (e) {
    if (e.which == 13) {
        e.preventDefault();
        // Get all focusable elements on the page
        var $canfocus = $(':focusable');
        var index = $canfocus.index(document.activeElement) + 1;
        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }
});

// Focus the first element that has an error.
$('.has-error:first input').focus();

// Automatically dismiss alerts after several seconds
$("#divAlertSuccess").delay(4000).fadeOut(600);
