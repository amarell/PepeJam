function jsonize_form(selector) {
  var data = $(selector).serializeArray();

  var form_data = {};

  for(var i=0; i<data.length; i++){
    form_data[data[i].name] = data[i].value;
  }

  return form_data;
}
