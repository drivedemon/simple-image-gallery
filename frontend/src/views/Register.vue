<template>
  <div class="d-flex justify-content-center">
    <form @submit.prevent="onSubmit" class="d-flex flex-column justify-content-center w-50 p-3">
      <div class="form-group">
        <label for="exampleInputName">Name</label>
        <input v-model="name" type="text" class="form-control" id="exampleInputName"
               placeholder="FullName">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input v-model="username" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
               placeholder="Enter email">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input v-model="password" type="password" class="form-control" id="exampleInputPassword1"
               placeholder="Password">
      </div>
      <p class="text-red-500 text-xs italic mb-3" v-if="generalError">{{ generalError }}</p>
      <button type="submit" class="btn btn-secondary">Submit</button>
    </form>
  </div>
</template>

<script>
import authenticationService from '@/services/authenticationService';

export default {
  name: "Register",
  data: () => {
    return {
      name: "",
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
      if (!this.name.trim()) this.error.name = "Full Name is required";
      if (!this.username.trim()) this.error.username = "Username is required";
      if (!this.password.trim()) this.error.password = "Password is required";
      if (Object.keys(this.error).length) return;
      const data = {
        name: this.name,
        email: this.username,
        password: this.password
      }
      try {
        await authenticationService.register(data).then((response) => {
          localStorage.status = true;
          localStorage.user = response.data.user.id
          setTimeout(() => {
            window.location.href = '/upload'
          }, 10);
        })
      } catch (e) {
        this.generalError = e.response.data.error
      }
    }
  }
}
</script>

<style scoped>
</style>