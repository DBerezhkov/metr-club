<template>
    <div>
        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions"
                      @vdropzone-file-added="dropzoneFileAdded" @vdropzone-removed-file="dropzoneFileRemoved">
        </vue-dropzone>
        <div style="color: #DC3543" v-if="isRejectedFiles || isFilesServerError"><b>Внимание! Ошибка при загрузке
            файлов! Превышен лимит файлов, либо загружен недопустимый тип.</b></div>
        <div style="color: #DC3543" v-if="dropzoneTotalFilesize > 30000000"><b>Общий размер файлов превышает 30МБ!</b>
        </div>
        <div class="mb-3" v-if="dropzoneTotalFilesize > 0"><b>Объем загруженных файлов составляет:
            {{ (dropzoneTotalFilesize / 1000000).toFixed(1) }} МБ. <p
                v-if="dropzoneTotalFilesize < 30000000 && dropzoneCountFiles < 30">Вы можете добавить еще
                {{ 30 - dropzoneCountFiles }} файлов.</p></b></div>
    </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

export default {
    components: {
        vueDropzone: vue2Dropzone
    },

    data() {
        return {
            rejectedFiles: null,
            dropzoneTotalFilesize: 0,
            dropzoneCountFiles: 0,
            dropzoneOptions: {
                url: 'none',
                thumbnailWidth: 120,
                thumbnailHeight: 120,
                dictRemoveFile: 'Удалить',
                dictInvalidFileType: 'Данный тип файла нельзя отправить',
                dictDefaultMessage: "<i class='nav-icon fas fa-cloud-upload-alt'></i> Перетащите файлы сюда, либо кликните для загрузки",
                maxFilesize: 20,
                maxFiles: 30,
                parallelUploads: 30,
                dictFileTooBig: "Превышен максимальный размер файла (20МБ).",
                dictMaxFilesExceeded: "Вы не можете загрузить более 30 файлов.",
                uploadMultiple: true,
                createImageThumbnails: true,
                clickable: true,
                addRemoveLinks: true,
                autoProcessQueue: false,
                acceptedFiles: 'image/png,image/jpeg,application/pdf,image/tiff,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/x-rar-compressed,application/vnd.rar,.rar,application/zip,application/octet-stream,application/x-zip-compressed,multipart/x-zip' +
                    'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                accept: function(file, done) {
                    var thumbnail = $('.dropzone .dz-preview.dz-file-preview .dz-image:last');
                    console.log(file.type)
                    switch (file.type) {
                        case 'application/pdf':
                            thumbnail.css('background', 'url(/img/dropzone/PDF.png');
                            thumbnail.css('background-position', 'center');
                            break;
                        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                        case 'application/msword':
                            thumbnail.css('background', 'url(/img/dropzone/WORD.png');
                            thumbnail.css('background-position', 'center');
                            break;
                        case 'application/zip':
                        case 'application/x-rar':
                        case 'application/x-rar-compressed,application/vnd.rar,.rar,application/zip':
                        case 'application/vnd.rar,.rar,application/zip':
                        case '.rar':
                        case 'application/x-zip-compressed':
                        case 'multipart/x-zip':
                            thumbnail.css('background', 'url(/img/dropzone/ARCHIVE.png');
                            thumbnail.css('background-position', 'center');
                            break;
                        case 'application/vnd.ms-excel':
                        case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                            thumbnail.css('background', 'url(/img/dropzone/EXCEL_2.png');
                            thumbnail.css('background-position', 'center');
                            break;
                    }

                    done();
                },

            },

        }
    },


    mounted() {
    },


    methods: {

        dropzoneFileAdded(file) {
            this.dropzoneTotalFilesize += file.size;
            this.dropzoneCountFiles += 1;
            this.$parent.dropzoneCountFiles += 1;
        },

        dropzoneFileRemoved(file) {
            this.dropzoneTotalFilesize -= file.size;
            this.dropzoneCountFiles -= 1;
           this.$parent.dropzoneCountFiles -= 1;
        },
    },
    computed: {

        isRejectedFiles() {
            return this.rejectedFiles;
        },
        isFilesServerError(){
            return this.$parent.filesServerError;
        },

    },

}
</script>

<style>
.dz-progress {
    display: none;
}

.dropzone {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.vue-dropzone > .dz-preview .dz-details {
    background-color: rgba(119, 127, 134, 0);
    opacity: 1;
    color: black;
}

.vue-dropzone > .dz-preview .dz-image {
    border-radius: 20px;
}

.dropzone .dz-preview.dz-file-preview .dz-details {
    border-radius: 20px;
}

.dropzone .dz-preview.dz-image-preview .dz-details {
    border-radius: 20px;
}

.dropzone .dz-preview.dz-image-preview {
    border-radius: 20px;
}

.dropzone .dz-preview {
    max-width: 120px;
    max-height: 120px;
}

.vue-dropzone > .dz-preview .dz-image img:not([src]) {
    max-width: 120px;
    max-height: 120px;
}

.dropzone .dz-preview .dz-details .dz-filename:not(:hover) {
    color: #000;
    position: relative;
    top: -8px;
}

.dropzone .dz-preview .dz-details .dz-filename:hover {
    position: relative;
    top: -8px;
}

.vue-dropzone > .dz-preview .dz-details {
    text-align: center;
}

.vue-dropzone > .dz-preview .dz-remove {
    top: -0.825rem;
}

.dropzone .dz-remove {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 1.65rem;
    width: 1.65rem;
    font-size: 1rem;
    text-indent: -9999px;
    white-space: nowrap;
    position: absolute;
    z-index: 2;
    background-color: #ffffff;
    box-shadow: #3B3E3F;
    border-radius: 100%;
    right: -0.825rem;
}

.dropzone .dz-remove:after {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    display: block;
    content: "";
    mask-size: 40%;
    -webkit-mask-size: 40%;
    mask-repeat: no-repeat;
    mask-position: center;
    -webkit-mask-repeat: no-repeat;
    -webkit-mask-position: center;
    background-color: #dc0000;
    -webkit-mask-image: url(/img/demands/cross.svg);
}

.dropzone .dz-preview .dz-details .dz-size {
    font-size: 14px;
}

.dz-size {
    margin-top: 78%;
    color: #FFFFFF;
}

.dropzone.dz-started .dz-message {
    display: flex;
    justify-content: center;
    width: 100%;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */
{
    opacity: 0;
}

@media(max-width: 550px) {
    .vue-dropzone>.dz-preview .dz-remove {
        opacity: 1;
    }
}
</style>
