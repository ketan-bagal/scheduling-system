function validateLoginForm() 
{	
    var username = document.forms["login"]["username"].value;
    if (username == null || username == "") 
	{
        return ("Username must be filled out.");
    }
	
	var password = document.forms["login"]["password"].value;
    if (password == null || password == "") 
	{
        return ("Password must be filled out.");
    }
}


function validateRegisterForm() 
{
    var username = document.forms["register"]["usernamesignup"].value;
    if (username == null || username == "") 
	{
        return ("Username must be filled out.");
    }
	
	var email = document.forms["register"]["emailsignup"].value;
    if (email == null || email == "") 
	{
        return ("Email must be filled out.");
    }
	
	var x = email;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) 
	{
        return ("Not a valid e-mail address");
    }
	
	var password = document.forms["register"]["passwordsignup"].value;
    if (password == null || password == "") 
	{
        return ("Password must be filled out.");
    }
	
    if (password.length < 5) 
	{
        return ("Password is too short. It should be at least 5 characters long.");
    }
	
	var password_confirm = document.forms["register"]["passwordsignup_confirm"].value;
    if (password_confirm == null || password_confirm == "") 
	{
        return ("Password confirmation must be filled out.");
    }
	
	if (password_confirm != password) 
	{
        return ("Passwords do not match.");
    }
	
}


