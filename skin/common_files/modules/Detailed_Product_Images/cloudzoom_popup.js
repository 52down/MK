/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * Cloud zoom popup
 *
 * @category   X-Cart
 * @package    X-Cart
 * @subpackage JS Library
 * @author     Michael Bugrov
 * @version    560248120aea4394a3d11152a1e1e4789338b825, v2 (xcart_4_7_7), 2016-08-26 15:59:20, cloudzoom_popup.js, mixon
 * @link       http://www.x-cart.com/
 * @see        ____file_see____
 */

function cloudzoom_onwindow_resize() {
    cloudzoom_popup = document.getElementById('cloud_zoom_image');
    if (!cloudzoom_popup) {
        return false;
    }

    cloudzoom_popup.rel = cloudzoom_update_position_type(cloudzoom_popup.rel);
}

function cloudzoom_params_as_object(params) {
    var result = new Object();

    if (!params) {
        return result;
    }

    var list = params.toString().split(',');

    list.forEach(function (item) {
        var pair = item.split(':');
        if (pair[0] && pair[1]) {
            result[pair[0].toString().trim()] = pair[1].toString().trim();
        }
    });

    return result;
}

function cloudzoom_params_as_string(params) {
    var result = new String();

    if (!params) {
        return result;
    }

    var list = new Array();

    for (var param in params) {
        list.push(param + ': ' + params[param]);
    }

    return list.join(', ');
}

function cloudzoom_get_param_value(name, params) {
    var op = cloudzoom_params_as_object(params);

    if (!op[name]) {
        return null;
    }

    return op[name];
}

function cloudzoom_set_param_value(name, value, params) {
    var op = cloudzoom_params_as_object(params);

    if (!op[name]) {
        return op;
    }

    op[name] = value;

    return op;
}

function cloudzoom_update_position_type(params) {
    var w = getDocumentWidth();
    var op = cloudzoom_params_as_object(params);

    if (w < 450) {
        op['position'] = "'inside'";
        delete op['adjustX'];
        delete op['adjustY'];
    } else if ( w > 450 && w < 850) {
        op['position'] = "'bottom'";
        delete op['adjustX'];
        delete op['adjustY'];
    } else {
        op['position'] = "'right'";
        op['adjustX'] = '10';
        op['adjustY'] = '-4';
    }

    return cloudzoom_params_as_string(op);
}

function cloudzoom_change_image_size(image_width, image_height) {
    image = document.getElementById('product_thumbnail');
    if (!image) {
        return false;
    }

    image.width = image_width;
    image.height = image_height;

    return true;
}

function cloudzoom_change_popup_params(params) {
    cloudzoom_popup = document.getElementById('cloud_zoom_image');
    if (!cloudzoom_popup) {
        return false;
    }

    cloudzoom_popup.rel = cloudzoom_update_position_type(params);

    return true;
}

// Bind window.onresize event
jQuery.event.add(
    window,
    "resize",
    cloudzoom_onwindow_resize
);
