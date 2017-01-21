<template>
    <div class="modal is-active" id="imageUploader">
        <div class="modal-content">
            <div class="box">
                <div v-if="files.length <= 0">
                    <h2 class="title is-4" v-if="!multifile">Select an image to upload</h2>
                    <h2 class="title is-4" v-if="multifile">Select one or more images to upload</h2>
                    <div v-if="errors">
                        <ul v-for="error in errors">
                            <span class="primary font-normal">Error: {{ error }}</span>
                        </ul>
                    </div>
                    <input type="file" @change="onFileChange" class="m-t-l m-b-l" :multiple="multifile">
                </div>
                <div v-else>
                    <p v-if="image" class="font-normal">
                        <strong>Filename:</strong> <span class="image-info">{{ files[selectedFile].name }}</span>
                        <strong>Size:</strong> <span class="image-info">{{ size }}</span>
                        <strong>file:</strong> <span class="image-info" v-if="multifile">{{ fileNo }}</span>
                        <strong>of files:</strong> <span class="image-info" v-if="multifile">{{ fileCount }}</span>
                    </p>
                    <div class="columns is-gapless is-paddingless is-marginless v-parent">
                        <div class="column is-paddingless is-marginless is-hidden-mobile">
                            <a class="button is-outlined is-primary m-r-s" @click="prevFile">
                                <span class="icon">
                                    <i class="fa fa-arrow-left"></i>
                                 </span>
                            </a>
                        </div>

                        <figure class="image" v-if="fileCount >= 1">
                            <div class="column is-paddingless is-marginless">
                                <img :src="image"/>
                            </div>
                        </figure>

                        <div class="column is-paddingless is-marginless is-hidden-mobile">
                            <a class="button is-outlined is-primary m-l-s" @click="nextFile">
                                <span class="icon">
                                    <i class="fa fa-arrow-right"></i>
                                 </span>
                            </a>
                        </div>
                    </div>
                    <div class="columns is-hidden-desktop">
                        <div class="column m-t-s is-half is-offset-one-quarter">
                            <a class="button is-outlined is-primary m-l-b" @click="prevFile">
                                <span class="icon">
                                    <i class="fa fa-arrow-left"></i>
                                 </span>
                            </a>
                            <a class="button is-outlined is-primary is-pulled-right" @click="nextFile">
                                <span class="icon">
                                    <i class="fa fa-arrow-right"></i>
                                 </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="m-t-s">
                    <a class="button" @click="uploaderClosed">Cancel</a>
                    <a class="button is-outlined is-primary" v-if="image" @click="removeImage">Remove image</a>
                    <a class="button is-outlined is-primary" v-if="image" @click="removeAll">Remove all</a>
                    <a class="button is-pulled-right is-success" @click="fileUpload"
                       :class="{ 'is-loading': uploading }">Upload</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        selectedFile: -1,
        files       : [],
        image       : '',
        errors      : [],
        uploading   : false,
        title       : '',
        body        : ''
      }
    },

    props: {
      multifile: {default: false}
    },

    destroyed() {
      if (this.image) {
        URL.revokeObjectURL(this.image);
      }
    },

    methods: {
      onFileChange(e) {
        let files = e.target.files;
        if (!files.length) {
          return;
        }

        Object.keys(files).forEach((file) => {
          this.files.push(files[file]);
        });

        this.selectedFile = 0;
        this.imagePreview();
      },

      imagePreview() {
        if (this.files.length > 0) {
          this.image = URL.createObjectURL(this.files[this.selectedFile]);
        }
      },

      removeImage() {
        if (this.image !== '') {
          URL.revokeObjectURL(this.image);
        }
        this.image = '';
        this.size = 0;
        this.files.splice(this.selectedFile, 1);
        if (this.selectedFile > (this.files.length - 1)) {
          this.selectedFile -= 1;
        }
        this.imagePreview()
      },

      removeAll() {
        this.selectedFile = -1;
        this.files = [];
        this.image = '';
        this.errors = [];
        this.uploading = false;
      },

      uploaderClosed() {
        if (this.image) {
          URL.revokeObjectURL(this.image);
        }
        this.$emit('uploaderClosed');
      },

      /**
       * Performs the file upload request.
       */
      fileUpload() {
        this.errors = [];
        this.error = '';

        let form = new FormData();
        this.files.forEach((file, i) => {
          form.append('image[' + i + ']', file, file.name)
        });
        this.uploading = true;
        this.$http.post(window.myapp.url + '/api/admin/files/upload/', form, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        })
          .then((response) => {
            if (response.ok) {
              this.uploading = false;
              if (!this.multifile) {
                bus.$emit('imageUploaded', {url: response.body, title: this.files[this.selectedFile].name});
              } else {
                this.$emit('imageUploaded', {url: response.body, images: this.files});
              }
            }
          }, (response) => {
            this.uploading = false;
            if (response.body.image !== undefined) {
              response.body.image.forEach((e) => {
                this.errors.push(e);
              });
            } else {
              this.errors.push(response.statusText)
            }
            this.uploadError();
          });
      },

      uploadError() {
        this.removeImage();
      },

      nextFile() {
        if (this.selectedFile < (this.files.length - 1)) {
          if (this.image) {
            URL.revokeObjectURL(this.image);
          }
          this.selectedFile += 1;
          this.imagePreview();
        }
      },

      prevFile() {
        if (this.selectedFile > 0) {
          if (this.image) {
            URL.revokeObjectURL(this.image);
          }
          this.selectedFile -= 1;
          this.imagePreview();
        }
      }

    },

    computed: {

      fileNo() {
        return this.selectedFile + 1;
      },

      fileCount() {
        return this.files.length;
      },

      size() {
        if (this.files.indexOf(this.files[this.selectedFile]) !== -1) {
          let size = this.files[this.selectedFile].size;
          let i = Math.floor(Math.log(size) / Math.log(1000));
          return ( size / Math.pow(1000, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        } else {
          return 0;
        }
      }
    }
  }
</script>
