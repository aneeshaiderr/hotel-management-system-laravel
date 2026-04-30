<x-app-layout :showDefaultNavigation="false">
<div class="main-content d-flex flex-column min-vh-100">
	<div class="container py-5">
		<h5 class="fw-bold mb-2 ps-2">Create Reservation</h5>

		<div class="card card-custom w-100">
			<div class="card-body">

				<form
					method="POST" action="{{ url('reservation/store') }}">
					@csrf

					<div class="mb-3">
						<label for="hotel_code" class="form-label">Hotel Code</label>
						<input type="text" class="form-control" id="hotel_code" name="hotel_code" required>
					</div>

					<div class="mb-3">
						<label for="user_id" class="form-label">User Email</label>
						<select id="user_id" name="user_id" class="form-control" required>
							<option value="">Select User</option>
							@foreach ($users as $user)
								<option value="{{ $user->id ?? $user['id'] ?? '' }}">{{ $user->email ?? $user['email'] ?? '' }}</option>
							@endforeach
						</select>
					</div>

					<div class="mb-3">
						<label for="hotel_id" class="form-label">Hotel</label>
						<select id="hotel_id" name="hotel_id" class="form-control" required>
							<option value="">Select Hotel</option>
							@foreach ($hotels as $hotel)
								<option value="{{ $hotel->id ?? $hotel['id'] ?? '' }}">{{ $hotel->hotel_name ?? $hotel['hotel_name'] ?? '' }}</option>
							@endforeach
						</select>
					</div>

					<div class="mb-3">
						<label for="room_id" class="form-label">Room</label>
						<select id="room_id" name="room_id" class="form-control" required>
							<option value="">Select Room</option>
							@foreach ($rooms as $room)
								<option value="{{ $room->id ?? $room['id'] ?? '' }}">Room #{{ $room->id ?? $room['id'] ?? '' }}</option>
							@endforeach
						</select>
					</div>

					<div class="mb-3">
						<label for="discount_id" class="form-label">Discount</label>
						<select id="discount_id" name="discount_id" class="form-control">
							<option value="">Select Discount</option>
							@foreach ($discounts as $discount)
								<option value="{{ $discount->id ?? $discount['id'] ?? '' }}">
									{{ $discount->discount_name ?? $discount['discount_name'] ?? '' }}
									-
									{{ $discount->discount_type ?? $discount['discount_type'] ?? '' }}
									({{ $discount->value ?? $discount['value'] ?? '' }})
								</option>
							@endforeach
						</select>
					</div>

					<div class="mb-3">
						<label for="check_in" class="form-label">Check In</label>
						<input type="date" id="check_in" name="check_in" class="form-control" required>
					</div>

					<div class="mb-3">
						<label for="check_out" class="form-label">Check Out</label>
						<input type="date" id="check_out" name="check_out" class="form-control" required>
					</div>

					<div class="mb-3">
						<label for="status" class="form-label">Status</label>
						<select id="status" name="status" class="form-control" required>
							<option value="active">Active</option>
							<option value="cancelled">Cancelled</option>
							<option value="completed">Completed</option>
						</select>
					</div>

					<button type="submit" class="btn btn-success">Create Reservation</button>
                    <a href="{{ route('dashboard.reservation') }}" class="btn btn-secondary">Cancel</a>
				</form>

			</div>
		</div>
	</div>
</div>
</x-app-layout>
