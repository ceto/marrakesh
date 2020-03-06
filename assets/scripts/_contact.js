/*** CONTACT FORM ******/
$("#request_form").on("submit", function(ev, frm) {
    ev.preventDefault();

    // alert("elcsipve");

    //get input field values
    var user_name = $("input[name=r_name]").val();
    var user_email = $("input[name=r_email]").val();
    var user_tel = $("input[name=r_tel]").val();
    var user_msg = $("textarea[name=r_message]").val();
    var user_product = $("input[name=r_product]").val();
    var user_amount = $("input[name=r_amount]").val();
    var user_time = $("input[name=r_time]").val();

    var proceed = true;

    if (user_name === "") {
        proceed = false;
    }
    if (user_email === "") {
        proceed = false;
    }

    if (user_tel === "") {
        proceed = false;
    }

    if ($("input:checkbox[name=r_acceptgdpr]:checked").length < 1) {
        proceed = false;
    }

    //everything looks good! proceed...
    if (proceed) {
        //data to be sent to server
        var post_data = {
            userName: user_name,
            userEmail: user_email,
            userTel: user_tel,
            userMsg: user_msg,
            userProduct: user_product,
            userAmount: user_amount,
            userTime: user_time
        };
        $("#contact_submit").addClass("disabled");
        $("#contact_submit").attr("disabled", "disabled");

        //Ajax post data to server
        $.post(
            $("#request_form").attr("action"),
            post_data,
            function(response) {
                var output = "";

                //load json data from server and output message
                if (response.type === "error") {
                    output = '<p class="itsnotok">' + response.text + "</p>";
                    console.log(response.text);
                } else {
                    output = '<p class="itsok">' + response.text + "</p>";
                    $("#request_form").addClass("is-alreadysent");
                    $("#successresult").prepend(output);
                    $("#successresult").addClass("is-active");

                    var fn = window.gtag;
                    if (typeof fn === "function") {
                        gtag("event", "sent", {
                            event_category: "requestform"
                        });
                        console.log("Gtag event fired");
                    } else {
                        console.log("No global gtag defined");
                    }
                    //reset values in all input fields
                    $("#request_form input").val("");
                    $("#request_form textarea").val("");
                }
                $("#result")
                    .hide()
                    .html(output)
                    .slideDown();
                $("#contact_submit").removeClass("disabled");
                $("#contact_submit").removeAttr("disabled");
            },
            "json"
        );
    }

    return false;
});

//reset previously set border colors and hide all message on .keyup()
$(
    "#request_form input, #request_form textarea, #request_form #r_acceptgdpr"
).keyup(function() {
    $("#result").slideUp();
    $("#formerror").slideUp();
});

$("#request_form #r_acceptgdpr").on("change", function() {
    $("#result").slideUp();
    $("#formerror").slideUp();
});
