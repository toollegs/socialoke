<html><head><title>AJAX PHP test</title>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
<form id="foo">

    <label for="bar">A bar</label>
    <input id="bar" name="bar" type="text" value="" />

    <input type="submit" value="Send" />

</form>
<script/>
var request;
// bind to the submit event of our form
$("#foo").submit(function(event){
    // abort any pending request
    alert("Yup");
    if (request) {
        request.abort();
    }
    alert("Yup");
    // setup some local variables
    var $form = $(this);
    // let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");
    // serialize the data in the form
    var serializedData = $form.serialize();

    // let's disable the inputs for the duration of the ajax request
    $inputs.prop("disabled", true);

    // fire off the request to /form.php
    request = $.ajax({
        url: "/beta/test/form.php",
        type: "post",
        data: serializedData
    });

    // callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // log a message to the console
        console.log("Hooray, it worked!");
    });

    // callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // log the error to the console
        console.error(
            "The following error occured: "+
            textStatus, errorThrown
        );
    });

    // callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // reenable the inputs
        $inputs.prop("disabled", false);
    });

    // prevent default posting of form
    event.preventDefault();
});
</script>
</body>
</html>
