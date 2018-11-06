/**
 * Created by ym-purna pachhai on 3/28/16.
 */
// JavaScript Document
function loginfunction() {

    var x = document.getElementById("name").value;
    var p = document.getElementById("password").value;
    if(x!=null && p!=null){
        alert("Email and password not Matched!");
    }
}

function errormessage()
{
    alert("Email already taken!");
}



function successmessage()
{
    alert("You have successfully added into database!");
}
function checkPass()
{
    // var myBtn = document.getElementById('myBtn');
    //Store the password field objects into variables ...
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    //Store the Confimation Message Object ...
    var message = document.getElementById('confirmMessage');
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field
    //and the confirmation field
    if(pass1.value == pass2.value){
        document.getElementById("myBtn").disabled = false;

        //The passwords match.
        //Set the color to the good color and inform
        //the user that they have entered the correct password
        pass2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords Match!"

    }else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        pass2.style.backgroundColor = badColor;
        message.style.color = badColor;

    }
}
