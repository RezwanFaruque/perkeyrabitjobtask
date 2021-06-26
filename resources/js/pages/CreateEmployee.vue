<template>
  <div id="login_form">
    <div class="page-title text-center">Create Employee</div>
    <div class="form-section">
      <ValidationObserver v-slot="{ invalid }">
        <form @submit.prevent="createEmployee">
          <div class="section">
            <ValidationProvider rules="required" v-slot="{ errors }">
              <input
                :class="{
                  email: true,
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
                type="text"
                placeholder="Designation"
                v-model="formData.designation"
              />
              <span id="error">{{ errors[0] }}</span>
            </ValidationProvider>
          </div>
          <div class="login-submit">
            <button :disabled="invalid" type="submit" class="button-submit">
              Create Employee
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
  name: "CreateEmployee",

  components: {
    ValidationObserver,
    ValidationProvider,
  },

  data: function () {
    return {
      formData: {
        name: "",
        designation: "",
      },
    };
  },

  methods: {
    async createEmployee() {
      return new Promise((resolve, reject) => {
        axios
          .post("http://127.0.0.1:8000/api/employees", this.formData, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("Token"), //the token is a variable which holds the token
            },
          })
          .then(({ data }) => {
            resolve(data);
            console.log(data);
            if (data.status.toLowerCase() == "success") {
              alert(data.message);
              this.$router.push("/employee-list");
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