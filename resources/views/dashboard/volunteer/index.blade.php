@extends('layouts.logged')

@section('title', 'Volunteer Dashboard')
@section('dashboard', 'active')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
/* Modern Dashboard Styles */
body {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    min-height: 100vh;
}

.container-dashboard {
    max-width: 1400px; 
    margin: auto;
}

/* Modern Dashboard Header */
.dashboard-header {
    padding: 40px 30px;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
    border-radius: 50%;
    transform: translate(30%, -30%);
}

.dashboard-greeting {
    font-weight: 800;
    font-size: 2.5rem;
    background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
    z-index: 1;
}

/* Modern Stat Cards - Keep original colors */
.card {
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.stat-card {
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
}

.stat-card h5 {
    font-weight: 600;
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 12px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.stat-card h3 {
    font-weight: 800;
    font-size: 2.5rem;
    color: white;
}

/* Keep original gradient colors */
.stat-card-gradient-1 { 
    background: linear-gradient(135deg, #3b82f6 0%, #6c757d 100%); 
}

.stat-card-gradient-2 { 
    background: linear-gradient(135deg, #3c68b1 0%, #6c757d 100%); 
}

.stat-card-gradient-3 { 
    background: linear-gradient(135deg, #375a7f 0%, #6c757d 100%); 
}

.text-white-card { 
    color: white !important; 
}

/* Modern Chart Containers */
.chart-container {
    padding: 30px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(59, 130, 246, 0.1);
}

.chart-container h5 {
    color: #1e293b;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 20px;
}

/* Modern Event Cards */
.event-list .card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(59, 130, 246, 0.1);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.event-list h5 {
    color: #1e293b;
    font-weight: 700;
    font-size: 1.4rem;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.event-list h5 i {
    font-size: 1.5rem;
    color: #3b82f6;
}

.event-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    color: #1e293b;
    padding: 24px;
    border-radius: 16px;
    margin-bottom: 16px;
    border: 1px solid rgba(59, 130, 246, 0.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.event-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
    transition: left 0.5s ease;
}

.event-card:hover::before {
    left: 100%;
}

.event-card:hover {
    transform: translateY(-4px) scale(1.01);
    box-shadow: 0 12px 30px rgba(59, 130, 246, 0.25);
    border-color: #3b82f6;
}

.event-card .event-title {
    font-size: 1.3rem;
    font-weight: 800;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 12px;
}

.event-card .event-detail {
    font-size: 0.95rem;
    color: #64748b;
    margin-bottom: 8px;
    display: flex;
    align-items: start;
}

.event-card .event-detail i {
    width: 24px;
    margin-right: 8px;
    color: #3b82f6;
    flex-shrink: 0;
    margin-top: 2px;
    font-size: 1rem;
}

.event-card .event-description {
    font-size: 0.9rem;
    color: #475569;
    margin-top: 12px;
    padding-top: 12px;
    border-top: 2px solid rgba(59, 130, 246, 0.1);
    line-height: 1.6;
}

.event-card .badge {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 8px;
}

/* Map Preview */
.event-map-preview {
    height: 200px;
    width: 100%;
    border-radius: 12px;
    margin-top: 12px;
    cursor: pointer;
    border: 2px solid rgba(59, 130, 246, 0.2);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.event-map-preview:hover {
    border-color: #3b82f6;
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    transform: scale(1.02);
}

.map-modal-content {
    height: 500px;
    width: 100%;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.view-map-btn {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.1) 100%);
    color: #3b82f6;
    border: 1px solid rgba(59, 130, 246, 0.3);
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-left: 8px;
}

.view-map-btn:hover {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #fff;
    border-color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

/* Buttons */
.btn-join {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    padding: 12px 20px;
    font-size: 0.95rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-join::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-join:hover::before {
    width: 300px;
    height: 300px;
}

.btn-join:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #fff;
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
}

.btn-join:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border: none;
    border-radius: 12px;
    font-weight: 700;
    padding: 12px 24px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
}

/* Alert Styling */
.alert {
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.alert-success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.2) 100%);
    color: #065f46;
    border-left: 5px solid #10b981;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
}

.alert-warning {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%);
    color: #92400e;
    border-left: 5px solid #f59e0b;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2);
}

.alert-danger {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.2) 100%);
    color: #991b1b;
    border-left: 5px solid #ef4444;
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
}

.alert .alert-heading {
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.alert hr {
    opacity: 0.3;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
    border-width: 0.15em;
}

.text-light {
    color: #94a3b8 !important;
}

/* Report Trash Modal */
.report-trash-modal {
    border-radius: 24px;
    border: none;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.report-trash-modal .modal-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border-radius: 24px 24px 0 0;
    padding: 24px 28px;
    border: none;
}

.report-trash-modal .modal-title {
    font-weight: 800;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
}

.report-trash-modal .modal-title i {
    font-size: 1.8rem;
}

.report-trash-modal .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.report-trash-modal .btn-close:hover {
    opacity: 1;
    transform: rotate(90deg);
    transition: all 0.3s ease;
}

.report-trash-modal .modal-body {
    padding: 32px 28px;
}

.report-trash-modal .event-info-box {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(37, 99, 235, 0.05) 100%);
    padding: 20px;
    border-radius: 12px;
    border-left: 4px solid #3b82f6;
    margin-bottom: 24px;
}

.report-trash-modal .event-info-box h5 {
    color: #1e293b;
    font-weight: 700;
    margin-bottom: 12px;
}

.report-trash-modal .event-info-box p {
    color: #64748b;
    margin-bottom: 6px;
    font-size: 0.95rem;
}

.report-trash-modal .info-tip {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
    padding: 16px;
    border-radius: 12px;
    border-left: 4px solid #10b981;
    margin-bottom: 24px;
}

.report-trash-modal .info-tip strong {
    color: #059669;
    display: block;
    margin-bottom: 8px;
}

.report-trash-modal .info-tip ul {
    margin-bottom: 0;
    padding-left: 20px;
}

.report-trash-modal .existing-alert {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.05) 100%);
    padding: 16px;
    border-radius: 12px;
    border-left: 4px solid #f59e0b;
    margin-bottom: 24px;
    color: #92400e;
}

.report-trash-modal .form-label {
    font-weight: 700;
    color: #1e293b;
    font-size: 1rem;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.report-trash-modal .form-label i {
    color: #10b981;
    font-size: 1.1rem;
    margin-right: 8px;
}

.report-trash-modal .form-control {
    border-radius: 12px;
    padding: 14px 16px;
    border: 2px solid rgba(16, 185, 129, 0.2);
    transition: all 0.3s ease;
    font-size: 1.1rem;
    font-weight: 600;
}

.report-trash-modal .form-control:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
    outline: none;
}

.report-trash-modal .input-group-text {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
    border: 2px solid rgba(16, 185, 129, 0.2);
    border-left: none;
    font-weight: 700;
    font-size: 1.1rem;
    color: #059669;
    border-radius: 0 12px 12px 0;
}

.report-trash-modal .btn-submit-report {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
    padding: 14px 24px;
    font-weight: 700;
    font-size: 1.1rem;
    border-radius: 12px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    position: relative;
    overflow: hidden;
}

.report-trash-modal .btn-submit-report::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.report-trash-modal .btn-submit-report:hover::before {
    width: 300px;
    height: 300px;
}

.report-trash-modal .btn-submit-report:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.5);
}

.report-trash-modal .impact-preview {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
    padding: 24px;
    border-radius: 16px;
    text-align: center;
    margin-top: 24px;
    border: 2px solid rgba(16, 185, 129, 0.2);
}

.report-trash-modal .impact-preview h6 {
    color: #64748b;
    font-weight: 600;
    margin-bottom: 8px;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.report-trash-modal .impact-preview h3 {
    color: #10b981;
    font-weight: 800;
    font-size: 2.5rem;
    margin-bottom: 8px;
}

.report-trash-modal .impact-preview p {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 0;
}
</style>
@endpush

@section('content')
<div class="container-dashboard p-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-start">
                <i class="bi bi-check-circle-fill me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <h5 class="alert-heading mb-2">
                        <i class="bi bi-party-popper"></i> Event Joined Successfully!
                    </h5>
                    <p class="mb-1"><strong>{{ session('success') }}</strong></p>
                    @if(session('event_name'))
                        <hr class="my-2">
                        <p class="mb-1"><strong>Event:</strong> {{ session('event_name') }}</p>
                        <p class="mb-1"><strong>Date:</strong> {{ date('F d, Y', strtotime(session('event_date'))) }}</p>
                        <p class="mb-0"><strong>Organized by:</strong> {{ session('organizer_name') }}</p>
                    @endif
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 1.5rem;"></i>
                <div>{{ session('warning') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-x-circle-fill me-3" style="font-size: 1.5rem;"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="dashboard-header mb-4">
        <div style="margin-left: 1rem;">
            <h1 class="dashboard-greeting"><i class="bi bi-speedometer2 me-3"></i>Welcome, {{ $volunteer->usr_name }}!</h1>
            <p class="text-white mt-3 mb-0" style="font-size: 1.1rem; opacity: 0.8;">
                <i class="bi bi-person-badge me-2"></i>Volunteer Dashboard
            </p>
        </div>
    </div>

    <!-- Top Stats -->
    <div class="row g-4 mb-4 justify-content-center text-center">
        <div class="col-md-4">
            <div class="card p-4 stat-card stat-card-gradient-1">
                <h5 class="text-white-card">Total Events Participated</h5>
                <h3 class="text-white-card">{{ $volunteer->totl_evts_partd }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 stat-card stat-card-gradient-2">
                <h5 class="text-white-card">Currently Joined Events</h5>
                <h3 class="text-white-card">{{ $volunteer->evt_curr_joined }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 stat-card stat-card-gradient-3">
                <h5 class="text-white-card">Total Trash Collected (kg)</h5>
                <h3 class="text-white-card">{{ $volunteer->totl_trash_collected_kg }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card chart-container">
                <h5 class="text-center mb-3">Monthly Events Participated</h5>
                <canvas id="eventsParticipatedChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card chart-container">
                <h5 class="text-center mb-3">Monthly Trash Collected (kg)</h5>
                <canvas id="trashCollectedChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Events Section -->
    <div class="row g-4 event-list">
        <!-- Browse Events -->
        <div class="col-md-6">
            <div class="card mb-3 p-3">
                <h5><i class="bi bi-calendar-event"></i> Browse & Join Events</h5>
                <p class="text-light mb-3">Discover upcoming cleanup events organized by our community partners.</p>
                <a href="{{ route('events.index') }}" class="btn btn-primary btn-lg w-100">
                    <i class="bi bi-search"></i> View All Available Events
                </a>
            </div>
        </div>

        <!-- Joined Events -->
        <div class="col-md-6">
            <div class="card mb-3 p-3">
                <h5><i class="bi bi-check-circle"></i> Your Joined Events</h5>
                @forelse($joinedEvents as $event)
                    <div class="event-card">
                        <div class="event-title">{{ $event->evt_name }}</div>
                        
                        <div class="event-detail">
                            <i class="bi bi-calendar3"></i>
                            <strong>Date:</strong> {{ date('F d, Y', strtotime($event->evt_date)) }}
                            @if($event->end_date)
                                - {{ date('F d, Y', strtotime($event->end_date)) }}
                            @endif
                        </div>
                        
                        <div class="event-detail">
                            <i class="bi bi-person-badge"></i>
                            <strong>Organizer:</strong> {{ $event->organizer->org_name ?? 'N/A' }}
                        </div>
                        
                        @if($event->location)
                            <div class="event-detail">
                                <i class="bi bi-geo-alt"></i>
                                <strong>Location:</strong> {{ $event->location->evt_loctn_name }}
                                @if($event->location->map_details)
                                    <button type="button" class="view-map-btn" 
                                            onclick="showEventMap({{ $event->evt_id }}, '{{ $event->location->map_details }}', '{{ addslashes($event->evt_name) }}', '{{ addslashes($event->location->evt_loctn_name) }}')"
                                            data-bs-toggle="modal" data-bs-target="#mapModal">
                                        <i class="bi bi-map"></i> Map
                                    </button>
                                @endif
                            </div>
                            
                            @if($event->location->map_details)
                                <div class="event-map-preview" id="map-preview-{{ $event->evt_id }}" 
                                     onclick="showEventMap({{ $event->evt_id }}, '{{ $event->location->map_details }}', '{{ addslashes($event->evt_name) }}', '{{ addslashes($event->location->evt_loctn_name) }}')"
                                     data-bs-toggle="modal" data-bs-target="#mapModal">
                                </div>
                            @endif
                        @endif
                        
                        <div class="event-detail">
                            <i class="bi bi-flag"></i>
                            <strong>Status:</strong> 
                            <span class="badge bg-success">
                                <i class="bi bi-check2"></i> Joined
                            </span>
                        </div>
                        
                        @if($event->evt_details)
                            <div class="event-description">
                                <strong>About:</strong> {{ Str::limit($event->evt_details, 150) }}
                            </div>
                        @endif
                        
                        <!-- Report Trash Button -->
                        <div class="mt-3">
                            <button type="button" class="btn btn-join w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#reportTrashModal"
                                    onclick="openReportModal({{ $event->evt_id }}, '{{ addslashes($event->evt_name) }}', '{{ date('F d, Y', strtotime($event->evt_date)) }}', '{{ addslashes($event->location->evt_loctn_name ?? 'N/A') }}', '{{ addslashes($event->organizer->org_name ?? 'N/A') }}')">
                                <i class="bi bi-trash3"></i> Report Trash Collected
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-light">You haven't joined any events yet. Check out upcoming events!</p>
                @endforelse
            </div>
        </div>
    </div>

</div>

<!-- Map Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: #fff;">
                <h5 class="modal-title" id="mapModalLabel">
                    <i class="bi bi-map-fill"></i> <span id="modalEventName">Event Location</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <strong><i class="bi bi-geo-alt-fill text-primary"></i> <span id="modalLocationName"></span></strong>
                </div>
                <div id="modalMap" class="map-modal-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Close
                </button>
                <a id="openInGoogleMaps" href="#" target="_blank" class="btn btn-primary">
                    <i class="bi bi-box-arrow-up-right"></i> Open in Google Maps
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Report Trash Modal -->
<div class="modal fade" id="reportTrashModal" tabindex="-1" aria-labelledby="reportTrashModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content report-trash-modal">
            <div class="modal-header">
                <h4 class="modal-title" id="reportTrashModalLabel">
                    <i class="bi bi-trash3 me-2"></i>Report Trash Collected
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="bi bi-recycle" style="font-size: 4rem; color: #10b981;"></i>
                    <p class="text-muted mt-2">Track your environmental impact</p>
                </div>

                <!-- Event Information -->
                <div class="event-info-box">
                    <h5><i class="bi bi-calendar-event me-2"></i>Event Details</h5>
                    <p><strong>Event:</strong> <span id="modalReportEventName"></span></p>
                    <p><strong>Date:</strong> <span id="modalReportEventDate"></span></p>
                    <p><strong>Location:</strong> <span id="modalReportEventLocation"></span></p>
                    <p class="mb-0"><strong>Organizer:</strong> <span id="modalReportEventOrganizer"></span></p>
                </div>

                <!-- Info Tips -->
                <div class="info-tip">
                    <strong><i class="bi bi-info-circle me-2"></i>How to measure:</strong>
                    <ul style="font-size: 0.9rem;">
                        <li>Use a scale to weigh collected trash in kilograms</li>
                        <li>Estimate based on bag count (1 large trash bag ≈ 5-10 kg)</li>
                        <li>Be as accurate as possible to track your impact</li>
                    </ul>
                </div>

                <!-- Form -->
                <form id="reportTrashForm" method="POST" action="">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-trash3-fill"></i>Amount of Trash Collected
                        </label>
                        <div class="input-group input-group-lg">
                            <input type="number" 
                                   name="trash_collected_kg" 
                                   id="trashAmount"
                                   class="form-control" 
                                   step="0.01"
                                   min="0"
                                   max="10000"
                                   placeholder="0.00"
                                   required>
                            <span class="input-group-text">kg</span>
                        </div>
                        <small class="text-muted">Enter the weight in kilograms (e.g., 15.5)</small>
                    </div>

                    <!-- Impact Preview -->
                    <div class="impact-preview">
                        <h6>Your Total Contribution</h6>
                        <h3><i class="bi bi-award"></i> {{ $volunteer->totl_trash_collected_kg }} kg</h3>
                        <p>Total trash collected across all events</p>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-submit-report">
                            <i class="bi bi-check-circle me-2"></i>Submit Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Store map instances
let previewMaps = {};
let modalMap = null;
let currentMarker = null;

// Open Report Trash Modal
function openReportModal(eventId, eventName, eventDate, eventLocation, eventOrganizer) {
    // Populate modal with event details
    document.getElementById('modalReportEventName').textContent = eventName;
    document.getElementById('modalReportEventDate').textContent = eventDate;
    document.getElementById('modalReportEventLocation').textContent = eventLocation;
    document.getElementById('modalReportEventOrganizer').textContent = eventOrganizer;
    
    // Update form action with event ID
    const form = document.getElementById('reportTrashForm');
    form.action = '/volunteer/report-trash/' + eventId;
    
    // Reset form
    document.getElementById('trashAmount').value = '';
}

// Initialize preview maps for each event
document.addEventListener('DOMContentLoaded', function() {
    @foreach($joinedEvents as $event)
        @if($event->location && $event->location->map_details)
            initPreviewMap({{ $event->evt_id }}, '{{ $event->location->map_details }}');
        @endif
    @endforeach
});

// Initialize small preview map
function initPreviewMap(eventId, coordinates) {
    const mapElement = document.getElementById('map-preview-' + eventId);
    if (!mapElement) return;
    
    const coords = coordinates.split(',').map(c => parseFloat(c.trim()));
    if (coords.length !== 2 || isNaN(coords[0]) || isNaN(coords[1])) return;
    
    const map = L.map(mapElement, {
        center: [coords[0], coords[1]],
        zoom: 13,
        dragging: false,
        touchZoom: false,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        boxZoom: false,
        keyboard: false,
        zoomControl: false
    });
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);
    
    L.marker([coords[0], coords[1]], {
        icon: L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        })
    }).addTo(map);
    
    previewMaps[eventId] = map;
}

// Show full map in modal
function showEventMap(eventId, coordinates, eventName, locationName) {
    const coords = coordinates.split(',').map(c => parseFloat(c.trim()));
    if (coords.length !== 2 || isNaN(coords[0]) || isNaN(coords[1])) {
        alert('Invalid map coordinates');
        return;
    }
    
    // Update modal content
    document.getElementById('modalEventName').textContent = eventName;
    document.getElementById('modalLocationName').textContent = locationName;
    
    // Update Google Maps link
    const googleMapsUrl = `https://www.google.com/maps?q=${coords[0]},${coords[1]}`;
    document.getElementById('openInGoogleMaps').href = googleMapsUrl;
    
    // Wait for modal to be shown before initializing map
    const mapModal = document.getElementById('mapModal');
    mapModal.addEventListener('shown.bs.modal', function initMap() {
        // Remove existing map if any
        if (modalMap) {
            modalMap.remove();
        }
        
        // Create new map
        modalMap = L.map('modalMap').setView([coords[0], coords[1]], 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19
        }).addTo(modalMap);
        
        // Add marker
        currentMarker = L.marker([coords[0], coords[1]], {
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        }).addTo(modalMap)
        .bindPopup(`<strong>${eventName}</strong><br>${locationName}`)
        .openPopup();
        
        // Fix map display issue
        setTimeout(() => {
            modalMap.invalidateSize();
        }, 100);
        
        // Remove this listener after first execution
        mapModal.removeEventListener('shown.bs.modal', initMap);
    });
}

// Clean up modal map when closed
document.getElementById('mapModal').addEventListener('hidden.bs.modal', function() {
    if (modalMap) {
        modalMap.remove();
        modalMap = null;
    }
});
</script>
<script>
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

// Events Participated Chart
new Chart(document.getElementById('eventsParticipatedChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Events Participated',
            data: @json($eventsParticipatedPerMonth),
            backgroundColor: 'rgba(59,130,246,0.7)',
            borderColor: 'rgba(59,130,246,1)',
            borderWidth: 1
        }]
    }
});

// Trash Collected Chart
new Chart(document.getElementById('trashCollectedChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Trash Collected (kg)',
            data: @json($trashCollectedPerMonth),
            borderColor: 'rgba(0,123,255,1)',
            backgroundColor: 'rgba(0,123,255,0.25)',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    }
});

// Join Event Confirmation
document.querySelectorAll('.join-event-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const eventName = this.dataset.eventName;
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalContent = submitBtn.innerHTML;
        
        // Show confirmation dialog
        if (confirm(`Are you sure you want to join "${eventName}"?\n\nYou will be registered as a participant for this cleanup event.`)) {
            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Joining...';
            
            // Submit form
            this.submit();
        }
    });
});

// Auto-dismiss alerts after 8 seconds
setTimeout(() => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 8000);

// Smooth scroll to alerts
@if(session('success') || session('error') || session('warning'))
    window.scrollTo({ top: 0, behavior: 'smooth' });
@endif
</script>
@endpush
