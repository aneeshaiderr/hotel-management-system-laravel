<x-app-layout :showDefaultNavigation="false">
<div class="main-content d-flex flex-column min-vh-100">
	<div class="container py-5">
		<main>
			<div class="mx-auto max-w-4xl py-7 px-7">

				<h5 class="fw-bold mb-4">Edit Room</h5>

				<form
					id="editRoomForm">
					@csrf
					<input
					type="hidden" name="id" value="{{ $room->id ?? '' }}">

					<div class="mb-4">
						<label for="room_number">Room Number</label>
						<input type="number" id="room_number" name="room_number" class="form-control" required value="{{ $room->room_number ?? '' }}">
					</div>

					<div class="mb-4">
						<label for="floor">Floor</label>
						<input type="number" id="floor" name="floor" class="form-control" required value="{{ $room->floor ?? '' }}">
					</div>

					<div class="mb-4">
						<label for="beds">Beds</label>
						<input type="number" id="beds" name="beds" class="form-control" required value="{{ $room->beds ?? '' }}">
					</div>

					<div class="mb-4">
						<label for="max_guests">Max Guests</label>
						<input type="number" id="max_guests" name="max_guests" class="form-control" required value="{{ $room->max_guests ?? '' }}">
					</div>

					<div class="mb-4">
						<label for="hotel_id">Hotel</label>
						<select name="hotel_id" id="hotel_id" class="form-control" required>
							@foreach($hotels as $hotel)
								<option value="{{ $hotel->id }}" {{ ($room->hotel_id ?? '') == $hotel->id ? 'selected' : '' }}>{{ $hotel->hotel_name }}</option>
							@endforeach
						</select>
					</div>

					<div class="mb-4">
						<label for="status">Status</label>
						<select name="status" id="status" class="form-control" required>
							<option value="available" {{ ($room->status ?? '') == 'available' ? 'selected' : '' }}>Available</option>
							<option value="booked" {{ ($room->status ?? '') == 'booked' ? 'selected' : '' }}>Booked</option>
							<option value="maintenance" {{ ($room->status ?? '') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
						</select>
					</div>

					<div class="mt-6 d-flex justify-content-end gap-2">
						<a href="{{ url('rooms') }}" class="btn btn-secondary">Cancel</a>
						<button type="submit" id="updateBtn" class="btn btn-success" style="background-color:#16a34a;" onmouseover="this.style.backgroundColor='#15803d'" onmouseout="this.style.backgroundColor='#16a34a'">
							Update
						</button>
					</div>

				</form>

			</div>
		</main>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$(function () {
            $('#editRoomForm').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            console.log(form.serialize());

            $.ajax({
                url: "{{ url('room/update') }}",
                type: "POST",
                data: form.serialize(),
                dataType: "json",

            beforeSend: function () {
                $('#updateBtn').prop('disabled', true).text('Updating...');
                },

            success: function (response) {
            if (response.status === 'success') {
            alert(response.message || 'Room updated successfully!');
            window.location.href = "{{ url('rooms') }}";
            } else {
            alert(response.message || 'Update failed');
            }
            },

            error: function (xhr) {
            alert('Server error!');
            console.log(xhr.responseText);
            },

            complete: function () {
            $('#updateBtn').prop('disabled', false).text('Update');
            }
            });
            });
            });
</script>
</x-app-layout>
