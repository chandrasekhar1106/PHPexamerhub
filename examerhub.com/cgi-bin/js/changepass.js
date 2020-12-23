// JavaScript Document
function validateform(mmyform)
{
    var em=/[a-zA-Z0-9]+@[a-zA-Z0-9]+.[a-zA-Z]+/;
    myform=document.forms[mmyform];
    if(myform.oldpass.value=="" || myform.newpass.value=="" || myform.cpass.value=="")
     {
         alert("Some of the fields are Empty.");
         return false;
         //  myform.onsubmit=false;
     }
     else if(myform.newpass.value!=myform.cpass.value)
         {
             alert("Passwords Donot Match!");
            // myform.onsubmit=false;
            return false;
         }
         else if(!em.test(myform.email.value))
             {
                 alert("Enter the E-mail Correctly!");
               //  myform.onsubmit=false;
                 return false;
             }


}