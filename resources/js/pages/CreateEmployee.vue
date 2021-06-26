<template>
  <div id="login_form">
    <div class="page-title text-center">Create Employee</div>
    <div class="form-section">
      <ValidationObserver v-slot="{ invalid }">
        <form @submit.prevent="loginUser">
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


};
</script>

<style>
</style>