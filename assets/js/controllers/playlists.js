class Playlist {
  static init(){
    $("#add-playlist").validate({
     submitHandler: function(form, event) {
       event.preventDefault();
       var data = PepeJamUtils.jsonize_form($(form));

       if(data.playlist_id === ""){
         delete data.playlist_id;
         Playlist.add(data);
       }
       else{
         Playlist.update(data);
       }
     }
    });
    Playlist.get_all();
  }

  static get_all(){
    $("#playlists-table").DataTable({
      "processing": true,
      "serverSide": true,
      "bDestroy": true,
      "pagingType": "simple",
      "ajax": {
        url: "/api/admin/playlists?order=%2Bplaylist_id",
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
            { "data": "playlist_id",
              "render": function ( data, type, row, meta ) {
                return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Playlist.pre_edit('+data+')"><i class="fa fa-edit"></i></a>';
              }
            },
            { "data": "name" },
            { "data": "user_id" }
        ]
      });
  }

  static add(playlist){
    RestClient.post("/api/admin/playlists", playlist, function(data){
      toastr.success("Playlist has been added to the database!");
      Playlist.get_all();
      $("#add-playlist").trigger("reset");
      $("#add-playlist-modal").modal("hide");
    });
  }

  static update(playlist){
    RestClient.put("/api/admin/playlist/"+playlist.playlist_id, playlist, function(data){
      toastr.success("Playlist has been updated");
      Playlist.get_all();
      $("#add-playlist").trigger("reset");
      $("#add-playlist *[name='playlist_id']").val("");
      $('#add-playlist-modal').modal("hide");
    });
  }

  static pre_edit(id){
    RestClient.get("/api/admin/playlist/"+id, function(data){
      PepeJamUtils.json2form("#add-playlist", data);
      $("#add-playlist-modal").modal("show");
    });
  }
}
