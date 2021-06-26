<template>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="search-employee">
            <h4>Searh By Designation</h4>
            <form @submit.prevent="fetchSearchEmployee">
              <select v-model="designation" class="form-select">
                <option
                  v-for="alldesignations in alldesignation"
                  :key="alldesignations.id"
                  :value="alldesignations.designation"
                >
                  {{ alldesignations.designation }}
                </option>
              </select>
              <button type="submit">Search</button>
            </form>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Designation</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="employee in employees" :key="employee.id">
                <td>
                  <div>
                    {{ employee.name }}
                  </div>
                </td>
                <td>
                  <div>
                    {{ employee.designation }}
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <hr />
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="search-employee">
            <h4>All Search Data</h4>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Select</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="searchemp in searchemployees" :key="searchemp.id">
                <td>
                  <div>
                    {{ searchemp.name }}
                  </div>
                </td>
                <td>
                  <div>
                    {{ searchemp.designation }}
                  </div>
                </td>
                <td>
                  <button v-bind:disabled="searchemp.diseable == true" @click="selectEmployee(searchemp.id)">select</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <hr />
    <div v-if="openselectedtable == true" class="row">
      <ValidationObserver v-slot="{ invalid }">
        <form @submit.prevent="saveSelectedEmployee">
          <div class="col">
            <div class="card">
              <div class="search-employee">
                <h4>All Search Data</h4>
              </div>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Phone Number</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="selectemp in formData.selectedemployees"
                    :key="selectemp.id"
                  >
                    <td>
                      <div>
                        {{ selectemp.name }}
                      </div>
                    </td>
                    <td>
                      <div>
                        <ValidationProvider
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <input
                            :class="{
                              error: errors.length > 0,
                            }"
                            type="text"
                            v-model="selectemp.address"
                          />
                          <span id="error">{{ errors[0] }}</span>
                        </ValidationProvider>
                      </div>
                    </td>
                    <td>
                      <div>
                        <ValidationProvider
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <input
                            :class="{
                              error: errors.length > 0,
                            }"
                            type="text"
                            v-model="selectemp.phone_number"
                          />
                          <span id="error">{{ errors[0] }}</span>
                        </ValidationProvider>
                      </div>
                    </td>
                    <td>
                      <div>
                        <ValidationProvider
                          rules="required"
                          v-slot="{ errors }"
                        >
                          <input
                            :class="{
                              error: errors.length > 0,
                            }"
                            type="email"
                            v-model="selectemp.email"
                          />
                          <span id="error">{{ errors[0] }}</span>
                        </ValidationProvider>
                      </div>
                    </td>
                    <td>
                      <button @click.prevent="remove(selectemp.id)">
                        remove
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <button
                :disabled="invalid"
                style="width: 200px"
                class="btn btn-primary"
                type="submit"
              >
                submit
              </button>
            </div>
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
  name: "SearchEmployee",
   components: {
    ValidationObserver,
    ValidationProvider,
  },
  data: function () {
    return {
      employees: [],
      searchemployees: [],
      editemployee: false,
      designation: "",
      alldesignation: [],
      openselectedtable: false,
      hasclicked: false,

      formData: {
        selectedemployees: [],
      },
      // name: [],
      // address: [],
      // phone_number: [],
      // email: [],
    };
  },

  mounted() {
    this.fetchEmployee();
    this.fetchAllDesignation();
  },

  methods: {
    async fetchEmployee() {
      return new Promise((resolve, reject) => {
        axios
          .get("http://127.0.0.1:8000/api/employees", {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("Token"), //the token is a variable which holds the token
            },
          })
          .then(({ data }) => {
            resolve(data);
            // console.log(data.data);
            data.data.forEach((element) => {
              this.employees.push({
                id: element.id,
                name: element.name,
                designation: element.designation,
                edit: false,
              });
            });
            // console.log(this.employees);
          })
          .catch((e) => {
            reject(e);
          });
      });
    },

    async fetchAllDesignation() {
      return new Promise((resolve, reject) => {
        axios
          .get("http://127.0.0.1:8000/api/fetchalldesignation", {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("Token"), //the token is a variable which holds the token
            },
          })
          .then(({ data }) => {
            resolve(data);
            // console.log(data.data);
            data.data.forEach((element) => {
              this.alldesignation.push({
                designation: element.designation,
              });
            });
            // console.log(this.employees);
          })
          .catch((e) => {
            reject(e);
          });
      });
    },

    async fetchSearchEmployee() {
      // empty search array before api call
      this.searchemployees.splice(0, this.searchemployees.length);
      return new Promise((resolve, reject) => {
        axios
          .post(
            "http://127.0.0.1:8000/api/search-employee",
            {
              designation: this.designation,
            },
            {
              headers: {
                Authorization: "Bearer " + localStorage.getItem("Token"), //the token is a variable which holds the token
              },
            }
          )
          .then(({ data }) => {
            resolve(data);
            // console.log(data.data);
            data.data.forEach((element) => {
              this.searchemployees.push({
                id: element.id,
                name: element.name,
                designation: element.designation,
                diseable: false,
              });
            });
            console.log(this.searchemployees);
          })
          .catch((e) => {
            reject(e);
          });
      });
    },

    selectEmployee(id) {
      this.openselectedtable = true;
      const index = this.searchemployees.findIndex((x) => x.id == id);
      let newemployess = [...this.searchemployees];
      newemployess[index] = {
        ...newemployess[index],
        diseable: !newemployess[index].diseable,
      };
      this.searchemployees = newemployess;

      let ssl = this.searchemployees[index];
      console.log(ssl);
      this.formData.selectedemployees.push({
        id: ssl.id,
        name: ssl.name,
        address: "",
        phone_number: "",
        email: "",
        
      });
      this.hasclicked = true;
    },

    remove(id) {
      const index = this.formData.selectedemployees.findIndex(
        (x) => x.id === id
      );

      this.formData.selectedemployees.splice(index, 1);
    },

    async saveSelectedEmployee() {
      return new Promise((resolve, reject) => {
        axios
          .post(
            "http://127.0.0.1:8000/api/save-selected-employee",
            this.formData,
            {
              headers: {
                Authorization: "Bearer " + localStorage.getItem("Token"), //the token is a variable which holds the token
              },
            }
          )
          .then(({ data }) => {
            resolve(data);
            alert(data.message);
            this.openselectedtable = false;
            this.formData.selectedemployees.splice(
              0,
              this.formData.selectedemployees.length
            );
            this.searchemployees.splice(0,this.searchemployees.length);
          })
          .catch((e) => {
            reject(e);
          });
      });
    },
  },
};
</script>

<style>
</style>