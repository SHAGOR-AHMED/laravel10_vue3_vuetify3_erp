import axios from "axios";

import { mapGetters } from 'vuex'

import paginateMethods from './paginate_methods'

import crudMethods from './crud'

import imageMethods from './image_methods'

export default {
    data() {
      return {
      
        paginate: 5,
        search: '',
        search_field: '',
        sex: '',
        sort_direction: 'desc',
        sort_field: 'id',
        currentPageNumber: null,
        // Our data object that holds the Laravel paginator data
        allData: {},
        totalValue: '',
        dataShowFrom: '',
        dataShowTo: '',

        pagination: {
            page: 1,
            total: 0,
            perPage: 0,
            pages:0,
        },

        editmode: false,
        roleDataModal: false,
        dataModal: false,
        dataModelTitle: '',
        // Loading Animation
        dataLoading: false,
        dataLodaing: false,

        imageMaxSize: '2111775',
        fileMaxSize: '5111775',

        // Tbl number of data show
        tblItemNumberShow: [5, 10, 15, 25, 50, 100],
        // v-form
        valid: false,

      }
    },

    methods: {
        
      //Pagination Methods
      ...paginateMethods,

      //CRUD Methods
      ...crudMethods,

      //Image Methods
      ...imageMethods,

    },

    watch: {

      //Excuted When make change value 
      paginate: function (value) {
          this.$progress.start();
          this.getResults();
          this.$progress.finish();
      },

      //Excuted When make change value 
      search: function (value) {
          this.$progress.start();
          this.getResults();
          this.$progress.finish();
      },

      //Excuted When make change value 
      search_field: function (value) {
          this.$progress.start();
          this.getResults();
          this.$progress.finish();
      }
       
    },

    created() {

    },

    mounted() {
 
    },

    destroyed() {

    },

    computed : {
      // map the auth data
      ...mapGetters({
          'auth'  : 'getAuth',
      }),

    },

  }