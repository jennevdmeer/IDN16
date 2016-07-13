$(function () {
	var $form = $("#contact"),
		$name = $("input[name=name]", $form),
		$email = $("input[name=email]", $form),
		$message = $("textarea[name=message]", $form),
		$submit = $("button[type=submit]", $form);

	$form.on("submit", function (event) {
		event.preventDefault();

		$submit.prop("class", "btn btn-warning").prop("disabled", true);

		$.post("php/message.php", {
			json: true,
			data: {
				name: $name.val(),
				email: $email.val(),
				message: $message.val()
			}
		}, function (data) {
			if (data.error.length == 0) {
				$submit.prop("class", "btn btn-success").html("Your message has been sent!");
				$message.val("");
			} else {
				alert(data.error.join("\r\n"));
				$submit.prop("class", "btn btn-danger");
			}

			setTimeout(function () {
				$submit.prop("class", "btn btn-default").prop("disabled", false).html("Send message");
			}, 5000);
		});
	});
});