<x-app-layout :showDefaultNavigation="false">
<div class="main-content d-flex flex-column min-vh-100">
	<div class="container py-5">
		<main>
			<div class="mx-auto" style="max-width: 700px;">

				<h5 class="fw-bold mb-4 text-primary">Update User</h5>

				<form
					id="updateUserForm" method="post" action="{{ url('user/update') }}">

					@csrf

					<input
					type="hidden" name="id" value="{{ $user->id ?? '' }}">

					<!-- Username -->
					<div class="mb-3">
						<label for="username" class="form-label">Username</label>
						<input type="text" name="username" id="username" class="form-control" value="{{ $user->username ?? '' }}" required>
						<div class="invalid-feedback" id="error-username"></div>
					</div>

					<!-- Name -->
					<div class="mb-3">
						<label for="name" class="form-label">Name</label>
						<input type="text" name="name" id="name" class="form-control" value="{{ $user->name ?? '' }}" required>
						<div class="invalid-feedback" id="error-name"></div>
					</div>

					<!-- Email -->
					<div class="mb-3">
						<label for="email" class="form-label">Email</label>
						<input type="email" name="email" id="email" class="form-control" value="{{ $user->email ?? '' }}" required>
						<div class="invalid-feedback" id="error-email"></div>
					</div>

					<!-- Buttons -->
					<div class="d-flex justify-content-end gap-2 mt-3">
						<a href="{{ url('user') }}" class="btn btn-secondary">
							Cancel
						</a>

						<button type="submit" id="submitBtn" class="btn btn-success">
							Update
						</button>
					</div>

				</form>

			</div>
		</main>
	</div>
</div>

<script>
	$(function () {
            $('#updateUserForm').on('submit', function (e) {
            e.preventDefault();
            $('.form-control').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            $.ajax({
                url: "{{ url('user/update') }}",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",

            beforeSend: function () {
                $('#submitBtn').prop('disabled', true).text('Updating...');
                },

            success: function (response) {

            if (response.status === 'success') {
                alert(response.message || 'User updated successfully!');
                window.location.href = "{{ url('user') }}";

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
                $('#submitBtn').prop('disabled', false).text('Update');
                }
            });
            });

            });
</script>
</x-app-layout>
