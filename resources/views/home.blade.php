@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Auditorias
                    <div class="float-right">
                        <nueva-auditoria-item :ruta-crear="{{ json_encode(route('api.auditorias.create')) }}" :sedes="{{ json_encode($sedes) }}" :sectores="{{ json_encode($sectores) }}"></nueva-venta-item>
                    </div>
                </div>

                <div class="card-body">
                    <table id="auditorias_table" class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Local</th>
                                <th>Turno</th>
                                <th>Sector</th>
                                <th>Responsable</th>
                                <th>Comentario</th>
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
@endsection

@section('scripts')

    <script type="text/javascript">

        $(function () {

            // Load table through ajax
            var table = $('#auditorias_table').DataTable({

                dom: 'Bfrtip',

                buttons: [
                    'copy',
                    {
                        extend: 'excel',
                        pageSize: 'LEGAL',
                        title: "{{ date('Y-m-d') }}" + ' - Auditorías',
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        title: "{{ date('Y-m-d') }}" + ' - Auditorías',
                    }
                ],

                processing: true,

                serverSide: false,

                ajax: "{{ route('api.auditorias.index') }}?api_token={{ auth()->user()->api_token }}",

                columns: [

                    {data: 'fecha', name: 'fecha', render: $.fn.dataTable.render.moment( 'DD/MM/YYYY' ) },

                    {data: 'local', name: 'local'},

                    {data: 'turno', name: 'turno'},

                    {data: 'sector', name: 'sector'},

                    {data: 'responsable', name: 'responsable'},

                    {data: 'comentario', name: 'comentario'},
                ],

                language: {

                    url: "{{ asset('js/datatables.spanish.json') }}",

                    buttons: {
                        copyTitle: 'Copiado al portapapeles!',
                        copySuccess: {
                            _: '%d líneas copiadas',
                            1: '1 linea copiada'
                        }
                    }
                },

                responsive: true,

                search: {

                     regex: false,
                     smart: false
                },

                order: [[ 0, "desc" ]],

                createdRow: function( row, data, dataIndex ) {
                    $(row).attr('data-id', data.id);
                  },
            });
        });

    </script>
@endsection