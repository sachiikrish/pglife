window.addEventListener("load", function(){
var signup_form = document.getElementById("signup_form");
signup_form.addEventListener("submit", function(event){
var xhr = new XMLHttpRequest();
var form_data = new FormData(signup_form);
//on success
xhr.addEventListener("load" , signup_success);
//on facing an error
xhr.addEventListener("error" , on_error);
//set up a request
xhr.open("POST" , "api/signup.php");
//send the form data along with the request
xhr.send(form_data);

document.getElementById("loading").style.display = "block";
event.preventDefault();

});

var login_form = this.document.getElementById("login_form");
login_form.addEventListener("submit", function (event){
var xhr = new XMLHttpRequest();
var form_data = new FormData(login_form);

//on success
xhr.addEventListener("load", login_success);
//on error
xhr.addEventListener("error", on_error);
xhr.open("POST", "api/login.php");
xhr.send(form_data);

document.getElementById("loading").style.display = "block";
xhr.preventDefault();
});
});

let signup_success = function(event){
document.getElementById("loading").style.display = "none";

var response  = JSON.parse(event.target.responseText);
if(response.success){
alert(response.message);
window.location.href = "index.php";
}
else {
    alert(response.message);
}
};

let login_success = function(event){
document.getElementById("loading").style.display = "none";

var response = JSON.parse(event.target.responseText);
if(response.success){
location.reload();
}
else {
    alert(response.message);
}
};

let on_error = function(event){
document.getElementById("loading").style.display = "none";
alert("Oops! Something went wrong!");
};