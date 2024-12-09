$(document).ready(function () {
  $("form#parser").submit(function (event) {
    let formData = {
      url: $("#url").val(),
      minWidth: $("#minwidth").val(),
      minHeight: $("#minheight").val(),
      text: $("#text").val(),
      action: 'parseIt',
    };

    $.ajax({
      type: "POST",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
        reloadCatalog();
    });

    event.preventDefault();
  });
});

reloadCatalog();

function reloadCatalog(){
    let formData = {
      action: 'getCatalog',
    };
    $.ajax({
      type: "POST",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function(data){
        let result = [];
        for(let k in data) {
           result += '<img src='+data[k]+'>';
        }
        $('#results').html(result);
    })
}
