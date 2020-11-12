<template>

    <div>
        <button data-toggle="modal" data-target="#create_auditoria_modal" class="btn btn-success">Nueva Auditoria</button>
    
        <div id="create_auditoria_modal" class="modal fade text-xs-left text-sm-right text-md-right text-lg-right">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        Nueva Auditoria
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- dialog body -->
                    <div class="modal-body">
                        <form class="form-horizontal" id="form_nueva_auditoria" @submit.prevent="crearAuditoria()">

                            <div class="form-group row">
                                <div class="col-2">
                                    <label for="sede" class="col-form-label" >Sede</label>
                                </div>

                                <div class="col-9">
                                    <select class="form-control" v-bind:class="{ 'is-valid': sede, 'is-invalid': !sede }" v-model="sede" id="sede">
                                        <option selected value="null" disabled>Seleccionar Sede</option>
                                        <option v-for="sede in sedes" :value="sede.id">{{ sede.nombre }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-2">
                                    <label for="fecha" class="col-form-label">Fecha</label>
                                </div>

                                <div class="col-9">
                                    <input type="date" class="form-control" v-bind:class="{ 'is-valid': fecha, 'is-invalid': !fecha }" v-model="fecha">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-2">
                                    <label for="turno" class="col-form-label">Turno</label>
                                </div>

                                <div class="col-9">
                                    <select class="form-control" v-bind:class="{ 'is-valid': turno, 'is-invalid': !turno }" v-model="turno" id="turno">
                                        <option selected value="null" disabled>Seleccionar Turno</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-2">
                                    <label for="sector" class="col-form-label" >Sector</label>
                                </div>

                                <div class="col-9">
                                    <select class="form-control" v-bind:class="{ 'is-valid': sector, 'is-invalid': !sector }" v-model="sector" id="sector">
                                        <option selected value="null" disabled>Seleccionar Sector</option>
                                        <option v-for="sector in sectores" :value="sector.id">{{ sector.nombre }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-2">
                                    <label for="comentario" class="col-form-label">Comentario</label>
                                </div>

                                <div class="col-9">
                                    <textarea class="form-control" v-bind:class="{ 'is-valid': comentario, 'is-invalid': !comentario }" v-model="comentario" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col text-center">
                                    <input type="submit" name="Crear" value="Crear" class="btn btn-success" v-bind:class="{ disabled: !validateNuevaAuditoriaForm }">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'NuevaAuditoria',
        props: ['rutaCrear', 'sedes', 'sectores'],
        data: () => ({
            sede: null,
            fecha: null,
            turno: null,
            sector: null,
            comentario: null,
        }),
        methods: {
            crearAuditoria: function() {

                if ( this.validateNuevaAuditoriaForm ) {

                    var data = {
                        api_token: window.Laravel.api_token,
                        sede: this.sede,
                        fecha: this.fecha,
                        turno: this.turno,
                        sector: this.sector,
                        comentario: this.comentario,
                    }

                    this.resetForm()
                    this.closeModal()

                    showSnackbar('Guardando auditoria ...')

                    axios.post(this.rutaCrear, data)
                        .then(res => {

                            this.reloadTable()

                            showSnackbar('Auditoria registrada...')
                        }).catch(err => {
                            showSnackBarFromAxiosErrors(err)
                    })
                }
            },

            resetForm: function() {

                this.sede = null
                this.fecha = null
                this.turno = null
                this.sector = null
                this.comentario = null
            },

            closeModal: function() {

                window.$('#create_auditoria_modal').modal('hide')
            },

            reloadTable: function() {

                window.$('#auditorias_table').DataTable().ajax.reload()
            },
        },

        computed: {

            validateNuevaAuditoriaForm: function() {
                return this.sede && this.fecha && this.turno && this.sector && this.comentario && 1
            },
        },
    }
</script>
