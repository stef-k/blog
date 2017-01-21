<template>
    <aside class="menu column admin-sidebar m-t-m">
        <a class="button is-hidden-desktop is-primary" @click="toggleMenu">
          <span class="icon">
            <i class="fa fa-gear"></i>
          </span>
        </a>
        <div class="p-s admin-menu" :class="{ 'is-visible': isVisible }">
            <p class="menu-label">
                <span class="is-large"> Dashboard</span>
            </p>
            <ul class="menu-list">
                <li><router-link  to="/" exact>
                    <span class="icon"><i class="fa fa-home"></i></span> Dashboard Home</router-link></li>
            </ul>
            <p class="menu-label">
                <span class="is-large"> Posts &amp; Projects</span>
            </p>
            <ul class="menu-list">
                <li><router-link to="/posts"><span class="icon"><i class="fa fa-file-text"></i></span></span> Posts</router-link></li>
                <li><router-link to="/projects"><span class="icon"><i class="fa fa-th "></i></span></span> Projects</router-link></li>
                <li><router-link to="/new-post"><span class="icon"><i class="fa fa-edit"></i></span> New</router-link></li>
            </ul>
            <p class="menu-label">
                <span class="is-large"> Media Library</span>
            </p>
            <ul class="menu-list">
                <li><router-link to="/library"><span class="icon"><i class="fa fa-image"></i></span></span> Files</router-link></li>
            </ul>
            <p class="menu-label">
                <span class="is-large"> Settings</span>
            </p>
            <ul class="menu-list">
                <li><router-link to="/security"><span class="icon"><i class="fa fa-user-circle-o"></i></span></span> Security</router-link></li>
                <li><router-link to="/integrations"><span class="icon"><i class="fa fa-gears "></i></span></span> Integrations</router-link></li>
            </ul>
        </div>
    </aside>
</template>

<script>
  export default {

    data() {
      return {
        isVisible: false
      }
    },

    methods: {
      toggleMenu() {
        this.isVisible = !this.isVisible;
      }
    }
  }
</script>
