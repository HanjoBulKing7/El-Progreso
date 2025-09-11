<template>
    <div>
        <div class="row">
            <div class="col-6">
                <date-picker v-model="month" type="month" placeholder="Mes"
                             value-type="format" format="YYYY-MM"></date-picker>
            </div>
            <div class="col-6 align-items-end">
                <button v-if="month" class="btn btn-outline-secondary"
                        @click="$modal.show('bono-anual-modal', {
                                    mes: month
                                })"
                >Definir % de
                    {{ this.$moment(this.month).format('YYYY') }}
                </button>
                <button v-if="nominas.length === 4" class="btn btn-outline-secondary"
                        @click="$modal.show('meta-mensual-modal', {
                                   mes_nomina_id: mes_nomina_id, mes: month
                                })"
                >Bono mensual
                </button>
                <button v-if="month" @click="$modal.show('meta-mensual-modal', {
                                   mes_nomina_id: mes_nomina_id, mes: month
                                })" class="btn btn-outline-secondary">Metas mensuales
                </button>
                <button class="btn btn-outline-secondary"
                        @click="$modal.show('nomina-modal', {
                                    mes_nomina_id: mes_nomina_id,
                                    mes: month
                                })" v-if="month && nominas.length < 4">
                    Nueva nomina
                </button>
            </div>
        </div>
        <div class="table" v-if="month">
            <div v-if="nominas.length > 0">
                <div class="row">
                    <template v-for="(nomina, index) in nominas">
                        <div class="col-12 col-xl-6 my-3">
                            <div class="card">
                                <div class="card-header bg-success text-white"><h5 style="color:#fff;">Semana
                                    {{
                                        index + 1 + ': ' + $moment(nomina.comienza_en).format('DD/MM/YYYY') + ' - ' + $moment(nomina.finaliza_en).format('DD/MM/YYYY')
                                    }}</h5></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">Percepciónes</div>
                                        <div class="col-4"></div>
                                        <div class="col-4">{{ $moneyFormat(nomina.total_activos) }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">Deducciónes</div>
                                        <div class="col-4"></div>
                                        <div class="col-4">{{ $moneyFormat(nomina.total_pasivos) }}</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4"><b>Total</b></div>
                                        <div class="col-4"></div>
                                        <div class="col-4"><b>{{ $moneyFormat(nomina.total) }}</b></div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-dim btn-success" @click="showNominas(nomina.id)"><i
                                        class="las la-eye"></i>
                                    </button>
                                    <button class="btn btn-dim btn-primary" @click="editNominas(nomina.id)"><i
                                        class="las la-pencil-alt"></i></button>
                                    <button class="btn btn-dim btn-danger" @click="deleteNominas(nomina.id)"><i
                                        class="las la-trash"></i>
                                    </button>
                                    <button class="btn btn-dim btn-info" @click="imprimirNominas(nomina.id)"><i
                                        class="las la-print"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            <div class="align-items-center text-center" v-else>
                <!--<meta-mensual v-if="mes_nomina_id" :mes_nomina_id="mes_nomina_id"></meta-mensual>-->
                <img :src="'../../img/empty.svg'" style="width: 20vw">
                <h3 class="mt-3">No has registrado aún ninguna nomina para este mes</h3>
                <button class="btn btn-outline-secondary"
                        @click="$modal.show('nomina-modal', {reset: true, mes_nomina_id: mes_nomina_id, mes: month})">
                    Nueva nomina
                </button>
            </div>

            <nominas-modal @created="reloadTable"></nominas-modal>
            <meta-mensual-modal></meta-mensual-modal>
            <bono-anual-modal></bono-anual-modal>
            <v-dialog/>
            <br>
        </div>
        <div v-else>
            <div class="align-items-center text-center">
                <img :src="'../../img/empty.svg'" style="width: 20vw">
                <h3 class="mt-3">Seleccióna un mes para comenzar</h3>
            </div>
        </div>
    </div>
</template>

<script>

import NominasModal from "./NominasModal";
import {Spanish} from "flatpickr/dist/l10n/es.js";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es.js';
import MetaMensualModal from "./MetaMensualModal";
import BonoAnualModal from "./BonoAnualModal";
import Vue from "vue";

export default {
    name: "NominasTable",
    components: {
        MetaMensualModal,
        NominasModal,
        DatePicker,
        BonoAnualModal
    },
    data() {
        return {
            month: "",
            mes_nomina_id: "",
            default_month: "",
            nominas: [],
            columns: [],
            filterable: [],
            headings: [],
            dateConfig: {
                mode: "range",
                dateFormat: 'Y-m-d',
                altFormat: 'M j, Y',
                wrap: true,
                locale: Spanish,
                altInput: true,
                disableMobile: true
            },
        }
    },
    methods: {
        $moneyFormat(quantity) {
            const options = {style: 'currency', currency: 'MXN'};
            const numberFormat = new Intl.NumberFormat('en-US', options);

            return numberFormat.format(quantity);
        },
        imprimirNominas(id) {
            axios.get(this.$route('nominas.imprimir', id)).then(response => {

                window.open('../../../../storage/' + response.data, '_blank');
            })
        },
        reloadTable() {
            console.log('evento emitido');
            this.obtenerNominas();
        },
        editNominas(id) {
            this.$modal.show("nomina-modal", {id: id, edit: true});
        },
        showNominas(id) {
            this.$modal.show("nomina-modal", {id: id, show: true});
        },
        deleteNominas(id) {
            this.$modal.show("dialog", {
                title: "Eliminar registro",
                text: "¿Desea eliminar el registro?",
                buttons: [
                    {
                        title: "Cancelar"
                    },
                    {
                        title: "Eliminar",
                        handler: () => {
                            axios.delete(this.$route("rutas.nominas.destroy", id)).then(this.reloadTable);
                            this.$modal.hide("dialog");
                            this.$toast.open({duration: 5000, message: "Elemento eliminado exitosamente."});
                        }
                    }
                ]
            })
        },
        obtenerNominas() {
            axios.post(this.$route('mes-nominas.store', {
                mes: this.month, ruta_id: this.ruta_id,
                columns: JSON.stringify([
                    'id', 'total_activos', 'total_pasivos', 'total', 'venta_semanal', 'comienza_en', 'finaliza_en'
                ])
            })).then(response => {
                this.nominas = response.data.nominas;
                this.mes_nomina_id = response.data.id;
            })
        }
    },
    computed: {
        ruta_id() {
            return window.location.href.split('/')[4];
        }
    },
    watch: {
        month() {
            this.obtenerNominas();
        }
    }
}
</script>

