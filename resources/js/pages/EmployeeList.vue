<template>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="card">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Designation</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="employee in employees" :key="employee.id">
                <td>
                  <div v-if="employee.edit == true">
                    <input type="text" v-model="name" />
                  </div>
                  <div v-else>
                    {{ employee.name }}
                  </div>
                </td>
                <td>
                  <div v-if="employee.edit == true">
                    <input type="text" v-model="designation" />
                  </div>
                  <div v-else>
                    {{ employee.designation }}
                  </div>
                </td>
                <div v-if="employee.edit == false">
                  <td>
                    <button
                      :disabled="editemployee == true"
                      @click="editEmployee(employee.id)"
                    >
                      Edit
                    </button>
                  </td>
                </div>
                <div v-else>
                  <td>
                    <button @click="updateEmployee(employee.id)">Update</button>
                    <button @click="editEmployee(employee.id)">Cancel</button>
                  </td>
                </div>

                <td><button style="background:red" @click="deleteEmployee(employee.id)">Delete</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "EmployeeListPage",

  data: function () {
    return {
      employees: [],
      editemployee: false,
      name: "",
      designation: "",
    };
  },

  mounted() {
    this.fetchEmployee();
  },

  computed: {},

  methods: {

    // fetch emoloyeee data
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


    // edit employee data

    async editEmployee(id) {
      // console.log(id);
      this.editemployee = !this.editemployee;
      const elementindex = this.employees.findIndex((x) => x.id === id);

      // console.log(elementindex);
      let newemployess = [...this.employees];
      newemployess[elementindex] = {
        ...newemployess[elementindex],
        edit: !newemployess[elementindex].edit,
      };
      this.employees = newemployess;

      return new Promise((resolve, reject) => {
        axios
          .get("http://127.0.0.1:8000/api/employees/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("Token"), //the token is a variable which holds the token
            },
          })
          .then(({ data }) => {
            resolve(data);
            this.name = data.data.name;
            this.designation = data.data.designation;
          })
          .catch((e) => {
            reject(e);
          });
      });
    },

// update employee data
    async updateEmployee(id) {
      const index = this.employees.findIndex((x) => x.id == id);
      return new Promise((resolve, reject) => {
        axios
          .patch(
            "http://127.0.0.1:8000/api/employees/" + id,
            {
              name: this.name,
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
            let newemployess = [...this.employees];
            newemployess[index] = {
              ...newemployess[index],
              id: data.data.id,
              name: data.data.name,
              designation: data.data.designation,
              edit: false,
            };
            this.employees = newemployess;
            this.editemployee = false;
          })
          .catch((e) => {
            reject(e);
          });
      });
    },

  // delete employee data
   async deleteEmployee(id){
     const index = this.employees.findIndex((x)=>x.id === id);
     if(confirm("Are You sure You want to Delet")){
        return new Promise((resolve, reject) => {
        axios
          .delete("http://127.0.0.1:8000/api/employees/" + id, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("Token"), //the token is a variable which holds the token
            },
          })
          .then(({ data }) => {
            resolve(data);
            this.employees.splice(index,1);
            
          })
          .catch((e) => {
            reject(e);
          });
      });
     }
   }


  },
};
</script>

<style>
</style>