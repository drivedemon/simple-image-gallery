<template>
  <div class="d-flex justify-content-center">
    <form @submit.prevent="onSubmit" class="d-flex flex-column justify-content-center w-50 p-3">
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input v-model="username" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
               placeholder="Enter email">
        <p class="text-red-500 text-xs italic" v-if="!!error.username">{{ error.username }}</p>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input v-model="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        <p class="text-red-500 text-xs italic" v-if="!!error.password">{{ error.password }}</p>
      </div>
      <p class="text-red-500 text-xs italic mb-3" v-if="generalError">{{ generalError }}</p>
      <button type="submit" class="btn btn-primary mb-3">Sign In</button>
      <router-link to="/register" class="btn btn-sm btn-secondary" href="#">
        Sign Up
      </router-link>
    </form>
  </div>
</template>

<script>
import authenticationService from '@/services/authenticationService';

export default {
  name: "Login",
  data: () => {
    return {
      username: "",
      password: "",
      error: {},
      generalError: "",
    }
  },
  create() {
    localStorage.clear();
  },
  methods: {
    onSubmit: async function () {
      this.error = {};
      if (!this.username.trim()) this.error.username = "Username is required"
      if (!this.password.trim()) this.error.password = "Password is required"
      if (Object.keys(this.error).length) return
      const data = {
        email: this.username,
        password: this.password
      }
      try {
        await authenticationService.login(data).then((response) => {
          localStorage.status = true
          localStorage.user = response.data.user.id
          setTimeout(() => {
            window.location.href = '/upload'
          }, 10);
        })
      } catch (e) {
        this.generalError = e.response.data.error_message;
      }
    }
  }
}
</script>

<style scoped>
</style>