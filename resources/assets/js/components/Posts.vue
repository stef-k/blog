<template>
    <div>

        <h1 class="title is-2 has-text-centered">All posts</h1>
        <!--loading inticator-->
        <div v-if="loading" class="has-text-centered">
            <span class="underliner p-s">Loading posts, please wait...</span>
        </div>

        <div class="columns">
            <div class="column is-offset-one-quarter is-half-desktop is-full-mobile">
                <div class="column">
                    <p class="control is-hidden-tablet">
                        <input type="text"  class="input" placeholder="search in posts (in title or article)" v-model="searchTerm">
                    </p>
                    <div class="control is-grouped">
                        <p class="control is-expanded is-hidden-mobile">
                            <input type="text"  class="input" placeholder="search in posts (in title or article)" v-model="searchTerm">
                        </p>
                        <p class="control">
                            <a class="button" :class="{'is-disabled': searchTerm === ''}" @click="search">Search</a>
                        </p>
                        <p class="control">
                            <a class="button" :class="{'is-disabled': searchTerm === ''}" @click="clearSearch">All posts</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!--error feedback-->
        <div v-if="errors" class="column is-offset-one-quarter is-half-desktop is-full-mobile">
            <ul v-for="error in errors">
                <span class="primary font-normal">Error: {{ error }}</span>
            </ul>
        </div>
        <div class="columns" v-for="post in posts" :key="post.id">
            <div class="column is-offset-one-quarter is-half-desktop is-full-mobile">
                <h2 class="title is-3">{{ post.title }}</h2>
                <div class="content">
                    <p v-html="compiledMarkdown(post.body)"></p>
                </div>
                <p>
                    <span v-for="tag in post.tags" class="tag is-primary m-t">{{tag.name}}</span>
                </p>
                <span class="light-notice font-normal">created at: {{post.created_at}} |</span>
                <span class="light-notice font-normal">updated at: {{post.updated_at}}</span>
                <span class="light-notice font-normal"
                      v-if="post.published_at != null">| published at: {{post.published_at}}</span>
                <span class="light-notice font-normal" v-if="post.published_at == null">| unpublished</span>
                <p>
                    <a class="button is-link" title="View this post as public" v-if="post.published_at !== null"
                       :href="getPublicUrl(post.id)" target="_blank">View public</a>
                    <a class="button is-link" :href="getEditUrl(post.id)" title="Edit this post">Edit</a>
                    <a class="button is-pulled-right is-outlined primary" title="Delete this post permantly!"
                       @click="deletePost(post.id)">Delete</a>
                </p>
                <hr>
            </div>
        </div>
        <p class="has-text-centered"> Showing articles {{resultsFrom}} - {{resultsTo}} from total of {{total}}, page
            {{currentPage}} of {{lastPage}}.</p>
        <p class="centered m-t-s center-all" v-if="lastPage > 1">
            <span class="has-space">Go to page</span>
            <input type="text" v-model="goto" class="input page-input m-x-s has-text-centered">
            <a class="button" :href="gotoPage()" title="Go to selected page" :class="{ 'is-disabled': !validGoto }">
                <span class="icon">
                    <i class="fa fa-fast-forward "></i>
                </span>
            </a>
        </p>
        <p class="centered m-t-s center-all" v-if="lastPage > 1">
            <a class="button" href="posts" title="Go to start" :class="{ 'is-disabled':currentPage === 1 }">
                <span class="icon">
                    <i class="fa fa-step-backward"></i>
                </span>
            </a>
            <a class="button" :class="{ 'is-disabled':prevPageUrl === null }" :href="prevPageUrl" title="Previous page">
                <span class="icon">
                    <i class="fa fa-backward "></i>
                </span>
            </a>
            <a class="button" :class="{ 'is-disabled': nextPageUrl === null }" :href="nextPageUrl" title="Next page">
                <span class="icon">
                    <i class="fa fa-forward"></i>
                </span>
            </a>
            <a class="button" :class="{ 'is-disabled': currentPage === lastPage }" :href="getLastPage()"
               title="Go to end">
                <span class="icon">
                    <i class="fa fa-step-forward"></i>
                </span>
            </a>
        </p>
    </div>
</template>

<script>
  import marked, { Renderer } from 'marked';
  import _ from 'lodash';
  import highlightjs from 'highlightjs';

  export default {
    data() {
      return {
        searchTerm : '',
        goto       : 0,
        total      : 0,
        perPage    : 0,
        currentPage: 0,
        lastPage   : 0,
        nextPageUrl: null,
        prevPageUrl: null,
        resultsFrom: 0,
        resultsTo  : 0,
        posts      : [],
        errors     : [],
        loading    : false
      }
    },

    created() {
      let query = this.$route.query;
      if (query.page) {
        this.loadPosts('?page=' + query.page);
      } else {
        this.loadPosts();
      }

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

    methods: {
      loadPosts(page = '') {
        this.errors = [];
        this.loading = true;
        this.$http.get(window.myapp.url + '/api/admin/posts/' + page, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.posts = response.body.data;
            this.total = response.body.total;
            this.perPage = response.body.per_page;
            this.currentPage = response.body.current_page;
            this.lastPage = response.body.last_page;
            this.resultsFrom = response.body.from;
            this.resultsTo = response.body.to;
            this.nextPageUrl = response.body.next_page_url || null;
            this.prevPageUrl = response.body.prev_page_url || null;
            this.loading = false;
          } else {
            this.loading = false;
            this.errors.push(response);
          }
        }, (error) => {
          this.loading = false;
          this.errors.push('Could not load posts');
        });
      },

      gotoPage() {
        return '?page=' + this.goto;
      },

      getLastPage(){
        return '?page=' + this.lastPage;
      },

      getEditUrl(id) {
        return window.myapp.url + '/admin/posts/' + id;
      },

      getPublicUrl(id) {
        let post;
        this.posts.forEach((entry) => {
          if (entry.id === id) {
            post = entry;
          }
        });

        if (post.published_at !== null) {
          let ymd = post.published_at.split(/\s|\-/);
          return window.myapp.url +
            '/posts/' + ymd[0] + '/' + ymd[1] +
            '/' + ymd[2] + '/' + post.slug;
        }
      },

      deletePost(id) {
        this.errors = [];
        this.$http.post(window.myapp.url + '/api/admin/posts/delete/', {id: id}, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          // no need for feedback, user will see the post removed from posts list
          // delete local copy
          this.posts.forEach((post, index) => {
            if (post.id === id) {
              this.posts.splice(index, 1);
            }
          })
        }, (error) => {
          this.errors.push(error.statusText);
        });
      },

      compiledMarkdown (body) {
        return marked(body.substring(0, 150)) + '[...]';
      },

      search() {
        this.errors = [];
        this.loading = true;
        this.$http.post(window.myapp.url + '/api/admin/posts/search', {term: this.searchTerm}, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.posts = response.body.data;
            this.total = response.body.total;
            this.perPage = response.body.per_page;
            this.currentPage = response.body.current_page;
            this.lastPage = response.body.last_page;
            this.resultsFrom = response.body.from;
            this.resultsTo = response.body.to;
            this.nextPageUrl = response.body.next_page_url || null;
            this.prevPageUrl = response.body.prev_page_url || null;
            this.loading = false;
          } else {
            this.loading = false;
            this.errors.push(response);
          }
        }, (error) => {
          this.loading = false;
          this.errors.push('Could not load posts');
        });
      },

      clearSearch() {
        this.searchTerm = '';
        this.loadPosts('');
      }

    },

    computed: {
      validGoto() {
        return this.goto >= 0 && this.goto <= this.lastPage && this.goto !== this.currentPage;
      }
    }
  }
</script>
