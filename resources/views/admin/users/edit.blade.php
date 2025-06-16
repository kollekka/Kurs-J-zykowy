@extends('layouts.admin')

@section('title', 'Edit User')
@push('styles')
<style>
    /* Profile Image Styles - can be moved to global admin CSS */
    .profile-image-container {
        text-align: center;
        margin-bottom: 25px;
        position: relative;
    }
    .profile-image-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 10px; /* Smaller margin for admin panel */
    }
    .profile-image, .default-profile-icon {
        width: 100px; /* Smaller size for admin panel */
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #ddd; /* Subtle border */
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .default-profile-icon {
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #495057;
        font-size: 40px;
    }
    .image-upload-overlay {
        position: absolute;
        bottom: 0;
        right: 0;
        background: var(--admin-primary-color, #007bff); /* Use admin CSS variable if exists */
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        border: 2px solid white;
    }
    .custom-file-input-admin { /* Unique class for admin input */
        opacity: 0;
        position: absolute;
        z-index: -1;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-admin">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user-edit mr-2"></i>Edit User: {{ $user->name }}</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Errors occurred:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Image Section -->
                    <div class="form-group">
                        <label>Profile Image</label>
                        <div class="profile-image-container">
                            <div class="profile-image-wrapper">
                                @if($user->profile_image && Storage::disk('public')->exists($user->profile_image))
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                         alt="Profile Image" 
                                         class="profile-image" 
                                         id="adminProfileDisplay">
                                @else
                                    <div class="default-profile-icon" id="adminProfileDisplay">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <div class="image-upload-overlay" onclick="document.getElementById('adminProfileImageInput').click()">
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                            <input type="file"
                                   id="adminProfileImageInput"
                                   name="profile_image"
                                   accept="image/*"
                                   class="custom-file-input-admin"
                                   onchange="previewAdminImage(this)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Username</label>
                        <input type="text" class="form-control form-control-admin" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control form-control-admin" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="current_password">Your current password (admin) <small class="text-muted">(required only if you change the above user's password)</small></label>
                        <input type="password" class="form-control form-control-admin" id="current_password" name="current_password">
                    </div>

                    <div class="form-group">
                        <label for="password">New password for user</label>
                        <input type="password" class="form-control form-control-admin" id="password" name="password">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm new password for user</label>
                        <input type="password" class="form-control form-control-admin" id="password_confirmation" name="password_confirmation">
                    </div>
                    <hr>

                    <div class="form-group form-check">
                        <input type="hidden" name="is_admin" value="0"> 
                        <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1" {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_admin">Is administrator?</label>
                    </div>

                    <button type="submit" class="btn btn-admin-primary"><i class="fas fa-save mr-1"></i> Update User</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-admin-secondary"><i class="fas fa-times mr-1"></i> Cancel</a>
                </form>
            </div>
        </div>

        @if($user->profile_image && Storage::disk('public')->exists($user->profile_image))
        <div class="card card-admin mt-3">
            <div class="card-body text-center">
                <form action="{{ route('admin.users.remove-profile-image', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this user\'s profile image?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Remove profile image
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewAdminImage(input) {
        const currentDisplayElement = document.getElementById('adminProfileDisplay');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                if (currentDisplayElement.tagName === 'IMG') {
                    // If it's already an <img>, just update its src
                    currentDisplayElement.src = e.target.result;
                } else {
                    // If it's a <div> (default icon), replace it with a new <img>
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.alt = "Profile Preview";
                    // Use classes defined in <style> or global admin styles
                    newImg.className = 'profile-image'; 
                    newImg.id = 'adminProfileDisplay'; // Keep ID for future previews

                    // Replace the old div with the new image
                    currentDisplayElement.parentNode.replaceChild(newImg, currentDisplayElement);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush