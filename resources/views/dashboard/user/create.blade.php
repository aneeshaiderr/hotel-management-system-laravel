<x-app-layout :showDefaultNavigation="false">
<div class="main-content d-flex flex-column min-vh-100">
	<div class="container py-5">
		<main>
			<div class="mx-auto" style="max-width: 700px;">
				<h5 class="fw-bold mt-5 text-primary">Create User</h5>

				<form
					id="createUserForm" method="post" action="{{ url('user/store') }}">

					@csrf

					<!-- Username -->
					<div class="mb-3">
						<label for="username" class="form-label">Username</label>
						<input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
						<div class="invalid-feedback" id="error-username"></div>
					</div>

					<!-- Name -->
					<div class="mb-3">
						<label for="name" class="form-label">Name</label>
						<input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
						<div class="invalid-feedback" id="error-name"></div>
					</div>

					<!-- Email -->
					<div class="mb-3">
						<label for="email" class="form-label">Email</label>
						<input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
						<div class="invalid-feedback" id="error-email"></div>
					</div>



					<!-- Password -->
					<div class="mb-3">
						<label for="password" class="form-label">Password</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
						<div class="invalid-feedback" id="error-password"></div>
					</div>

					<!-- Buttons -->
					<div class="d-flex mt-3 gap-2">
						<a href="{{ url('user') }}" class="btn btn-secondary fw-bold">
							← Back
						</a>

						<button type="submit" id="submitBtn" class="btn btn-primary">
							Create User
						</button>
					</div>

				</form>
			</div>
		</main>
	</div>
</div>

<script>
	$(function () {

$('#createUserForm').on('submit', function (e) {
e.preventDefault();

	$('.form-control').removeClass('is-invalid');
	$('.invalid-feedback').text('');

	$.ajax({
	url: "{{ url('user/store') }}",
	type: "POST",
	data: $(this).serialize(),
	dataType: "json",

	beforeSend: function () {
	$('#submitBtn').prop('disabled', true).text('Creating...');
	},

	success: function (response) {

	if (response.status === 'success') {
	alert(response.message);
	$('#createUserForm')[0].reset();

	} else if (response.status === 'validation') {

	$.each(response.errors, function (field, message) {
	$('#' + field).addClass('is-invalid');
	$('#error-' + field).text(message);
	});

	} else {
	alert(response.message || 'Something went wrong!');
	}
	},

	error: function () {
	alert('Server error!');
	},

	complete: function () {
	$('#submitBtn').prop('disabled', false).text('Create User');
	}
	});
	});

	});
</script>
</x-app-layout>
