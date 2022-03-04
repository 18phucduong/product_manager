$().ready(function() {
	$("#login-form").validate({

		rules: {
			"user_name": {
				required: true,
				maxlength: 50
			},
			"password": {
				required: true,
				minlength: 8
			},
		},
        messages: {
            user_name: {
                required: "Please provide a user_name",
                minlength: "You have exceeded the maximum number of characters allowed"
              },
            password: {
              required: "Please provide a password",
              minlength: "Your password must be at least 8 characters long"
            },
        }
	});
});