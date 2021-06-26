<template>
  <div id="navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <router-link class="navbar-brand" to="/">Employ Management</router-link>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto">
            <div class="d-flex" v-if="token == null">
              <li class="nav-item">
                <router-link to="/user/register">Register</router-link>
              </li>
              <li class="nav-item">
                <router-link to="/">Login</router-link>
              </li>
            </div>
            <div class="d-flex" v-else>
               <li class="nav-item">
                <router-link to="/create-employee">Create Employee</router-link>
              </li>

              <li class="nav-item">
                <router-link to="/search-employee">Search Employee</router-link>
              </li>

              <li class="nav-item">
                <router-link to="/employee-list">Employee List</router-link>
              </li>

              <form @submit.prevent="Logout">
                <li class="nav-item">
                  <button class="btn btn-primary">Logout</button>
                </li>
              </form>
            </div>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: "NavbarComponent",

  data: function () {
    return {
      token: localStorage.getItem("Token"),
    };
  },

  methods: {
    Logout() {
      localStorage.removeItem("Token");
      this.$router.push("/");
      window.location.reload();
    },
  },
};
</script>

<style>
</style>