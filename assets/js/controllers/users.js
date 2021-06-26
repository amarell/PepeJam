class User {
  static init(){
    $("#add-user").validate({
     submitHandler: function(form, event) {
       event.preventDefault();
       var data = PepeJamUtils.jsonize_form($(form));

       if(data.user_id === ""){
         delete data.user_id;
         User.add(data);
       }
       else{
         User.update(data);
       }
     }
    });
    User.get_all();
  }

  static get_all(){
    $("#users-table").DataTable({
      "processing": true,
      "serverSide": true,
      "bDestroy": true,
      "pagingType": "simple",
      "ajax": {
        url: "/api/admin/users?order=%2Buser_id",
        type: "GET",
        beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
        dataSrc: function(resp){
          return resp;
        },
        data: function ( d ) {

          d.offset = d.start;
          d.limit = d.length;
          d.search = d.search.value;
          d.order = encodeURIComponent((d.order[0].dir == "asc" ? "-" : "+")+d.columns[d.order[0].column].data);
          delete d.start;
          delete d.length;
          delete d.columns;
          delete d.draw;
          console.log(d);
        }
      },
      "preDrawCallback": function( settings ) {
        if(settings.jqXHR){
          settings._iRecordsTotal = settings.jqXHR.getResponseHeader("total-records");
          settings._iRecordsDisplay = settings.jqXHR.getResponseHeader("total-records");
        }
      },
      "language": {
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_",
            "infoEmpty": "No records available",
            "infoFiltered": ""
      },
      "responsive": true,
      "columns": [
            { "data": "user_id",
              "render": function ( data, type, row, meta ) {
                return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="User.pre_edit('+data+')"><i class="fa fa-edit"></i></a>';
              }
            },
            { "data": "username" },
            { "data": "password" },
            { "data": "email" },
            { "data": "status" },
            { "data": "token" },
            { "data": "created_at" },
            { "data": "role" }
        ]
      });
  }

  static add(user){
    RestClient.post("/api/admin/users", user, function(data){
      toastr.success("User has been added to the database!");
      User.get_all();
      $("#add-user").trigger("reset");
      $("#add-user-modal").modal("hide");
    });
  }

  static update(user){
    RestClient.put("/api/admin/user/"+user.user_id, user, function(data){
      toastr.success("User has been updated");
      User.get_all();
      $("#add-user").trigger("reset");
      $("#add-user *[name='user_id']").val("");
      $('#add-user-modal').modal("hide");
    });
  }

  static pre_edit(id){
    RestClient.get("/api/admin/user/"+id, function(data){
      PepeJamUtils.json2form("#add-user", data);
      $("#add-user-modal").modal("show");
    });
  }
}
