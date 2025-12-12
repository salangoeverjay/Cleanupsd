@extends('layouts.logged')

@section('title', 'Organizer Dashboard')

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

/* Modern Stat Cards */
.card {
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(255, 255, 255, 0.95);
}

.card h5 {
    color: #1e293b;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.card h5 i {
    color: #0077b6;
    font-size: 1.2rem;
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

.stat-card-gradient-create {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    cursor: pointer;
    position: relative;
}

.stat-card-gradient-create:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
}

.stat-card-gradient-create i {
    transition: transform 0.3s ease;
}

.stat-card-gradient-create:hover i {
    transform: rotate(90deg) scale(1.1);
}

.stat-card-gradient-1 {
    background: linear-gradient(135deg, #3b82f6 0%, #6c757d 100%);
}

.stat-card-gradient-2 {
    background: linear-gradient(135deg, #3c68b1 0%, #6c757d 100%);
}

.stat-card-gradient-3 {
    background: linear-gradient(135deg, #375a7f 0%, #6c757d 100%);
}

/* Modern Chart Containers */
.chart-container {
    padding: 30px;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.chart-container h5 {
    color: white;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 20px;
}

/* Modern Event Cards */
.event-list .card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 119, 182, 0.1);
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
    color: #0077b6;
}

.event-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    color: #1e293b;
    padding: 24px;
    border-radius: 16px;
    margin-bottom: 16px;
    border: 1px solid rgba(0, 119, 182, 0.1);
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
    background: linear-gradient(90deg, transparent, rgba(0, 119, 182, 0.1), transparent);
    transition: left 0.5s ease;
}

.event-card:hover::before {
    left: 100%;
}

.event-card:hover {
    transform: translateY(-4px) scale(1.01);
    box-shadow: 0 12px 30px rgba(0, 119, 182, 0.25);
    border-color: #0077b6;
}

.event-card strong {
    color: #0f172a;
    font-size: 1.2rem;
}

.event-card .badge {
    font-size: 0.85rem;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 8px;
}

.event-card .btn {
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.event-card .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.text-white-card {
    color: white !important;
}

/* Alert Styling */
.alert {
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.alert-success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.2) 100%);
    color: #10b981;
    border-color: rgba(16, 185, 129, 0.3);
}

.alert-danger {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.2) 0%, rgba(220, 38, 38, 0.2) 100%);
    color: #ef4444;
    border-color: rgba(239, 68, 68, 0.3);
}

/* Modern Create Event Modal */
.create-event-modal {
    border-radius: 24px;
    border: none;
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.create-event-modal .modal-header {
    background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
    color: white;
    border-radius: 24px 24px 0 0;
    padding: 24px 28px;
    border: none;
}

.create-event-modal .modal-title {
    font-weight: 800;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
}

.create-event-modal .modal-title i {
    font-size: 1.8rem;
}

.create-event-modal .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.create-event-modal .btn-close:hover {
    opacity: 1;
    transform: rotate(90deg);
    transition: all 0.3s ease;
}

.create-event-modal .modal-body {
    padding: 32px 28px;
}

.create-event-modal .form-label {
    font-weight: 700;
    color: #1e293b;
    font-size: 1rem;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.create-event-modal .form-label i {
    color: #0077b6;
    font-size: 1.1rem;
}

.create-event-modal .form-control,
.create-event-modal .form-select {
    border-radius: 12px;
    padding: 12px 16px;
    border: 2px solid rgba(0, 119, 182, 0.2);
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.create-event-modal .form-control:focus,
.create-event-modal .form-select:focus {
    border-color: #0077b6;
    box-shadow: 0 0 0 4px rgba(0, 119, 182, 0.15);
    outline: none;
}

.create-event-modal .form-control::placeholder {
    color: #94a3b8;
}

.create-event-modal textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

.create-event-modal hr {
    border: none;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(0, 119, 182, 0.3), transparent);
}

.create-event-modal .btn-create-event {
    background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
    border: none;
    color: white;
    padding: 14px 24px;
    font-weight: 700;
    font-size: 1.1rem;
    border-radius: 12px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 6px 20px rgba(0, 119, 182, 0.3);
    position: relative;
    overflow: hidden;
}

.create-event-modal .btn-create-event::before {
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

.create-event-modal .btn-create-event:hover::before {
    width: 300px;
    height: 300px;
}

.create-event-modal .btn-create-event:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 119, 182, 0.5);
}

.create-event-modal .text-muted {
    color: #64748b !important;
    font-size: 0.85rem;
    display: block;
    margin-top: 6px;
}

#eventMap {
    border: 2px solid rgba(0, 119, 182, 0.2);
    transition: border-color 0.3s ease;
    width: 100%;
    height: 300px;
    z-index: 1;
}

#eventMap:hover {
    border-color: #0077b6;
}

.leaflet-container {
    font-family: inherit;
}
</style>
@endpush


@section('content')
<div class="container-dashboard p-4">
    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
    @endif
    <div class="dashboard-header">
        <div style="margin-left: 1rem;">
            <h1 class="dashboard-greeting"><i class="bi bi-speedometer2 me-3"></i>Welcome, Organizer!</h1>
            <p class="text-white mt-3 mb-0" style="font-size: 1.1rem; opacity: 0.8;">
                <i class="bi bi-building me-2"></i>{{ $organizer->org_name ?? 'Your Organization' }}
            </p>
        </div>
    </div>

    <!-- Top Stats -->
<div class="row g-4 mb-4 justify-content-center text-center">
    <div class="col-md-3">
        <div class="card p-3 stat-card stat-card-gradient-create text-center" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#createEventModal">
            <h5 class="text-white-card mb-3"style="font-size: 1.5rem;">Create Event</h5>
            <h3 class="text-white-card">
                <i class="bi bi-plus-circle" style="font-size: 2.3rem;"></i>
            </h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 stat-card stat-card-gradient-1">
            <h5 class="text-white-card">Total Events</h5>
            <h3 class="text-white-card">{{ $organizer->totl_evts_orgzd }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 stat-card stat-card-gradient-2">
            <h5 class="text-white-card">Total Trash (kg)</h5>
            <h3 class="text-white-card">{{ $organizer->totl_trsh_collected_kg }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-3 stat-card stat-card-gradient-3">
            <h5 class="text-white-card">Total Participants</h5>
            <h3 class="text-white-card">{{ $organizer->totl_partpts_overall }}</h3>
        </div>
    </div>
</div>


    <!-- Charts -->
    <div class="row g-4 justify-content-center">
        <div class="col-md-6">
            <div class="card chart-container">
                <h5 class="mb-3 text-center">Monthly Trash Collected (kg)</h5>
                <canvas id="trashChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card chart-container">
                <h5 class="mb-3 text-center">Events Per Month</h5>
                <canvas id="eventsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card chart-container">
                <h5 class="mb-3 text-center">Volunteer Participation</h5>
                <canvas id="participantsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Upcoming and Ongoing Events -->
<div class="event-list row mt-4">

    <!-- UPCOMING EVENTS -->
    <div class="col-md-6">
        <div class="card mb-3 p-4">
            <h5><i class="bi bi-calendar-event"></i>Upcoming Events</h5>

            @forelse($upcomingEvents as $event)
                <div class="event-card mb-3 p-3" style="background:#fff; color:#000; border-radius:10px;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div style="flex: 1;">
                            <strong style="font-size: 1.1rem;">{{ $event->evt_name }}</strong><br>
                            <small class="text-muted">
                                <i class="bi bi-calendar3"></i> {{ date('M d, Y', strtotime($event->evt_date)) }}
                            </small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info d-block mb-2">{{ ucfirst($event->status) }}</span>
                            <a href="{{ route('organizer.eventParticipants', $event->evt_id) }}" 
                               class="btn btn-sm btn-primary" style="font-size: 0.8rem;">
                                <i class="bi bi-people-fill"></i> Participants
                            </a>
                        </div>
                    </div>
                    
                    @if($event->participants && $event->participants->count() > 0)
                        <div class="mt-2 pt-2" style="border-top: 1px solid #e0e0e0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-people-fill"></i> 
                                    <strong>{{ $event->participants->count() }} Volunteer{{ $event->participants->count() > 1 ? 's' : '' }} Joined:</strong>
                                </small>
                            </div>
                            <div class="mt-2">
                                @foreach($event->participants->take(5) as $volunteer)
                                    <span class="badge bg-primary me-1 mb-1">
                                        <i class="bi bi-person-check"></i> {{ $volunteer->user->usr_name ?? 'Unknown' }}
                                    </span>
                                @endforeach
                                @if($event->participants->count() > 5)
                                    <span class="badge bg-secondary mb-1">+{{ $event->participants->count() - 5 }} more</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mt-2 pt-2" style="border-top: 1px solid #e0e0e0;">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> No volunteers joined yet
                            </small>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-4">
                    <i class="bi bi-exclamation-circle" style="font-size: 2.5rem; color:#ffffff;"></i>
                    <p class="mt-2 text-light">No upcoming events.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ONGOING EVENTS -->
    <div class="col-md-6">
        <div class="card mb-3 p-4">
            <h5><i class="bi bi-clock-history"></i>Ongoing Events</h5>

            @forelse($ongoingEvents as $event)
                <div class="event-card mb-3 p-3" style="background:#fff; color:#000; border-radius:10px;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div style="flex: 1;">
                            <strong style="font-size: 1.1rem;">{{ $event->evt_name }}</strong><br>
                            <small class="text-muted">
                                <i class="bi bi-calendar3"></i> {{ date('M d, Y', strtotime($event->evt_date)) }}
                            </small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success d-block mb-2">{{ ucfirst($event->status) }}</span>
                            <a href="{{ route('organizer.eventParticipants', $event->evt_id) }}" 
                               class="btn btn-sm btn-success" style="font-size: 0.8rem;">
                                <i class="bi bi-people-fill"></i> Participants
                            </a>
                        </div>
                    </div>
                    
                    @if($event->participants && $event->participants->count() > 0)
                        <div class="mt-2 pt-2" style="border-top: 1px solid #e0e0e0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-people-fill"></i> 
                                    <strong>{{ $event->participants->count() }} Active Volunteer{{ $event->participants->count() > 1 ? 's' : '' }}:</strong>
                                </small>
                            </div>
                            <div class="mt-2">
                                @foreach($event->participants->take(5) as $volunteer)
                                    <span class="badge bg-success me-1 mb-1">
                                        <i class="bi bi-person-check-fill"></i> {{ $volunteer->user->usr_name ?? 'Unknown' }}
                                    </span>
                                @endforeach
                                @if($event->participants->count() > 5)
                                    <span class="badge bg-secondary mb-1">+{{ $event->participants->count() - 5 }} more</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mt-2 pt-2" style="border-top: 1px solid #e0e0e0;">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> No volunteers participating yet
                            </small>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-4">
                    <i class="bi bi-exclamation-circle" style="font-size: 2.5rem; color:#ffffff;"></i>
                    <p class="mt-2 text-light">No ongoing events.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>


</div>

<!-- Create Event Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content create-event-modal">
            <div class="modal-header">
                <h4 class="modal-title" id="createEventModalLabel">
                    <i class="bi bi-calendar-plus me-2"></i>Create New Event
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('organizer.createEvent') }}" id="createEventForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-tag me-2"></i>Event Name</label>
                        <input type="text" name="evt_name" 
                               class="form-control @error('evt_name') is-invalid @enderror" 
                               value="{{ old('evt_name') }}" required
                               placeholder="Enter event name">
                        @error('evt_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-card-text me-2"></i>Event Details</label>
                        <textarea name="evt_details" 
                                  class="form-control @error('evt_details') is-invalid @enderror" 
                                  rows="4" required
                                  placeholder="Describe the cleanup event, goals, and what participants should know">{{ old('evt_details') }}</textarea>
                        @error('evt_details')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label"><i class="bi bi-calendar-event me-2"></i>Event Date</label>
                        <input type="date" name="evt_date" 
                               class="form-control @error('evt_date') is-invalid @enderror" 
                               value="{{ old('evt_date') }}" required>
                        @error('evt_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <hr class="my-4">
                    <h5 class="form-label mb-3"><i class="bi bi-geo-alt-fill me-2"></i>Event Location</h5>

                    <div class="mb-3">
                        <label class="form-label">Click on the map to select event location</label>
                        <div id="eventMap" style="height: 300px; border-radius: 12px; overflow: hidden;"></div>
                        <small class="text-muted">
                            <i class="bi bi-info-circle"></i> Click anywhere on the map to set the event location. You can drag the marker to adjust.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-pin-map me-2"></i>Location Name</label>
                        <input type="text" id="evt_loctn_name" name="evt_loctn_name" 
                               class="form-control @error('evt_loctn_name') is-invalid @enderror" 
                               value="{{ old('evt_loctn_name') }}" required 
                               placeholder="e.g., Central Park, Manila Bay">
                        @error('evt_loctn_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-compass me-2"></i>Coordinates</label>
                        <input type="text" id="map_details" name="map_details" 
                               class="form-control @error('map_details') is-invalid @enderror" 
                               value="{{ old('map_details') }}" readonly
                               placeholder="Click on map to set coordinates">
                        @error('map_details')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Latitude, Longitude (auto-filled when you click the map)</small>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-create-event">
                            <i class="bi bi-check-circle me-2"></i>Create Event
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
// Initialize map when modal is shown
var eventMap = null;
var eventMarker = null;

document.addEventListener('DOMContentLoaded', function() {
    var modalElement = document.getElementById('createEventModal');
    
    if (modalElement) {
        modalElement.addEventListener('shown.bs.modal', function () {
            console.log('Modal shown, initializing map...');
            
            try {
                if (!eventMap) {
                    console.log('Creating new Leaflet map instance...');
                    
                    // Initialize map centered on Philippines (default location)
                    eventMap = L.map('eventMap', {
                        center: [14.5995, 120.9842],
                        zoom: 11,
                        scrollWheelZoom: true
                    });
                    
                    console.log('Map instance created, adding tile layer...');
                    
                    // Add OpenStreetMap tiles (free, no API key needed)
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 19
                    }).addTo(eventMap);
                    
                    console.log('Tile layer added successfully');
                    
                    // Try to get user's current location
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var lat = position.coords.latitude;
                            var lng = position.coords.longitude;
                            console.log('User location:', lat, lng);
                            eventMap.setView([lat, lng], 13);
                            
                            // Add marker at current location
                            if (eventMarker) {
                                eventMap.removeLayer(eventMarker);
                            }
                            eventMarker = L.marker([lat, lng], {
                                draggable: true
                            }).addTo(eventMap);
                            
                            updateEventCoordinates(lat, lng);
                            
                            // Update coordinates when marker is dragged
                            eventMarker.on('dragend', function(e) {
                                var position = eventMarker.getLatLng();
                                updateEventCoordinates(position.lat, position.lng);
                            });
                        }, function(error) {
                            console.log('Geolocation error:', error);
                        });
                    }
                    
                    // Click on map to set location
                    eventMap.on('click', function(e) {
                        var lat = e.latlng.lat;
                        var lng = e.latlng.lng;
                        console.log('Map clicked:', lat, lng);
                        
                        // Remove existing marker if any
                        if (eventMarker) {
                            eventMap.removeLayer(eventMarker);
                        }
                        
                        // Add draggable marker
                        eventMarker = L.marker([lat, lng], {
                            draggable: true
                        }).addTo(eventMap);
                        
                        updateEventCoordinates(lat, lng);
                        
                        // Update coordinates when marker is dragged
                        eventMarker.on('dragend', function(e) {
                            var position = eventMarker.getLatLng();
                            updateEventCoordinates(position.lat, position.lng);
                        });
                    });
                }
                
                // Fix map display issue when modal is shown
                setTimeout(function() {
                    if (eventMap) {
                        console.log('Invalidating map size...');
                        eventMap.invalidateSize();
                    }
                }, 200);
                
            } catch (error) {
                console.error('Error initializing map:', error);
            }
        });
    } else {
        console.error('Modal element not found!');
    }
});

function updateEventCoordinates(lat, lng) {
    // Store coordinates in the form field
    document.getElementById('map_details').value = lat.toFixed(6) + ', ' + lng.toFixed(6);
    
    // Reverse geocoding to get location name (using Nominatim - free service)
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(response => response.json())
        .then(data => {
            if (data.display_name) {
                // Auto-fill location name if it's empty
                var locationInput = document.getElementById('evt_loctn_name');
                if (!locationInput.value) {
                    // Extract relevant parts of the address
                    var address = data.address;
                    var locationName = address.suburb || address.city || address.town || address.village || address.county || 'Selected Location';
                    locationInput.value = locationName;
                }
            }
        })
        .catch(error => {
            console.log('Geocoding error:', error);
        });
}

// Auto-open modal if there are validation errors
@if($errors->any())
    var createEventModal = new bootstrap.Modal(document.getElementById('createEventModal'));
    createEventModal.show();
@endif

const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

new Chart(document.getElementById('trashChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Trash (kg)',
            data: @json($trashPerMonth),
            borderWidth: 2,
            borderColor: 'rgba(0,123,255,1)',
            backgroundColor:'rgba(0,123,255,0.25)',
            tension: 0.3,
            fill: true
        }]
    }
});

new Chart(document.getElementById('eventsChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Events',
            data: @json($eventsPerMonth),
            borderWidth: 1,
            backgroundColor:'rgba(0,123,255,0.7)',
            borderColor:'rgba(0,123,255,1)',
        }]
    }
});

new Chart(document.getElementById('participantsChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: ['Participants'],
        datasets: [{
            data: [{{ $organizer->totl_partpts_overall }}, 100],
            backgroundColor: ['#0d6efd', '#6c757d']
        }]
    },
    options: {
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>
@endpush
