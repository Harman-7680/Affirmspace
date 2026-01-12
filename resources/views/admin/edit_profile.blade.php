<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Profile Image -->
                    <div class="form-group text-center">
                        <label>Current Profile Image</label><br>
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile Image"
                            class="img-thumbnail" width="100" height="100">
                    </div>

                    <div class="form-group">
                        <label for="profile_image">Change Profile Image</label>
                        <input type="file" class="form-control-file" id="profile_image" name="image">
                    </div>

                    <div class="form-group">
                        <label for="name">First Name</label>
                        <input type="text" class="form-control" id="name" name="first_name"
                            value="{{ Auth::user()->first_name }}">
                    </div>

                    <div class="form-group">
                        <label for="name">Last Name</label>
                        <input type="text" class="form-control" id="name" name="last_name"
                            value="{{ Auth::user()->last_name }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ Auth::user()->email }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
