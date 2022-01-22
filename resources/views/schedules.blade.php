@extends("master.main")

@section("title","Empleados")

@section("content")

<h1>Registro de empleados</h1>
<a class="btn btn-success" id="createNewEmployeer"> Nuevo empleado</a>

<hr class="my-4">

<table id="employeers" class="display" style="width:100%">
    <thead>
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Fecha de Nacimiento</th>
            <th>Foto</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($employeers as $employeer)
        <tr>
            <td>{{$employeer->dni}}</td>
            <td>{{$employeer->name}}</td>
            <td>{{$employeer->lastname}}</td>
            <td>{{$employeer->email}}</td>
            <td>{{$employeer->birthdate}}</td>
            <td>
                <img src="{{$employeer->profile_photo_path}}" alt="{{$employeer->name}}" width="100px">
            </td>
            <td>{{$employeer->created_at}}</td>
            <td>
                <a href="{{route('employeers.edit',$employeer->id)}}" class="btn btn-warning">Editar</a>
                <a href="{{route('employeers.destroy',$employeer->id)}}" class="btn btn-danger">Eliminar</a>
            </td>
        </tr>
        @endforeach
    <tbody>
    </tbody>
</table>
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="employeerForm" name="employeerForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="employeer_id" id="employeer_id">
                    <div class="form-group">
                        <label for="dni" class="col-sm-2 control-label">DNI</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingresa DNI"
                                value="" maxlength="8" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa nombre"
                                value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Apellido</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                placeholder="Ingresa apellido" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Correo</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Ingresa correo"
                                value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthdate" class="col-sm-2 control-label">Fecha de nacimiento</label>
                        <div class="col-sm-12">
                            <div class="input-group date" id="datepicker">
                                <input type="text" class="form-control" id="birthdate" name="birthdate" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="profile_photo_path" class="form-label">Foto del empleado</label>
                        <input class="form-control" type="file" id="profile_photo_path" name="profile_photo_path"
                            accept="image/png, image/jpg, image/jpeg">
                    </div>

                    <hr class="my-2">

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section("js")
<script>
    $(document).ready(function() {
        $('#employeers').DataTable();
        $('#datepicker').datepicker();
    });

    $('#createNewEmployeer').click(function () {
        $('#saveBtn').val("create-employeer");
        $('#employeer_id').val('');
        $('#employeerForm').trigger("reset");
        $('#modelHeading').html("Registrar nuevo empleado");
        $('#ajaxModel').modal('show');
    });

    $('body').on('submit', '#employeerForm', function (e) {
        e.preventDefault();
        $('#saveBtn').html('Sending..');
        var formData = new FormData(this);

        $.ajax({
          data: formData,
          url: "{{ route('employeers.store') }}",
          type: "POST",
cache:false,
contentType: false,
processData: false,
          success: function (data) {

              $('#employeerForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();

          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
</script>
@endsection
