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
                  <td class="text-center">
                    <v-btn v-if="singleData.status" @click="statusChange(singleData)" color="btn_active"
                        depressed small>
                        <v-icon small left>mdi-check-circle-outline</v-icon> Active
                    </v-btn>

                    <v-btn v-else @click="statusChange(singleData)" color="btn_inactive" depressed small>
                        <v-icon small left>mdi-alert-circle-outline </v-icon> Inactive
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
          <!-- <pagination
            :data="allData"
            @pagination-change-page="getResults"
            class="justify-content-end"
          >
            <span slot="prev-nav">&lt; Previous</span>
            <span slot="next-nav">Next &gt;</span>
          </pagination> -->
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

  </div>
</template>

<script>
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
      }),

    };
  },

  watch:{
   
  },

  methods:{

  },

  mounted() {
    this.$Progress.start();
    // Fetch initial results
    this.getResults();
    this.$Progress.finish();
  }
};
</script>

<style>
</style>
