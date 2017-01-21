<template>
    <div class="modal is-active">
        <div class="box">
            <library embed="true" @imageSelected="imageSelected"></library>
            <p>
                <a class="button" @click="previewerClosed">Cancel</a>
                <a class="button is-outlined is-info" @click="insertImage">Insert image</a>
            </p>
        </div>
    </div>

</template>

<script>
    import Libary from './Library.vue';

  export default {

    components: {
      library: Libary
    },

    data() {
      return {
        selectedImage: ''
      }
    },

    methods: {

      imageSelected(name) {
        this.selectedImage = name;

      },

      insertImage() {
        bus.$emit('imageSelected', this.selectedImage);
      },

      previewerClosed() {
        this.$emit('previewerClosed');
      }
    }

  }
</script>
