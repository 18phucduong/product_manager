$().ready(function() {
	$("#login-form").validate({

		rules: {
			"user_name": {
				required: true,
				minlength: 5,
				maxlength: 50
			},
			"password": {
				required: true,
				minlength: 8,
			},
		},
        messages: {
            user_name: {
                required: "Please provide a user_name",
                minlength: "Min length username = 5",
                maxlength: "Max length username = 5"
              },
            password: {
              required: "Please provide a password",
              minlength: "Your password must be at least 8 characters long"
            },
        }
	});
});