<template>
  <div id="registration_form">
    <div class="page-title text-center">Registration Page</div>
    <div class="form-section">
      <ValidationObserver v-slot="{ invalid }">
        <form @submit.prevent="registerUser">
          <div class="section">
            <ValidationProvider rules="required" v-slot="{ errors }">
              <input
                :class="{
                  firstname: true,
                  error: errors.length > 0,
                }"
                type="text"
                placeholder="Name"
                v-model="formData.name"
              />
              <span id="error">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>

          <div class="section">
            <ValidationProvider rules="required" v-slot="{ errors }">
              <input
                :class="{
                  lastname: true,
                  error: errors.length > 0,
                }"
                type="text"
                placeholder="User Name"
                v-model="formData.username"
              />
              <span id="error">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>

          <div class="section">
            <ValidationProvider rules="required" v-slot="{ errors }">
              <input
                :class="{
                  email: true,
                  error: errors.length > 0,
                }"
                type="email"
                placeholder="Email"
                v-model="formData.email"
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

          <div class="section">
            <ValidationProvider
              rules="required|confirmed:confirmation"
              v-slot="{ errors }"
            >
              <input
                :class="{
                  confirmpassword: true,
                  error: errors.length > 0,
                }"
                type="password"
                placeholder="Confirm Your Password"
                v-model="formData.confirmpassword"
              />
              <span id="error">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>

          <div class="login-submit">
            <button :disabled="invalid" type="submit" class="button-submit">
              Sign up
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
  name: "Register",

  components: {
    ValidationObserver,
    ValidationProvider,
  },

  data: function () {
    return {
      formData: {
        name: "",
        username: "",
        email: "",
        password: "",
        confirmpassword: "",
      },
    };
  },

  methods: {
    async registerUser() {
      return new Promise((resolve, reject) => {
        axios
          .post("http://127.0.0.1:8000/api/user/register", this.formData)
          .then(({ data }) => {
            resolve(data);
            console.log(data);
            if (data.status.toLowerCase() == "success") {
              this.$router.push("/");

            } else if (data.status.toLowerCase() == "error") {

              alert(data.message);

            }
          })
          .catch((e) => {
            alert("Your Given Data is invalid");
            reject(e);
          });
      });
    },
  },
};
</script>

<style>
</style>