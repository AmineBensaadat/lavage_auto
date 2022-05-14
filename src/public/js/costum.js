// this is the id of the form
$("#order_form").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.
    alert("eeee");
    // var form = $(this);
    // var actionUrl = form.attr('action');
    
    // $.ajax({
    //     type: "POST",
    //     url: actionUrl,
    //     data: form.serialize(), // serializes the form's elements.
    //     success: function(data)
    //     {
    //       alert(data); // show response from the php script.
    //     }
    // });
    
});