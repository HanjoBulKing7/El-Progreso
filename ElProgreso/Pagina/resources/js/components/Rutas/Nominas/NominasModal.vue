<template>
    <modal name="nomina-modal" class="pt-5 pb-5" height="auto" :scrollable="true" :clickToClose="false"
           @before-open="beforeOpen" width="800">
        <div class="modal-header bg-success">
            <h5 class="modal-title" id="exampleModalLabel" style="color: #FFFFFF;">
                Nóminas
            </h5>
            <button type="button" class="close" @click="$modal.hide('nomina-modal')">
                <span aria-hidden="true" class="text-white">&times;</span>
            </button>
        </div>
        <div class="modal-content">
            <alv-form :action="form.action" id="nomina-create" :method="form.method" :spinner="true"
                      :data-object="nomina" @after-done="afterDone" @after-error="afterError" ref="form">
                <form-wizard :color="'#007B5E'" :title="'Crear Nómina'" ref="wizard"
                             :subtitle="'Por favor completa los pasos para crear la nómina de esta ruta'">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="edit">
                        <strong><i class="fa fa-warning"></i> ATENCIÓN: </strong> Estás editando una nómina,
                        probablemente no quieras estar haciendo esto
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <tab-content title="Metas de mes">
                        <div class="row g-4 align-center">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Semana</label>
                                    <div class="form-control-wrap">
                                        <flat-pickr
                                            ref="mes"
                                            id="mes" name="mes"
                                            v-model="mes"
                                            :config="configDate">
                                        </flat-pickr>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Ventas obtenidas en {{
                                            this.mes
                                        }}</label>
                                    <div class="form-control-wrap">
                                        <input type="text" disabled class="form-control"
                                               id="venta_semanal" name="venta_semanal"
                                               v-model="venta_semanal"
                                        >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="meta_minima">Meta minima</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.meta_minima"
                                                        name="meta_minima" id="meta_minima"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options" disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="meta_maxima">Meta máxima</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.meta_maxima"
                                                        name="meta_maxima" id="meta_maxima"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options" disabled
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 align-center" v-if="modalShow">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="formatted_created_at">Fecha de Creación:</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-calender-date"></em>
                                        </div>
                                        <input type="text" class="form-control" id="formatted_created_at"
                                               name="formatted_created_at" v-model="nomina.formatted_created_at"
                                               disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4 align-center" v-if="modalShow">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label" for="formatted_updated_at">Ultima de
                                        actualización:</label>
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-calender-date"></em>
                                        </div>
                                        <input type="text" class="form-control" id="formatted_updated_at"
                                               name="formatted_updated_at" v-model="nomina.formatted_updated_at"
                                               disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tab-content>
                    <tab-content title="Pago de percepciones">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Sueldo base</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.activos.sueldo_base"
                                                        name="sueldo_base" id="sueldo_base"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                                        disabled :value="nomina.activos.sueldo_base"
                                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Ayuda de transporte</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.activos.ayuda_transporte"
                                                        name="ayuda_transporte" id="ayuda_transporte"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Ayuda de despensa</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.activos.ayuda_despensa"
                                                        name="ayuda_despensa" id="ayuda_despensa"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Comisión</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.activos.comision"
                                                        name="comision" id="comision"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        disabled
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Bono de servicio al cliente</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.activos.bono_servicio_cliente"
                                                        name="bono_servicio_cliente" id="bono_servicio_cliente"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Bono personal</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.activos.bono_personal"
                                                        name="bono_personal" id="bono_personal"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Bono devolución</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.activos.bono_devolucion"
                                                        name="bono_devolucion" id="bono_devolucion"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="tiene_bono_mensual">¿Bono mensual?</label>
                                <toggle-button id="tiene_bono_mensual" name="tiene_bono_mensual"
                                               v-model="tiene_bono_mensual"></toggle-button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label" for="comienza_en">Cuota mensual</label></div>
                                    </div>

                                    <div class="form-control-wrap">
                                        <currency-input v-model="cuota_mensual"
                                                        name="cuota_mensual" id="cuota_mensual"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        disabled
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label" for="comienza_en">Venta mensual</label></div>
                                    </div>

                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.venta_mensual"
                                                        name="venta_mensual" id="venta_mensual"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :disabled="true"
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label class="form-label" for="comienza_en">Bono mensual</label></div>
                                    </div>

                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.activos.bono_mensual"
                                                        name="bono_mensual" id="bono_mensual"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                                        :disabled="!tiene_bono_mensual"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tab-content>
                    <tab-content title="Deducciones">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Infonavit</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.pasivos.infonavit"
                                                        name="infonavit" id="infonavit"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Prestamo</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.pasivos.prestamo"
                                                        name="prestamo" id="prestamo"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Faltante</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.pasivos.faltante"
                                                        name="faltante" id="faltante"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Devolución</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.pasivos.devolucion"
                                                        disabled
                                                        name="devolucion" id="devolucion"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label" for="comienza_en">Descuento por falta</label>
                                    <div class="form-control-wrap">
                                        <currency-input v-model="nomina.pasivos.descuento_por_falta"
                                                        name="descuento_por_falta" id="descuento_por_falta"
                                                        classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                        :options="options"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <h2>Otros descuentos</h2>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5">
                                        <label class="form-label" for="comienza_en">Cantidad</label>
                                        <div class="form-control-wrap">
                                            <currency-input v-model="actual_otro_descuento.cantidad"
                                                            name="cantidad" id="cantidad"
                                                            classes="form-control w-full border border-gray-200 rounded py-1 px-1 mb-3"
                                                            :options="options"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label" for="comienza_en">Descripción</label>
                                        <input name="descripcion" id="descripcion" class="form-control" type="text"
                                               v-model="actual_otro_descuento.descripcion">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label" for="comienza_en"> </label>
                                        <button class="btn btn-primary" @click="agregarOtroDescuento" type="button">
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Descripción</th>
                                    </tr>
                                    </thead>
                                    <tbody v-for="(otro_descuento, index) in descuento_extra">
                                    <tr>
                                        <th scope="row">{{ index + 1 }}</th>
                                        <td>{{ otro_descuento.cantidad }}</td>
                                        <td>{{ otro_descuento.descripcion }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </tab-content>
                    <tab-content title="Ticket">
                        <div class="row mx-5">
                            <div class="col-6">
                                <h3>Percepciónes</h3>
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Concepto</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> Sueldo base:</td>
                                        <td>{{ $moneyFormat(nomina.activos.sueldo_base) }}</td>
                                    </tr>
                                    <tr>
                                        <td> Ayuda de transporte:</td>
                                        <td>{{ $moneyFormat(nomina.activos.ayuda_transporte) }}</td>
                                    </tr>
                                    <tr>
                                        <td> Ayuda de despensa:</td>
                                        <td>{{ $moneyFormat(nomina.activos.ayuda_despensa) }}</td>
                                    </tr>
                                    <tr>
                                        <td> Comisión:</td>
                                        <td>{{ $moneyFormat(nomina.activos.comision) }}</td>
                                    </tr>
                                    <tr>
                                        <td> Bono de servicio al cliente:</td>
                                        <td>{{ $moneyFormat(nomina.activos.bono_servicio_cliente) }}</td>
                                    </tr>
                                    <tr>
                                        <td> Bono personal:</td>
                                        <td>{{ $moneyFormat(nomina.activos.bono_personal) }}</td>
                                    </tr>
                                    <tr>
                                        <td> Bono devolución:</td>
                                        <td>{{ $moneyFormat(nomina.activos.bono_devolucion) }}</td>
                                    </tr>
                                    <tr>
                                        <td> Bono mensual:</td>
                                        <td>{{ this.tiene_bono_mensual ? $moneyFormat(nomina.activos.bono_mensual) : $moneyFormat(0) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <h3>Deducciónes</h3>
                                <table class="table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Concepto</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td> infonavit</td>
                                        <td>{{ $moneyFormat(nomina.pasivos.infonavit) }}</td>
                                    </tr>
                                    <tr>
                                        <td> prestamo</td>
                                        <td>{{ $moneyFormat(nomina.pasivos.prestamo) }}</td>
                                    </tr>
                                    <tr>
                                        <td> faltante</td>
                                        <td>{{ $moneyFormat(nomina.pasivos.faltante) }}</td>
                                    </tr>
                                    <tr>
                                        <td> devolucion</td>
                                        <td>{{ $moneyFormat(nomina.pasivos.devolucion) }}</td>
                                    </tr>
                                    <tr>
                                        <td> descuento_por_falta</td>
                                        <td>{{ $moneyFormat(nomina.pasivos.descuento_por_falta) }}</td>
                                    </tr>
                                    <tr>
                                        <td> descuento_extra</td>
                                        <td>{{ $moneyFormat(nomina.pasivos.descuento_extra_total) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row mx-5">
                            <div class="col-6">
                                <h4 style="color: lawngreen">Total: {{ $moneyFormat(nomina.total_activos) }}</h4>
                            </div>
                            <div class="col-6">
                                <h4 style="color: red">Total: {{ $moneyFormat(nomina.total_pasivos) }}</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row mx-5">
                            <div class="col-6">
                            </div>
                            <div class="col-6">
                                <h3>Total: {{ $moneyFormat(nomina.total) }}</h3>
                            </div>
                        </div>
                    </tab-content>
                    <template slot="footer" slot-scope="props">
                        <div class="wizard-footer-left">
                            <button v-if="props.activeTabIndex > 0 && !props.isLastStep"
                                    @click="props.prevTab()" class="wizard-btn"
                                    :style="props.fillButtonStyle"> Anterior
                            </button>
                        </div>
                        <div class="wizard-footer-right">
                            <button v-if="!props.isLastStep" type="button" @click="enviarInformacion()"
                                    class="wizard-btn"
                                    :style="props.fillButtonStyle">Siguiente
                            </button>

                            <button v-else @click="finalizarWizard()" class="wizard-btn" type="button"
                                    :style="props.fillButtonStyle"> {{ props.isLastStep ? 'Listo!' : 'Siguiente' }}
                            </button>
                        </div>
                    </template>
                </form-wizard>
            </alv-form>
        </div>
        <div class="modal-footer"></div>
    </modal>
</template>

<script>
import {Spanish} from "flatpickr/dist/l10n/es";
import {FormWizard, TabContent} from 'vue-form-wizard';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';
import CurrencyInput from "../../Templates/CurrencyInput/CurrencyInput";

const default_fields = {
    mes_nomina_id: "",
    ruta_id: "",
    venta_semanal: 0,
    venta_mensual: 0,
    total_activos: 0,
    total_pasivos: 0,
    cuota_mensual: 0,
    total: 0,
    activos: {
        sueldo_base: 0,
        ayuda_transporte: 0,
        ayuda_despensa: 0,
        comision: 0,
        bono_servicio_cliente: 0,
        bono_personal: 0,
        bono_devolucion: 0,
        bono_mensual: 0,
        tiene_bono_mensual: false,
    },
    pasivos: {
        infonavit: 0,
        prestamo: 0,
        faltante: 0,
        devolucion: 0,
        descuento_por_falta: 0,
        descuento_extra_total: 0,
        descuento_extra: []
    },
    formatted_created_at: 0,
    formatted_updated_at: 0,
};

export default {
    name: "NominaModal",
    components: {
        CurrencyInput,
        FormWizard,
        TabContent,

    },
    data() {
        return {
            tiene_bono_mensual: false,
            edit: false,
            cuota_mensual: 0,
            venta_semanal: 0,
            descuento_extra: [],
            actual_otro_descuento: {
                cantidad: 0,
                descripcion: ""
            },
            mes: "",
            usuario: {},
            enable_next_tab: false,
            configDate: {
                defaultDate: "",
                mode: "range",
                dateFormat: "Y-m-d",
                altFormat: "M j, Y",
                wrap: true,
                altInput: true,
                locale: Spanish,
                enable: [
                    {
                        from: "",
                        to: ""
                    }
                ],
            },
            form: {
                action: null,
                method: null
            },
            nomina: Object.assign({}, default_fields),
            modalShow: false,
        }
    },
    methods: {

        obtenerUsuarioAutenticado() {
            axios.get(this.$route('users.auth')).then(response => {
                this.usuario = response.data;
            })
        },

        obtenerUsuarioRuta() {
            axios.get(this.$route('rutas.usuario', this.ruta_id)).then(response => {
                this.nomina.activos.sueldo_base = response.data.salario;
                this.nomina.pasivos.infonavit = response.data.infonavit;
            })
        },

        enviarInformacion() {
            this.form.action = this.determinarRutaALlamar();
            this.$refs.form.sendFormData();
        },
        /*
        *   Determino el paso actual del wizard
         */
        determinarRutaALlamar() {
            switch (this.$refs.wizard.activeTabIndex) {
                case 0:
                    return this.$route('nominas.validar-primer-paso');
                case 1:
                    return this.$route('nominas.validar-segundo-paso');
                case 2:
                    return this.$route('nominas.validar-tercer-paso');
                case 3:
                    this.calcularDeducciones();
                    this.calcularPercepciones();
                    this.calcularTotal();
                    return this.$route('rutas.nominas.store', this.usuario.id);
            }

        },
        finalizarWizard() {
            axios.post(this.form.action, this.nomina).then(response => {
              this.$modal.hide('nomina-modal');
              this.$emit("created");
              this.$refs.form.unsetButtonLoading();
            })

        },
        afterError(error) {
            console.log(this.enable_next_tab);
        },
        async afterDone() {
            this.$refs.wizard.nextTab();
            this.$refs.form.unsetButtonLoading();
            this.form.action = this.determinarRutaALlamar();
        },
        obtenerMetaMes(mes_nomina_id) {
            axios.get(this.$route('mes-nomina.metas', mes_nomina_id)).then(response => {
                this.nomina.meta_minima = response.data.meta_minima;
                this.nomina.meta_maxima = response.data.meta_maxima;
                this.cuota_mensual = response.data.meta_maxima * 4;
            });
        },
        beforeOpen(event) {
            this.edit = event.params.edit;
            this.nomina.mes_nomina_id = event.params.mes_nomina_id;
            this.configDate.enable[0].from = this.$moment(event.params.mes).startOf('month').format('YYYY-MM-DD');
            this.configDate.enable[0].to= this.$moment(event.params.mes).endOf('month').format('YYYY-MM-DD');
            this.mes = this.$moment(event.params.mes).format('YYYY-MM-DD');
            this.obtenerMetaMes(this.nomina.mes_nomina_id);
            this.obtenerUsuarioAutenticado();
            this.obtenerUsuarioRuta();
            this.calcularComision();
            if (typeof event.params.id != "undefined") {
                if (typeof event.params.show != "undefined") {
                    this.modalShow = true;
                }
                this.form.action = this.$route("rutas.nominas.update", event.params);
                this.form.method = "put";
                axios.get(this.$route("rutas.nominas.show", event.params)).then(response => {
                    this.nomina = response.data;
                    this.mes = response.data.mes;

                    var wizard = this.$refs.wizard;
                    wizard.maxStep = wizard.tabs.length - 1;
                    wizard.tabs.forEach((tab) => {
                        tab.checked = true
                    });

                    this.$nextTick(function () {
                        if (typeof event.params.show != "undefined") {
                            this.$refs.form.$refs.form.querySelectorAll("[name]").forEach(e => e.disabled = true);
                        } else {
                            this.$refs.form.$refs.form.querySelectorAll("[name]").forEach(e => e.disabled = false);
                            this.$refs.form.submitButton.style.display = null
                        }
                    })
                });
            } else {
                this.nomina = Object.assign({}, default_fields);
                this.nomina.mes_nomina_id = event.params.mes_nomina_id;
                //this.mes = this.$moment(event.params.mes).format('YYYY-MM-DD');
                this.obtenerMetaMes(this.nomina.mes_nomina_id);
                this.nomina.ruta_id = this.ruta_id;
                this.form.action = this.$route("nominas.validar-primer-paso", this.ruta_id);
                this.form.method = "post";
            }
        },
        calcularComision() {
            if (this.nomina.venta_semanal >= this.nomina.meta_minima && this.nomina.venta_semanal < this.nomina.meta_maxima)
                this.nomina.activos.comision = this.nomina.meta_minima * .01;
            else if (this.nomina.venta_semanal > this.nomina.meta_maxima)
                this.nomina.activos.comision = this.nomina.meta_maxima * .02;
            else
                this.nomina.activos.comision = 0;
        },
        agregarOtroDescuento() {
            this.descuento_extra.push(this.actual_otro_descuento);
            this.actual_otro_descuento = [];
        },
        $moneyFormat(quantity) {
            const options = {style: 'currency', currency: 'MXN'};
            const numberFormat = new Intl.NumberFormat('en-US', options);

            return numberFormat.format(quantity);
        },
        calcularPercepciones() {
            this.nomina.total_activos = this.nomina.activos.sueldo_base + this.nomina.activos.ayuda_transporte +
                this.nomina.activos.ayuda_despensa + this.nomina.activos.comision +
                this.nomina.activos.bono_servicio_cliente + this.nomina.activos.bono_personal + this.nomina.activos.bono_devolucion ;
            this.nomina.total_activos += this.tiene_bono_mensual ? this.nomina.activos.bono_mensual : 0;
        },
        calcularDeducciones() {
            this.nomina.total_pasivos = this.nomina.pasivos.infonavit + this.nomina.pasivos.prestamo + this.nomina.pasivos.faltante +
                this.nomina.pasivos.devolucion + this.nomina.pasivos.descuento_por_falta +
                this.nomina.pasivos.descuento_extra_total;
        },
        calcularTotal() {
            this.nomina.total = this.nomina.total_activos - this.nomina.total_pasivos;
        },
        obtenerVentasMensuales() {
            console.log("this.mes");
            console.log(this.mes);
            console.log("this.mes");
            axios.get(this.$route('users.venta-mensual-total', {
                mes: this.mes,
                ruta_id: this.ruta_id
            })).then(response => {
                this.nomina.venta_mensual = response.data;
            })
        }
    },
    computed: {
        ruta_id() {
            return window.location.href.split('/')[4];
        },
        options() {
            return {
                precision: 2,
                decimal: '.',
                thousands: ',',
                prefix: '$',
                suffix: 'MXN',
                masked: false
            }
        },
    },
    watch: {
        descuento_extra() {
            this.nomina.pasivos.descuento_extra = this.descuento_extra;
            if (this.descuento_extra.length > 0)
                this.nomina.pasivos.descuento_extra_total = this.descuento_extra.reduce((a, b) => {
                    return a + b.cantidad;
                }, 0);
        },
        mes() {
            console.log('hola');
            this.nomina.mes = this.mes;
            axios.get(this.$route('users.venta-devoluciones-mensual', {
                rango_fechas: this.mes,
                ruta_id: this.ruta_id
            })).then(response => {
                this.venta_semanal = response.data.total_ventas;
                this.nomina.activos.bono_devolucion = response.data.devoluciones.activo_devoluciones;
                this.nomina.pasivos.devolucion = response.data.devoluciones.pasivo_devoluciones;
            })
        },
        venta_semanal() {
            this.nomina.venta_semanal = this.venta_semanal;
            this.calcularComision();
        },
        cuota_mensual() {
            this.nomina.activos.cuota_mensual = this.cuota_mensual;
            this.nomina.activos.bono_mensual = Math.abs((this.nomina.venta_mensual - this.cuota_mensual) * .06);
        },
        tiene_bono_mensual(){
            this.nomina.activos.tiene_bono_mensual = this.tiene_bono_mensual;
        }
    }
}
</script>
