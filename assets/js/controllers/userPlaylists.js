class UserPlaylist {
  static init(){
    $("#add-user-playlist").validate({
     submitHandler: function(form, event) {
       event.preventDefault();
       var data = PepeJamUtils.jsonize_form($(form));

       if(data.playlist_id === ""){
         delete data.playlist_id;
         UserPlaylist.add(data);
       }
       else{
         UserPlaylist.update(data);
       }
     }
    });
    var user_info = PepeJamUtils.parse_jwt(window.localStorage["token"]);
    $("#add-user-playlist *[name='user_id']").val(user_info["id"]);
    UserPlaylist.get_all();
  }

  static get_all(){
    $("#user-playlists-table").DataTable({
      "processing": true,
      "serverSide": true,
      "bDestroy": true,
      "pagingType": "simple",
      "ajax": {
        url: "http://localhost:8080/api/user/playlists?order=%2Bplaylist_id",
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
                return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="UserPlaylist.pre_edit('+data+')"><i class="fa fa-edit"></i></a>';
              }
            },
            { "data": "name" }
        ]
      });
  }

  static add(playlist){
    RestClient.post("http://localhost:8080/api/user/playlists", playlist, function(data){
      toastr.success("Playlist has been added to the database!");
      UserPlaylist.get_all();
      $("#add-user-playlist").trigger("reset");
      $("#add-user-playlist-modal").modal("hide");
    });
  }

  static update(playlist){
    RestClient.put("http://localhost:8080/api/user/playlist/"+playlist.playlist_id, playlist, function(data){
      toastr.success("Playlist has been updated");
      UserPlaylist.get_all();
      $("#add-user-playlist").trigger("reset");
      $("#add-user-playlist *[name='playlist_id']").val("");
      $('#add-user-playlist-modal').modal("hide");
    });
  }

  static pre_edit(id){
    RestClient.get("http://localhost:8080/api/playlist/"+id, function(data){
      PepeJamUtils.json2form("#add-user-playlist", data);
      $("#add-user-playlist-modal").modal("show");
    });
  }
}
