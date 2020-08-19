@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Usuarios
                    <div class="float-right"><button data-toggle="modal" data-target="#create_user_modal" class="btn btn-success">Nuevo Usuario</button></div>
                </div>

                <div class="card-body">
                    <table id="users_table" class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Admin</th>
                                <th>Sedes</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- set up the modal to start hidden and fade in and out -->
<div id="delete_user_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                Eliminar Usuario
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- dialog body -->
            <div class="modal-body">
                ¿ Estás seguro de boorar este usuario ?

                <form id="form_confirm_delete_user">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <input type="hidden" id="delete_user_id">
                            <input type="submit" id="confirm_delete_user_btn" class="btn btn-danger" value="Si">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div id="snackbar">Some text some message..</div>

<!-- set up the modal to start hidden and fade in and out -->
<div id="update_user_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                Editar Usuario
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- dialog body -->
            <div class="modal-body">
                <form class="form-horizontal" method="POST" id="form_update_user">
                    <input type="hidden" id="update_user_id">

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="admin" class="col-md-4 col-form-label text-md-right">Admin</label>

                        <div class="col-md-6">
                            <input id="admin" type="checkbox" name="admin">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sedes" class="col-md-4 col-form-label text-md-right">Sedes</label>

                        <div class="col-md-6">
                            <select class="form-control" multiple="multiple" name="sedes[]" id="sedes">
                                @foreach($sedes as $sede)
                                    <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button id="confirm_update_user_btn" type="submit" class="btn btn-primary">
                                Actualizar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="create_user_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                Nuevo Usuario
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- dialog body -->
            <div class="modal-body">
                <form class="form-horizontal" method="POST" id="form_create_user" action="{{ route('api.users.create') }}">
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="admin" class="col-md-4 col-form-label text-md-right">Admin</label>

                        <div class="col-md-6">
                            <input id="admin" type="checkbox" name="admin">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sedes" class="col-md-4 col-form-label text-md-right">Sedes</label>

                        <div class="col-md-6">
                            <select class="form-control" multiple="multiple" name="sedes[]" id="sedes">
                                @foreach($sedes as $sede)
                                    <option value="{{ $sede->id }}">{{ $sede->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button id="confirm_create_user_btn" type="submit" class="btn btn-success">
                                Crear
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- set up the modal to start hidden and fade in and out -->
<div id="view_user_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- dialog body -->
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-6" id="view_name"></div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-6" id="view_email"></div>
                </div>

                <div class="form-group row">
                    <label for="admin" class="col-md-4 col-form-label text-md-right">Admin</label>

                    <div class="col-md-6" id="view_admin"></div>
                </div>

                <div class="form-group row">
                    <label for="sedes" class="col-md-4 col-form-label text-md-right">Sedes</label>

                    <div id="view_sedes" class="col-md-6"></div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">

        $(function () {

            function showSnackbar(msg) {
              // Get the snackbar DIV
              var x = document.getElementById("snackbar");

              $("#snackbar").html(msg);

              // Add the "show" class to DIV
              x.className = "show";

              // After 3 seconds, remove the show class from DIV
              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }

            function showSnackBarFromErrors(data)
            {
                var errors = data.responseJSON;
                var msg = '';

                for (let field in errors.errors)
                {
                    msg += errors.errors[field] + '<br>';
                }

                showSnackbar(msg);
            }

            // Load table through ajax
            var table = $('#users_table').DataTable({

                processing: true,

                serverSide: true,

                ajax: "{{ route('api.users.index') }}?api_token={{ auth()->user()->api_token }}",

                columns: [

                    {data: 'id', name: 'id'},

                    {data: 'name', name: 'name'},

                    {data: 'email', name: 'email'},

                    {data: 'admin', name: 'admin'},

                    {data: 'sedes', name: 'sedes'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],

                createdRow: function( row, data, dataIndex ) {
                    $(row).attr('data-id', data.id);
                  },

            });

            $('#delete_user_modal').on('show.bs.modal', function (e)
            {
                // Populate url & id
               $("#form_confirm_delete_user").attr('action', $(e.relatedTarget).attr('data-url'));
               $("#delete_user_id").val($(e.relatedTarget).attr('data-id'));
            });

            $('#delete_user_modal').on('click', '#confirm_delete_user_btn', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $('#form_confirm_delete_user').attr('action'),
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        'api_token': '{{ auth()->user()->api_token }}'
                    },
                    headers: {
                        'accept': 'application/json',
                    }
                })
                .done(function() {

                    // Hide modal
                    $('#delete_user_modal').modal('hide');

                    table.draw();

                    // Show message
                    showSnackbar('Usuario #' + $('#delete_user_id').val() + ' borrado.');
                })
                .fail(function(data) {

                    showSnackBarFromErrors(data);
                    $('#delete_user_modal').modal('hide');
                });
            });

            $('#update_user_modal').on('show.bs.modal', function (e) {

                // Populate url & id
                $("#form_update_user").attr('action', $(e.relatedTarget).attr('data-url'));
                $("#update_user_id").val($(e.relatedTarget).attr('data-id'));

                // Fill modal
                $("#form_update_user #name").val($(e.relatedTarget).attr('data-name'));
                $("#form_update_user #email").val($(e.relatedTarget).attr('data-email'));
                $("#form_update_user #admin").prop("checked", $(e.relatedTarget).attr('data-admin'));
                $("#form_update_user #sedes").val( $(e.relatedTarget).attr('data-sedes').split(',') );
            });

            $('#update_user_modal').on('click', '#confirm_update_user_btn', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $('#form_update_user').attr('action'),
                    type: 'PUT',
                    dataType: 'json',
                    data: {
                        api_token: '{{ auth()->user()->api_token }}',
                        name: $('#update_user_modal #name').val(),
                        email: $('#update_user_modal #email').val(),
                        admin: $('#update_user_modal #admin').prop('checked') ? 1 : 0,
                        sedes: $('#update_user_modal #sedes').val(),
                    },
                })
                .done(function() {
                    table.draw();
                    $('#update_user_modal').modal('hide');

                    // Update name in nav bar
                    $("#navbarDropdown").html($('#update_user_modal #name').val());

                    // Show message
                    showSnackbar('Usuario #' + $('#update_user_id').val() + ' actualizado.');
                })
                .fail(function(data) {
                    showSnackBarFromErrors(data);
                });
            });

            $('#view_user_modal').on('show.bs.modal', function (e) {

                // Fill modal
                $("#view_name").html($(e.relatedTarget).attr('data-name'));
                $("#view_email").html($(e.relatedTarget).attr('data-email'));
                $("#view_admin").html($(e.relatedTarget).attr('data-admin') ? 'Si' : 'No');

                var sedes = '';
                var sedes_array = $(e.relatedTarget).attr('data-sedes').split(',');
                for ( let key in sedes_array )
                {
                    sedes += sedes_array[key] + '<br>';
                }
                $("#view_sedes").html(sedes);
            });

            $('#create_user_modal').on('click', '#confirm_create_user_btn', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $('#form_create_user').attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        api_token: '{{ auth()->user()->api_token }}',
                        name: $('#create_user_modal #name').val(),
                        email: $('#create_user_modal #email').val(),
                        admin: $('#create_user_modal #admin').prop('checked') ? 1 : 0,
                        sedes: $('#create_user_modal #sedes').val(),
                    },
                })
                .done(function() {
                    table.draw();
                    $('#create_user_modal').modal('hide');

                    // Show message
                    showSnackbar('Usuario creado.');
                })
                .fail(function(data) {
                    showSnackBarFromErrors(data);
                });
            });

            $('#view_user_modal').on('show.bs.modal', function (e) {

                // Fill modal
                $("#view_name").html($(e.relatedTarget).attr('data-name'));
                $("#view_email").html($(e.relatedTarget).attr('data-email'));
                $("#view_admin").html($(e.relatedTarget).attr('data-admin') ? 'Si' : 'No');

                var sedes = '';
                var sedes_array = $(e.relatedTarget).attr('data-sedes').split(',');
                for ( let key in sedes_array )
                {
                    sedes += sedes_array[key] + '<br>';
                }
                $("#view_sedes").html(sedes);
            });
        });

    </script>
@endsection