<template>
    <div>
        <h1 class="title is-2 has-text-centered">Integrations</h1>

        <div v-if="errors" class="column is-offset-one-quarter is-half-desktop is-full-mobile">
            <ul v-for="error in errors">
                <span class="primary font-normal">Error: {{ error }}</span>
            </ul>
        </div>


        <div class="columns">

            <div class="column is-offset-one-quarter is-half-desktop is-full-mobile">
                <h2 class="title is-3">Google Analytics</h2>
                <p>Set your Google tracking ID here and analytics will be automatically enabled.</p>
                <p class="control m-y-s">
                    <input type="text" class="input" placeholder="UA-XXXXXXXX-X" v-model="trackingId">
                </p>
                <a class="button is-primary"
                   :class="{ 'is-disabled': analyticsBtnDisabled, 'is-loading': loadingAnalytics }"
                   @click="saveAnalytics">Save</a>
                <a class="button is-pulled-right" :class="{ 'is-loading': loadingClearAnalytics }"
                   @click="clearAnalytics">Clear</a>
                <hr>
            </div>

        </div>

        <div class="columns">

            <div class="column is-offset-one-quarter is-half-desktop is-full-mobile">
                <h2 class="title is-3"> Disqus Comments</h2>
                <p>Set your Disqus site URL and comments will be automatically enabled for posts.</p>
                <p class="control m-y-s">
                    <input type="text" class="input" placeholder="Your site disqus URL, e.g: iccode"
                           v-model="disqusUrl">
                </p>
                <p class="light-notice font-normal m-b-s">
                    Example: for <span class="primary">www.iccode.net</span>, the value must be <span class="primary">iccode</span>
                    which on Disqus platform will be <span class="primary">iccode.disqus.com</span>
                </p>
                <a class="button is-primary" :class="{ 'is-disabled': disqusBtnDisabled, 'is-loading': loadingDisqus }"
                   @click="saveDisqus">Save</a>
                <a class="button is-pulled-right" :class="{ 'is-loading': loadingClearDisqus }"
                   @click="clearDisqus">Clear</a>
                <hr>
            </div>

        </div>

    </div>
</template>
<script>

  export default {

    created() {
      this.loadData();
    },

    data() {
      return {
        errors            : [],
        loadingAnalytics  : false,
        loadingClearAnalytics  : false,
        loadingDisqus     : false,
        loadingClearDisqus: false,
        oldTrackingId     : '',
        trackingId        : '',
        oldDisqusUrl      : '',
        disqusUrl         : ''
      }
    },

    computed: {
      analyticsBtnDisabled() {
        return this.oldTrackingId === this.trackingId || this.trackingId === '';
      },

      disqusBtnDisabled() {
        return this.oldDisqusUrl === this.disqusUrl || this.disqusUrl === '';
      },

    },

    methods: {

      loadData() {
        this.errors = [];
        this.$http.get(window.myapp.url + '/api/admin/integrations', {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.oldTrackingId = response.body.tracking_id;
            this.trackingId = response.body.tracking_id;
            this.oldDisqusUrl = response.body.disqus_url;
            this.disqusUrl = response.body.disqus_url;
          } else {
            this.errors.push(response.statusText);
          }
        }, (error) => {
          this.errors.push(error.statusText);
        });
      },

      saveAnalytics() {
        this.loadingAnalytics = true;
        this.errors = [];
        this.$http.post(window.myapp.url + '/api/admin/integrations/analytics/save', {trackingId: this.trackingId}, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.oldTrackingId = response.body;
            this.loadingAnalytics = false;
          } else {
            this.loadingAnalytics = false;
            this.errors.push(response.statusText);
          }
        }, (error) => {
          this.loadingName = false;
          this.errors.push(error.statusText);
        });
      },

      clearAnalytics() {
        this.loadingClearAnalytics = true;
        this.errors = [];
        this.$http.post(window.myapp.url + '/api/admin/integrations/analytics/clear', {}, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.oldTrackingId = '';
            this.trackingId = '';
            this.loadingClearAnalytics = false;
          } else {
            this.loadingClearAnalytics = false;
            this.errors.push(response.statusText);
          }
        }, (error) => {
          this.loadingClearAnalytics = false;
          this.errors.push(error.statusText);
        });
      },

      saveDisqus() {
        this.loadingDisqus = true;
        this.errors = [];
        this.$http.post(window.myapp.url + '/api/admin/integrations/disqus/save', {disqusUrl: this.disqusUrl}, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.oldDisqusUrl = response.body;
            this.loadingDisqus = false;
          } else {
            this.loadingDisqus = false;
            this.errors.push(response.statusText);
          }
        }, (error) => {
          this.loadingDisqus = false;
          this.errors.push(error.statusText);
        });
      },

      clearDisqus() {
        this.loadingClearDisqus = true;
        this.errors = [];
        this.$http.post(window.myapp.url + '/api/admin/integrations/disqus/clear', {}, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.oldDisqusUrl = '';
            this.disqusUrl = '';
            this.loadingClearDisqus = false;
          } else {
            this.loadingClearDisqus = false;
            this.errors.push(response.statusText);
          }
        }, (error) => {
          this.loadingClearDisqus = false;
          this.errors.push(error.statusText);
        });
      }
    }

  }
</script>
