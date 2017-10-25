/*
 $Id$
 
 vim: set ts=2 sw=2 sts=2 et:
 */

/*
 Common wrappers for CKEditor
 */

function enableEditor(id, name, onEditorReady, configObj) {
    if (!$("#" + id) || !$("#" + id + 'Box') || !$("#" + id + 'Adv') || !$("#" + id + 'Dis') || (typeof CKEDITOR === "undefined"))
        return false;

    if (configObj) {
        CKEDITOR.replace(id, configObj);
    } else {
        CKEDITOR.replace(id);
    }
    if (typeof onEditorReady === 'function') {
        CKEDITOR.on("instanceReady", onEditorReady);
    }


    $("#" + id + "Enb, #" + id + "DisB").hide();
    $("#" + id + "EnbB, #" + id + "Dis").show();

    setCookie(id + 'EditorEnabled', 'Y');

    if (localBrowser == 'Opera' && localVersion == '9.00') {
        window.scrollTo(sx, sy);
    }
}

function disableEditor(id, name) {
    if (!$("#" + id) || !$("#" + id + 'Box') || !$("#" + id + 'Adv') || !$("#" + id + 'Dis') || (typeof CKEDITOR === "undefined"))
        return false;

    get_html_editor(id).destroy();

    $("#" + id + "EnbB, #" + id + "Dis").hide();
    $("#" + id + "Enb, #" + id + "DisB").show();

    if (localBFamily == 'MSIE')
        setTimeout("document.getElementById('" + id + "').value = document.getElementById('" + id + "').value;", 100);

    deleteCookie(id + 'EditorEnabled');
}

function editor_get_xhtml_body(name) {
    return get_html_editor(name).getData();
}

function editor_puthtml(name, value) {
    get_html_editor(name).setData(value);
}

function get_html_editor(name) {
    obj = CKEDITOR.instances[name];
    return obj;
}
