export default {

    // Create Data
    createData() {
        this.dataLodaing = true;
        this.$progress.start()
        // request send and get response
        this.form.post(this.currentUrl + '/store' + '').then(response => {
            // Input field make empty
            this.resetForm();
            
            // modal hide
            this.dataModal = false;
            this.dataLodaing = false;

            // Refresh Tbl Data with current page
            this.getResults(this.currentPageNumber);
            this.$progress.finish();

            // Toast.fire({
            //     icon: response.data.icon,
            //     title: response.data.msg
            // });

            this.$swal.fire({
                title: "Success",
                text: response.data.msg,
                icon: response.data.icon,
            });

        }).catch(error=>{
            //this.dataModal = false;
            this.dataLodaing = false;
            // this.$toast.fire({
            //     icon: "warning",
            //     title: "Data not saved",
            // });
            this.$swal.fire("Failed!", 'Data not saved', "warning");
        });

    },


    // Update data
    updateData() {
        this.dataLodaing = true
        this.$progress.start()
        // request send and get response
        this.form.put(this.currentUrl + '/update').then(response => {
            
            // Input field make empty
            this.resetForm()
            // modal hide
            this.dataModal = false
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
    

    // Delete Data
    deleteData(id) {
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
                //console.log(id);
                this.$progress.start();
                this.form.delete(this.currentUrl + '/destroy/' + id).then((response) => {
                    //console.log(response);
                    this.$swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
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


    // Delete DataDirict Data without form
    deleteDataDirict(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            // Send request to the server
            if (result.value) {
                //console.log(id);
                this.$progress.start();
                axios.delete(this.currentUrl + '/destroy/' + id).then((response) => {
                    //console.log(response);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    );
                    // Refresh Tbl Data with current page
                    this.getResults(this.currentPageNumber);
                    this.$progress.finish();

                }).catch((data) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Somthing Going Wrong<br>'+data.message,
                        customClass: 'text-danger'
                    });
                    // Swal.fire("Failed!", data.message, "warning");
                });
            }
        })
    },

    // Change Status
    statusChange(data) {

        if (data.status == 1) {
            var text = "Are you want to inactive ?"
            var btnText = "Inactive"

        } else {
            var text = "Are you want to active ?"
            var btnText = "Active"
        }

        this.$swal.fire({
            title: 'Are you sure?',
            text: text,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: btnText,
        }).then((result) => {

            // Send request to the server
            if (result.value) {
                //console.log(id);
                this.$progress.start();
                axios.post(this.currentUrl + '/status/' + data.id).then((response) => {
                    //console.log(response);
                    this.$swal.fire(
                        'Changed!',
                        'Status has been Changed.',
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


    // Add Data Model
    addDataModal(title=null) {
        this.dataModelTitle = title ? title : 'Store Data'
        this.dataModal = true;
        this.editmode = false;
        this.resetForm(); 
    },

    // Edit Data Modal
    editDataModel(singleData, title=null) {
        this.dataModal = true;
        this.editmode = true;
        this.dataModelTitle = title ? title : 'Update Data'
        this.resetForm();
        this.form.fill(singleData);
    },

    // reset form
    resetForm(){
        this.form.reset();
        // this.$refs.form.resetValidation();
        this.form.errors.clear();
    }


}
