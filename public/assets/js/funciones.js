function DatatableFilters(Elem) {
  $("#" + Elem + " tfoot tr th").each(function () {
    var title = $(this).text();
    $(this).html('<input type="text" placeholder="Filtrar.." />');
    $("#" + Elem).addClass("table table-striped table-bordered table-hover");
  });

  var table = $("#" + Elem).DataTable({
    pageLength: 100,
    dom: 'B<"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
    responsive: false,
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json",
    },
    order: [[0, "asc"]],
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
    buttons: ["excel", "pdf"],
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
    timer: 1500,
    width: 250,
    timerProgressBar: false,
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

/*  
LLAMAR LA FUNCION

const  misDatos = "b=" + consulta + "&soc=" + soc;
enviarDatosPorAjax(misDatos, "calidad_detalle.php", function(respuesta) {
                  const resultado = document.getElementById("resultado_Ver_comentarios1");
                  resultado.innerHTML = respuesta;
                }); */
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
