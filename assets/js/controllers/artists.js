class Artist {
  static init(){
    $("#add-artist").validate({
     submitHandler: function(form, event) {
       event.preventDefault();
       var data = PepeJamUtils.jsonize_form($(form));

       if(data.artist_id === ""){
         delete data.artist_id;
         Artist.add(data);
       }
       else{
         Artist.update(data);
       }
     }
    });
    Artist.get_all();
  }

  static get_all(){
    $("#artists-table").DataTable({
      "processing": true,
      "serverSide": true,
      "bDestroy": true,
      "pagingType": "simple",
      "ajax": {
        url: "http://localhost:8080/api/artists?order=%2Bartist_id",
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
            { "data": "artist_id",
              "render": function ( data, type, row, meta ) {
                return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Artist.pre_edit('+data+')"><i class="fa fa-edit"></i></a>';
              }
            },
            { "data": "artist_name" },
            { "data": "number_of_followers" }
        ]
      });
  }

  static add(artist){
    RestClient.post("http://localhost:8080/api/admin/artists", artist, function(data){
      toastr.success("Artist has been added to the database!");
      Artist.get_all();
      $("#add-artist").trigger("reset");
      $("#add-artist-modal").modal("hide");
    });
  }

  static update(artist){
    RestClient.put("http://localhost:8080/api/admin/artist/"+artist.artist_id, artist, function(data){
      toastr.success("Artist has been updated");
      Artist.get_all();
      $("#add-artist").trigger("reset");
      $("#add-artist *[name='artist_id']").val("");
      $('#add-artist-modal').modal("hide");
    });
  }

  static pre_edit(id){
    RestClient.get("http://localhost:8080/api/artist/"+id, function(data){
      PepeJamUtils.json2form("#add-artist", data);
      $("#add-artist-modal").modal("show");
    });
  }
}
