<template>
    <modal name="bono-anual-modal" class="pt-5 pb-5" height="auto" :scrollable="true" :clickToClose="false"
           @before-open="beforeOpen" width="800">
        <alv-form :action="$route('bono-anuales.show', this.bono_anual.year)" id="nomina-create" method="POST"
                  :spinner="true" @after-done="afterDone"
                  :data-object="bono_anual" ref="form">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #FFFFFF;">
                    Porcentaje de bono anual
                </h5>
                <button type="button" class="close" @click="$modal.hide('bono-anual-modal')">
                    <span aria-hidden="true" class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-content">
                <div class="row my-3 mx-5">
                    <div class="col-6">
                        <label for="meta-minima">Porcentaje de Bono Anual</label>
                        <input v-model="bono_anual.bono" class="form-control" id="bono_anual" name="bono_anual">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" type="submit">Guardar</button>
            </div>
        </alv-form>
    </modal>
</template>

<script>


export default {
    name: "BonoAnualModal",
    data() {
        return {
            bono_anual: {
                bono: "",
                year: ""
            }
        }
    },
    methods: {
        beforeOpen(event) {
            this.bono_anual.year = this.$moment(event.params.mes).format('YYYY');
            axios.get(this.$route('bono-anuales.show', this.bono_anual.year)).then(response => {this.bono_anual = response.data})
        },
        afterDone() {
            this.$modal.hide('bono-anual-modal');
            this.$toast.success('Porcentaje de bono anual cambiado!');
        }
    },
}
</script>

<style scoped>

</style>
