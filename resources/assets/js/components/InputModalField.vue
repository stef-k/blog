<template>
    <p class="control">
        <input class="input" type="text" :placeholder="text" :name="name" v-model.lazy="value">
    </p>
</template>

<script>
  export default {

    mounted() {
      this.value = this.initial;
    },

    props: {
      name   : {required: true},
      text   : {required: true},
      initial: {required: false}
    },

    data() {
      return {
        value: ''
      }
    },

  }
</script>
