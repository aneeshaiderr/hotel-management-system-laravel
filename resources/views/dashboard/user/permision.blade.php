<div class="main-content d-flex flex-column min-vh-100">
	<div class="container py-5">

		<h5 class="fw-bold mb-3">User Permissions</h5>

		<div class="mb-4">
			<a href="{{ url('permission/createPermission') }}" class="btn btn-sm btn-success">
				+ Assign Permission
			</a>
		</div>

		<div class="card w-100">
			<div class="card-body">

				<table class="table table-bordered table-striped align-middle">
					<thead class="table-light">
						<tr>
							<th width="60">ID</th>
							<th width="100">User ID</th>
							<th>Permission</th>
							<th width="180">Created At</th>
							<th width="150">Action</th>
						</tr>
					</thead>

					<tbody>
						@if (!empty($permissions) && count($permissions) > 0)
							@foreach ($permissions as $row)
								<tr>
									<td>{{ $row->id ?? $row['id'] ?? '' }}</td>
									<td>{{ $row->user_id ?? $row['user_id'] ?? '' }}</td>
									<td>
										<span class="badge bg-info text-dark">
											{{ $row->permission ?? $row['permission'] ?? '' }}
										</span>
									</td>
									<td>{{ $row->created_at ?? $row['created_at'] ?? '' }}</td>
									<td
										class="d-flex gap-2">

										<a href="{{ url('permission/view/' . ($row->id ?? $row['id'] ?? '')) }}" class="btn btn-sm btn-primary">
											View
										</a>

										<form action="{{ url('permission/delete') }}" method="post" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this permission?');">
											@csrf
											<input type="hidden" name="id" value="{{ $row->id ?? $row['id'] ?? '' }}">

											<button type="submit" class="btn btn-sm btn-danger py-1 px-3">
												Delete
											</button>
										</form>

									</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="5" class="text-center text-muted">
									No permissions found
								</td>
							</tr>
						@endif
					</tbody>

				</table>

			</div>
		</div>

	</div>
</div>
