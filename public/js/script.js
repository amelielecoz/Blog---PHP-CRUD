//document.getElementById('emailHelpBlock')
const emailHelp = $('#emailHelpBlock');
const passwordHelp = $('#passwordHelpBlock');
emailHelp.css('display', 'none');

const regexFirstName = /^[a-zA-Z._-]/;

const regexEmail = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
const regexPassword = /^\S*(?=\S{8,30})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/;


$('#email').blur(function () {
   if (!regexEmail.test(this.value)) {
      this.style.backgroundColor = "#fba";
      emailHelp.css('display', 'block');
   } else {
      this.style.backgroundColor = "#fff";
      emailHelp.css('display', 'none');
   }
});
$('#email').focus(function () {
   this.style.backgroundColor = "#fff";
   emailHelp.css('display', 'none');
});

$('#password1').blur(function () {
   if (!regexPassword.test(this.value)) {
      this.style.backgroundColor = "#fba";
      passwordHelp.css('display', 'block');
   } else {
      this.style.backgroundColor = "#fff";
      passwordHelp.css('display', 'none');
   }
});
$('#password1').focus(function () {
   this.style.backgroundColor = "#fff";
   passwordHelp.css('display', 'none');
});

$('#reportComment').on('show.bs.modal', function (event) {
   var button = $(event.relatedTarget) // Button that triggered the modal
   var recipient = button.data('whatever') // Extract info from data-* attributes
   // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
   // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
   var modal = $(this)
   modal.find('.modal-title').text(recipient)
   modal.find('.modal-body input').val(recipient)
})

$('#exampleModal').on('show.bs.modal', function (event) {
   var button = $(event.relatedTarget) // Button that triggered the modal
   var recipient = button.data('whatever') // Extract info from data-* attributes
   // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
   // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
   var modal = $(this)
   modal.find('.modal-title').text('New message to ' + recipient)
   modal.find('.modal-body input').val(recipient)
})


function confirmationReport() {
   reportPost = "Etes-vous sûr(e) de vouloir signaler ce commentaire aux modérateurs ?";
   return confirm(reportPost);
}

function confirmationDelete() {
   deletePost = "Etes-vous sûr(e) de vouloir supprimer cet article ?";
   return confirm(deletePost);
}

$(document).ready(function () {
   $("#show_hide_password span").on('click', function (event) {
      event.preventDefault();
      if ($('#show_hide_password input').attr("type") == "text") {
         $('#show_hide_password input').attr('type', 'password');
         $('#show_hide_password i').addClass("fa-eye-slash");
         $('#show_hide_password i').removeClass("fa-eye");
      } else if ($('#show_hide_password input').attr("type") == "password") {
         $('#show_hide_password input').attr('type', 'text');
         $('#show_hide_password i').removeClass("fa-eye-slash");
         $('#show_hide_password i').addClass("fa-eye");
      }
   });
});