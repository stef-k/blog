<template>
    <div :class="{ 'must-fullwidth': embed }">

        <h1 class="title is-2 has-text-centered">Media files</h1>

        <div class="columns">
            <div class="column is-full-mobile is-half-desktop is-paddingless">
                <a class="button" @click="showUploader" title="Upload images">
                    <span class="icon">
                        <i class="fa fa-upload"></i>
                    </span>
                </a>
                <span v-if="files.length > 0">
                    <a class="button" @click="toggleSelectAll" v-if="!embed" title="Toggle select all">
                        <span class="icon">
                            <i class="fa"
                               :class="{ 'fa-check-square': selectedFiles.length > 0, 'fa-square-o': selectedFiles.length === 0 }"></i>
                        </span>
                    </a>
                    <a class="button" @click="deleteSelected" title="Delete selected"
                       :class="{ 'is-disabled': selectedFiles.length === 0 }">
                        <span class="icon">
                            <i class="fa fa-trash"></i>
                        </span>
                    </a>
                </span>
            </div>
            <div class="column is-full-mobile is-half-desktop">
                <div v-if="errors">
                    <ul v-for="error in errors">
                        <span class="primary">Error: {{ error }}</span>
                    </ul>
                </div>
            </div>
        </div>

        <div class="the-grid" :class="{ 'is-previewer': embed }">
            <div v-for="file in files" class="the-cell" :key="file.selected + file.name">
                <file :name="file.name" :link="file.link" :size="file.size" @imageSelected="imageSelected"
                      :isSelected="file.selected"></file>
            </div>
        </div>

        <p class="centered m-t-s center-all" v-if="files.length > 0">
            <span class="has-space"> Page <strong>{{ currentPage }}</strong> of <strong>{{ pages }}</strong>. Go to page </span>
            <input type="text" v-model="goto" class="input page-input m-x-s has-text-centered">
            <a class="button" @click="gotoPage" title="Go to selected page" :class="{ 'is-disabled': !validGoto }">
                <span class="icon">
                    <i class="fa fa-fast-forward "></i>
                </span>
            </a>
        </p>
        <p class="centered m-t-s center-all" v-if="files.length > 0">
            <a class="button" @click="gotoStart" title="Go to start">
                <span class="icon">
                    <i class="fa fa-step-backward"></i>
                </span>
            </a>
            <a class="button" @click="prevPage" title="Previous page">
                <span class="icon">
                    <i class="fa fa-backward "></i>
                </span>
            </a>
            <a class="button" @click="nextPage" title="Next page">
                <span class="icon">
                    <i class="fa fa-forward"></i>
                </span>
            </a>
            <a class="button" @click="gotoEnd" title="Go to end">
                <span class="icon">
                    <i class="fa fa-step-forward"></i>
                </span>
            </a>
        </p>

        <uploader @uploaderClosed="uploaderClosed" v-if="uploaderActive" :multifile="true"
                  @imageUploaded="imageUploaded"></uploader>
    </div>
</template>

<script>
  import File from './File.vue';
  import Uploader from './Uploader.vue';


  export default {

    components: {
      'file'    : File,
      'uploader': Uploader
    },

    props: {
      embed: {default: false}
    },

    data() {
      return {
        start         : 0, // start of pagination
        batch         : 6, // items per page
        total         : 0, // total items
        pages         : 0, // total pages
        itemsPerPage  : 6,
        goto          : '',
        files         : [],
        errors        : [],
        selectedFiles : [],
        loading       : false,
        uploaderActive: false,
      }
    },

    mounted() {
      this.getFiles();
    },

    methods: {

      clear() {
        this.files = [];
        this.selectedFiles = [];
      },

      /**
       * Handles the request to get image URLs from server
       *
       * @param {number} start the starting item for pagination
       */
      getFiles() {
        this.clear();
        this.errors = [];
        this.loading = true;
        this.$http.get(window.myapp.url + '/api/admin/files/' + this.start + '/' + this.itemsPerPage,{
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        })
          .then((response) => {
            if (response.ok) {
              this.loading = false;
              response.json().then((result) => {
                this.total = parseInt(result.total);
                this.start = parseInt(result.start);
                this.pages = parseInt(result.pages);
                this.batch = parseInt(result.batch);
                result.urls.forEach((url) => {
                  this.files.push(url);
                });
              });
            }
          }, (response) => {
            this.loading = false;
            this.errors.push(response.statusText)
          });
      },

      // Toggles selected state on the given element
      imageSelected(name) {
        let selected = [];
        if (this.embed) {
          this.selectedFiles = [name];
          let element;
          this.files.forEach((file) => {
            if (file.name === name) {
              element = file.link;
            }
          });

          this.$emit('imageSelected', element);
        } else {
          let element = this.selectedFiles.indexOf(name);
          if (element === -1) {
            this.selectedFiles.push(name);
          } else {
            this.selectedFiles.splice(element, 1);
          }
        }
        this.files.forEach((file) => {
          if (this.embed) {
            if (file.name === name) {
              file.selected = !file.selected;
            } else {
              file.selected = false;
            }
          } else {
            if (file.name === name) {
              file.selected = !file.selected;
            }
          }
          selected.push(file);
        });
        this.files = selected;
      },

      /**
       * Deletes the selected images from the server
       */
      deleteSelected() {
        if (this.selectedFiles.length === 0) {
          return;
        }
        this.errors = [];
        this.loading = true;

        // request remote file deletion
        this.$http.post(window.myapp.url + '/api/admin/files/delete', {'deletable': this.selectedFiles},{
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        })
          .then((response) => {
            this.loading = false;

            if (response.ok) {
              if (response.body !== undefined && response.body.length > 0) {
                this.errors = response.body;
              } else {
                this.getFiles();
              }
            } else {
              this.errors.push(response.statusText)
            }
          }, (response) => {
            this.loading = false;
            this.errors.push(response.statusText)
          });

      },


      /**
       * Toggles selected state of all images
       * Gets the state of the many or half elements as the user intended state
       */
      toggleSelectAll() {

        let many = false;
        let all = this.files.length;
        let selects = this.selectedFiles.length;
        if (selects >= (all / 2) || selects === 0) {
          many = true;
        }
        if (selects === all) {
          many = false;
        }
        this.selectedFiles = [];
        this.files.forEach((file) => {
          file.selected = many;
          if (many) {
            this.selectedFiles.push(file.name);
          }
        });
      },

      /**
       * Shows the image uploader component
       */
      showUploader() {
        this.uploaderActive = true;
      },

      /**
       * Hides the uploader component
       */
      uploaderClosed() {
        this.uploaderActive = false;
      },

      /**
       * Handles UI refresh upon image upload
       */
      imageUploaded() {
        this.uploaderClosed();
        this.getFiles();
      },

      gotoStart() {
        if (this.start > 0) {
          this.start = 0;
          this.getFiles();
        }
      },

      gotoEnd() {
        this.start = this.total - 1;
        this.getFiles();
      },

      nextPage() {
        if (this.start < this.total) {
          this.start = this.start + this.batch;
          this.getFiles();
        }
      },

      prevPage() {
        if (this.start > 0) {
          this.start = this.start - this.batch;
          this.getFiles();
        }
      },

      gotoPage() {
        let goto = parseInt(this.goto);
        this.start = (goto - 1) * this.batch;
        this.getFiles();
      }

    },

    computed: {
      currentPage() {
        return Math.ceil(this.start / this.batch) + 1;
      },

      validGoto() {
        let valid = false;
        let validNumber = /^[0-9]+$/;
        if (validNumber.test(this.goto)) {
          let goto = parseInt(this.goto);
          if (this.pages > 0) {
            if ((goto > 0 && goto <= this.pages) && (goto !== this.currentPage)) {
              valid = true;
            }
          }
        }
        return valid;
      }

    }
  }
</script>
