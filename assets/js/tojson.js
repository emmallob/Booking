function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

$.fn.formToJson = function() {
    form = $(this);

    var formArray = form.serializeArray();
    var jsonOutput = {};

    $.each(formArray, function(i, element) {
        var elemNameSplit = element['name'].split('[');
        var elemObjName = 'jsonOutput';

        $.each(elemNameSplit, function(nameKey, value) {
            if (nameKey != (elemNameSplit.length - 1)) {
                if (value.slice(value.length - 1) == ']') {
                    if (value === ']') {
                        elemObjName = elemObjName + '[' + Object.keys(eval(elemObjName)).length + ']';
                    } else {
                        elemObjName = elemObjName + '[' + htmlEntities(value);
                    }
                } else {
                    elemObjName = elemObjName + '.' + htmlEntities(value);
                }

                if (typeof eval(elemObjName) == 'undefined')
                    eval(elemObjName + ' = {};');
            } else {
                if (value.slice(value.length - 1) == ']') {
                    if (value === ']') {
                        eval(elemObjName + '[' + Object.keys(eval(elemObjName)).length + '] = \'' + htmlEntities(element['value'].replace("'", "\\'")) + '\';');
                    } else {
                        eval(elemObjName + '[' + value + ' = \'' + htmlEntities(element['value'].replace("'", "\\'")) + '\';');
                    }
                } else {
                    eval(elemObjName + '.' + value + ' = \'' + htmlEntities(element['value'].replace("'", "\\'")) + '\';');
                }
            }
        });
    });

    return jsonOutput;
}