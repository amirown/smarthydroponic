$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='registration']").validate({
      // Specify validation rules
      rules: {
        // The key name on the left side is the name attribute
        // of an input field. Validation rules are defined
        // on the right side
        firstname: "required",
        email: {
          required: true,
          // Specify that email should be validated
          // by the built-in "email" rule
          email: true
        },
        password: {
          required: true,
          minlength: 5
        },
        message: {
          required:true
        }
      },
      // Specify validation error messages
      messages: {
        firstname: "Please enter your name",
        email: "Please enter a valid email address",
        message: "Message is required...."
      },
      // Make sure the form is submitted to the destination defined
      // in the "action" attribute of the form when valid
      submitHandler: function(form) {
        form.submit(
          alert("you have succsessfully submit your message."));
      }
    });
  });
  