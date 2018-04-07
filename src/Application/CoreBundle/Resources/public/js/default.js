/**
* Funcion para llamar al mensaje de alerta el cual es lanzado por showDialogMsg
*se customizo para que filtre el tipo de mensaje, el titulo y el mensaje  a mostrar
* @param {String} titulo titulo de la ventana
* @param {String} mensaje mensaje a mostrar
* @param {integer} tipoAlert tipo de alerta puede ser:
*        0----> ventana error
*        1----> ventana success
*        2----> ventana warning
*        otro num----> ventana default
* @returns mensaje de alerta
*/
function lanzarAlerta(titulo,mensaje,tipoAlert){
  var width='750px';
  var clase='dialog-default';
  switch (tipoAlert) {
          case 0:
              clase='dialog-error';
            break;
          case 1:
              clase='dialog-success';
              break;
          case 2:
              clase='dialog-warning';
                break;
          default:
              clase='dialog-default';
            break;
        }
  var arrayBtns = [
      {
          text: 'Ok', click: function( event, ui) {
              $(this).dialog('close');
              $('#ver').hide();
          }
      }
  ];
  showDialogMsg(titulo, mensaje, clase, '', arrayBtns, false, width, true);
}


/**
* Inicializa los select para ello se necesita mandarle el objeto del elementos
* y se uitilizo la fucnion initializeSelect2
* @param {integer} idElemento elemento a inicializar
* @param {String}  msg mensage a mostrar en el placeholder
* @returns select inicializado
*/
function inicializarSelect(idElemento, msg){
  initializeSelect2(idElemento, true, false, {
      placeholder:msg,
      allowClear: true,
      width: '100%'
  });
}
