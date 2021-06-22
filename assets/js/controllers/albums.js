class Album {
  static init(){
    $("#add-album").validate({
     submitHandler: function(form, event) {
       event.preventDefault();
       var data = PepeJamUtils.jsonize_form($(form));

       if(data.album_id === ""){
         delete data.album_id;
         Album.add(data);
       }
       else{
         Album.update(data);
       }
     }
    });
    Album.get_all();
  }

  static get_all(){
    $("#albums-table").DataTable({
      "processing": true,
      "serverSide": true,
      "bDestroy": true,
      "pagingType": "simple",
      "ajax": {
        url: "http://localhost:8080/api/user/albums?order=%2Bartist_id",
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
            { "data": "album_id",
              "render": function ( data, type, row, meta ) {
                return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Album.pre_edit('+data+')"><i class="fa fa-edit"></i></a>';
              }
            },
            { "data": "album_name" },
            { "data": "artist_id" }
        ]
      });
  }

  static add(album){
    RestClient.post("http://localhost:8080/api/admin/albums", album, function(data){
      toastr.success("Album has been added to the database!");
      Album.get_all();
      $("#add-album").trigger("reset");
      $("#add-album-modal").modal("hide");
    });
  }

  static update(album){
    RestClient.put("http://localhost:8080/api/admin/album/"+album.album_id, album, function(data){
      toastr.success("Album has been updated");
      Album.get_all();
      $("#add-album").trigger("reset");
      $("#add-album *[name='album_id']").val("");
      $('#add-album-modal').modal("hide");
    });
  }

  static pre_edit(id){
    RestClient.get("http://localhost:8080/api/user/album/"+id, function(data){
      PepeJamUtils.json2form("#add-album", data);
      $("#add-album-modal").modal("show");
    });
  }
}
