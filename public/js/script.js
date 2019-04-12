//var help = '<small id="passwordHelpBlock" class="form-text text-muted"> Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.</small>'

var emailHelp = $('#emailHelpBlock');
emailHelp.css('display', 'none');

function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}


function checkEmail(champ)
{
   var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
   if(!regex.test(champ.value))
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

checkEmail($('#email'));
