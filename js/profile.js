
var loggedInUser = localStorage.getItem('email')
// console.log(loggedInUser)
$.ajax({
    type: "GET",
    url: "php/profile.php",
    data: { email: loggedInUser },
    success: function (response) {
        // console.log(response);
        response = JSON.parse(response);
        var fullName;
        if (response.mongoUser && response.mongoUser.fullName) {
            fullName = response.mongoUser.fullName;

        } else if (response.sqlUser) {
            fullName = response.sqlUser.fname + " " + response.sqlUser.lname;
        }
        $("#user-name").text(fullName);
        $("#user-email").text(response.sqlUser.email);
        $("#name").val(fullName);
        $("#email").val(response.sqlUser?.email);
        $("#contact").val(response.mongoUser?.phone);
        $("#age").val(response.mongoUser?.age);
        $("#dob").val(response.mongoUser?.dob);
        $("#street").val(response.mongoUser?.Street);
        $("#city").val(response.mongoUser?.city);
        $("#state").val(response.mongoUser?.sTate);
        $("#zip").val(response.mongoUser?.zIp);
    },
    error: function (error) {
        console.log(error.responseText);
    },
});

function validate(e) {
    e.preventDefault();

    // var emailValid = validateEmail(document.getElementById("email").value);
    var params = {
        fullName: document.getElementById("name").value,
        phone: document.getElementById("contact").value,
        age: document.getElementById("age").value,
        dob: document.getElementById("dob").value,
        email: document.getElementById("email").value,
        street: document.getElementById("street").value,
        city: document.getElementById("city").value,
        state: document.getElementById("state").value,
        zip: document.getElementById("zip").value,
    };

    // console.log(params)


    $.ajax({
        type: "POST",
        url: "php/profile.php",
        data: params,
        success: function (response) {
            response = JSON.parse(response);
            // console.log(response);

            // if (response.data === "User already exists") {
            //     $("#errorMessage").text("*"+response.data);
            // } else {
            //     // console.log("Registered Successfully");
            //     // console.log(response);
            //     window.location.href="login.html"
            // }


            $("#user-name").text(response.user.fullName);
            $("#user-email").text(response.user.email);
            // $("#name").val(response.user.name);
            $("#contact").val(response.user.phone);
            $("#age").val(response.user.age);
            $("#email").val(response.user.email);



        },
        error: function (error) {
            console.log(error.responseText);
        },
    });
}

function logout() {
    $.ajax({
        type: "DELETE",
        url: "php/profile.php",
        success: function (response) {
            response = JSON.parse(response);
            // console.log(response);
            localStorage.removeItem('email');
            window.location.href = "login.html";
        },
        error: function (error) {
            console.log(error.responseText);
        },
    });
}

