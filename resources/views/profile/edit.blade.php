@extends('layouts.logged')

@section('title', 'Edit Profile')

@push('styles')
<style>
body { background: #1a1a1a; }
.profile-container { max-width: 800px; margin: 40px auto; padding: 0 20px; }
.profile-card { 
    background: #ffffff; 
    border-radius: 12px; 
    padding: 30px; 
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.profile-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: #fff;
    padding: 25px;
    border-radius: 12px 12px 0 0;
    margin: -30px -30px 25px -30px;
}
.profile-header h3 {
    margin: 0;
    font-weight: 700;
}
.form-label {
    font-weight: 600;
    color: #34495e;
    margin-bottom: 8px;
}
.form-control {
    border-radius: 8px;
    padding: 10px 14px;
    border: 1px solid #d0d4d8;
    transition: border-color .2s ease, box-shadow .2s ease;
}
.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.15rem rgba(59, 130, 246, 0.25);
}
.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border: none;
    padding: 10px 24px;
    font-weight: 600;
    border-radius: 8px;
    transition: transform 0.2s;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}
.btn-secondary {
    background: #6c757d;
    border: none;
    padding: 10px 24px;
    font-weight: 600;
    border-radius: 8px;
}
.alert {
    border-radius: 8px;
    border: none;
}
.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border-left: 4px solid #10b981;
}
.info-badge {
    background: #f1f5f9;
    padding: 12px;
    border-radius: 8px;
    border-left: 4px solid #3b82f6;
    margin-bottom: 20px;
}
</style>
@endpush

@section('content')
<div class="profile-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Profile Information Card -->
    <div class="profile-card">
        <div class="profile-header">
            <h3><i class="bi bi-person-circle me-2"></i> Edit Profile</h3>
            <p class="mb-0 mt-2" style="font-size: 0.95rem;">Update your personal information</p>
        </div>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-person me-1"></i> Full Name
                </label>
                <input type="text" name="usr_name" 
                       class="form-control @error('usr_name') is-invalid @enderror" 
                       value="{{ old('usr_name', $user->usr_name) }}" required>
                @error('usr_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-envelope me-1"></i> Email Address
                </label>
                <input type="email" name="email_add" 
                       class="form-control @error('email_add') is-invalid @enderror" 
                       value="{{ old('email_add', $userDetails->email_add ?? '') }}" required>
                @error('email_add')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">
                    <i class="bi bi-telephone me-1"></i> Contact Number
                </label>
                <input type="text" name="contact_num" 
                       class="form-control @error('contact_num') is-invalid @enderror" 
                       value="{{ old('contact_num', $userDetails->contact_num ?? '') }}"
                       placeholder="e.g., +63 912 345 6789">
                @error('contact_num')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small class="text-muted">Optional: Add your contact number for event organizers</small>
            </div>

            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-geo-alt me-1"></i> Address
                </label>
                <textarea name="address" 
                          class="form-control @error('address') is-invalid @enderror" 
                          rows="3"
                          placeholder="Your complete address (optional)">{{ old('address', $userDetails->address ?? '') }}</textarea>
                @error('address')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Save Changes
                </button>
                <a href="{{ Auth::user()->isVolunteer() ? route('dashboard.volunteer') : route('dashboard.organizer') }}" 
                   class="btn btn-secondary">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Change Password Card -->
    <div class="profile-card">
        <div class="profile-header">
            <h3><i class="bi bi-shield-lock me-2"></i> Change Password</h3>
            <p class="mb-0 mt-2" style="font-size: 0.95rem;">Update your account password</p>
        </div>

        <div class="info-badge mb-3">
            <small>
                <i class="bi bi-info-circle me-1"></i>
                Password must be at least 8 characters long
            </small>
        </div>

        <form method="POST" action="{{ route('profile.updatePassword') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" 
                       class="form-control @error('current_password') is-invalid @enderror" required>
                @error('current_password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="new_password" 
                       class="form-control @error('new_password') is-invalid @enderror" required>
                @error('new_password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="new_password_confirmation" 
                       class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-key me-1"></i> Update Password
            </button>
        </form>
    </div>
</div>
@endsection
