<template>
    <input type="text" v-model="value">
</template>

<script>
import $ from 'jquery';
import 'suggestions-jquery';
export default {
    props: {
        model: {
            required: true
        },
        coordinates: {},
        dadatas: {},
        options: {
            type: Object,
            default: {
                type: 'ADDRESS',
                addon: 'none'
            }
        }
    },
    data() {
        return {
            value: '',
            coords: {
                latitude: '',
                longitude: ''
            },
            dadata: '',
        }
    },
    mounted() {
        this.callbacks = $.Callbacks();
        this.value = this.model;
        this.initSuggestion();
    },
    destroyed() {
        this.destroySuggestion();
    },
    watch: {
        coords: {
            handler() {
                this.$emit('update:coordinates', this.coords);
            },
            deep: true
        },
        dadata: {
            handler() {
                this.$emit('update:dadatas', this.dadata);
            },
            deep: true
        },
        value() {
            this.$emit('update:model', this.value);
        },
        model() {
            this.value = this.model;
        }
    },
    methods: {
        initSuggestion() {
            this.callbacks.add(this.onSelect);
            this.callbacks.add(this.options.onSelect || $.noop)
            const options = Object.assign({}, this.options, {
                onSelect: suggestion => this.callbacks.fire(suggestion)
            });
            $(this.$el).suggestions(options);
        },
        destroySuggestion() {
            const plugin = $(this.$el).suggestions();
            plugin.dispose();
        },
        onSelect(suggestion) {
            this.value = suggestion.value;
            this.dadata = suggestion;
            const { geo_lat, geo_lon } = suggestion.data;
            this.coords.latitude = geo_lat;
            this.coords.longitude = geo_lon;
        }
    }
};
</script>
