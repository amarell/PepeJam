class PepeJamUtils {
  static jsonize_form(selector) {
    var data = $(selector).serializeArray();

    var form_data = {};

    for(var i=0; i<data.length; i++){
      form_data[data[i].name] = data[i].value;
    }

    return form_data;
  }

  static json2form(selector, data) {
    for (const attr in data){
       $(selector+" *[name='"+attr+"']").val(data[attr]);
    }
  }

  static parse_jwt (token) {
      var base64Url = token.split('.')[1];
      var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
      var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
          return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
      }).join(''));
      return JSON.parse(jsonPayload);
  }
}
