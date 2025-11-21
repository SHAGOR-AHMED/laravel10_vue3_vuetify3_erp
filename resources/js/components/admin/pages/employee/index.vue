<template>
  <div>
    <v-card>
      <v-card-title class="justify-center">
        <v-row>
          <v-col cols="10">Employee(s) List</v-col>
          <v-col cols="2">
            <v-btn
              @click="addDataModal('Add New Employee')"
              class="btn_add float-right"
              small
            >
              <v-icon left>mdi-plus-circle-outline</v-icon>Add New Employee
            </v-btn>
          </v-col>
        </v-row>
      </v-card-title>

      <v-card-text>
        <div v-if="allData.data">
          <v-row>
            <v-col cols="6" lg="3">
              <v-select :items="tblItemNumberShow" dense v-model="paginate"></v-select>
            </v-col>

            <v-col cols="6" lg="3">
              <v-select v-model="sex" label="Gender:" :items="genders" item-text="text" item-value="value" dense>
              </v-select>
            </v-col>

            <v-col cols="6" lg="3">
              <v-select v-model="search_field" label="Search By:" :items="searchByFieldName" item-text="name" item-value="value" dense>
              </v-select>
            </v-col>

            <v-col cols="6" lg="3">
                <v-text-field v-model="search" placeholder="Search Input..." dense></v-text-field>
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
                        sort_direction == 'desc' && sort_field == 'employee_name'
                      "
                      >&uarr;</span
                    >
                    <span
                      v-if="
                        sort_direction == 'asc' && sort_field == 'employee_name'
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
                  <td>{{ singleData.employee_name }}, {{ singleData.mobile }}</td>
                  <td>{{ singleData.email }}</td>
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
          <pagination
            :data="allData"
            @pagination-change-page="getResults"
            class="justify-content-end"
          >
            <span slot="prev-nav">&lt; Previous</span>
            <span slot="next-nav">Next &gt;</span>
          </pagination>
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
              <v-col cols="3" lg="3">
                <v-text-field v-model="form.employee_name" label="Full Name" placeholder="Enter Full Name" :error-messages="form.errors.get('employee_name')">
                </v-text-field>
              </v-col>

              <v-col cols="3" lg="3">
                <v-text-field v-model="form.email" label="Email" placeholder="Enter Email" :error-messages="form.errors.get('email')"
                ></v-text-field>
              </v-col>

              <v-col cols="3" lg="3">
                <v-text-field v-model="form.mobile" label="Mobile Number" placeholder="Enter Mobile Number" :error-messages="form.errors.get('mobile')" :rules="employeeRules" required></v-text-field>
              </v-col>

              <!-- <v-col cols="3" lg="3">
                <v-radio-group v-model="form.gender" label="Gender" row :error-messages="form.errors.get('gender')">
                    <v-radio label="Male" :value="1"></v-radio>
                    <v-radio label="Female" :value="2"></v-radio>
                </v-radio-group>
              </v-col> -->

              <v-col cols="3" lg="3">
                <v-radio-group v-model="form.gender" label="Gender" row :error-messages="form.errors.get('gender')">
                  <v-radio v-for="n in genders" :key="n.value" :label="n.text" :value="n.value"></v-radio>
                </v-radio-group>
              </v-col>

              <v-col cols="3" lg="3">
                <v-select :items="employeeType" item-text="name" item-value="id" placeholder="Employment Type" :error-messages="form.errors.get('e_type')" label="Employment Type" v-model="form.e_type"></v-select>
              </v-col>

              <v-col cols="3" lg="3">
                <v-combobox
                    v-model="form.e_skills"
                    :items="items"
                    label="Skills"
                    placeholder="Select Skills"
                    multiple
                    chips
                    :error-messages="form.errors.get('e_skills')"
                  >
                    <template v-slot:selection="data">
                      <v-chip
                        :key="JSON.stringify(data.item)"
                        v-bind="data.attrs"
                        :input-value="data.selected"
                        :disabled="data.disabled"
                        @click:close="data.parent.selectItem(data.item)"
                      >
                        <v-avatar
                          class="accent white--text"
                          left
                          v-text="data.item.slice(0, 1).toUpperCase()"
                        ></v-avatar>
                        {{ data.item }}
                      </v-chip>
                    </template>
                </v-combobox>
              </v-col>

              <v-col cols="3" lg="3">
                <v-menu
                  ref="abc"
                  v-model="mytime"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="time"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="form.created_time"
                      label="Time Picker"
                      prepend-icon="mdi-clock-time-four-outline"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-time-picker
                    v-if="mytime"
                    v-model="form.created_time"
                    full-width
                    @click:minute="$refs.abc.save(time)"
                  ></v-time-picker>
                </v-menu>
              </v-col>

              <v-col cols="3">
                  <v-menu v-model="menu" min-width="auto">
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field v-model="form.created_date" label="Select Date" prepend-icon="mdi-calendar"
                            readonly v-bind="attrs" v-on="on"></v-text-field>
                    </template>
                    <v-date-picker v-model="form.created_date" no-title scrollable>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="menu = false">
                            Cancel
                        </v-btn>
                    </v-date-picker>
                </v-menu>
              </v-col>

              <v-col cols="12">
                <label>Sports:</label>
                <v-row>
                  <!-- {{ currentRoles }} -->
                  <v-col
                    class="pa-0"
                    cols="6"
                    lg="3"
                    v-for="(sport, index) in sports"
                    :key="index"
                  >
                    <v-checkbox
                      v-model="form.sports"
                      :label="sport.text"
                      :value="sport.value"
                      color="success"
                      hide-details
                      :error-messages="form.errors.get('sports')"
                    ></v-checkbox>
                  </v-col>
                </v-row>
              </v-col>
              <hr />

              <!-- <v-row>
                <v-col cols="12" lg="12">
                  <v-checkbox v-model="form.sports" v-for="n in sports" :key="n.value" :label="n.text" :value="n.value" :error-messages="form.errors.get('sports')" multiple></v-checkbox>
                </v-col>
              </v-row> -->

              <v-row>
                <v-col cols="12" lg="12">
                  <v-textarea  rows="2" v-model="form.others" label="Others (if any)" placeholder="Enter Employee Additional Info" :error-messages="form.errors.get('others')"></v-textarea>
                </v-col>
              </v-row>

              <v-row>
                  <!-- Image 1 -->
                  <v-col md="4">
                      <v-file-input prepend-icon="mdi-camera" @change="uploadImageByName($event, 'image')"
                          label="Choose 1st Image" size="sm" accept=".jpg, .png, .jpeg">
                      </v-file-input>
                  </v-col>
              </v-row>

              <v-row class="mb-2">
                  <v-col md="4">
                      <img :src="showImageByName('image')"
                          class="rounded mx-auto d-block image-thum-size" />
                  </v-col>
              </v-row>

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
import Form from "vform";

export default {
  data() {
    return {
      //current page url
      currentUrl: "/admin/employee",

      imagePathSm: "/images/employee/small/",
      imagePath: "/images/employee/",
      imageMaxSize: "2111775",

      //date picker
      show: '',
      created_date:'',
      menu: false,

      //time picker
      time: null,
      mytime: false,

      employeeRules: [v => !!v || 'This field is required!'],

      employeeType: [
					{
              name: 'Permanent',
              id: 1
          },
          {
              name: 'Intern',
              id: 0
          },
      ],

      searchByFieldName:[
        {
            name: 'Mobile No',
            value: 'mobile',
        },
        {
            name: 'Email',
            value: 'email',
        },
      ],

      genders: [
					{
              text: 'Male',
              value: 1
          },
          {
              text: 'Female',
              value: 2
          },
      ],

      sports: [
					{
              text: 'Cricket',
              value: 'Cricket'
          },
          {
              text: 'Football',
              value: 'Football'
          },
          {
              text: 'Chess',
              value: 'Chess'
          },
      ],

      items: [
        'Programming',
        'Design',
        'Vue',
        'Vuetify',
      ],

      // Form
      form: new Form({
        id: "",
        employee_name: "",
        email: "",
        mobile:"",
        gender:"",
        e_type:"",
        e_skills:[],
        sports:[],
        image:"",
        others:"",
        created_time:'',
        created_date:'',
      }),

    };
  },

  watch:{
   
  },

  methods:{

    // Edit Data Modal
    editDataModel(singleData, title=null) {
       
       this.dataModelTitle = title ? title : 'Update Data'
       this.resetForm();
       this.form.fill(singleData);
       //console.log(this.form.e_skills, this.form.e_skills.split(","));
       if(this.form.e_skills){
         this.form.e_skills = this.form.e_skills.split(",");
       }
       if(this.form.sports){
         this.form.sports = this.form.sports.split(",");
       }
       this.dataModal = true;
       this.editmode = true;
    },

  },

  mounted() {
    this.$Progress.start();
    // Fetch initial results
    this.getResults();
    this.$Progress.finish();
  }
};
</script>

<style scoped>
  .image-thum-size {
      height: 50px;
      width: 100px;
  }

</style>
