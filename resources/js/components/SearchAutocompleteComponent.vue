<template>
    <div class="autocomplete-root">
        <input
            v-bind:value="value"
            :id="this.myid"
            v-on:input="onChange($event.target.value)"
            @keydown.down.prevent="onArrowDown"
            @keydown.up.prevent="onArrowUp"
            @keydown.enter="onEnter(arrowCounter)"
            type="text"
            class="form-control"
            :class="{'is-invalid': invalid}"
        />
        <small class="invalid-feedback" :class="{'is-invalid': invalid}"
        >Укажите ФИО!</small>
        <ul
            v-show="isOpen"
            class="autocomplete-results"
        >
            <li
                v-for="(result, i) in results"
                :key="i"
                @click="setResult(result)"
                class="autocomplete-result"
                :class="{ 'is-active': i === arrowCounter }"
            >
                {{ result.name }}
            </li>
            <li v-show="isEmptyResults"
                class="autocomplete-empty-result"
            >
                Упс... Ничего не найдено
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'SearchAutocompleteComponent',
    props: {
        url: String,
        myid: String,
        invalid: Boolean,
        exceptions: [],
        value: String,
    },

    data() {
        return {
            items: [],
            client_name_mortgage: '',
            results: [],
            isOpen: false,
            isEmptyResults: false,
            arrowCounter: -1,
        };
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside)
    },
    destroyed() {
        document.removeEventListener('click', this.handleClickOutside)
    },
    methods: {
        handleClickOutside(event) {
            if (!this.$el.contains(event.target)) {
                this.arrowCounter = -1;
                this.isOpen = false
                this.arrowCounter = -1;
            }
        },

        onArrowDown() {
            if (this.arrowCounter < this.results.length) {
                this.arrowCounter = this.arrowCounter + 1;
            }
        },

        onArrowUp() {
            if (this.arrowCounter > 0) {
                this.arrowCounter = this.arrowCounter - 1;
            }
        },

        onEnter(id) {
            this.setResult(this.results[id])
            this.isOpen = false;
            this.arrowCounter = -1;
        },

        setResult(result) {
            this.$emit('submit', result)
            this.isOpen = false
            this.arrowCounter = -1;
        },

        onChange(inputText) {
            this.$emit('input', inputText)
            if(inputText.length > 1) {
                const apiUrl = this.url + encodeURI(inputText) + '/' + this.exceptions
                axios.get(apiUrl)
                    .then(data => {
                        this.results = data.data
                        this.isEmptyResults = this.results.length === 0;
                        this.isOpen = true
                    })
            }
            else {
                this.isEmptyResults = true
                this.isOpen = false
            }
        }
    },
};
</script>

<style>
.autocomplete-root {
    width: 100%;
    z-index: 10;
}

.autocomplete-results {
    background-color: white;
    margin-top: 0px;
    border: 1px solid #d7d1d1;
    border-radius: 0 0 5px 5px;
    height: auto;
    min-height: 1em;
    max-height: 9em;
    overflow: auto;
    width: 100%;
    position: absolute;
    padding-left: 0px;
}

.autocomplete-result, .autocomplete-empty-result {
    height: 35px;
    list-style: none;
    text-align: left;
    padding: 5px 12px;
    cursor: pointer;
}
.autocomplete-result.is-active, .autocomplete-result:hover {
    background-color: #007bff;
    color: white;
}

.autocomplete-empty-result {
    height: 35px;
    list-style: none;
    text-align: left;
    padding: 5px 12px;
    cursor: not-allowed;
    color: gray;
}

</style>
