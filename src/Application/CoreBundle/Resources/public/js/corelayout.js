/*
 *  Funcion que permite obtener los atributos de un elemento como un objeto json
 *
 *  Ejemplo:
 *      var $div = $("<div data-a='1' id='b'>");
 *      $div.attr();  // { "data-a": "1", "id": "b" }
 */
(function(old) {
    $.fn.attr = function() {
        if(arguments.length === 0) {
            if(this.length === 0) {
                return null;
            }

            var obj = {};

            $.each(this[0].attributes, function() {
                if(this.specified) {
                    obj[this.name] = this.value;
                }
            });

            return obj;
        }

        return old.apply(this, arguments);
    };
})($.fn.attr);

/*
 * sortBy: Función que permite ordenar un array u objeto por un campo determinado
 *
 *  Ejemplo:
 *      var aNumbers = [10,8,5,3,7,4,5,1];
 *      var aObject = [
 *              {nombre: "david",  edad: 30},
 *              {nombre: "Luis",   edad: 24},
 *              {nombre: "julian", edad: 24},
 *              {nombre: "alex",   edad: 36},
 *              {nombre: "Samuel", edad: 28},
 *              {nombre: "Diana",  edad: 25}
 *            ];
 *
 * ***************** Objeto ******************      * ****************** ARRAY ******************
 * ------------ Versión Prototipo ------------      * ------------ Version Prototipo ------------
 *      -- Ordenado por elemento edad               *      -- Ascendente por defecto
 *          aObject.sortBy({ prop: "edad" });       *          aNumbers.sortBy();
 *                                                  *
 *      -- Salida descendente por defecto           *      -- Salida Ascendente
 *          edad: 24, nombre: Luis                  *          [1,3,4,5,5,7,8,10]
 *          edad: 24, nombre: julian                *
 *          edad: 25, nombre: Diana                 * ------------- Versión Función -------------
 *          edad: 28, nombre: Samuel                *      -- Descendente, enviado por parametro
 *          edad: 30, nombre: david                 *          sortBy(aNumbers, { desc: true });
 *          edad: 36, nombre: alex                  *
 *                                                  *      -- Salida Descendente
 * ------------- Versión Función -------------      *          [10,8,7,5,5,4,3,1]
 *      -- Ordenada por elemento nombre, desc.      *
 *          sortBy(aObject, {                       *
 *              prop: "nombre",                     *
 *              desc: true,                         *
 *              parser: function (item) {           *
 *                  //ignores uppercase/lowercase   *
 *                  return item.toUpperCase();      *
 *              }                                   *
 *          });                                     *
 *                                                  *
 *      -- Salida descendente                       *
 *          edad: 28, nombre: Samuel                *
 *          edad: 24, nombre: Luis                  *
 *          edad: 24, nombre: julian                *
 *          edad: 25, nombre: Diana                 *
 *          edad: 30, nombre: david                 *
 *          edad: 36, nombre: alex                  *
 *                                                  *
 * ------------ Versión Prototipo ------------      *
 *      -- Ordenado por fecha                       *
 *          aObject.sortBy({                        *
 *              prop: "fecha",                      *
 *              desc: true,                         *
 *              parser: function (item) {           *
 *                  return new Date(item);          *
 *              }                                   *
 *          });                                     *
 */
var sortBy = (function () {
    var _toString = Object.prototype.toString,
    //the default parser function
    _parser = function (x) { return x; },
    //gets the item to be sorted
    _getItem = function (x) {
        return this.parser((_toString.call(x) === "[object Object]" && x[this.prop]) || x);
    };

    /* PROTOTYPE VERSION */
    // Creates a sort method in the Array prototype
    Object.defineProperty(Array.prototype, "sortBy", {
        configurable: false,
        enumerable: false,
        // @o.prop: property name (if it is an Array of objects)
        // @o.desc: determines whether the sort is descending
        // @o.parser: function to parse the items to expected type
        value: function (o) {
            if (_toString.call(o) !== "[object Object]")
            o = {};
            if (typeof o.parser !== "function")
            o.parser = _parser;
            //if @o.desc is false: set 1, else -1
            o.desc = [1, -1][+!!o.desc];
            return this.sort(function (a, b) {
                a = _getItem.call(o, a);
                b = _getItem.call(o, b);
                return ((a > b) - (b > a)) * o.desc;
                //return o.desc * (a < b ? -1 : +(a > b));
            });
        }
    });

    /* FUNCTION VERSION */
    // Creates a method for sorting the Array
    // @array: the Array of elements
    // @o.prop: property name (if it is an Array of objects)
    // @o.desc: determines whether the sort is descending
    // @o.parser: function to parse the items to expected type
    return function (array, o) {
        if (!(array instanceof Array) || !array.length)
        return [];
        if (_toString.call(o) !== "[object Object]")
        o = {};
        if (typeof o.parser !== "function")
        o.parser = _parser;
        //if @o.desc is false: set 1, else -1
        o.desc = [1, -1][+!!o.desc];
        return array.sort(function (a, b) {
            a = _getItem.call(o, a);
            b = _getItem.call(o, b);
            return ((a > b) - (b > a)) * o.desc;
        });
    };
}());

/*
 * Declaración de variables globales
 */
var modal_elements = [];
var collectionIndex = [];

/*
 *  slugToCamelCase:
 *      Funcion que permite convertir un string separado por guion '-'
 *      en un string en formato camelCase
 *
 *  Parámetros:
 *      string: Cadena de texto dividido por guiones.
 *
 *  Retorna:
 *      String en formato camelCase
 *
 *  Ejemplo:
 *      Entrada: 'esto-es-un-string'
 *      Salida:  'estoEsUnString'
 */
function slugToCamelCase(string) {
    return string.replace( /-([a-z])/ig, function( all, letter ) {
        return letter.toUpperCase();
    });
}

/*
 *  time:
 *      Funcion que permite obtener el tiempo actual en segundos.
 *
 *  example 1: timeStamp = time();
 *  example 1: timeStamp > 1000000000 && timeStamp < 2000000000
 *  returns 1: true
 */
function time() {
    return Math.floor(new Date().getTime() / 1000);
}

/*
 *  appendEmptyOption:
 *      Funcion que permite agregar un option vacio, normalmente utilizado en la
 *      inicializaicón del select2
 *
 *  Parámetros:
 *      id: id del elemento al cual se le quiere agregar un option vacio.
 */
function appendEmptyOption(id) {
    if($('#'+id).find('option[value=""]').length === 0 && $('#'+id).find('option[value=null]').length === 0 && $('#'+id).find('option:not([value])').length === 0 && ( typeof $('#'+id).attr('multiple') === 'undefined' || $('#'+id).attr('multiple') === false ) ) {
        $('#'+id).prepend('<option/>').val(function(){
            return $('[selected]',this).val();
        });
    }
}

/*
 *  getCurrentTime:
 *      Funcion que permite obtener la hora actual en formato de 12 horas
 *
 *  Retorna:
 *      time: Ejemplo: 01:00:00 PM
 */
function getCurrentTime() {
    var now  = new Date();
    var time = '';

    time = ("0" + (now.getHours() > 12 ? now.getHours() - 12 : now.getHours()) ).slice(-2) + ':' + ("0" + now.getMinutes()).slice(-2) + ':' + ("0" + now.getSeconds()).slice(-2) + ' ' + (now.getHours() >= 12 ? 'PM' : 'AM');

    return time;
}

/*
 *  getBusinessDaysInMonth
 *      Funcion que permite obtener el número de Dias laborables
 *      en el Mes (Días hábilies), excluye sabado y domingo.
 *
 *  Parámetros:
 *      year: Año del mes del que se desea obtener el número de días.
 *      month: Mes, debe ser tipo numérico, Enero debe empezar en 1, Diciembre: 12
 */
function getBusinessDaysInMonth(year, month) {
    var days     = new Date(year, month, 0).getDate();
    var day      = 0;
    var businessDays = 0;

    for(var i=0; i < days; i++) {
        day = new Date(year, month-1, i+1).getDay();
        if (day !== 0 && day !== 6) {
            businessDays++;
        }
    }

    return businessDays;
}

/*
 *  getSelect2TextInHTML
 *      Función que permite obtener el texto a mostrar al seleccionar un option
 *      del select2, esto srive cuando es enviado el html desde la entidad.
 *      dentro del texto debe existir el siguiente string: data-select2-text="texto"
 *      en donde texto es lo que se mostraría al seleccionar el option
 *
 *  Parámetros:
 *      str: String del option seleccionado que contiene el siguiente texto: data-select2-text="texto"
 */
function getSelect2TextInHTML(str) {
    var ret = "";

    if ( /"/.test( str ) ){
        ret = str.match(/data-select2-text="(.*?)"/)[1];
    } else {
        ret = str;
    }

    return ret;
}

/*
 * getCurrencyFormat:
 *      Función que permite transformar una cadena o float a tipo moneda.
 *      Currency Symbol from ISO http://en.wikipedia.org/wiki/ISO_4217
 *
 * Parámetros:
 *      currency: Texto de 3 letras que indica el codigo de la moneda segun la ISO 4217, por defecto USD
 *      money: número o string al que se le desea dar formato.
 *      decimal: número de decimales que se desea presentar.
 */
function getCurrencyFormat(currency, money, decimal) {
    var parts = [];
    var simbol = 'N/A';

    if(typeof currency === "undefined" || currency === null || currency === '') {
        currency = 'USD';
    }

    if(typeof decimal === "undefined" || decimal === null || decimal === '') {
        decimal = 2;
    }

    if(typeof money === "undefined" || money === null || money === '') {
        money = 0;
        money = money.toFixed(decimal);
    }

    if(typeof decimal === 'string') {
        decimal = parseInt(decimal);
    }

    if(typeof money === 'number') {
        parts = money.toString().split(".");
    } else {
        parts = money.split(".");
    }

    if(!parts[1]) {
        parts[1] = '0';

        while (parts[1].length < decimal) {
            parts[1] = "0" + parts[1];
        }
    }

    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    switch (currency.toUpperCase()) {
        case 'USD':
            simbol = '$';
            break;
        case 'EUR':
            simbol = '€';
            break;
        case 'N/A':
            simbol = '';
            break;
        default:
            simbol = '$';
    }

    return simbol + parts.join(".");
}

/*
 *  openPostPopUpWindows
 *      Funcion que permite abrir un popoup enviando los parametros a través de POST
 *
 *  Parametros que acepta la funcion
 *      method     : metodo a traves del cual se se realizara el envio de la informacion POST o GET
 *      action     : url al cual se enviara la informacion
 *      target     : Nombre de la nueva ventana
 *      parameters : json enconde de los parametros que  seran enviado al nuevo popoup
 */
function openPostPopUpWindows(winParams) {
    var windowObjectReference;
    var params = winParams['parameters'];

    var form = document.createElement("form");
    form.setAttribute("method", winParams['method']);
    form.setAttribute("action", winParams['action']);
    form.setAttribute("target", winParams['target']);

    for (var i in params) {
        if (params.hasOwnProperty(i)) {
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = i;
            input.value = params[i];
            form.appendChild(input);
        }
    }

    document.body.appendChild(form);

    windowObjectReference = window.open("", winParams['target'], "_blank");
    windowObjectReference.resizeTo(screen.width, screen.height);

    form.submit();

    document.body.removeChild(form);
}

/*
 *  setBootstrapDatePicker
 *      Función que inicializa los calendarios que tengan la classe bootstrap-datepicker
 *      con el plugin bootstrap-datepicker
 *
 *  Documentación:
 *      http://eternicode.github.io/bootstrap-datepicker/
 */
function setBootstrapDatePicker() {
    jQuery('body .bootstrap-datepicker').each(function() {
        initializeElementBootstrapDatePicker(jQuery(this));
    });
}

function initializeElementBootstrapDatePicker(element) {
    var options = setBootstrapDatePickerOptions(element);

    element.datepicker(options);
}

function setBootstrapDatePickerOptions(element) {
    var newOptions = {
        format   : "dd/mm/yyyy",
        weekStart: 0,
        clearBtn : true,
        language : "es",
        autoclose: true
    };
    var attr = element.attr();

    jQuery.each(attr, function(key, value) {
        if(key.match('^data-date-')) {
            var option = slugToCamelCase(key.replace('data-date-',''));

            newOptions[option] = isNaN(value) ? ( value === 'true' ? true : ( value === 'false' ? false : ( isJson( value ) ? JSON.parse(value) : value ) ) ) : parseInt(value);
        }
    });

    if(element.hasClass('now')) {
        newOptions['endDate'] = moment().format('DD/MM/YYYY');
    }

    return newOptions;
}

/*
 *  setBootstrapDateRangePicker
 *      Función que inicializa los calendarios que tengan la classe bootstrap-daterangepicker
 *      con el plugin bootstrap-daterangepicker
 *
 *  Documentación:
 *      https://github.com/dangrossman/bootstrap-daterangepicker
 */
function setBootstrapDateRangePicker() {
    jQuery('body .bootstrap-daterangepicker').each(function() {
        initializeElementBootstrapDateRangePicker(jQuery(this));
    });
}

function initializeElementBootstrapDateRangePicker(element) {
    var options = setBootstrapDateRangePickerOptions(element);
    element.daterangepicker(options);
}

function setBootstrapDateRangePickerOptions(element) {
    var newOptions = {
        locale: {
            format:      'DD/MM/YYYY',
            applyLabel:  'Aceptar',
            cancelLabel: 'Cancelar',
            fromLabel:   'DESDE',
            toLabel:     'HASTA',
            daysOfWeek:  ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi','Sa'],
            monthNames:  ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        }
    };
    var attr = element.attr();

    jQuery.each(attr, function(key, value) {
        if(key.match('^data-date-')) {
            var option = slugToCamelCase(key.replace('data-date-',''));

            newOptions[option] = isNaN(value) ? ( value === 'true' ? true : ( value === 'false' ? false : ( isJson( value ) ? JSON.parse(value) : value ) ) ) : parseInt(value);
        }
    });

    if(element.hasClass('now')) {
        newOptions['endDate'] = moment().format('DD/MM/YYYY');
    }

    return newOptions;
}

/*
 *  checkToSwitch
 *      Función que permite cambiar un checkbox a la forma siwtch on - off
 *
 *  Opciones:
 *      Las opciones se envian a tráves de los attr que inicien con data-switch,
 *      los cuales se describen a continuacion:
 *          .- data-switch-enabled   = true : Permite habilitar el cambio de check a switch
 *          .- data-switch-on-label  = 'label' : Permite establecer el label cuando el switch este On
 *          .- data-switch-off-label = 'label' : Permite establecer el label cuando el switch este Off
 *          .- data-switch-float     = false | 'right' | 'left' : Permite colocar el switch flotante izquierda, derecha,
 *                                     valor por defecto false.
 *
 *  Documentación:
 *      https://proto.io/freebies/onoff/
 */
function checkToSwitch() {
    jQuery('body input[data-switch-enabled="true"]').each(function() {
        var element     = jQuery(this);
        var attr        = element.attr();
        var hasOnLabel  = false;
        var hasOffLabel = false;
        var onLabel     = 'SI';
        var offLabel    = 'NO';
        var float       = false;

        jQuery.each(attr, function(key, value) {
            if(key.match('^data-switch-')) {
                var option = key.replace('data-switch-','');

                switch (option) {
                    case 'on-label':
                            onLabel = value;
                        break;
                    case 'off-label':
                            offLabel = value;
                        break;
                    case 'float':
                            float = value;
                        break;
                    default:
                        break;
                }
            }
        });

        initializeSwitchOnOff(element, onLabel, offLabel, float)
    });
}

function initializeSwitchOnOff(element, onLabel, offLabel, float) {
    element.parent().css('width', 'auto');
    element.parent().prepend(
        '<div class="onoffswitch" id="onoff_'+element.attr('id')+'">'+
            '<label class="onoffswitch-label" for="'+element.attr('id')+'">'+
                '<span class="onoffswitch-inner" data-switch-on-label="'+onLabel+'" data-switch-off-label="'+offLabel+'"></span>'+
                '<span class="onoffswitch-switch"></span>'+
            '</label>'+
        '</div>'
    );

    element.prependTo($('#onoff_' + element.attr('id'))).addClass('onoffswitch-checkbox');

    if (typeof float === "undefined" || float === null || float === '') {
        float = false;
    }

    if( float ) {
        var outDiv = jQuery('#onoff_'+element.attr('id')).parent();
        outDiv.addClass('float-'+float);
    }
}


/*
 *  setEditors
 *      Función que permite inicializar los editores wysihtml5 y CK Editor
 *      que vienen incorporados con AdminLTE
 *
 *  Documentación:
 *      https://almsaeedstudio.com/themes/AdminLTE/pages/forms/editors.html
 *      https://github.com/bootstrap-wysiwyg/bootstrap3-wysiwyg/
 *      http://docs.cksource.com/Main_Page
 */
function setEditors() {
    jQuery('body [data-editor-enabled="true"]').each(function() {
        switch ($(this).attr('data-editor-type')) {
            case 'wysihtml5':
                    var wysihtml5Options = {
                        "image"      : false,
                        "blockquote" : false,
                        'locale': "es-ES"
                        // 'toolbar': {
                        //     "image"      : false,
                        //     "blockquote" : false
                        // },
                        // 'events': {
                        //     'load': function() {
                        //         jQuery('#'+jQuery(this).attr('editableElement').id).addClass('wysihtml5-offscrren');
                        //     }
                        // },
                    };

                    $(this).wysihtml5(wysihtml5Options);
                break;
            case 'ckeditor':
                break;
            default:
                break;
        }
    });
}

/* Funcion que permite inicializar un Select2 especificando:
 *   element:        Selector del objeto
 *   blankOption:    Si es true, agrega una opcion en blanco al select2
 *   removeChildren: Si es true, remueve las opciones iniciales del select2
 *   options:        Opciones propias utilizadas por el select2
 */
function initializeSelect2(element, blankOption, removeChildren, options) {
    // var attr = element.attr();
    // var hasDataStyle = false;
    //
    // jQuery.each(attr, function(key, value) {
    //     if(key.match('^data-style')) {
    //         hasDataStyle = true;
    //     }
    // });

    if( removeChildren ) {
        element.children().remove();
    }

    if( blankOption ) {
        appendEmptyOption(jQuery(element).attr('id'));
    }

    if (typeof options === 'undefined' || options == '' || options === null) {
        options = {
            placeholder: 'Seleccione...',
            allowClear: true,
            containerCss: {
                'width': '100%'
            }
        }
    }

    // if(hasDataStyle) {
    //     element.removeAttr('style');
    //     element.attr('style',element.attr('data-style'));
    // } else {
    //     element.attr('data-style',element.attr('style'));
    // }
    //
    // element.parent().css('position','relative');
    // element.select2(options).attr('style','display:block; position:absolute; bottom: 0; left: 0; clip:rect(0,0,0,0);width:100%;');
    element.select2(options);
};

/*
 *  setClockPicker
 *      Función que permite agregar el plugin de Reloj ClockPicker.
 *
 *  Opciones:
 *      Las opciones se envian a tráves de los attr que inicien con data-clockpicker,
 *      los cuales se describen a continuacion:
 *      Para las opciones que son camelCase segun la documentacion oficial listada arriba,
 *      colocar la opcion separada por un guion y seguido de su letra en minuscula ejemplos:
 *          .- data-clockpicker = true : Permite habilitar el plugin
 *
 *          Opcion     | enviada a traves de attr     | Descripcion
 *          -----------+------------------------------+--------------------------------------------------------------------------
 *          donetext   | data-clockpicker-donetext    | 'label'   : Permite cambiar el label por defecto del botón Done.
 *          beforeShow | data-clockpicker-before-show | 'calback' : Permite invocar una funcion antes de que se muestre el reloj.
 *
 *  Documentación:
 *      http://weareoutman.github.io/clockpicker/
 *      https://github.com/weareoutman/clockpicker
 */
function setClockPicker() {
    jQuery('body input[data-clockpicker-enabled="true"]').each(function() {
        initializeClockPicker(jQuery(this));
    });
}

function initializeClockPicker(element) {
    var options = setClockPickerOptions(element);
    element.clockpicker(options);
}

function setClockPickerOptions(element) {
    var newOptions = {
        placement : 'bottom',
        align     : 'left',
        autoclose : true,
        twelvehour: true,
        vibrate   : true
    };
    var attr = element.attr();

    jQuery.each(attr, function(key, value) {
        if(key.match('^data-clockpicker-')) {
            var option = slugToCamelCase(key.replace('data-clockpicker-',''));

            newOptions[option] = isNaN(value) ? ( value === 'true' ? true : ( value === 'false' ? false : ( isJson( value ) ? JSON.parse(value) : value ) ) ) : parseInt(value);
        }
    });

    if(element.hasClass('now')) {
        newOptions['default'] = 'now';
        //newOptions['fromnow'] = '*';
    }

    return newOptions;
}

/*
 *  setDataTables
 *      Función que inicializa las tablas que tengan la classe data-tables
 *      con el plugin data-tables
 *
 *  Documentación:
 *      https://datatables.net/
 */
function setDataTables() {
    jQuery('body table[data-table-enabled="true"]').each(function() {
        initializeDataTable(jQuery(this));
    });
}

function initializeDataTable(element) {
    var options = setDataTableOptions(element);

    element.DataTable(options);
}

function setDataTableOptions(element) {
    var newOptions = {
            "language": {
                decimal:        "",
                emptyTable:     "Sin resultados para mostrar...",
                info:           "Mostrando _START_ a _END_ de _TOTAL_ resultados",
                infoEmpty:      "Mostrando 0 a 0 de 0 resultados",
                infoFiltered:   "(filtrado de _MAX_ resultados en total)",
                infoPostFix:    "",
                thousands:      ",",
                lengthMenu:     "Mostrar _MENU_ resultados",
                loadingRecords: "Cargando...",
                processing:     "Procesando...",
                search:         "Buscar en la Tabla:",
                zeroRecords:    "No se encontraron coincidencias",
                paginate: {
                    first:      "Primero",
                    last:       "Último",
                    next:       "Siguiente",
                    previous:   "Anterior"
                },
                aria: {
                    sortAscending:  ": activar para ordenar la columna ascendentemente",
                    sortDescending: ": activar para ordenar la columna descendentemente"
                }
            },
            "autoWidth": true
        };

    var attr = element.attr();

    jQuery.each(attr, function(key, value) {
        if(key.match('^data-table-')) {
            var option = slugToCamelCase(key.replace('data-date-',''));

            newOptions[option] = isNaN(value) ? ( value === 'true' ? true : ( value === 'false' ? false : ( isJson( value ) ? JSON.parse(value) : value ) ) ) : parseInt(value);
        }
    });

    return newOptions;
}

/*
 *  getCurrentDate
 *      Funcion que retorna la fecha actual en un formato determinado
 *
 *  Parametro:
 *      parameter: String que contiene el formato de la fecha
 *
 *  Formatos Soportados:
 *      'dd/mm/yyyy', (Valor por defecto)
 *      'dd-mm-yyyy',
 *      'yyyy/mm/dd',
 *      'yyyy-mm-dd'
 */
function getCurrentDate(format) {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd='0'+dd
    }

    if(mm<10) {
        mm='0'+mm
    }

    switch (format) {
        case 'dd/mm/yyyy':
            today = dd+'/'+mm+'/'+yyyy;
            break;
        case 'dd-mm-yyyy':
            today = dd+'-'+mm+'-'+yyyy;
            break;
        case 'yyyy/mm/dd':
            today = yyyy+'/'+mm+'/'+dd;
            break;
        case 'yyyy-mm-dd':
            today = yyyy+'-'+mm+'-'+dd;
            break;
        default:
            today = dd+'/'+mm+'/'+yyyy;
            break;
    }

    return today;
}

/*
 *  defalutlModalBodyMessage
 *      Función que muestra mensaje de error por defecto cuando no se puede cargar un Modal.
 *
 *  Parámetros:
 *      e:  Objeto de evento de error de JavaScript.
 *
 */
function defalutlModalBodyMessage(e) {

    e = typeof e !== 'undefined' ? e : '';

    var html = '<div class="alert alert-block alert-danger">\
                <h4>Error al cargar el elemento</h4>\
                Lo sentimos, hubo un problema al cargar la vista, \
                por favor intente nuevamente.<br /> \
                Si el problema persiste por favor contacte al administrador...</div>';

    if(e != '') {
        html = html + '<p><b>Detalle del Error</b><br />' + e + '</p>';
    }
    return html;
}

/*
 *  exportDocument
 *      Función auxiliar para el modal que permite la exportación de Documentos
 *
 *  Parámetros:
 *      parameters: JavaScript Object (objeto tipo JSON), cual debe de contener como mínimo un array de objetos con los siguientes campos:
 *          formats: Array de Objetos que contenga la estructura id, text que son los valores de value y el texto del option que se mostrará en el select del modal-
 *
 *
 *  Ejemplo de uso:
 *      parameters = {
 *          "formats": [
 *              { "id": "HTML", "text": 'Documento Web' },
 *              { "id": "PDF",  "text": 'Documento PDF' },
 *              { "id": "XLS",  "text": 'Documento de Hoja de Cálculo' }
 *          ],
 *          "url": Routing.generate(
 *              'nombre_ruta_symfony',
 *                  {
 *                      'report_name'   : 'rpt_nombre_reporte',
 *                      'report_format' : 'report_format',
 *                      'parametro_1'   : "valor_1",
 *                      'parametro_n'   : "valor_n",
 *                  }
 *              ),
 *          "method": "GET|POST"
 *      };
 *
 *      modal_elements.push({
 *          id                   : 'export_modal',
 *          func                 : 'exportDocument',
 *          header               : 'Encabezado',
 *          footer               : '<button id="btn-export-document" type="button" class="btn btn-primary"><i class="fa fa-download"></i> Exportar</button>',
 *          afterLoadCallFunction: 'initializeDocumentExport',
 *          closeBtnName         : 'Cancelar',
 *          parameters           : parameters
 *      });
 */
function exportDocument(parameters) {
    var html = '';

    if( typeof parameters === 'undefined' || Object.keys(parameters).length === 0 ) {
        parameters = {
            "formats": [
                { "id": "HTML", "text": 'Documento Web' },
                { "id": "PDF",  "text": 'Documento PDF' },
                { "id": "XLS",  "text": 'Documento de Hoja de Cálculo' }
            ]
        };
    } else {
        if( typeof parameters.formats === 'undefined' || Object.keys(parameters.formats).length === 0 ) {
            parameters.formats = [
                { "id": "HTML", "text": 'Documento Web' },
                { "id": "PDF",  "text": 'Documento PDF' },
                { "id": "XLS",  "text": 'Documento de Hoja de Cálculo' }
            ];
        }
    }

    if( typeof parameters.url === 'undefined' || parameters.url === '' ) {
        parameters.url = '#';
    }

    if( typeof parameters.method === 'undefined' || parameters.method === '' ) {
        parameters.method = 'GET';
    }

    html =
        '<div class="row">'+
            '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">'+
                '<p>'+
                    'Para poder exportar los datos es encesario que <strong>seleccione</strong> de la lista que se presenta a continuación el <strong>formato de documento en el cual desea exportar los datos</strong>.'+
                '</p><br />'+
                '<form action="'+parameters.url+'" method="'+parameters.method+'" target="_blank" id="form-export-document" name="form-export-document">'+
                    '<div class="form-group">'+
                        '<label>Formatos de Documento</label>'+
                        '<select class="form-control" id="format-document">';
                            for (var i = 0; i < Object.keys(parameters.formats).length; i++) {
                                html += '<option value="'+parameters.formats[i].id+'">'+parameters.formats[i].text+'</option>';
                            }
                            html +=
                        '</select>'+
                    '</div>'+
                '</form>'+
            '</div>'+
        '</div>';

    return html;
}

function initializeDocumentExport() {
    $formatDocument = $('#format-document');

    var action         = '#';
    var selectedFormat = '';
    var select2Options = {
        placeholder: 'Seleccionar Formato...',
        allowClear: false,
        containerCss: {
            'width': '100%'
        }
    };

    initializeSelect2($formatDocument, false, false, select2Options);

    $('body').on('click','#btn-export-document', function() {
        selectedFormat = $formatDocument.select2('val');
        var regexp     = new RegExp(selectedFormat, 'g');

        action = $('form#form-export-document').attr('action');
        action = action.replace(/report_format/g, selectedFormat);

        $('form#form-export-document').attr('action', action).submit();

        action = action.replace(regexp, 'report_format');

        $('form#form-export-document').attr('action', action)
    });
}

/*
 *  isJson
 *      Función que verifica si un string es un json válido.
 *
 *  Parámetros:
 *      str:  String que contiene el json.
 *
 *  Retorna: Boolean TRUE | FALSE si es un json válido o no.
 */
function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

jQuery(document).ready(function($) {
    /*
     *  Inicialización de Funciones.
     */
    setEditors();
    checkToSwitch();
    setDataTables();
    setClockPicker();
    setBootstrapDatePicker();
    setBootstrapDateRangePicker();

    /*
     *  enableDisableRequiredCollection
     *      Función que permite eliminar en vivo un tr o la tabla en sí de los collections,
     *      esta función se ha creado con el objetivo de poder agregar el attr o la opcion
     *      disabled en los collections.
     *
     *  Parámetros:
     *      selector: String que contiene el selector del checkbox delete del collection
     *                Ejemplo de Selector: 'input[id^="{{ admin.uniqid ~ '_dependenciaTipoDependencia_'}}"]input[id$="__delete"]'
     *                desde el twig de la vista edit.html.twig.
     */
    window.enableDisableRequiredCollection = function(selector) {
        $('body').on('ifChecked', selector, function(e) {
            var numberRows = $(this).closest('table').find('tbody tr').length;
            var idSplit = $(this).attr('id').split('_');
            var $btnAdd = $('#field_actions_'+idSplit[0]+'_'+idSplit[1]+' a');

            if(numberRows > 1) {
                $(this).closest("tr").remove();
            } else {
                $(this).closest("table").remove();
                $btnAdd.removeClass('hidden');
            }
        });
    }

    /*
     *  sonata-collection-add
     *      Evento que se ejecuta cada ves que se agrega una nueva fila al collecto con sonata
     *      pero de forma nativa. El objetivo de capturar este evento es crear un arreglo de Indices
     *      que permitan determinar si un elemento (row) ya ha sido agregado previamente para no ejecutar
     *      su javascript nuevamente y reducir el tiempo de ejecución y carga al sistema.
     */
    window.addIndexToCollection = function(index, collectionName) {
        if(typeof collectionIndex[collectionName] === 'undefined') {
            collectionIndex[collectionName] = {};
        }

        if( $.inArray( index.toString(), Object.keys(collectionIndex[collectionName]) ) < 0 ) {
            collectionIndex[collectionName][index] = false;
        }
    }

    $('body [data-prototype]').each(function() {
        var container = $(this);
        var countRegex = new RegExp('sonata-ba-field-container-'+container.attr('id')+'_','g');
        var idSplit    = container.attr('id').split('_');

        container.find('.sonata-collection-row').each(function() {
            var index = $(this).find('.form-group').attr('id').replace(countRegex, '');

            addIndexToCollection(index, idSplit[1]);
        });
    });

    $('body').on('click', 'a.sonata-collection-add', function() {
        var element   = $(this);
        var container = $(this).closest('[data-prototype]');

        $('body').on('sonata-collection-item-added', function() {
            var countRegex = new RegExp('sonata-ba-field-container-'+container.attr('id')+'_','g');
            var idSplit    = container.attr('id').split('_');
            var index      = container.find('.sonata-collection-row').last().find('.form-group').attr('id').replace(countRegex, '');

            addIndexToCollection(index, idSplit[1]);

            element.trigger('sonata-collection-item-indexed');
        });
    });

    /*
     *  sonata-collection-delete
     *      Evento que se ejecuta cada ves que se elimina una nueva fila al collecto con sonata
     *      pero de forma nativa. El objetivo de capturar este evento es eliminar del arreglo de Indices
     *      el índice de la fila que actualmente se esta eliminando para que cuando se vuelva a crear la fila
     *      con el índice eliminado se ejecute el javascript correspondiente a él.
     */
    $('body').on('click', 'a.sonata-collection-delete', function() {
        var element    = $(this);
        var container  = $(this).closest('[data-prototype]');
        var countRegex = new RegExp('sonata-ba-field-container-'+container.attr('id')+'_','g');
        var idSplit    = container.attr('id').split('_');
        var index      = element.closest('.sonata-collection-row').find('.form-group').attr('id').replace(countRegex, '');

        $(document).on('sonata-collection-item-deleted-successful', function() {
            if(typeof collectionIndex[idSplit[1]] === 'undefined') {
                console.log('Error no se encontró el array perteneciente al collection "'+idSplit[1]+'"');
            } else {
                if( $.inArray( index.toString(), Object.keys(collectionIndex[idSplit[1]]) ) > -1 ) {
                    delete collectionIndex[idSplit[1]][index];
                } else {
                    console.log('No se encontró el valor: "'+index+'" dentro del Array:');
                    console.log(collectionIndex[idSplit[1]]);
                }
            }
        });
    });

    /*
     *  Estandarización del uso de Modal dentro del Proyecto
     */
    $('body').append('\
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">\
            <div class="modal-dialog">\
                <div class="modal-content">\
                    <div class="modal-header">\
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>\
                    </div>\
                    <div class="modal-body">\
                    </div>\
                    <div class="modal-footer">\
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #636363;font-weight: bold;">Cerrar</button>\
                    </div>\
                </div>\
            </div>\
        </div>');

    $('a[href="#myModal"]').each(function(e) {
        if ( $(this).attr('data-tooltip-enabled') === 'true' ) {
            $(this).append('<i class="icon-info-sign" title="Click para ver detalles." id="'+$(this).attr("id")+'_i"></i>');
            $('#'+$(this).attr("id")+'_i').tooltip();
        }
    });

    $("body").on('click', 'a[href="#myModal"]', function(e){
        var currentIDM = $(this).attr("id");
        if (!(typeof modal_elements === 'undefined') && modal_elements.length != 0) {
            for (var i = 0; i < modal_elements.length; i++) {
                if (currentIDM == modal_elements[i].id) {
                    if (modal_elements[i].empty != true) {
                        /*Limpiando los elementos del modal*/
                        $('#myModal div.modal-header h4#myModalLabel').empty();
                        $('#myModal div.modal-body').empty();
                        $('#myModal div.modal-footer').empty();

                        /*Verificando el contendio a mostrar*/
                        if (typeof modal_elements[i].header === 'undefined' || modal_elements[i].header == '') {
                            modal_elements[i].header = 'Detalle';
                        }

                        if (typeof modal_elements[i].func === 'undefined' || modal_elements[i].func == '') {
                            modal_elements[i].func = 'defalutlModalBodyMessage';
                        }

                        if (typeof modal_elements[i].parameters === 'undefined' || modal_elements[i].func == '') {
                            var modalBody = window[modal_elements[i].func]();
                        } else {
                            var modalBody = window[modal_elements[i].func](modal_elements[i].parameters);
                        }

                        /*Estableciendo los nuevos valores del modal*/
                        $('#myModal div.modal-header h4#myModalLabel').append(modal_elements[i].header);
                        if (modalBody != '') {
                            $('#myModal div.modal-body').append(modalBody);
                            if (typeof modal_elements[i].closeBtnName === 'undefined' || modal_elements[i].closeBtnName == '') {
                                $('#myModal div.modal-footer').append(modal_elements[i].footer + '<button type="button" class="btn btn-default" data-dismiss="modal" style="color: #636363;font-weight: bold;">Cerrar</button>');
                            } else {
                                $('#myModal div.modal-footer').append(modal_elements[i].footer + '<button type="button" class="btn btn-default" data-dismiss="modal" style="color: #636363;font-weight: bold;">'+modal_elements[i].closeBtnName+'</button>');
                            }
                        } else {
                            $('#myModal div.modal-body').append(window['defalutlModalBodyMessage']());
                            $('#myModal div.modal-footer').append('<button type="button" class="btn btn-default" data-dismiss="modal" style="color: #636363;font-weight: bold;">Cerrar</button>');
                        }

                        if (typeof modal_elements[i].afterLoadCallFunction !== 'undefined' && modal_elements[i].afterLoadCallFunction != '') {
                            window[modal_elements[i].afterLoadCallFunction]();
                        }

                        if (typeof modal_elements[i].widthModal !== 'undefined' && modal_elements[i].widthModal != '') {
                            /*$('div#myModal').css({ 'width': modal_elements[i].widthModal+'px', 'margin-left': '-'+(modal_elements[i].widthModal/2)+'px' });*/
                            $('div#myModal div.modal-dialog').css({ 'width': modal_elements[i].widthModal+'px' });
                        }

                    } else {
                        if (typeof modal_elements[i].emptyMessage === 'undefined') {
                            var mBody = '<i class="icon-exclamation-sign" style="margin-right:7px;"></i>\
                                         No se ha seleccionado ningun elemento del cual se puedan mostrar los detalles,\
                                         por favor seleccione uno e intente nuevamente.';

                            modal_elements[i].emptyMessage = [ {emptyMTitle: 'Elemento no seleccionado', emptyMBody: mBody } ];
                        } else  {

                            if (typeof modal_elements[i].emptyMessage[0].emptyMTitle === 'undefined' || modal_elements[i].emptyMessage[0].emptyMTitle == '') {
                                modal_elements[i].emptyMessage[0].emptyMTitle = 'Elemento no seleccionado';
                            }

                            if (typeof modal_elements[i].emptyMessage[0].emptyMBody === 'undefined' || modal_elements[i].emptyMessage[0].emptyMBody == '') {
                                modal_elements[i].emptyMessage[0].emptyMBody = '<i class="icon-exclamation-sign" style="margin-right:7px;"></i>\
                                         No se ha seleccionado ningun elemento del cual se puedan mostrar los detalles,\
                                         por favor seleccione uno e intente nuevamente.';
                            }
                        }

                        $('#myModal div.modal-header h4#myModalLabel').empty();
                        $('#myModal div.modal-body').empty();
                        $('#myModal div.modal-footer').empty();

                        $('#myModal div.modal-header h4#myModalLabel').append(modal_elements[i].emptyMessage[0].emptyMTitle);
                        $('#myModal div.modal-body').append(modal_elements[i].emptyMessage[0].emptyMBody);
                        $('#myModal div.modal-footer').append('<button class="action" data-dismiss="modal" aria-hidden="true"><span class="label">Cerrar</span></button>');
                    }
                }
            }
        } else {
            $('#myModal div.modal-header h4#myModalLabel').empty();
            $('#myModal div.modal-body').empty();
            $('#myModal div.modal-footer').empty();

            $('#myModal div.modal-header h4#myModalLabel').append('Error!!!');
            $('#myModal div.modal-body').append('<div class="alert alert-danger">\
                                                     <h4>Ops! ha ocurrido un error</h4>\
                                                     Lo sentimos pero ha ocurrido un error, por favor intente nuevamente, si el problema persiste por favor contacte con el administrador\
                                                 </div>');
            $('#myModal div.modal-footer').append('<button class="action" data-dismiss="modal" aria-hidden="true"><span class="label">Cerrar</span></button>');
        }
    });
    /* Fin Estandarización del uso de Modal dentro del Proyecto */

    /* Selector de archivos */
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        var input = $(this).parents('.input-group').find(':text'), log = numFiles > 1 ? numFiles + ' files selected' : label;

        if( input.length ) {
            input.val(log);
        } else {
            if( log ) {
                console.log(log);
            }
        }
    });
    /* Fin selector de archivos */
});

$(document).on('change', '.btn-file :file', function() {
    var input = $(this), numFiles = input.get(0).files ? input.get(0).files.length : 1, label = input.val().replace(/\\/g, '/').replace(/.*\//, '').replace("C:\\fakepath\\", "");
    input.trigger('fileselect', [numFiles, label]);
});
