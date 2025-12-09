<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <v-row>
          <v-col cols="10">User(s) List</v-col>
          <v-col cols="2">
            <v-btn
              @click="addDataModal('Add New User')"
              class="btn_add float-right"
              small
            >
              <v-icon left>mdi-plus-circle-outline</v-icon>Add New User
            </v-btn>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <div v-if="allData.data">
          <v-row>
            <v-col cols="6" lg="2">
              <v-select :items="tblItemNumberShow" dense v-model="paginate"></v-select>
            </v-col>

            <v-col cols="6" lg="10">
              <v-text-field v-model="search" dense placeholder="Search by any data at the table..."></v-text-field>
            </v-col>
          </v-row>

          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>
                    <a href="#" @click.prevent="change_sort('id')"
                      >ID</a
                    >
                    <span
                      v-if="
                        sort_direction == 'desc' && sort_field == 'id'
                      "
                      >&uarr;</span
                    >
                    <span
                      v-if="
                        sort_direction == 'asc' && sort_field == 'id'
                      "
                      >&darr;</span
                    >
                  </th>
                  <th>
                    <a href="#" @click.prevent="change_sort('name')"
                      >Name</a
                    >
                    <span
                      v-if="
                        sort_direction == 'desc' && sort_field == 'name'
                      "
                      >&uarr;</span
                    >
                    <span
                      v-if="
                        sort_direction == 'asc' && sort_field == 'name'
                      "
                      >&darr;</span
                    >
                  </th>
                  <th>
                    <a href="#" @click.prevent="change_sort('email')"
                      >Contact</a
                    >
                    <span
                      v-if="
                        sort_direction == 'desc' && sort_field == 'email'
                      "
                      >&uarr;</span
                    >
                    <span
                      v-if="
                        sort_direction == 'asc' && sort_field == 'email'
                      "
                      >&darr;</span
                    >
                  </th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="singleData in allData.data" :key="singleData.id">
                  <td>{{ singleData.id }}</td>
                  <td>{{ singleData.name }}</td>
                  <td>{{ singleData.email }}<br>
                      {{ (singleData.phone) ?  singleData.phone : 'N/A' }}
                  </td>
                  <td>
                      <span v-if="singleData.roles.length">
                      <span
                        v-for="(item, index) in singleData.roles"
                        :key="index"
                      >
                        <v-chip class="m-1 small">{{ item.name }}</v-chip>
                      </span>
                    </span>
                    <span v-else>
                      <span class="text-danger">Role Not Assigned</span>
                    </span>
                  </td>
                  <td class="text-center">
                    <v-btn v-if="singleData.status" @click="statusChange(singleData)" color="btn_active"
                        depressed small>
                        <v-icon small left>mdi-check-circle-outline</v-icon> Active
                    </v-btn>

                    <v-btn v-else @click="statusChange(singleData)" color="btn_inactive" depressed small>
                        <v-icon small left>mdi-alert-circle-outline </v-icon> Inactive
                    </v-btn>

                    <v-btn
                      @click="editRoleModel(singleData)"
                      small
                      class="ma-1 btn_role"
                    >
                      <v-icon left>mdi-camera-control</v-icon>Role
                    </v-btn>

                    <v-btn
                      @click="editDataModel(singleData, 'Update User Info')"
                      small
                      class="ma-1 btn_edit"
                    >
                      <v-icon left>mdi-pencil-outline</v-icon>Edit
                    </v-btn>

                    <v-btn @click="deleteData(singleData.id)" small class="ma-1 btn_delete">
                      <v-icon left>mdi-delete-empty-outline</v-icon>Delete
                    </v-btn>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div>
            <span>Total Records: {{ totalValue }}</span>
          </div>
          <Bootstrap5Pagination
              :data="allData"
              @pagination-change-page="getResults"
              class="justify-content-end"
          />
        </div>

        <div v-else>
          <tbl-data-loader v-if="dataLoading" />
        </div>
        <data-not-available v-if="!totalValue && !dataLoading" />
      </v-card-text>

    </v-card>

    <!-- data modal start -->
    <v-dialog v-model="dataModal">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10">{{ dataModelTitle }}</v-col>
            <v-col cols="2">
              <v-btn
                @click="dataModal = false"
                color="btn_close lighten-1 white--text"
                small
                class="float-right"
              >
                <v-icon left dark>mdi-close-octagon</v-icon>Close
              </v-btn>
            </v-col>
          </v-row>
        </v-card-title>

        <v-card-text>
          <form @submit.prevent="editmode ? updateData() : createData()">

            <v-row>
              <v-col cols="4" lg="4">
                <v-text-field v-model="form.name" label="Full Name" placeholder="Enter Full Name" :error-messages="form.errors.get('name')">
                </v-text-field>
              </v-col>

              <v-col cols="4" lg="4">
                <v-text-field v-model="form.email" label="Email" placeholder="Enter Email" :error-messages="form.errors.get('email')"
                ></v-text-field>
              </v-col>

              <v-col cols="4" lg="4">
                <v-text-field v-model="form.phone" label="Mobile No" placeholder="Enter Mobile No" :error-messages="form.errors.get('phone')"
                ></v-text-field>
              </v-col>

              <v-col cols="4" lg="6" v-if="!editmode">
                <v-text-field v-model="form.password" label="Password" placeholder="Enter Password" :error-messages="form.errors.get('password')"
                ></v-text-field>
              </v-col>

              <v-col cols="4" lg="6" v-if="!editmode">
                <v-text-field v-model="form.password_confirm" label="Confirm Password" placeholder="Enter Confirm Password"
                ></v-text-field>
              </v-col>

              <hr />
              <v-col cols="12">
                <label>Assign Roles:</label>
                <v-row>
                  <!-- {{ currentRoles }} -->
                  <v-col
                    class="pa-0"
                    cols="6"
                    lg="3"
                    v-for="(role, index) in allRoles"
                    :key="index"
                  >
                    <v-checkbox
                      v-model="form.role_id"
                      :label="role.name"
                      color="success"
                      :value="role.id"
                      hide-details
                    ></v-checkbox>
                  </v-col>
                </v-row>
              </v-col>
              <hr />
              
              <v-btn v-show="editmode" type="'submit" block class="my-2 btn_update" :loading="dataLodaing">
                <v-icon left>mdi-pencil-outline</v-icon>Update
              </v-btn>
              <v-btn v-show="!editmode" type="submit" block class="my-2 btn_save" :loading="dataLodaing">
                <v-icon left> mdi-plus-box</v-icon>Create
              </v-btn>
            </v-row>
          </form>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- role model start -->
    <v-dialog v-model="roleDataModal">
      <v-card>
        <v-card-title class="justify-center">
          <v-row>
            <v-col cols="10">Update Role</v-col>
            <v-col cols="2">
              <v-btn
                @click="roleDataModal = false"
                color="btn_close lighten-1 white--text"
                small
                class="float-right"
              >
                <v-icon left dark>mdi-close-octagon</v-icon>Close
              </v-btn>
            </v-col>
          </v-row>
        </v-card-title>

        <v-card-text>
          <form @submit.prevent="updateRoleData()">
            <v-row>
                <v-col cols="12">
                  <label>Assign Roles:</label>
                  <v-row>
                    <!-- {{ currentRoles }} -->
                    <v-col
                      class="pa-0"
                      cols="6"
                      lg="3"
                      v-for="(role, index) in allRoles"
                      :key="index"
                    >
                      <v-checkbox
                        v-model="form.role_id"
                        :label="role.name"
                        color="success"
                        :value="role.id"
                        hide-details
                      ></v-checkbox>
                    </v-col>
                  </v-row>
                </v-col>
                <hr />
                <v-btn
                  type="submit"
                  block
                  class="my-2 btn_update"
                  :loading="dataLodaing"
                ><v-icon left>mdi-pencil-outline</v-icon>Update
                </v-btn>
            </v-row>
          </form>
        </v-card-text>
      </v-card>
    </v-dialog>

  </div>
</template>

<script>
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
// vform
import Form from 'vform'

export default {
  data() {
    return {
      //current page url
      currentUrl: "/admin/user",

      imagePathSm: "/images/admin/small/",
      imagePath: "/images/admin/",
      imageMaxSize: "2111775",

      // Form
      form: new Form({
        id: "",
        name: "",
        email: "",
        phone: "",
        password:"",
        role_id: [],
      }),

      allRoles: [],

    };
  },

  watch:{
   
  },

  methods:{

    getRoles(){
      axios.get(this.currentUrl + '/get-roles').then(response => {
        this.allRoles = response.data.get_all_roles;
      });
    },

    // Edit Data Modal
    editDataModel(singleData, title = null) {
      this.dataModal = true;
      this.editmode = true;
      this.dataModelTitle = title ? title : "Update Data";
      this.resetForm();
      this.form.fill(singleData);
      // Role
      this.form.role_id = [];
      singleData.roles.forEach((element) => {
        this.form.role_id.push(element.id);
      });

      console.log('role id = ', this.form.role_id);
      console.log(this.form.role_id, singleData.roles);
    
    },

    // Edit Dynamic Role Modal
    editRoleModel(singleData) {
      this.roleDataModal = true;
      this.resetForm();
      // this.form.fill(singleData);
      this.form.id = singleData.id
      // Role
      this.form.role_id = [];
      singleData.roles.forEach((element) => {
        this.form.role_id.push(element.id);
      });
    },

    //update role data with axios
    updateRoleData() {
        this.dataLodaing = true
        this.$progress.start()
        // request send and get response
        axios.put(this.currentUrl + '/role-update', {data: this.form}).then(response => {
            // Input field make empty
            this.resetForm()
            // modal hide
            this.roleDataModal = false
            this.dataLodaing = false

            // Refresh Tbl Data with current page
            this.getResults(this.currentPageNumber)
            this.$progress.finish()

            this.$swal.fire({
                title: "Success",
                text: response.data.msg,
                icon: response.data.icon,
            });
           
        }).catch(error=>{
            // this.dataModal = false;
            this.dataLodaing = false;
            this.$swal.fire("Failed!", 'Data not saved', "warning");
        });

    },

  },

  mounted() {
    this.$progress.start();
    // Fetch initial results
    this.getResults();
    this.getRoles();
    this.$progress.finish();
  }
};
</script>

<style>
</style>
