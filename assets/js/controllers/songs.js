class Song {
  static init(){
    $("#add-song").validate({
     submitHandler: function(form, event) {
       event.preventDefault();
       var data = PepeJamUtils.jsonize_form($(form));

       if(data.song_id === ""){
         delete data.song_id;
         Song.add(data);
       }
       else{
         Song.update(data);
       }
     }
    });
    Song.get_all();
  }

  static get_all(){
    $("#songs-table").DataTable({
      "processing": true,
      "serverSide": true,
      "bDestroy": true,
      "pagingType": "simple",
      "ajax": {
        url: "http://localhost:8080/api/songs?order=%2Bsong_id",
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
            { "data": "song_id",
              "render": function ( data, type, row, meta ) {
                return '<span class="badge">'+data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Song.pre_edit('+data+')"><i class="fa fa-edit"></i></a>';
              }
            },
            { "data": "song_name",
              "render": function ( data, type, row, meta ) {
                return data+'</span><a class="pull-right" style="font-size: 15px; cursor: pointer;" onclick="Song.play('+row.song_id+')"><i class="fas fa-play"></i></a>';
              }
            },
            { "data": "song_duration" },
            { "data": "number_of_plays" },
            { "data": "artist_id" }
        ]
      });
  }

  static play(song_id){
    RestClient.get("http://localhost:8080/api/song/"+song_id, function(data){
      console.log(data);
      var audio = document.getElementById("audioPlayer");
      var source = document.getElementById("song-url-source");
      source.src = data.song_url;
      audio.load();

      if(data.cover_url == null){
          $("#cover-image").attr("src", "https://image.flaticon.com/icons/png/512/4313/4313261.png");
      } else {
        $("#cover-image").attr("src", data.cover_url);
      }
      
      RestClient.get("http://localhost:8080/api/artist/"+data.artist_id, function(result){
        var artist = result.artist_name;
        console.log(artist);
        $("#play-song-modal-song-title").text(data.song_name + " - " + artist);
      });

      $("#play-song-modal").modal("show");
    });
  }

  static add(song){
    RestClient.post("http://localhost:8080/api/songs", song, function(data){
      toastr.success("Song has been added to the database!");
      Song.get_all();
      $("#add-song").trigger("reset");
      $("#add-song-modal").modal("hide");
    });
  }

  static update(song){
    RestClient.put("http://localhost:8080/api/song/"+song.song_id, song, function(data){
      toastr.success("Song has been updated");
      Song.get_all();
      $("#add-song").trigger("reset");
      $("#add-song *[name='song_id']").val("");
      $('#add-song-modal').modal("hide");
    });
  }

  static pre_edit(id){
    RestClient.get("http://localhost:8080/api/song/"+id, function(data){
      PepeJamUtils.json2form("#add-song", data);
      $("#add-song-modal").modal("show");
    });
  }
}
