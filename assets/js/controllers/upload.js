class Upload {
  static fileToBase64(event) {
    if(event.files.length == 0){
      toastr.error("Choose a file to upload!");
      return 0;
    }
    console.log(event.files);
    var f = event.files[0];
    var reader = new FileReader();
    // Closure to capture the file information.
    reader.onload = (function(theFile) {
        return function(e) {
            // Render thumbnail.

            var upload = {
               name: f.name,
               content: e.target.result.split(',')[1]
            };

            $("#upload-song-button").prop("disabled", true);

            $.ajax({
                url: "/api/admin/cdn",
                type: "POST",
                data: JSON.stringify(upload),
                contentType: "application/json",
                beforeSend: function(xhr){xhr.setRequestHeader('Authentication', localStorage.getItem("token"));},
                success: function(data) {
                  $("#upload-song-button").prop("disabled", false);
                  toastr.success("File uploaded successfully");
                  console.log(data);
                  $('#upload-img').attr('src',data.url);
                  $("#add-song *[name='song_url']").val(data.url);
                },
                error: function(jqXHR, textStatus, errorThrown ){
                  $("#upload-song-button").prop("disabled", false);
                  toastr.error(jqXHR.responseJSON.message);
                  console.log(jqXHR);
                }
             });
        };
    })(f);
    // Read in the image file as a data URL.
    reader.readAsDataURL(f);
  }
}
