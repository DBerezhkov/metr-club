<template>
    <div>
        <input v-model="title" type="text" class="form-control" placeholder="title">
        <!--div ref="dropzone111" class="p-5 text-center border btn d-block rounded files" id="dropzone1111">
            Нажмите, или перетащите сюда файлы
        </div-->
        <input ref="dropzone" type="file" id="dropzone" >
        <button @click="store" type="submit" id='btnSubmit' class="btn btn-primary ">Отправить заявку</button>
    </div>
</template>

<script>
import Dropzone from 'dropzone'
export default {
    name: "Index",

    data() {
        return {
            dropzone: null,
            title: null,
        }
    },

    mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: "asdasd",
            maxFilesize: 20000000,
            maxFiles: 30,
            autoProcessQueue: false,
            addRemoveLinks: true
        })
    },

    methods: {
        store() {
            const form = document.getElementById('formSnd')
            form.addEventListener('submit', function(e){
                e.preventDefault()
                console.log(e)
            })
            const images = new FormData()
            const files = this.dropzone.getAcceptedFiles()
            console.log(files)
            files.forEach(file => {
                images.append('images[]', file)
            })
            console.log(images)
        }
    }
}
</script>

<style scoped>

</style>
