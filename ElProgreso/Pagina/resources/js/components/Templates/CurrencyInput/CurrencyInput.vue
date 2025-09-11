<template>
    <money v-model="inputValue" v-bind="options"
           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
</template>

<script>
export default {
    name: "CurrencyInput",
    props: {
        value: Number,
        options: {
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            inputValue: null
        }
    },
    created() {
        this.inputValue = this.value
    },
    watch: {
        value: {
            deep: true,
            handler() {
                this.inputValue = this.value
            }
        },
        inputValue: {
            deep: true,
            handler() {
                this.$emit('input', this.inputValue)
            }
        }
    }
}
</script>
