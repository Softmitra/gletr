@extends('layouts.admin')

@section('title', 'Edit User Profile')

@section('page_title', 'Edit User Profile')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('admin.user-profiles.index') }}">User Profiles</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.user-profiles.show', $user) }}">{{ $user->name }}</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('admin-content')
<div class="container-fluid">
    <form action="{{ route('admin.user-profiles.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row">
            <!-- Basic Information -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Basic Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                           id="date_of_birth" name="date_of_birth" 
                                           value="{{ old('date_of_birth', $user->profile && $user->profile->date_of_birth ? $user->profile->date_of_birth->format('Y-m-d') : '') }}">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $user->profile->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $user->profile->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $user->profile->gender ?? '') === 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="url" class="form-control @error('website') is-invalid @enderror" 
                                           id="website" name="website" value="{{ old('website', $user->profile->website ?? '') }}">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" 
                                      rows="3">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Links -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Social Media Links</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="url" class="form-control @error('social_links.facebook') is-invalid @enderror" 
                                           id="facebook" name="social_links[facebook]" 
                                           value="{{ old('social_links.facebook', $user->profile->social_links['facebook'] ?? '') }}">
                                    @error('social_links.facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <input type="url" class="form-control @error('social_links.twitter') is-invalid @enderror" 
                                           id="twitter" name="social_links[twitter]" 
                                           value="{{ old('social_links.twitter', $user->profile->social_links['twitter'] ?? '') }}">
                                    @error('social_links.twitter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="url" class="form-control @error('social_links.instagram') is-invalid @enderror" 
                                           id="instagram" name="social_links[instagram]" 
                                           value="{{ old('social_links.instagram', $user->profile->social_links['instagram'] ?? '') }}">
                                    @error('social_links.instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linkedin">LinkedIn</label>
                                    <input type="url" class="form-control @error('social_links.linkedin') is-invalid @enderror" 
                                           id="linkedin" name="social_links[linkedin]" 
                                           value="{{ old('social_links.linkedin', $user->profile->social_links['linkedin'] ?? '') }}">
                                    @error('social_links.linkedin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Preferences -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Preferences</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="notifications" name="preferences[notifications]" value="1"
                                           {{ old('preferences.notifications', $user->profile->preferences['notifications'] ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="notifications">
                                        Email Notifications
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="marketing" name="preferences[marketing]" value="1"
                                           {{ old('preferences.marketing', $user->profile->preferences['marketing'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="marketing">
                                        Marketing Emails
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="preferences[newsletter]" value="1"
                                           {{ old('preferences.newsletter', $user->profile->preferences['newsletter'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="newsletter">
                                        Newsletter
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Picture & Actions -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Profile Picture</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            @if($user->profile && $user->profile->profile_picture)
                                <img src="{{ $user->profile->profile_picture_url }}" 
                                     alt="{{ $user->name }}" 
                                     class="img-circle" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="avatar-title bg-primary rounded-circle mx-auto" style="width: 150px; height: 150px; font-size: 4rem; line-height: 150px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="profile_picture">Upload New Picture</label>
                            <input type="file" class="form-control-file @error('profile_picture') is-invalid @enderror" 
                                   id="profile_picture" name="profile_picture" accept="image/*">
                            <small class="form-text text-muted">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF</small>
                            @error('profile_picture')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- User Status -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Status</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="banned" {{ old('status', $user->status) === 'banned' ? 'selected' : '' }}>Banned</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="btn-group-vertical w-100">
                            <button type="submit" class="btn btn-primary mb-2">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                            <a href="{{ route('admin.user-profiles.show', $user) }}" class="btn btn-secondary mb-2">
                                <i class="fas fa-eye"></i> View Profile
                            </a>
                            <a href="{{ route('admin.user-profiles.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('js')
<script>
// Preview image before upload
document.getElementById('profile_picture').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.querySelector('.card-body img');
            if (img) {
                img.src = e.target.result;
            } else {
                const avatar = document.querySelector('.avatar-title');
                if (avatar) {
                    avatar.style.display = 'none';
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'img-circle';
                    newImg.style = 'width: 150px; height: 150px; object-fit: cover;';
                    avatar.parentNode.appendChild(newImg);
                }
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
