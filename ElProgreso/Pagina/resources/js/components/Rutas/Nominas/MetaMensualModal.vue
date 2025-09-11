<template>
    <modal name="meta-mensual-modal" class="pt-5 pb-5" height="auto" :scrollable="true" :clickToClose="false"
           @before-open="beforeOpen" width="800">
        <div class="modal-header bg-success">
            <h5 class="modal-title" id="exampleModalLabel" style="color: #FFFFFF;">
                Nóminas
            </h5>
            <button type="button" class="close" @click="$modal.hide('meta-mensual-modal')">
                <span aria-hidden="true" class="text-white">&times;</span>
            </button>
        </div>
        <div class="modal-content">
            <div class="row my-3 mx-5">
                <div class="col-6">
                    <label for="meta-minima">Meta minima</label>
                    <input v-model="meta_minima" class="form-control" id="meta-minima" name="meta-minima">
                </div>
                <div class="col-6">
                    <label for="meta-maxima">Meta maxima</label>
                    <input v-model="meta_maxima" class="form-control" id="meta-maxima" name="meta-maxima">
                </div>
                <slot name="buttons"></slot>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline-secondary" @click="cambiarMetas()">Guardar</button>
        </div>
    </modal>
</template>

<script>

import _ from 'lodash';

export default {
    name: "MetaMensualModal",
    data() {
        return {
            meta_minima: 0,
            meta_maxima: 0
        }
    },
    methods: {
        beforeOpen(event){
            this.mes_nomina_id = event.params.mes_nomina_id;
            this.obtenerMetas()
        },
        cambiarMetaMin: _.debounce(function () {
            this.cambiarMetaMinima();
        }, 500),
        cambiarMetas(){
            this.cambiarMetaMinima();
        },
        cambiarMetaMinima() {
            axios.post(this.$route('mes-nomina.meta-minima', {
                id: this.mes_nomina_id,
                cantidad: this.meta_minima
            })).then(response => {
                this.cambiarMetaMaxima();
            })
        },
        cambiarMetaMax: _.debounce(function () {
            this.cambiarMetaMaxima();
        }, 500),
        cambiarMetaMaxima() {
            axios.post(this.$route('mes-nomina.meta-maxima', {
                id: this.mes_nomina_id,
                cantidad: this.meta_maxima
            })).then(response => {
                this.meta_minima = response.data.meta_minima;
                this.meta_maxima = response.data.meta_maxima;
                this.$modal.hide('meta-mensual-modal');
                this.$toast.success('Metas cambiadas con exito');
            })
        },
        obtenerMetas() {
            axios.get(this.$route('mes-nomina.metas', this.mes_nomina_id)).then(response => {
                this.meta_minima = response.data.meta_minima;
                this.meta_maxima = response.data.meta_maxima;
            })
        },
    },
}
</script>

<style scoped>

</style>
