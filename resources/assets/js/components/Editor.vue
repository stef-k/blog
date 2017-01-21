<template>
    <div id="editor">
        <div class="columns">

            <div class="column is-offset-one-quarter is-half-desktop is-full-mobile">
                <div v-if="errors">
                    <ul v-for="error in errors">
                        <span class="primary font-normal">Error: {{ error }}</span>
                    </ul>
                </div>
                <p class="control">
                    <input type="text" class="input title is-4 has-text-centered " v-model="title"
                           placeholder="Click to set post's title">
                </p>
                <p class="light-notice">
                    Add <span class="tag is-primary is-small">is-project</span> tag to save post as <strong>project</strong> type.
                </p>
            </div>
        </div>
        <div class="columns">
            <div class="column is-half-desktop is-offset-one-quarter is-full-mobile">
                <p class="control has-addons anime anime-1" v-if="editing">
                    <a class="button" @click="addHeader('1')">H1</a>
                    <a class="button" @click="addHeader('2')">H2</a>
                    <a class="button" @click="addHeader('3')">H3</a>
                    <a class="button" @click="addHeader('4')">H4</a>
                    <a class="button" @click="addHeader('5')">H5</a>
                    <a class="button" @click="addHeader('6')">H6</a>

                    <a class="button" @click="addOrderedList"><span class="icon is-small"><i
                            class="fa fa-list-ol "></i></span><span></span></a>

                    <a class="button" @click="addUnorderedList"><span class="icon is-small"><i
                            class="fa fa-list-ul"></i></span><span></span></a>

                    <a class="button" @click="addLink"><span class="icon is-small"><i
                            class="fa fa-link"></i></span><span></span></a>

                    <a class="button" @click="addImage"><span class="icon is-small"><i
                            class="fa fa-image"></i></span><span></span></a>

                    <a class="button" @click="addCode"><span class="icon is-small"><i
                            class="fa  fa-code"></i></span><span></span></a>

                    <a class="button" @click="addHorizontalRuler"><span class="icon is-small"><i
                            class="fa fa-minus"></i></span><span></span></a>

                    <a class="button" @click="undo"><span class="icon is-small"><i
                            class="fa  fa-undo"></i></span><span></span></a>

                    <a class="button" @click="redo"><span class="icon is-small"><i
                            class="fa  fa-repeat"></i></span><span></span></a>

                    <a class="button" @click="clear"><span class="icon is-small"><i
                            class="fa fa-times"></i></span><span></span></a>
                </p>
                <span class="font-normal light-notice">Changing from edit to preview undo/redo steps are lost. </span>

                <a class="font-normal" href="https://guides.github.com/features/mastering-markdown/"
                   target="_blank">Github's Markdown guide</a>

                <!--markdown edit-->
                <p class="control" v-if="editing">
                    <textarea v-model="body" @input="update" class="textarea" id="edit"></textarea>
                </p>

                <!--tag input-->
                <p class="control" v-if="editing">
                    <input type="text" v-model.trim="tags" class="input" id="tags"
                           placeholder="tags comma, space or semicolon separated. multi-word-tag">
                </p>

                <!--post preview-->
                <div v-if="!editing">
                    <div v-html="compiledMarkdown" id="editorPreview"></div>
                </div>
                <!--tags preview-->
                <p v-if="!editing">
                    <span v-for="tag in allTags" class="tag is-primary m-t">{{tag}}</span>
                </p>

                <div class="anime anime-3">
                    <!--create - update button-->
                    <a class="button is-primary is-outlined m-r-s" title="publish the post" @click="save">
                        <span v-if="postId === null" :class="{ 'is-loading': loading }">Publish</span>
                        <span v-if="postId !== null" :class="{ 'is-loading': loading }">Save</span>
                    </a>

                    <!--publish or draft control-->
                    <label class="checkbox m-t-s"><input type="checkbox" v-model="status">Publish?</label>


                    <div class="icon is-medium is-hidden-desktop m-x-s" :class="{ 'is-on': editing }" title="edit"
                         @click="edit">
                        <i class="fa fa-edit"></i>
                    </div>
                    <div class="icon is-medium is-hidden-desktop m-l-s" :class="{ 'is-on': !editing }" title="preview"
                         @click="preview">
                        <i class="fa fa-eye"></i>
                    </div>

                    <!--status bar-->
                    <div class="editor-status">
                        <span class="light-notice font-normal ">total words: {{ words }} | chars: {{ chars }}</span>
                    </div>
                </div>


                <div class="editor-status">
                    <span class="light-notice font-normal" v-if="createdAt != null">created: {{createdAt}} | </span>
                    <span class="light-notice font-normal"
                          v-if="updatedAt != null">updated at: {{updatedAt}}</span>
                    <span class="light-notice font-normal"
                          v-if="publishedAt != null">| published at: {{publishedAt}}</span>
                </div>
            </div>

            <!--edit preview switch buttons-->
            <div class="vertical-toolbox anime anime-2 is-hidden-mobile">
                <div class="icon is-medium" :class="{ 'is-on': editing }" title="edit" @click="edit">
                    <i class="fa fa-edit"></i>
                </div>
                <div class="icon is-medium" :class="{ 'is-on': !editing }" title="preview" @click="preview">
                    <i class="fa fa-newspaper-o"></i>
                </div>
            </div>
        </div>

        <!--link modal-->
        <input-modal v-if="linkModal" @linkModalClosed="modalClosed" @linkModalSaved="linkModalSaved">
            <input-modal-field name="url" text="Paste or type the URL here"></input-modal-field>
            <input-modal-field name="text" text="Link text"
                               :initial="selection.selection"></input-modal-field>
            <input-modal-field name="title" text="Link title (on hover)"></input-modal-field>
        </input-modal>
        <!--image modal-->
        <input-modal v-if="imageModal" @linkModalClosed="modalClosed" @linkModalSaved="imageModalSaved" type="image">
            <input-modal-field name="url" text="Paste or type the URL here" :initial="url"></input-modal-field>
            <input-modal-field name="alt" text="Alt text"
                               :initial="urlAlt"></input-modal-field>
            <input-modal-field name="title" text="Link title (on hover)" :initial="urlAlt"></input-modal-field>
        </input-modal>
    </div>
</template>

<script>
  import marked, { Renderer } from 'marked';
  import _ from 'lodash';
  import highlightjs from 'highlightjs';

  import InputModalField from './InputModalField.vue';
  import InputModal from './InputModal.vue';

  export default {

    components: {
      inputModalField: InputModalField,
      inputModal     : InputModal
    },

    created() {

      // check if we are loading a post for editing
      if (this.$route.params.id !== undefined) {
        this.loadPost(this.$route.params.id);
      }

      bus.$on('imageUploaded', (obj) => {
        this.url = obj.url[0];
        this.urlAlt = obj.title;
      });

      bus.$on('imageSelected', (name) => {
        this.url = name;
      });

      marked.setOptions({
        renderer   : new marked.Renderer(),
        highlight  : function (code) {
          return highlightjs.highlightAuto(code).value;
        },
        gfm        : true,
        tables     : true,
        breaks     : true,
        pedantic   : false,
        sanitize   : false,
        smartLists : true,
        smartypants: false
      });

    },

    data() {
      return {
        errors     : [],
        body       : '',
        tags       : '',
        selection  : {},
        editing    : true,
        linkModal  : false,
        imageModal : false,
        url        : '',
        urlAlt     : '',
        title      : '',
        status     : false,
        postId     : null,
        createdAt  : null,
        updatedAt  : null,
        publishedAt: null,
        loading    : false
      }
    },

    computed: {
      compiledMarkdown () {
        return marked(this.body);
      },

      words() {
        if (this.body.length === 0) {
          return 0;
        } else {
          return this.body.trim().replace(/\s+/gi, ' ').split(' ').length;
        }
      },
      chars() {
        return this.body.length;
      },

      allTags() {
        let tags = [];
        this.tags.split(/[\s,;]+/).forEach((tag) => {
          tags.push(tag);
        });
        return tags;
      }

    },
    methods : {

      loadPost(id) {
        this.$http.get(window.myapp.url + '/api/admin/posts/' + id, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          this.postId = response.body.id;
          this.title = response.body.title;
          this.body = response.body.body;
          this.createdAt = response.body.created_at;
          this.updatedAt = response.body.updated_at;
          this.publishedAt = response.body.published_at;
          if (this.publishedAt != null) {
            this.status = true;
          }
          response.body.tags.forEach((tag) => {
            this.tags += tag.name + ' ';
          });
          this.tags = this.tags.trim();
        }, (error) => {
          console.log('loading post error ', error);
        });
      },

      edit() {
        this.editing = true;
      },

      preview() {
        this.editing = false;
      },

      update: _.debounce(function (e) {
        this.input = e.target.value
      }, 300),

      getSelection() {
        let element = document.getElementById('edit');
        let start = element.selectionStart;
        let end = element.selectionEnd;
        this.selection = {
          start    : start,
          end      : end,
          selection: element.value.substring(start, end)
        };
      },

      updateContent(start, end, content) {
        let preText = this.body.substring(0, start);
        let postText = this.body.substring(end);

        this.clear();
        document.execCommand("insertText", false, preText + content + postText);
      },

      undo() {
        document.execCommand('undo');
      },

      redo() {
        document.execCommand('redo');
      },

      clear() {
        let element = document.getElementById('edit');
        element.focus();
        document.execCommand('selectAll');
        document.execCommand('delete');
      },

      addHeader(header) {
        header -= 1;
        this.getSelection();
        let headers = ['# ', '## ', '### ', '#### ', '##### ', '###### '];
        this.updateContent(this.selection.start, this.selection.end, headers[header] + this.selection.selection + '\n');
      },

      addOrderedList() {
        this.getSelection();
        this.selection.selection = this.selection.selection.replace(/^/gm, '1. ');
        this.updateContent(this.selection.start, this.selection.end, this.selection.selection);
      },

      addUnorderedList() {
        this.getSelection();
        this.selection.selection = this.selection.selection.replace(/^/gm, '* ');
        this.updateContent(this.selection.start, this.selection.end, this.selection.selection);
      },

      addLink() {
        this.getSelection();
        this.linkModal = true;
      },

      modalClosed() {
        this.linkModal = false;
        this.imageModal = false;
      },

      linkModalSaved(fields) {

        this.linkModal = false;
        let url = fields[0].value !== undefined ? fields[0].value : '';
        let text = fields[1].value !== undefined ? fields[1].value : '';
        let title = fields[2].value !== undefined ? fields[2].value : '';
        let content = '';

        if (url.length > 0) {
          content = url;
          if (text.length > 0) {
            content = '[' + text + '](' + url + ')';
            if (title.length > 0) {
              content = '[' + text + '](' + url + ' "' + title + '")';
            }
          }
          this.updateContent(this.selection.start, this.selection.end, content);
        }
      },

      addImage() {
        this.getSelection();
        this.imageModal = true;
        this.url = '';
        this.urlAlt = '';
      },

      imageModalSaved(fields) {
        this.imageModal = false;
        let url = fields[0].value !== undefined ? fields[0].value : '';
        let alt = fields[1].value !== undefined ? fields[1].value : '';
        let title = fields[2].value !== undefined ? fields[2].value : '';
        let content = '';

        if (url.length > 0) {
          if (alt.length > 0) {
            content = '![' + alt + '](' + url + ')';
            if (title.length > 0) {
              content = '![' + alt + '](' + url + ' "' + title + '")';
            } else {
              content = '![' + alt + '](' + url + ' "' + alt + '")';
            }
          } else {
            content = '![' + '](' + url + ')';
          }
          this.updateContent(this.selection.start, this.selection.end, content);
        }
      },

      addCode() {
        this.getSelection();
        this.updateContent(this.selection.start, this.selection.end, '```\n' + this.selection.selection + '\n```');
      },

      addHorizontalRuler() {
        this.getSelection();
        this.updateContent(this.selection.start, this.selection.end, '\n\n---\n' + this.selection.selection);
      },

      titleClicked() {
        this.title = '';
      },

      titleChanged(e) {
        this.title = e.target.innerHTML;
        if (this.title === '') {
          this.title = 'Click to set post\'s title';
        }
      },

      save() {
        let tags = [];
        let post = {};
        this.tags.split(/[\s,;]+/).forEach((tag) => {
          tags.push(tag);
        });
        post.title = this.title;
        post.body = this.body;
        post.tags = tags;
        post.status = this.status;
        this.loading = true;
        if (this.postId === null) {
          this.remoteCreatePost(post);
        } else {
          this.remoteUpdatePost(post);
        }
      },

      remoteCreatePost(post) {
        this.$http.post(window.myapp.url + '/api/admin/posts/create', post, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.postId = response.body.id;
            this.loading = false;
            this.$router.push('/posts/' + this.postId);
          }
        }, (response) => {
          this.loading = false;
          console.log(response);
        });
      },

      remoteUpdatePost(post) {
        post.id = this.postId;
        this.$http.post(window.myapp.url + '/api/admin/posts/update', post, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.postId = response.body.id;
            this.createdAt = response.body.created_at;
            this.updatedAt = response.body.updated_at;
            this.publishedAt = response.body.published_at;
            this.loading = false;
          }
        }, (response) => {
          this.loading = false;
          console.log(response);
        });
      }

    }
  }
</script>

