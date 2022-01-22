<!DOCTYPE html>
<html>
<head>
    <title>Laravel 7 Ajax CRUD - Employee Registration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <!--<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">-->
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"></script>


    {{--<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">--}}
</head>
<body>

<div class="container">
    <h1>Registro de Empleados</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Registrar Empleado</a>
    <table class="table table-bordered data-table" id="example">
        <br><br>
        <label ><b>Buscar por Cargo</b>
        <input type="text" id="myInputTextField" class="form-control">

        <label ><b>Buscar por Área</b>
        <input type="text" id="myInputTextField2" class="form-control">
        </label>
        <br><br>
        <label><b>Rangos</b>
            <input type="date" id="myInputDate1" class="form-control">

          </label>
       <!-- <label><b>Rango Inicial</b>
          <input type="date" id="myInputDate1" class="form-control">

        </label>
        <label><b>Rango Final</b>
           <input type="date" id="myInputDate2" class="form-control">

        </label> -->
        <!--<label><b>Rango </b>
            <input type="text" id="Date_search" class="form-control">

         </label> -->

        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>DNI</th>
                <th>Correo Electrónico</th>
                <th>Fecha de Nacimiento</th>
                <th>Cargo</th>
                <th>Área</th>
                <th>Foto</th>
                <th>Fecha de Inicio (Contrato)</th>
                <th>Fecha de Fin (Contrato)</th>
                <th>Tipo de Contrato</th>

                <th width="280px">Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                   <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-12 control-label">Nombre (mínimo 4 dígitos)</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa Nombre" value="" maxlength="50" required="" id="nombre" onkeyup="guardar()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 control-label">Apellidos (mínimo 2 dígitos)</label>
                        <div class="col-sm-12">
                            <input id="apellidos" name="apellidos" required="" placeholder="Ingresa Apellidos" class="form-control" onkeyup="guardar()">
                        </div>
                    </div>

                    <div class="form-group" id="label_dni">
                        <label class="col-sm-12 control-label">DNI (8 dígitos)</label>
                        <div class="col-sm-12">
                            <input type="number" id="dni" name="dni" required="" placeholder="Ingresa tu DNI" class="form-control" onkeyup="guardar()"oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 control-label">Correo Electrónico</label>
                        <div class="col-sm-12">
                            <input type="email" id="email" name="email" required="" placeholder="Ingresa tu Correo Electrónico" class="form-control" {{--onkeyup="guardar()" onkeydown="validation()"--}} onkeyup="guardar();validation();" >
                            <span id="warning"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 control-label">Fecha de Nacimiento (requerido)</label>
                        <div class="col-sm-12">
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required="" placeholder="Ingresa tu Correo Electrónico" class="form-control" onChange="guardar()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 control-label">Cargo (mínimo 4 dígitos)</label>
                        <div class="col-sm-12">
                            <input id="cargo" name="cargo" required="" placeholder="Ingresa tu Cargo" class="form-control" onkeyup="guardar()">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 control-label">Área (mínimo 3 dígitos)</label>
                        <div class="col-sm-12">
                            <input id="area" name="area" required="" placeholder="Ingresa tu Área" class="form-control" onkeyup="guardar()">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-12 control-label">Fecha Inicio de Contrato (requerido)</label>
                        <div class="col-sm-12">
                            <input type="date" id="fecha_inicio" name="fecha_inicio" required="" placeholder="Ingresa tu Correo Electrónico" class="form-control" onChange="guardar()">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-12 control-label">Fecha Fin de Contrato (requerido)</label>
                        <div class="col-sm-12">
                            <input type="date" id="fecha_fin" name="fecha_fin" required="" placeholder="Ingresa tu Correo Electrónico" class="form-control" onChange="guardar()">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-12 control-label">Tipo de Contacto (mínimo 3 dígitos)</label>
                        <div class="col-sm-12">
                            <input id="tipo_contacto" name="tipo_contacto" required="" placeholder="Ingresa tu Tipo de Contacto" class="form-control" onkeyup="guardar()">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="profile_photo_path" class="form-label">Foto del empleado</label>
                        <input class="form-control" type="file" id="profile_photo_path" name="profile_photo_path"
                            accept="image/png, image/jpg, image/jpeg">
                    </div>

                    <hr class="my-2">


                    <div class="col-sm-offset-12 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create" disabled>Guardar Cambios
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

<script type="text/javascript">
/*minDateFilter = "";
maxDateFilter = "";
$.fn.dataTableExt.afnFiltering.push(
  function(oSettings, aData, iDataIndex) {
    if (typeof aData._date == 'undefined') {
      aData._date = new Date(aData[8]).getTime();
    }
    if (minDateFilter && !isNaN(minDateFilter)) {
      if (aData._date < minDateFilter) {
        return false;
      }
    }
    if (maxDateFilter && !isNaN(maxDateFilter)) {
      if (aData._date > maxDateFilter) {
        return false;
      }
    }
    return true;
  }
);
var table = $('#example').DataTable();
$("#Date_search").daterangepicker({
  "locale": {
    "format": "YYYY-MM-DD",
    "separator": " a ",
    "applyLabel": "Aplicar",
    "cancelLabel": "Cancelar",
    "fromLabel": "From",
    "toLabel": "To",
    "customRangeLabel": "Custom",
    "weekLabel": "W",
    "daysOfWeek": [
      "Dom",
      "Lun",
      "Mar",
      "Mie",
      "Jue",
      "Vie",
      "Sab"
    ],
    "monthNames": [
      "Enero",
      "Febrero",
      "Marzo",
      "Abril",
      "Mayo",
      "Junio",
      "Julio",
      "Agosto",
      "Setiembre",
      "Octubre",
      "Noviembre",
      "Diciembre"
    ],
    "firstDay": 1
  },
  "opens": "center",
}, function(start, end, label) {
  maxDateFilter = end;
  minDateFilter = start;
  table.draw();
});*/
function guardar(){
var form = document.getElementById('productForm');
var text = document.getElementById('warning');
var email = document.getElementById('email').value;
var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
//if(document.getElementById("nombre").value.length>=4 && document.getElementById("apellidos").value.length>=2 && document.getElementById("dni").value.length>=8 && document.getElementById("dni").value.length<=8 && document.getElementById("email").value.length>=2 && document.getElementById("fecha_nacimiento").value.length>=1 && document.getElementById("cargo").value.length>=4 && document.getElementById("area").value.length>=3 && document.getElementById("fecha_inicio").value.length>=1 && document.getElementById("fecha_fin").value.length>=1 && document.getElementById("tipo_contacto").value.length>=3) {
    if(document.getElementById("nombre").value.length>=4 && document.getElementById("apellidos").value.length>=2 && document.getElementById("dni").value.length>=8 && document.getElementById("dni").value.length<=8 && email.match(pattern) && document.getElementById("fecha_nacimiento").value.length>=1 && document.getElementById("cargo").value.length>=4 && document.getElementById("area").value.length>=3 && document.getElementById("fecha_inicio").value.length>=1 && document.getElementById("fecha_fin").value.length>=1 && document.getElementById("tipo_contacto").value.length>=3) {
    document.getElementById('saveBtn').disabled = false;
}
else {
  document.getElementById('saveBtn').disabled = true;
}
}
  $(function () {

    $("#Date_search").val("");
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    //$("#myInputDate1").datepicker();
    //$("#myInputDate1").datepicker("option", "dateFormat", 'yy-mm-dd');
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        "oLanguage": {
        "sSearch": "Búsqueda General",
        "sLengthMenu": "Mostrar _MENU_ registros por página",
        "sInfo": "Mostrando página _PAGE_ de _PAGES_ en total"
        },
        ajax: "{{ route('ajaxemployees.index') }}",

        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nombre', name: 'nombre'},
            {data: 'apellidos', name: 'apellidos'},
            {data: 'dni', name: 'dni'},
            {data: 'email', name: 'email'},
            {data: 'fecha_nacimiento', name: 'fecha_nacimiento'},
            {data: 'cargo', name: 'cargo'},
            {data: 'area', name: 'area'},
            {data: 'profile_photo_path', name: 'profile_photo_path'},
            {data: 'fecha_inicio', name: 'fecha_inicio'},
            {data: 'fecha_fin', name: 'fecha_fin'},
            {data: 'tipo_contacto', name: 'tipo_contacto'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
        $('#myInputTextField').on('keyup change', function () {
        table.column(6).search($(this).val()).draw();
        });
        $('#myInputTextField2').on('keyup change', function () {
        table.column(7).search($(this).val()).draw();
        });
        $('#myInputDate1').on('keyup change', function () {
        table.column(8).search($(this).val()).draw();
        });
        //table.column(8).search($(this).val()).draw();
        /*$('#myInputDate1, #myInputDate2').on('change', function () {
        table.column(8).search($(this).val()).draw();
        });*/
        //https://stackoverflow.com/questions/54691908/datatablesdatepicker-filter-table-by-date-range
    $('#createNewProduct').click(function () {
        //alert('Create new product')
        //Swal.fire('Any fool can use a computer');
        var form = document.getElementById('productForm');
        var text = document.getElementById('warning');
        var email = document.getElementById('email').value;
        var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        form.classList.remove('valid');
        form.classList.add('invalid');
        text.innerHTML = "Por favor, ingresa el formato válido para correo";
        text.style.color = "#ff0000";
        $( "#saveBtn" ).prop( "disabled", true );
        $('#dni').show();
          $('#label_dni').show();
        $('#saveBtn').val("create-product");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });

    $('body').on('click', '.editProduct', function () {
        $( "#saveBtn" ).prop( "disabled", false );
        var form = document.getElementById('productForm');
        var text = document.getElementById('warning');
        var email = document.getElementById('email').value;
        var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        form.classList.add('valid');
        form.classList.remove('invalid');
        text.innerHTML = "Tu Correo Electrónico es válido";
        text.style.color = "#00ff00";
      var product_id = $(this).data('id');
      $.get("{{ route('ajaxemployees.index') }}" +'/' + product_id +'/edit', function (data) {
          $('#modelHeading').html("Editar Empleado");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#product_id').val(data.id);
          $('#nombre').val(data.nombre);
          $('#apellidos').val(data.apellidos);
          $('#dni').val(data.dni);
          $('#dni').hide();
          $('#label_dni').hide();
          $('#email').val(data.email);
          $('#fecha_nacimiento').val(data.fecha_nacimiento);
          $('#cargo').val(data.cargo);
          $('#area').val(data.area);
          $('#fecha_inicio').val(data.fecha_inicio);
          $('#fecha_fin').val(data.fecha_fin);
          $('#tipo_contacto').val(data.tipo_contacto);
      })
   });

    $('body').on('submit', '#productForm', function (e) {
        e.preventDefault();
        $('#saveBtn').html('Sending..');
        var formData = new FormData(this);
        $.ajax({
          data: formData,
          url: "{{ route('ajaxemployees.store') }}",
          type: "POST",
cache:false,
contentType: false,
processData: false,
          success: function (data) {

              $('#productForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Empleado actualizado satisfactoriamente',
                showConfirmButton: false,
                timer: 1500
                })
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Guardar Cambios');
              Swal.fire('Disculpa, el DNI introducido ya existe');
          }
      });
    });

    $('body').on('click', '.deleteProduct', function () {

        /*var product_id = $(this).data("id");

        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxemployees.store') }}"+'/'+product_id,
            success: function (data) {
                table.draw();
                Swal.fire({
                icon: 'error',
                title: 'Eliminado...',
                })
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });*/
        Swal.fire({
        title: '¿Deseas Eliminar a este empleado?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Sí',

        }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            Swal.fire('Eliminado!', '', 'success')
            var product_id = $(this).data("id");

        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxemployees.store') }}"+'/'+product_id,
            success: function (data) {
                table.draw();
                Swal.fire({
                icon: 'error',
                title: 'Eliminado...',
                })
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
        } else if (result.isDenied) {
            Swal.fire('Confirmado, no se eliminó', '', 'info')
        }
        })
    });
    $('body').on('click', '.inactiveProduct', function () {

     var product_id = $(this).data("id");

     $.ajax({
         type: "PUT",
         url: "{{ route('ajaxemployees.store') }}"+'/'+product_id,
         success: function (data) {
            $.get("{{ route('ajaxemployees.index') }}" +'/' + product_id +'/edit', function (data) {
            if(data.estado == "1") {
                Swal.fire({
            icon: 'success',
            title: 'Empleado Activado',
            showConfirmButton: false,
            timer: 1500
            })
            }else {
                Swal.fire({
            icon: 'error',
            title: 'Empleado Desactivado',
            showConfirmButton: false,
            timer: 1500
            })
            }
      })
             table.draw();
            /* */
         },
         error: function (data) {
             console.log('Error:', data);
         }
     });
 });

});
var start = document.getElementById('fecha_inicio');
var end = document.getElementById('fecha_fin');
start.addEventListener('change', function() {
    if (start.value)
        end.min = start.value;
}, false);
end.addEventLiseter('change', function() {
    if (end.value)
        start.max = end.value;
}, false);
function validation() {
var form = document.getElementById('productForm');
var text = document.getElementById('warning');
var email = document.getElementById('email').value;
var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
if(email.match(pattern)){
    //form.
    form.classList.add('valid');
    form.classList.remove('invalid');
    text.innerHTML = "Tu Correo Electrónico es válido";
    text.style.color = "#00ff00";
}else{
    form.classList.remove('valid');
    form.classList.add('invalid');
    text.innerHTML = "Por favor, ingresa el formato válido para correo";
    text.style.color = "#ff0000";
}
}
/*var minDate, maxDate;

$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[8] );

        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);
$(document).ready(function() {
    // Create date inputs
    minDate = new DateTime($('#myInputDate1'), {
        format: 'MMMM Do YYYY'
    });
    maxDate = new DateTime($('#myInputDate12'), {
        format: 'MMMM Do YYYY'
    });

    // DataTables initialisation
    var table = $('#example').DataTable();

    // Refilter the table
    $('#myInputDate1, #myInputDate2').on('change', function () {
        table.draw();
    });
});*/
</script>

<style>
    .container {
        max-width: 1540px;
        margin-top: 30px;
    }
</style>

</html>
