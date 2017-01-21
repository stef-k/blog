<template>
    <div class="columns m-t-m">
        <sidebar></sidebar>

        <main role="main" class="section column is-10 fullheight">
            <div class="m-t-s container-fluid">
                <router-view></router-view>
            </div>
        </main>
    </div>
</template>

<script>
  import Sidebar from './Sidebar.vue';
  export default {
    components: {
      sidebar: Sidebar
    }
  }
</script>
