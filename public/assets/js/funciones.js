/* 
  @author     🆁🅼🅽
  @copyright 己〥-0己-己0己㇌
  @empresa FIBREMEX
 error_reporting(0);
  */

/* document ready 

$(function() {
        

      }); */

function DatatableFilters(Elem) {
  $("#" + Elem + " tfoot tr th").each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Filtrar.." />');
    $("#" + Elem).addClass(
      "table table-dark table-responsive table-hover cell-border  table-striped "
    );
  });

  var table = $("#" + Elem).DataTable({
    destroy: true,
    paging: false,
    pageLength: 100,
    dom: 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
    responsive: false,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
    order: [[0, "asc"]],
    responsive: true,
    initComplete: function () {
      this.api()
        .columns()
        .every(function () {
          var that = this;

          $("input", this.footer()).on("keyup change", function () {
            if (that.search() !== this.value) {
              that.search(this.value).draw();
            }
          });
        });
    },
    buttons: [
      {
        extend: "excel",
        text: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><defs><linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086" y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#18884f"/><stop offset=".5" stop-color="#117e43"/><stop offset="1" stop-color="#0b6631"/></linearGradient></defs><path fill="#185c37" d="M19.581 15.35L8.512 13.4v14.409A1.192 1.192 0 0 0 9.705 29h19.1A1.192 1.192 0 0 0 30 27.809V22.5Z"/><path fill="#21a366" d="M19.581 3H9.705a1.192 1.192 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z"/><path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z"/><path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2Z" opacity=".1"/><path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path fill="url(#vscodeIconsFileTypeExcel0)" d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.192 1.192 0 0 1 2 21.959V10.041A1.192 1.192 0 0 1 3.194 8.85Z"/><path fill="#000" d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.355 2.355 0 0 1 9.2 16.8h-.024a1.688 1.688 0 0 1-.168.351l-1.493 2.722Z"/><path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.192 1.192 0 0 0 28.806 3Z"/><path fill="#107c41" d="M19.581 16H30v6.5H19.581Z"/></svg>Excel&nbsp;&nbsp;',
        filename: Elem,
        excelStyles: [
          // Add an excelStyles definition
          {
            template: "green_medium", // Apply the 'green_medium' template
          },
          {
            cells: "sh", // Use Smart References (s) to target the header row (h)
            style: {
              // The style definition
              font: {
                // Style the font
                size: 14, // Size 14
                b: false, // Turn off the default bolding of the header row
              },
              fill: {
                // Style the cell fill
                pattern: {
                  // Add a pattern (default is solid)
                  color: "1C3144", // Define the fill color
                },
              },
            },
          },
        ],
      },
    ],
  });
  return table;
}
/*  
LLAMAR LA FUNCION
        $(function() {
          DatatableFilters('comp611');
          Datatable('comp6');

        }); */

function DatatableSelects(Elem) {
  let table = $("#" + Elem).DataTable({
    destroy: true,
    pageLength: 100,
    dom: 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
    responsive: false,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
    order: [[0, "asc"]],
    initComplete: function () {
      this.api()
        .columns()
        .every(function () {
          var column = this;
          var select = $('<select><option value=""></option></select>')
            .appendTo($(column.footer()).empty())
            .on("change", function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());

              column.search(val ? "^" + val + "$" : "", true, false).draw();
            });

          column
            .data()
            .unique()
            .sort()
            .each(function (d, j) {
              var val = $.fn.dataTable.util.escapeRegex(d);
              if (column.search() === "^" + val + "$") {
                select.append(
                  '<option value="' +
                    d +
                    '" selected="selected">' +
                    d +
                    "</option>"
                );
              } else {
                select.append('<option value="' + d + '">' + d + "</option>");
              }
            });
        });
    },
    buttons: ["excel", "pdf"],
  });
  return table;
}

function Toast(icono, titulo) {
  const Toast = Swal.mixin({
    toast: true,
    position: "top",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener("mouseenter", Swal.stopTimer);
      toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
  });

  Toast.fire({
    icon: icono,
    title: titulo,
  });

  return Toast;
}
/*  ToastDialog("success", "Guardado" ).then(function() {
                    window.location = 'index.php?menu=08&sub=12';
                  }); */
function ToastDialog(icono, titulo) {
  const Toast = Swal.fire({
    position: "center-end",
    icon: icono,
    title: titulo,
    showConfirmButton: false,
    timer: 1500,
  });

  return Toast;
}
function Numeros(string) {
  //Solo numeros
  var out = "";
  var filtro = "1234567890"; //Caracteres validos

  //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos
  for (var i = 0; i < string.length; i++)
    if (filtro.indexOf(string.charAt(i)) != -1)
      //Se añaden a la salida los caracteres validos
      out += string.charAt(i);

  //Retornar valor filtrado
  return out;
}
/*  
LLAMAR LA FUNCION

const  misDatos = "b=" + consulta + "&soc=" + soc;
enviarDatosPorAjax(misDatos, "calidad_detalle.php", function(respuesta) {
                  const resultado = document.getElementById("resultado_Ver_comentarios1");
                  resultado.innerHTML = respuesta;
                }); 
                
                
                   beforeSend: function() {
                            //imagen de carga
                            $("#geeks2").css("display", "none");

                            $("#resultado_ag_actividad1_optro").html("<p align='center'><img src='ajax-loader.gif' /></p>");

                          },
                */
function enviarDatosPorAjax(datos, ruta, callback) {
  const xhr = new XMLHttpRequest();

  // Configura la solicitud
  xhr.open("POST", ruta, true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Maneja la respuesta de la solicitud
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      callback(xhr.responseText);
    }
  };
  // Envía la solicitud
  xhr.send(datos);
}
/* DEPENDE DE LA RESPUESTA DA ALERTA */
/*    enviarDatosPorAjax("id=" + valor + "&opcion=4 ", "mkt_seminarios_guardar.php", function(respuesta) {
          if (respuesta == 'ok') {
            ToastDialog("success", "Borrado")
            $("#exampleModalver").modal("toggle");
          } else {
            ToastDialog("error", "Error")

          }

        }); */
        var InitialDatatableSvista2 = function (Elem, Ruta,datos) {
          let table = $("." + Elem).DataTable({
            searching: false,
            serverSide: true,
            info: false,
            ordering: false,
            paging: false,
            cache: true,
            fixedHeader: true,
            scrollX: true,
            bProcessing: true,
    processing: true,
            scrollCollapse: true, // Colapsar el área de desplazamiento cuando no es necesario
            scrollY: 500, // Altura máxima de la tabla   ZB
        
            dom: 'ZB<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
            },
            fixedColumns: {
        
                left: 2
            },
            language: {
              url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
            },
            buttons: [
              {
                extend: "excel",
                text: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><defs><linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086" y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#18884f"/><stop offset=".5" stop-color="#117e43"/><stop offset="1" stop-color="#0b6631"/></linearGradient></defs><path fill="#185c37" d="M19.581 15.35L8.512 13.4v14.409A1.192 1.192 0 0 0 9.705 29h19.1A1.192 1.192 0 0 0 30 27.809V22.5Z"/><path fill="#21a366" d="M19.581 3H9.705a1.192 1.192 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z"/><path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z"/><path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2Z" opacity=".1"/><path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path fill="url(#vscodeIconsFileTypeExcel0)" d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.192 1.192 0 0 1 2 21.959V10.041A1.192 1.192 0 0 1 3.194 8.85Z"/><path fill="#000" d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.355 2.355 0 0 1 9.2 16.8h-.024a1.688 1.688 0 0 1-.168.351l-1.493 2.722Z"/><path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.192 1.192 0 0 0 28.806 3Z"/><path fill="#107c41" d="M19.581 16H30v6.5H19.581Z"/></svg>Excel&nbsp;&nbsp;',
                filename: Elem,
                excelStyles: [
                  // Add an excelStyles definition
                  {
                    template: "green_medium", // Apply the 'green_medium' template
                  },
                  {
                    cells: "sh", // Use Smart References (s) to target the header row (h)
                    style: {
                      // The style definition
                      font: {
                        // Style the font
                        size: 14, // Size 14
                        b: false, // Turn off the default bolding of the header row
                      },
                      fill: {
                        // Style the cell fill
                        pattern: {
                          // Add a pattern (default is solid)
                          color: "1C3144", // Define the fill color
                        },
                      },
                    },
                  },
                ],
              },
            ],
            ajax: {
              url: Ruta,
              data: {"familia": datos} ,
              type: "POST",
              
              error: function (data) {
                alert("error petición ajax");
              },
            },
          });
          return table;
        };
var Datatable = function (Elem) {
  let table = $("#" + Elem).DataTable({
    destroy: true,
    paging: false,
    pageLength: 100,
    dom: 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
    responsive: false,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
    order: [[0, "asc"]],
    responsive: true,

    buttons: [
      {
        extend: "excel",
        text: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><defs><linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086" y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#18884f"/><stop offset=".5" stop-color="#117e43"/><stop offset="1" stop-color="#0b6631"/></linearGradient></defs><path fill="#185c37" d="M19.581 15.35L8.512 13.4v14.409A1.192 1.192 0 0 0 9.705 29h19.1A1.192 1.192 0 0 0 30 27.809V22.5Z"/><path fill="#21a366" d="M19.581 3H9.705a1.192 1.192 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z"/><path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z"/><path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2Z" opacity=".1"/><path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path fill="url(#vscodeIconsFileTypeExcel0)" d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.192 1.192 0 0 1 2 21.959V10.041A1.192 1.192 0 0 1 3.194 8.85Z"/><path fill="#000" d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.355 2.355 0 0 1 9.2 16.8h-.024a1.688 1.688 0 0 1-.168.351l-1.493 2.722Z"/><path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.192 1.192 0 0 0 28.806 3Z"/><path fill="#107c41" d="M19.581 16H30v6.5H19.581Z"/></svg>Excel&nbsp;&nbsp;',
        filename: Elem,
        excelStyles: [
          // Add an excelStyles definition
          {
            template: "green_medium", // Apply the 'green_medium' template
          },
          {
            cells: "sh", // Use Smart References (s) to target the header row (h)
            style: {
              // The style definition
              font: {
                // Style the font
                size: 14, // Size 14
                b: false, // Turn off the default bolding of the header row
              },
              fill: {
                // Style the cell fill
                pattern: {
                  // Add a pattern (default is solid)
                  color: "1C3144", // Define the fill color
                },
              },
            },
          },
        ],
      },
    ],
  });
  return table;
};
var fixedDatatable = function (Elem) {
  let table = $("#" + Elem).DataTable({
    dom: 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
    scrollY: "300px",
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    fixedColumns: {
      left: 2,
    },
    buttons: [
      {
        extend: "excel",
        text: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><defs><linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086" y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#18884f"/><stop offset=".5" stop-color="#117e43"/><stop offset="1" stop-color="#0b6631"/></linearGradient></defs><path fill="#185c37" d="M19.581 15.35L8.512 13.4v14.409A1.192 1.192 0 0 0 9.705 29h19.1A1.192 1.192 0 0 0 30 27.809V22.5Z"/><path fill="#21a366" d="M19.581 3H9.705a1.192 1.192 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z"/><path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z"/><path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2Z" opacity=".1"/><path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path fill="url(#vscodeIconsFileTypeExcel0)" d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.192 1.192 0 0 1 2 21.959V10.041A1.192 1.192 0 0 1 3.194 8.85Z"/><path fill="#000" d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.355 2.355 0 0 1 9.2 16.8h-.024a1.688 1.688 0 0 1-.168.351l-1.493 2.722Z"/><path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.192 1.192 0 0 0 28.806 3Z"/><path fill="#107c41" d="M19.581 16H30v6.5H19.581Z"/></svg>Excel&nbsp;&nbsp;',
        filename: Elem,
        excelStyles: [
          // Add an excelStyles definition
          {
            template: "green_medium", // Apply the 'green_medium' template
          },
          {
            cells: "sh", // Use Smart References (s) to target the header row (h)
            style: {
              // The style definition
              font: {
                // Style the font
                size: 14, // Size 14
                b: false, // Turn off the default bolding of the header row
              },
              fill: {
                // Style the cell fill
                pattern: {
                  // Add a pattern (default is solid)
                  color: "1C3144", // Define the fill color
                },
              },
            },
          },
        ],
      },
    ],
  });
  return table;
};
var fixedFiltersDatatable = function (Elem) {
  $("#" + Elem + " tfoot th").each(function (i) {
    var title = $("#" + Elem + " thead th")
      .eq($(this).index())
      .text();
    $(this).html(
      '<input type="text" placeholder="' + title + '" data-index="' + i + '" />'
    );
  });
  let table = $("#" + Elem).DataTable({
    dom: 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
    scrollY: "300px",
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    fixedColumns: {
      left: 4,
    },
    initComplete: function () {
      this.api()
        .columns()
        .every(function () {
          var that = this;

          $("input", this.footer()).on("keyup change", function () {
            if (that.search() !== this.value) {
              that.search(this.value).draw();
            }
          });
        });
    },
    buttons: [
      {
        extend: "excel",
        text: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><defs><linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086" y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#18884f"/><stop offset=".5" stop-color="#117e43"/><stop offset="1" stop-color="#0b6631"/></linearGradient></defs><path fill="#185c37" d="M19.581 15.35L8.512 13.4v14.409A1.192 1.192 0 0 0 9.705 29h19.1A1.192 1.192 0 0 0 30 27.809V22.5Z"/><path fill="#21a366" d="M19.581 3H9.705a1.192 1.192 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z"/><path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z"/><path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2Z" opacity=".1"/><path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path fill="url(#vscodeIconsFileTypeExcel0)" d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.192 1.192 0 0 1 2 21.959V10.041A1.192 1.192 0 0 1 3.194 8.85Z"/><path fill="#000" d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.355 2.355 0 0 1 9.2 16.8h-.024a1.688 1.688 0 0 1-.168.351l-1.493 2.722Z"/><path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.192 1.192 0 0 0 28.806 3Z"/><path fill="#107c41" d="M19.581 16H30v6.5H19.581Z"/></svg>Excel&nbsp;&nbsp;',
        filename: Elem,
        excelStyles: [
          // Add an excelStyles definition
          {
            template: "green_medium", // Apply the 'green_medium' template
          },
          {
            cells: "sh", // Use Smart References (s) to target the header row (h)
            style: {
              // The style definition
              font: {
                // Style the font
                size: 14, // Size 14
                b: false, // Turn off the default bolding of the header row
              },
              fill: {
                // Style the cell fill
                pattern: {
                  // Add a pattern (default is solid)
                  color: "1C3144", // Define the fill color
                },
              },
            },
          },
        ],
      },
    ],
  });
  return table;
};
var InitialDatatable = function (Elem) {
  let table = $("#" + Elem).DataTable({
    destroy: true,
    paging: false,
    pageLength: 100,
    dom: 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
    responsive: false,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
    order: false,
    responsive: true,

    buttons: [
      {
        extend: "excel",
        text: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><defs><linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086" y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#18884f"/><stop offset=".5" stop-color="#117e43"/><stop offset="1" stop-color="#0b6631"/></linearGradient></defs><path fill="#185c37" d="M19.581 15.35L8.512 13.4v14.409A1.192 1.192 0 0 0 9.705 29h19.1A1.192 1.192 0 0 0 30 27.809V22.5Z"/><path fill="#21a366" d="M19.581 3H9.705a1.192 1.192 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z"/><path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z"/><path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2Z" opacity=".1"/><path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path fill="url(#vscodeIconsFileTypeExcel0)" d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.192 1.192 0 0 1 2 21.959V10.041A1.192 1.192 0 0 1 3.194 8.85Z"/><path fill="#000" d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.355 2.355 0 0 1 9.2 16.8h-.024a1.688 1.688 0 0 1-.168.351l-1.493 2.722Z"/><path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.192 1.192 0 0 0 28.806 3Z"/><path fill="#107c41" d="M19.581 16H30v6.5H19.581Z"/></svg>Excel&nbsp;&nbsp;',
        filename: Elem,
        excelStyles: [
          // Add an excelStyles definition
          {
            template: "green_medium", // Apply the 'green_medium' template
          },
          {
            cells: "sh", // Use Smart References (s) to target the header row (h)
            style: {
              // The style definition
              font: {
                // Style the font
                size: 14, // Size 14
                b: false, // Turn off the default bolding of the header row
              },
              fill: {
                // Style the cell fill
                pattern: {
                  // Add a pattern (default is solid)
                  color: "1C3144", // Define the fill color
                },
              },
            },
          },
        ],
      },
    ],
  });
  return table;
};
var InitialDatatableServer = function (Elem, Ruta) {
  let table = $("." + Elem).DataTable({
    destroy: true,
    bProcessing: true,
    processing: true,
    serverSide: true,
    /*   "scrollY":580, */
    order: [[0, "ASC"]],
    responsive: true,
    //"ordering": false,
    buttons: ["excel"],
    /*"scrollX":true,*/
    /*"scrollCollapse": true,*/
    Cache: false,
    pageLength: 25,

    /*"paging": false,*/
    dom: 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
    /*   "stateSave": true,  */
    lengthMenu: [
      [10, 25, 50, -1],
      ["10", "25", "50", "Todos"],
    ],
    pagingType: "full_numbers",
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
    buttons: [
      {
        extend: "excel",
        text: '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32"><defs><linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086" y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#18884f"/><stop offset=".5" stop-color="#117e43"/><stop offset="1" stop-color="#0b6631"/></linearGradient></defs><path fill="#185c37" d="M19.581 15.35L8.512 13.4v14.409A1.192 1.192 0 0 0 9.705 29h19.1A1.192 1.192 0 0 0 30 27.809V22.5Z"/><path fill="#21a366" d="M19.581 3H9.705a1.192 1.192 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z"/><path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z"/><path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2Z" opacity=".1"/><path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path fill="url(#vscodeIconsFileTypeExcel0)" d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.192 1.192 0 0 1 2 21.959V10.041A1.192 1.192 0 0 1 3.194 8.85Z"/><path fill="#000" d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.355 2.355 0 0 1 9.2 16.8h-.024a1.688 1.688 0 0 1-.168.351l-1.493 2.722Z"/><path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.192 1.192 0 0 0 28.806 3Z"/><path fill="#107c41" d="M19.581 16H30v6.5H19.581Z"/></svg>Excel&nbsp;&nbsp;',
        filename: Elem,
        excelStyles: [
          // Add an excelStyles definition
          {
            template: "green_medium", // Apply the 'green_medium' template
          },
          {
            cells: "sh", // Use Smart References (s) to target the header row (h)
            style: {
              // The style definition
              font: {
                // Style the font
                size: 14, // Size 14
                b: false, // Turn off the default bolding of the header row
              },
              fill: {
                // Style the cell fill
                pattern: {
                  // Add a pattern (default is solid)
                  color: "1C3144", // Define the fill color
                },
              },
            },
          },
        ],
      },
    ],
    ajax: {
      url: Ruta,
      beforeSend: function (data) {
        //imagen de carga
        /*  let timerInterval
        Swal.fire({
          title: 'Cargando....',
          html: ' <b></b> milliseconds.',
          timer: 1000,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
              b.textContent = Swal.getTimerLeft()
            }, 100)
          },
          willClose: () => {
            clearInterval(timerInterval)
          }
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
          }
        }) */
      },
      error: function (data) {
        alert("error petición ajax");
      },
    },
  });
  return table;
};
function DatatableFiltersServer(Elem, Ruta) {
  $("#" + Elem + " tfoot tr th").each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Filtrar.." />');
    $("#" + Elem).addClass("table table-striped table-bordered table-hover");
  });

  var table = $("#" + Elem).DataTable({
    destroy: true,
    bProcessing: true,
    /*"scrollY":580,*/
    /*"scrollX":true,*/
    /*"scrollCollapse": true,*/
    dom: 'ZB<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',

    serverSide: true,
    pageLength: 25,
    /*"paging": false,*/
    /*  "stateSave": true, */
    lengthMenu: [
      [10, 25, 50, -1],
      ["10", "25", "50", "Todos"],
    ],
    order: [[0, "desc"]],
    pagingType: "full_numbers",
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
    ajax: {
      url: Ruta,
      type: "POST",
      error: function (data) {
        alert("some error occured please try again.");
      },
    },
    responsive: true,
    initComplete: function () {
      this.api()
        .columns()
        .every(function () {
          var that = this;

          $("input", this.footer()).on("keyup change", function () {
            if (that.search() !== this.value) {
              that.search(this.value).draw();
            }
          });
        });
    },
    buttons: [
      {
        extend: "excel",
        text: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 32 32"><defs><linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086" y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#18884f"/><stop offset=".5" stop-color="#117e43"/><stop offset="1" stop-color="#0b6631"/></linearGradient></defs><path fill="#185c37" d="M19.581 15.35L8.512 13.4v14.409A1.192 1.192 0 0 0 9.705 29h19.1A1.192 1.192 0 0 0 30 27.809V22.5Z"/><path fill="#21a366" d="M19.581 3H9.705a1.192 1.192 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z"/><path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z"/><path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2Z" opacity=".1"/><path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path fill="url(#vscodeIconsFileTypeExcel0)" d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.192 1.192 0 0 1 2 21.959V10.041A1.192 1.192 0 0 1 3.194 8.85Z"/><path fill="#fff" d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.355 2.355 0 0 1 9.2 16.8h-.024a1.688 1.688 0 0 1-.168.351l-1.493 2.722Z"/><path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.192 1.192 0 0 0 28.806 3Z"/><path fill="#107c41" d="M19.581 16H30v6.5H19.581Z"/></svg>&nbsp;&nbsp;',
        filename: Elem,
      },
    ],
  });
  return table;
}
var InitialDatatableCuentas = function (Elem) {
  let groupColumn = 5;
  let table = $("#" + Elem).DataTable({
    destroy: true,
    paging: false,
    pageLength: 100,
    dom: 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
    responsive: false,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
    ordering: false,
    responsive: true,
    /* rowGroup: {
    startRender: null,
    endRender: function ( rows, group ) {
        return group +' ('+rows.count()+')';
    },
    dataSrc: [4,5]
}, */
    columnDefs: [{ visible: true, targets: groupColumn }],
    drawCallback: function (settings) {
      var api = this.api();
      var rows = api.rows({ page: "current" }).nodes();
      var last = null;

      api
        .column(groupColumn, { page: "current" })
        .data()
        .each(function (group, i) {
          if (last !== group) {
            var TOTAL = $(rows)
              .eq(i - 1)
              .find("td:eq(4)")
              .text();

            $(rows)
              .eq(i - 1)
              .before(
                '<tr class="group"><td colspan="6"><span class="badge d-block bg-Warning text-dark-900 rounded-0 pt-5px " style="min-height: 20px">TOTAL DEL CIERRE  ' +
                  TOTAL +
                  "</span> </td> </tr>"
              );
            /*   var counter = 0;
            console.log(table);
            table.row
              .add([
                counter + ".1",
                counter + ".2",
                counter + ".3",
                counter + ".4",
                counter + ".5",
                counter + ".5",

              ])
              .draw(false); */

            $(rows)
              .eq(i)
              .before(
                '<tr class="group"><td colspan="6">' + group + "</td></tr>"
              );
            last = group;
          }
        });
    },
    buttons: [
      {
        extend: "pdf",
        text: '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32"><path fill="#909090" d="m24.1 2.072l5.564 5.8v22.056H8.879V30h20.856V7.945L24.1 2.072"/><path fill="#f4f4f4" d="M24.031 2H8.808v27.928h20.856V7.873L24.03 2"/><path fill="#7a7b7c" d="M8.655 3.5h-6.39v6.827h20.1V3.5H8.655"/><path fill="#dd2025" d="M22.472 10.211H2.395V3.379h20.077v6.832"/><path fill="#464648" d="M9.052 4.534H7.745v4.8h1.028V7.715L9 7.728a2.042 2.042 0 0 0 .647-.117a1.427 1.427 0 0 0 .493-.291a1.224 1.224 0 0 0 .335-.454a2.13 2.13 0 0 0 .105-.908a2.237 2.237 0 0 0-.114-.644a1.173 1.173 0 0 0-.687-.65a2.149 2.149 0 0 0-.409-.104a2.232 2.232 0 0 0-.319-.026m-.189 2.294h-.089v-1.48h.193a.57.57 0 0 1 .459.181a.92.92 0 0 1 .183.558c0 .246 0 .469-.222.626a.942.942 0 0 1-.524.114m3.671-2.306c-.111 0-.219.008-.295.011L12 4.538h-.78v4.8h.918a2.677 2.677 0 0 0 1.028-.175a1.71 1.71 0 0 0 .68-.491a1.939 1.939 0 0 0 .373-.749a3.728 3.728 0 0 0 .114-.949a4.416 4.416 0 0 0-.087-1.127a1.777 1.777 0 0 0-.4-.733a1.63 1.63 0 0 0-.535-.4a2.413 2.413 0 0 0-.549-.178a1.282 1.282 0 0 0-.228-.017m-.182 3.937h-.1V5.392h.013a1.062 1.062 0 0 1 .6.107a1.2 1.2 0 0 1 .324.4a1.3 1.3 0 0 1 .142.526c.009.22 0 .4 0 .549a2.926 2.926 0 0 1-.033.513a1.756 1.756 0 0 1-.169.5a1.13 1.13 0 0 1-.363.36a.673.673 0 0 1-.416.106m5.08-3.915H15v4.8h1.028V7.434h1.3v-.892h-1.3V5.43h1.4v-.892"/><path fill="#dd2025" d="M21.781 20.255s3.188-.578 3.188.511s-1.975.646-3.188-.511Zm-2.357.083a7.543 7.543 0 0 0-1.473.489l.4-.9c.4-.9.815-2.127.815-2.127a14.216 14.216 0 0 0 1.658 2.252a13.033 13.033 0 0 0-1.4.288Zm-1.262-6.5c0-.949.307-1.208.546-1.208s.508.115.517.939a10.787 10.787 0 0 1-.517 2.434a4.426 4.426 0 0 1-.547-2.162Zm-4.649 10.516c-.978-.585 2.051-2.386 2.6-2.444c-.003.001-1.576 3.056-2.6 2.444ZM25.9 20.895c-.01-.1-.1-1.207-2.07-1.16a14.228 14.228 0 0 0-2.453.173a12.542 12.542 0 0 1-2.012-2.655a11.76 11.76 0 0 0 .623-3.1c-.029-1.2-.316-1.888-1.236-1.878s-1.054.815-.933 2.013a9.309 9.309 0 0 0 .665 2.338s-.425 1.323-.987 2.639s-.946 2.006-.946 2.006a9.622 9.622 0 0 0-2.725 1.4c-.824.767-1.159 1.356-.725 1.945c.374.508 1.683.623 2.853-.91a22.549 22.549 0 0 0 1.7-2.492s1.784-.489 2.339-.623s1.226-.24 1.226-.24s1.629 1.639 3.2 1.581s1.495-.939 1.485-1.035"/><path fill="#909090" d="M23.954 2.077V7.95h5.633l-5.633-5.873Z"/><path fill="#f4f4f4" d="M24.031 2v5.873h5.633L24.031 2Z"/><path fill="#fff" d="M8.975 4.457H7.668v4.8H8.7V7.639l.228.013a2.042 2.042 0 0 0 .647-.117a1.428 1.428 0 0 0 .493-.291a1.224 1.224 0 0 0 .332-.454a2.13 2.13 0 0 0 .105-.908a2.237 2.237 0 0 0-.114-.644a1.173 1.173 0 0 0-.687-.65a2.149 2.149 0 0 0-.411-.105a2.232 2.232 0 0 0-.319-.026m-.189 2.294h-.089v-1.48h.194a.57.57 0 0 1 .459.181a.92.92 0 0 1 .183.558c0 .246 0 .469-.222.626a.942.942 0 0 1-.524.114m3.67-2.306c-.111 0-.219.008-.295.011l-.235.006h-.78v4.8h.918a2.677 2.677 0 0 0 1.028-.175a1.71 1.71 0 0 0 .68-.491a1.939 1.939 0 0 0 .373-.749a3.728 3.728 0 0 0 .114-.949a4.416 4.416 0 0 0-.087-1.127a1.777 1.777 0 0 0-.4-.733a1.63 1.63 0 0 0-.535-.4a2.413 2.413 0 0 0-.549-.178a1.282 1.282 0 0 0-.228-.017m-.182 3.937h-.1V5.315h.013a1.062 1.062 0 0 1 .6.107a1.2 1.2 0 0 1 .324.4a1.3 1.3 0 0 1 .142.526c.009.22 0 .4 0 .549a2.926 2.926 0 0 1-.033.513a1.756 1.756 0 0 1-.169.5a1.13 1.13 0 0 1-.363.36a.673.673 0 0 1-.416.106m5.077-3.915h-2.43v4.8h1.028V7.357h1.3v-.892h-1.3V5.353h1.4v-.892"/></svg>PDF&nbsp;&nbsp;',
        filename: "Estados de cuenta",
      },
      {
        extend: "excel",
        text: '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 32 32"><defs><linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086" y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#18884f"/><stop offset=".5" stop-color="#117e43"/><stop offset="1" stop-color="#0b6631"/></linearGradient></defs><path fill="#185c37" d="M19.581 15.35L8.512 13.4v14.409A1.192 1.192 0 0 0 9.705 29h19.1A1.192 1.192 0 0 0 30 27.809V22.5Z"/><path fill="#21a366" d="M19.581 3H9.705a1.192 1.192 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z"/><path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z"/><path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2Z" opacity=".1"/><path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191Z" opacity=".2"/><path fill="url(#vscodeIconsFileTypeExcel0)" d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.192 1.192 0 0 1 2 21.959V10.041A1.192 1.192 0 0 1 3.194 8.85Z"/><path fill="#000" d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017c.082-.188.169-.369.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.355 2.355 0 0 1 9.2 16.8h-.024a1.688 1.688 0 0 1-.168.351l-1.493 2.722Z"/><path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.192 1.192 0 0 0 28.806 3Z"/><path fill="#107c41" d="M19.581 16H30v6.5H19.581Z"/></svg>Excel&nbsp;&nbsp;',
        filename: Elem,
        excelStyles: [
          // Add an excelStyles definition
          {
            template: "green_medium", // Apply the 'green_medium' template
          },
          {
            cells: "sh", // Use Smart References (s) to target the header row (h)
            style: {
              // The style definition
              font: {
                // Style the font
                size: 14, // Size 14
                b: false, // Turn off the default bolding of the header row
              },
              fill: {
                // Style the cell fill
                pattern: {
                  // Add a pattern (default is solid)
                  color: "1C3144", // Define the fill color
                },
              },
            },
          },
        ],
      },
    ],
  });
  return table;
};


