<template>
  <div>
    <b-navbar toggleable="lg" type="dark" variant="dark">
      <b-navbar-brand class="font-weight-bold mt-2" href="/dashboard">HOME</b-navbar-brand>
      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-nav-item class="border-0" v-if="authenticated" href="/upload">Gallery</b-nav-item>
        </b-navbar-nav>
      </b-collapse>

      <b-navbar-nav class="ml-auto">
        <b-navbar-brand right class="font-weight-bold mt-2" v-if="authenticated" href="/login" v-on:click.native="logout()">
          logout
        </b-navbar-brand>
      </b-navbar-nav>
    </b-navbar>
  </div>
</template>

<script>
export default {
  name: 'Header',
  data: () => ({ authenticated: localStorage.getItem('status') }),
  methods: {
    logout() {
      localStorage.clear();
      this.authenticated = false;
    }
  }
}
</script>