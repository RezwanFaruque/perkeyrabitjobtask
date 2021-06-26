<template>
  <div id="login_form">
    <div class="page-title text-center">Login To See Full Feature</div>
    <div class="form-section">
      <ValidationObserver v-slot="{ invalid }">
        <form @submit.prevent="loginUser">
          <div class="section">
            <ValidationProvider rules="required" v-slot="{ errors }">
              <input
                :class="{
                  username: true,
                  error: errors.length > 0,
                }"
                type="text"
                placeholder="UserName"
                v-model="formData.username"
              />
              <span id="error">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>

          <div class="section">
            <ValidationProvider
              rules="required"
              vid="confirmation"
              v-slot="{ errors }"
            >
              <input
                :class="{
                  password: true,
                  error: errors.length > 0,
                }"
                type="password"
                placeholder="Password"
                v-model="formData.password"
                ref="password"
              />
              <span id="error">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>
          <div class="login-submit">
            <button :disabled="invalid" type="submit" class="button-submit">
              Login
            </button>
          </div>
        </form>
      </ValidationObserver>
    </div>
  </div>
</template>

<script>
import {
  ValidationProvider,
  ValidationObserver,
} from "vee-validate/dist/vee-validate.full.esm";

export default {
  name: "Login",
  components: {
    ValidationObserver,
    ValidationProvider,
  },

  data: function () {
    return {
      formData: {
        username: "",
        password: "",
      },
    };
  },

  methods:{
    async loginUser(){
       return new Promise((resolve, reject) => {
        axios
          .post("http://127.0.0.1:8000/api/user/login", this.formData)
          .then(({ data }) => {
            resolve(data);
            console.log(data);
            if (data.status.toLowerCase() == "success") {
              localStorage.setItem("Token", data.token);
              this.$router.push("/create-employee");
              window.location.reload();

            } else if (data.status.toLowerCase() == "error") {

              alert(data.message);

            }
          })
          .catch((e) => {
            alert("Your Given Data is invalid");
            reject(e);
          });
      });
    }
  }



};
</script>

<style>
</style>