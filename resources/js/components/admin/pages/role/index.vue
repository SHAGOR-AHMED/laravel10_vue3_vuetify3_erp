<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <v-row>
          <v-col cols="10">Role(s) List</v-col>

          <v-col cols="2">
            <v-btn
              @click="addDataModal('Add New Role')"
              class="btn_add float-right"
              small
            >
              <v-icon left>mdi-plus-circle-outline</v-icon>Add New Role
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

            <v-menu
              bottom
              origin="center center"
              transition="scale-transition"
            >
              <template v-slot:activator="{ props }">
                <v-btn
                  color="btn_add"
                  v-bind="props"
                  dark
                  :disabled="!isSelected"
                >
                  Bulk Options
                </v-btn>
              </template>
              <v-list>
                <v-list-item>
                  <v-list-item-title>
                    <v-btn @click="deleteAll(selected)" small class="ma-1 btn_delete">
                      <v-icon left>mdi-delete-empty-outline</v-icon>Delete All
                    </v-btn>
                  </v-list-item-title>
                </v-list-item>
              </v-list>
            </v-menu>

          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th>
                    <v-checkbox @click="checkedAll()" v-model="selectedAll"></v-checkbox>
                  </th>
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
                      >Role Name</a
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
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="singleData in allData.data" :key="singleData.id">
                  <td><v-checkbox :value="singleData.id" v-model="selected"></v-checkbox></td>
                  <td>{{ singleData.id }}</td>
                  <td>{{ singleData.name }}</td>
                  <td class="text-center" v-if="!singleData.used_role">
                    <v-btn
                      @click="editDataModel(singleData, 'Update Role Info')"
                      small
                      class="ma-1 btn_edit"
                    >
                      <v-icon left>mdi-pencil-outline</v-icon>Edit
                    </v-btn>
                    <v-btn @click="deleteData(singleData.id)" small class="ma-1 btn_delete">
                      <v-icon left>mdi-delete-empty-outline</v-icon>Delete
                    </v-btn>
                  </td>
                  <td v-else>
                    <span class="text-danger"> Role Already Assigned </span>
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

          <div class="text-center">
            <v-pagination
              v-model="pagination.page"
              :length="pagination.pages"
              @input = "getResults"
              prev-icon="mdi-menu-left"
              next-icon="mdi-menu-right"
              circle
            ></v-pagination>
          </div>

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
            <v-text-field
              v-model="form.name"
              label="Enter Role Name"
              :error-messages="form.errors.get('name')"
            ></v-text-field>

            <v-btn
              v-show="editmode"
              type="submit"
              block
              class="my-2 btn_update"
              :loading="dataLodaing"
            ><v-icon left>mdi-pencil-outline</v-icon>Update</v-btn>
            <v-btn
              v-show="!editmode"
              type="submit"
              block
              class="my-2 btn_save"
              :loading="dataLodaing"
            ><v-icon left> mdi-plus-box</v-icon>Create</v-btn>
          </form>
        </v-card-text>
      </v-card>
    </v-dialog>

  </div>
</template>

<script>
// vform
import Form from "vform";
import axios from 'axios';
export default {
  data() {
    return {

      //current page url
      currentUrl: "/admin/role",
      imagePathSm: "/images/admin/small/",
      imagePath: "/images/admin/",
      imageMaxSize: "2111775",

      // Form
      form: new Form({
        id: "",
        name: "",
      }),

      selected:[],
      selectedAll: false,
      isSelected: false,

    };
  },

  watch:{
    selected: function (selected) {
        this.isSelected = (selected.length > 0);
        this.selectedAll = (selected.length == this.allData.data.length);
    },
  },

  methods:{

    checkedAll(){
      if(this.selectedAll == false){
        this.selected = [];
      }else{
        this.allData.data.forEach(bulkrole =>{
          this.selected.push(bulkrole.id);
        });
      }
    },

    deleteAll(selected){

      this.$swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            // Send request to the server
            if (result.value) {
                this.$progress.start();
                axios.post(this.currentUrl + '/delete-all', { data:selected }).then(response =>{
                  this.selected = [];
                  this.selectedAll = false;
                  this.$swal.fire(
                        'Deleted!',
                        response.data.total + ' ' + 'files has been deleted.',
                        'success'
                    );
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$progress.finish();

                }).catch((data) => {
                    this.$swal.fire("Failed!", data.message, "warning");
                });
            }

        })
      
    },

  },

  mounted() {
    this.$progress.start();
    // Fetch initial results
    this.getResults();
    this.$progress.finish();
  }
};
</script>

<style>

    /* vuetify pagination css */
		.v-pagination__item {
			background-color: #5cb85c !important;
			color: white !important;
			border-color: #5cb85c !important;
		}

    .v-pagination__item:hover{
			background-color: #000 !important;
			color: white !important;
      transition: all 0.3s ease-out;
		}

    .v-pagination__item:focus {
			background-color: red !important;
			color: white !important;
      text-decoration: underline;
		}

    /* laravel-vue-pagination */

    .justify-content-end{
      justify-content: center !important;
    }

    .page-link {
			background-color: #5cb85c !important;
			color: white !important;
			border-color: #5cb85c !important;
      margin: 0px 5px 0px 5px;
      border-radius: 50px;
		}

    .page-link:hover{
			background-color: #000 !important;
			color: white !important;
      transition: all 0.3s ease-out;
		}

    .page-link:focus {
			background-color: red !important;
			color: white !important;
      text-decoration: underline;
		}

</style>