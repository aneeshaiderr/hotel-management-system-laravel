<div class="main-content d-flex flex-column min-vh-100">
	<div class="container py-5">

		<h5 class="fw-bold mb-4">Assign Permission to User</h5>

		<form
			action="{{ url('permission/store') }}" method="post">

			@csrf

			<div class="mb-3">
				<label class="form-label">Select User ID</label>

				<select name="user_id" class="form-control" required>
					<option value="">-- Select User --</option>

					@foreach ($users as $user)
						<option value="{{ $user->user_id ?? $user['user_id'] ?? '' }}">
							User ID:
							{{ $user->user_id ?? $user['user_id'] ?? '' }}
						</option>
					@endforeach
				</select>
			</div>

			<div class="mb-3">
				<label class="form-label">Permission</label>

				<input type="text" name="permission" class="form-control" placeholder="e.g. discount.add, discount.delete" required>
			</div>

			<button type="submit" class="btn btn-primary">
				Assign Permission
			</button>

		</form>

	</div>
</div>
