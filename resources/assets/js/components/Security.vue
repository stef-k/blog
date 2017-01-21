<template>
    <div>
        <h1 class="title is-2 has-text-centered">Security</h1>

        <div v-if="errors" class="column is-offset-one-quarter is-half-desktop is-full-mobile">
            <ul v-for="error in errors">
                <span class="primary font-normal">Error: {{ error }}</span>
            </ul>
        </div>

        <div class="columns">

            <div class="column is-offset-one-quarter is-half-desktop is-full-mobile">
                <h2 class="title is-3">Name</h2>
                <p>Here you can change your name. This settings affects author's name in posts.</p>
                <p class="control m-y-s">
                    <input type="text" class="input" placeholder="Your public name" v-model="name">
                </p>
                <a class="button is-primary" :class="{ 'is-disabled': nameBtnDisabled, 'is-loading': loadingName }"
                   @click="saveName">Save</a>
                <hr>
            </div>
        </div>

        <div class="columns">

            <div class="column is-offset-one-quarter is-half-desktop is-full-mobile">
                <h2 class="title is-3">Email</h2>
                <p class="m-b-s">Choose on which mail account you want to receive incoming mail.</p>
                <label class="label">Email address</label>
                <p class="control m-y-s">
                    <input type="text" class="input" placeholder="address@example.com" v-model="email">
                </p>

                <label class="label">Email confirmation</label>
                <p class="control m-y-s">
                    <input type="text" class="input" placeholder="Email address confirmation"
                           v-model="emailConfirmation">
                </p>
                <a class="button is-primary" :class="{ 'is-disabled': emailBtnDisabled, 'is-loading': loadingMail }"
                   @click="saveEmail">Save</a>
                <hr>
            </div>

        </div>

        <div class="columns">

            <div class="column is-offset-one-quarter is-half-desktop is-full-mobile">
                <h2 class="title is-3">Password</h2>
                <p class="m-b-s">Change your password</p>
                <label class="label">Old password</label>
                <p class="control m-y-s">
                    <input type="password" class="input" v-model="oldPwd">
                </p>

                <label class="label">New password</label>
                <p class="control m-y-s">
                    <input type="password" class="input" v-model="pwd">
                    <span class="light-notice font-normal">Password must be at least {{ minPwd }} long.</span>
                </p>

                <label class="label">Password confirmation</label>
                <p class="control m-y-s">
                    <input type="password" class="input" v-model="pwdConfirmation">
                </p>
                <a class="button is-primary" :class="{ 'is-disabled': pwdBtnDisabled, 'is-loading': loadingPwd }"
                   @click="savePwd">Save</a>
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
        loadingName      : false,
        loadingMail      : false,
        loadingPwd       : false,
        errors           : [],
        minPwd           : 6,
        oldName          : '',
        name             : '',
        oldEmail         : '',
        email            : '',
        emailConfirmation: '',
        oldPwd           : '',
        pwd              : '',
        pwdConfirmation  : ''
      }
    },

    computed: {
      nameBtnDisabled() {
        return this.oldName === this.name || this.name === '';
      },

      emailBtnDisabled() {
        return this.oldEmail === this.email || this.email === '' || this.email !== this.emailConfirmation;
      },

      pwdBtnDisabled() {
        return this.pwd.length < 6 || this.pwd !== this.pwdConfirmation || this.pwdConfirmation === '' || this.oldPwd === '';
      }
    },

    methods: {

      loadData() {
        this.errors = [];
        this.$http.get(window.myapp.url + '/api/admin/security', {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.oldName = response.body.name;
            this.name = response.body.name;
            this.oldEmail = response.body.email;
            this.email = response.body.email;
          } else {
            this.errors.push(response.statusText);
          }
        }, (error) => {
          this.errors.push(error.statusText);
        });
      },

      saveName() {
        this.loadingName = true;
        this.errors = [];
        this.$http.post(window.myapp.url + '/api/admin/security/name/save', {name: this.name}, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.oldName = response.body;
            this.loadingName = false;
          } else {
            this.loadingName = false;
            this.errors.push(response.statusText);
          }
        }, (error) => {
          this.loadingName = false;
          this.errors.push(error.statusText);
        });
      },

      saveEmail() {
        this.loadingMail = true;
        this.errors = [];
        this.$http.post(window.myapp.url + '/api/admin/security/email/save', {
          mail       : this.email,
          mailConfirm: this.emailConfirmation
        }, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.oldEmail = response.body;
            this.emailConfirmation = '';
            this.loadingMail = false;
          } else {
            this.loadingMail = false;
            this.errors.push(response.statusText);
          }
        }, (error) => {
          this.loadingMail = false;
          this.errors.push(error.body);
        });
      },

      savePwd() {
        this.loadingPwd = true;
        this.errors = [];
        this.$http.post(window.myapp.url + '/api/admin/security/password/save', {
          oldPwd    : this.oldPwd,
          pwd       : this.pwd,
          pwdConfirm: this.pwdConfirmation
        }, {
          headers: {
            Authorization: 'Bearer ' + myapp.token
          }
        }).then((response) => {
          if (response.ok) {
            this.pwdConfirmation = '';
            this.pwd = '';
            this.oldPwd = '';
            this.loadingPwd = false;
          } else {
            this.loadingPwd = false;
            this.errors.push(response.statusText);
          }
        }, (error) => {
          this.loadingPwd = false;
          this.errors.push(error.body);
        });
      }
    }

  }
</script>
