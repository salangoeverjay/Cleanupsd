@extends('layouts.logged')

@section('title', 'Report Trash Collected')

@push('styles')
<style>
body { background: #1a1a1a; }
.report-container { max-width: 700px; margin: 40px auto; padding: 0 20px; }
.report-card { 
    background: #ffffff; 
    border-radius: 12px; 
    padding: 30px; 
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.report-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    padding: 25px;
    border-radius: 12px 12px 0 0;
    margin: -30px -30px 25px -30px;
}
.event-info {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #3b82f6;
    margin-bottom: 20px;
}
.event-info p {
    margin-bottom: 5px;
    font-size: 0.95rem;
}
.form-label {
    font-weight: 600;
    color: #34495e;
    margin-bottom: 8px;
}
.form-control {
    border-radius: 8px;
    padding: 12px 14px;
    border: 1px solid #d0d4d8;
    font-size: 1.1rem;
}
.form-control:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 0.15rem rgba(16, 185, 129, 0.25);
}
.btn-submit {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    color: #fff;
    font-size: 1.05rem;
    transition: transform 0.2s;
}
.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    color: #fff;
}
.btn-secondary {
    background: #6c757d;
    border: none;
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 8px;
    color: #fff;
}
.trash-icon {
    font-size: 3rem;
    color: #10b981;
    text-align: center;
    margin-bottom: 15px;
}
.info-box {
    background: #e0f2fe;
    border-left: 4px solid #0284c7;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}
.existing-report {
    background: #fef3c7;
    border-left: 4px solid #f59e0b;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}
.input-group-text {
    background: #f1f5f9;
    border: 1px solid #d0d4d8;
    font-weight: 600;
}
</style>
@endpush

@section('content')
<div class="report-container">
    <div class="report-card">
        <div class="report-header">
            <h3><i class="bi bi-trash3 me-2"></i> Report Trash Collected</h3>
            <p class="mb-0 mt-2" style="font-size: 0.95rem;">Track your environmental impact</p>
        </div>

        <div class="trash-icon">
            <i class="bi bi-recycle"></i>
        </div>

        <!-- Event Information -->
        <div class="event-info">
            <h5 class="mb-3"><i class="bi bi-calendar-event"></i> Event Details</h5>
            <p><strong>Event:</strong> {{ $event->evt_name }}</p>
            <p><strong>Date:</strong> {{ date('F d, Y', strtotime($event->evt_date)) }}</p>
            <p><strong>Location:</strong> {{ $event->location->evt_loctn_name ?? 'N/A' }}</p>
            <p class="mb-0"><strong>Organizer:</strong> {{ $event->organizer->org_name ?? 'N/A' }}</p>
        </div>

        @if($existingReport)
            <div class="existing-report">
                <strong><i class="bi bi-exclamation-triangle me-2"></i> You have already reported for this event</strong>
                <p class="mb-0 mt-2">Previous report: <strong>{{ $existingReport->trash_collected_kg }} kg</strong></p>
                <p class="mb-0"><small>You can update your report below</small></p>
            </div>
        @else
            <div class="info-box">
                <i class="bi bi-info-circle me-2"></i>
                <strong>How to measure:</strong>
                <ul class="mb-0 mt-2" style="font-size: 0.9rem;">
                    <li>Use a scale to weigh collected trash in kilograms</li>
                    <li>Estimate based on bag count (1 large trash bag ≈ 5-10 kg)</li>
                    <li>Be as accurate as possible to track your impact</li>
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Report Form -->
        <form method="POST" action="{{ route('volunteer.submitTrashReport', $event->evt_id) }}">
            @csrf

            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-trash3-fill me-1"></i> Amount of Trash Collected
                </label>
                <div class="input-group input-group-lg">
                    <input type="number" 
                           name="trash_collected_kg" 
                           class="form-control @error('trash_collected_kg') is-invalid @enderror" 
                           value="{{ old('trash_collected_kg', $existingReport->trash_collected_kg ?? '') }}"
                           step="0.01"
                           min="0"
                           max="10000"
                           placeholder="0.00"
                           required>
                    <span class="input-group-text">kg</span>
                </div>
                @error('trash_collected_kg')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
                <small class="text-muted">Enter the weight in kilograms (e.g., 15.5)</small>
            </div>

            <div class="d-flex gap-2 justify-content-between">
                <a href="{{ route('dashboard.volunteer') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                </a>
                <button type="submit" class="btn btn-submit">
                    <i class="bi bi-check-circle me-1"></i> 
                    {{ $existingReport ? 'Update Report' : 'Submit Report' }}
                </button>
            </div>
        </form>

        <!-- Impact Preview -->
        <div class="mt-4 text-center" style="padding: 20px; background: #f8f9fa; border-radius: 8px;">
            <h6 class="text-muted mb-2">Your Total Contribution</h6>
            <h3 class="text-success mb-0">
                <i class="bi bi-award"></i> {{ $volunteer->totl_trash_collected_kg }} kg
            </h3>
            <p class="text-muted mb-0 mt-1" style="font-size: 0.85rem;">
                Total trash collected across all events
            </p>
        </div>
    </div>
</div>
@endsection
