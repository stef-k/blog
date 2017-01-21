<template>
    <div>
        <image-previewer @previewerClosed="previewerClosed" v-if="previewerActive"></image-previewer>
        <uploader @uploaderClosed="uploaderClosed" v-if="uploaderActive"></uploader>
        <div class="modal is-active" id="inputModal" :type="type" v-if="!uploaderActive && !previewerActive">
            <div class="modal-content">
                <div class="box">
                    <h2 class="title is-4" v-if="!type">Insert URL</h2>
                    <h2 class="title is-4" v-if="type">Insert image URL, select from library or upload new</h2>
                    <slot></slot>
                    <a class="button is-outlined" @click="linkModalClosed">Cancel</a>
                    <a class="button is-tuquoise" @click="showPreviewer" v-if="type">Select image</a>
                    <a class="button is-info is-outlined" @click="showUploader" v-if="type">Upload image</a>
                    <a class="button is-pulled-right is-success" @click="linkModalSaved">Insert Link</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import ImagePreviewer from './ImagePreviewer.vue';
  import Uploader from './Uploader.vue';
  export default {

    components: {
      imagePreviewer: ImagePreviewer,
      uploader: Uploader
    },
    props     : {
      // type will be either link or image
      type: {required: false}
    },
    created() {
      bus.$on('imageUploaded', () => {
        this.uploaderActive = false;
      });

      bus.$on('imageSelected', () => {
        this.previewerActive = false;
      });
    },

    data() {
      return {
        previewerActive: false,
        uploaderActive : false,
        fields         : []
      }
    },

    methods: {

      showPreviewer(){
        this.previewerActive = true;
      },

      previewerClosed() {
        this.previewerActive = false;
      },

      showUploader() {
        this.uploaderActive = true;
      },

      uploaderClosed() {
        this.uploaderActive = false;
      },

      linkModalClosed() {
        this.$emit('linkModalClosed');
      },

      linkModalSaved() {
        this.$emit('linkModalSaved', this.$children);
      }
    }
  }
</script>
