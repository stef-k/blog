<template>
    <div class="cell-child">
        <div>
            <figure @click="imageSelected">
                <img :src="link">
            </figure>
        </div>

        <div >
            <strong>Filename:</strong> {{name}} <br>
            <strong>Size:</strong> {{size}} <br>
            <a :href="link" class="button" target="_blank" :title="link">Open in new tab</a>

            <div class="the-checkbox">
                <input type="checkbox" v-model="selected" id="imgSelected">
                <label for="imgSelected"></label>
            </div>
        </div>
    </div>
</template>

<script>
  export default {

    props: {
      link: {required: true},
      name: {required: true},
      size: {required: true},
      isSelected: {required:false, default: false}
    },


    mounted() {
      this.selected = this.isSelected;
    },

    data() {
      return {
        selected: false
      }
    },

    methods: {
      imageSelected() {
        this.selected = !this.selected;
        this.$emit('imageSelected', this.name)
      }
    }
  }
</script>
