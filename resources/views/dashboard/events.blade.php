@extends('layouts.logged')

@section('title', 'Upcoming Events')
@section('events', 'active')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
body { 
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    scroll-behavior: smooth; 
    min-height: 100vh;
}

.hero-section { 
    padding: 80px 20px 60px; 
    text-align: center; 
    background: linear-gradient(135deg, rgba(0, 119, 182, 0.95) 0%, rgba(0, 180, 216, 0.95) 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    animation: pulse 15s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.hero-content { position: relative; z-index: 1; }
.hero-content h1 { 
    font-size: 3rem; 
    font-weight: 800; 
    color: #fff; 
    margin-bottom: 20px; 
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    display: inline-flex;
    align-items: center;
    gap: 15px;
}

.hero-content h1 i {
    font-size: 3rem;
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.hero-content p { 
    font-size: 1.3rem; 
    color: rgba(255, 255, 255, 0.95);
    max-width: 700px;
    margin: 0 auto;
}
.event-map-preview { 
    height: 200px; 
    width: 100%; 
    border-radius: 12px; 
    margin-top: 12px; 
    cursor: pointer; 
    border: 2px solid rgba(0, 119, 182, 0.2); 
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.event-map-preview:hover { 
    border-color: #0077b6; 
    box-shadow: 0 8px 20px rgba(0, 119, 182, 0.3);
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
    background: linear-gradient(135deg, rgba(0, 119, 182, 0.1) 0%, rgba(0, 180, 216, 0.1) 100%); 
    color: #0077b6; 
    border: 1px solid rgba(0, 119, 182, 0.3); 
    padding: 8px 16px; 
    border-radius: 10px; 
    font-size: 0.9rem; 
    font-weight: 600; 
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.view-map-btn:hover { 
    background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%); 
    color: #fff; 
    border-color: #0077b6;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 119, 182, 0.3);
}
.container-events { 
    max-width: 1400px; 
    margin: 40px auto; 
    padding: 0 20px; 
}

.event-card { 
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    color: #1e293b;
    padding: 28px; 
    border-radius: 20px; 
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(0, 119, 182, 0.1);
    position: relative;
    overflow: hidden;
}

.event-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(0, 119, 182, 0.1) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.4s ease;
}

.event-card:hover::before {
    opacity: 1;
}

.event-card:hover { 
    transform: translateY(-8px) scale(1.02); 
    box-shadow: 0 20px 50px rgba(0, 119, 182, 0.25);
    border-color: #0077b6;
}
.event-title { 
    font-size: 1.5rem; 
    font-weight: 800; 
    background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 16px;
    position: relative;
    z-index: 1;
}

.event-detail { 
    font-size: 1rem; 
    color: #64748b; 
    margin-bottom: 10px; 
    display: flex; 
    align-items: start;
    position: relative;
    z-index: 1;
}

.event-detail i { 
    width: 26px; 
    margin-right: 10px; 
    color: #0077b6; 
    flex-shrink: 0; 
    margin-top: 3px;
    font-size: 1.1rem;
}

.event-description { 
    font-size: 0.95rem; 
    color: #475569; 
    margin-top: 16px; 
    padding-top: 16px; 
    border-top: 2px solid rgba(0, 119, 182, 0.1); 
    flex-grow: 1;
    position: relative;
    z-index: 1;
    line-height: 1.6;
}
.btn-join { 
    background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%); 
    color: #fff; 
    border: none;
    border-radius: 12px; 
    font-weight: 700; 
    padding: 14px 24px; 
    font-size: 1rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 15px rgba(0, 119, 182, 0.3);
    width: 100%;
    margin-top: 20px;
    position: relative;
    z-index: 1;
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
    background: linear-gradient(135deg, #005f8a 0%, #0096b8 100%); 
    color: #fff; 
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 8px 25px rgba(0, 119, 182, 0.5);
}

.btn-join:disabled { 
    opacity: 0.6; 
    cursor: not-allowed;
    transform: none !important;
}
.badge { 
    font-size: 0.9rem; 
    font-weight: 600; 
    padding: 8px 16px; 
    border-radius: 10px;
}

.alert { 
    border: none; 
    border-radius: 16px; 
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
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

.search-box { 
    max-width: 400px; 
    border-radius: 12px; 
    border: 2px solid rgba(0, 119, 182, 0.2); 
    padding: 12px 18px;
    background: rgba(255, 255, 255, 0.95);
    transition: all 0.3s ease;
}

.search-box:focus { 
    border-color: #0077b6; 
    box-shadow: 0 0 0 4px rgba(0, 119, 182, 0.15);
    background: #fff;
    outline: none;
}

.section-header { 
    color: #fff; 
    margin-bottom: 35px;
    font-weight: 700;
    font-size: 1.8rem;
}

.spinner-border-sm { 
    width: 1rem; 
    height: 1rem; 
    border-width: 0.15em; 
}
</style>
@endpush

@section('content')

<!-- Hero -->
<section class="hero-section">
    <div class="hero-content">
        <h1><i class="bi bi-calendar-check"></i> Upcoming Cleanup Events</h1>
        <p>Join community-driven cleanup initiatives and make a positive environmental impact!</p>
    </div>
</section>

<!-- Alerts -->
<div class="container-events">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
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
        <div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-3" style="font-size: 1.5rem;"></i>
                <div>{{ session('warning') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-x-circle-fill me-3" style="font-size: 1.5rem;"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

<!-- Events List -->
<div class="container-events">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="section-header mb-0">
            <i class="bi bi-calendar-event"></i> Available Events 
            <span class="badge bg-primary">{{ $upcomingEvents->count() }}</span>
        </h2>
        <input type="text" id="searchInput" class="form-control search-box" placeholder="🔍 Search events..." onkeyup="filterEvents()">
    </div>

    <div class="row g-4" id="eventsContainer">
        @forelse($upcomingEvents as $event)
        <div class="col-lg-4 col-md-6 event-card-wrapper">
            <div class="event-card">
                <div class="event-title">{{ $event->evt_name }}</div>
                
                <div class="event-detail">
                    <i class="bi bi-calendar3"></i>
                    <div>
                        <strong>Date:</strong> {{ date('F d, Y', strtotime($event->evt_date)) }}
                        @if($event->end_date && $event->end_date != $event->evt_date)
                            - {{ date('F d, Y', strtotime($event->end_date)) }}
                        @endif
                    </div>
                </div>
                
                <div class="event-detail">
                    <i class="bi bi-person-badge"></i>
                    <div><strong>Organizer:</strong> {{ $event->organizer->org_name ?? 'N/A' }}</div>
                </div>
                
                @if($event->location)
                    <div class="event-detail">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <strong>Location:</strong> {{ $event->location->evt_loctn_name }}
                            @if($event->location->map_details)
                                <button type="button" class="view-map-btn ms-2" 
                                        onclick="showEventMap({{ $event->evt_id }}, '{{ $event->location->map_details }}', '{{ addslashes($event->evt_name) }}', '{{ addslashes($event->location->evt_loctn_name) }}')"
                                        data-bs-toggle="modal" data-bs-target="#mapModal">
                                    <i class="bi bi-map"></i> View Map
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    @if($event->location->map_details)
                        <div class="event-map-preview" id="map-preview-{{ $event->evt_id }}" 
                             onclick="showEventMap({{ $event->evt_id }}, '{{ $event->location->map_details }}', '{{ addslashes($event->evt_name) }}', '{{ addslashes($event->location->evt_loctn_name) }}')"
                             data-bs-toggle="modal" data-bs-target="#mapModal"
                             style="background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                            <div class="text-muted" style="font-size: 0.9rem;">
                                <i class="bi bi-hourglass-split"></i> Loading map...
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info mt-2 mb-0" style="font-size: 0.85rem;">
                            <i class="bi bi-info-circle"></i> Map location not available for this event
                        </div>
                    @endif
                @endif
                
                <div class="event-detail">
                    <i class="bi bi-flag"></i>
                    <div>
                        <strong>Status:</strong> 
                        <span class="badge bg-primary">{{ ucfirst($event->status) }}</span>
                    </div>
                </div>
                
                @if($event->evt_details)
                    <div class="event-description">
                        <strong>About:</strong> {{ Str::limit($event->evt_details, 120) }}
                    </div>
                @endif
                
                @if($isVolunteer)
                    <form action="{{ route('volunteer.joinEvent', $event->evt_id) }}" method="POST" class="join-event-form" data-event-name="{{ $event->evt_name }}">
                        @csrf
                        <button type="submit" class="btn-join">
                            <i class="bi bi-person-plus"></i> Join This Event
                        </button>
                    </form>
                @else
                    <div class="mt-3 text-center text-muted">
                        <small><i class="bi bi-info-circle"></i> Login as volunteer to join events</small>
                    </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-calendar-x" style="font-size: 4rem; color:#64748b;"></i>
            <p class="mt-3 text-light fs-5">No upcoming events available at the moment.</p>
            <p class="text-muted">Check back later for new cleanup initiatives!</p>
        </div>
        @endforelse
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

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
// Store map instances
let previewMaps = {};
let modalMap = null;
let currentMarker = null;

// Initialize preview maps for each event
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, checking for Leaflet...');
    
    // Check if Leaflet is loaded
    if (typeof L === 'undefined') {
        console.error('Leaflet is not loaded!');
        return;
    }
    
    console.log('Leaflet is loaded, initializing event maps...');
    
    // Add a small delay to ensure everything is ready
    setTimeout(function() {
        @foreach($upcomingEvents as $event)
            @if($event->location && $event->location->map_details)
                console.log('Event {{ $event->evt_id }}: {{ $event->location->map_details }}');
                initPreviewMap({{ $event->evt_id }}, '{{ $event->location->map_details }}');
            @else
                console.log('Event {{ $event->evt_id }}: No location or map details');
            @endif
        @endforeach
    }, 500);
});

// Initialize small preview map
function initPreviewMap(eventId, coordinates) {
    console.log('InitPreviewMap called for event:', eventId, 'coords:', coordinates);
    const mapElement = document.getElementById('map-preview-' + eventId);
    if (!mapElement) {
        console.error('Map element not found for event:', eventId);
        return;
    }
    
    const coords = coordinates.split(',').map(c => parseFloat(c.trim()));
    if (coords.length !== 2 || isNaN(coords[0]) || isNaN(coords[1])) {
        console.error('Invalid coordinates:', coordinates);
        return;
    }
    
    console.log('Creating map for event:', eventId, 'at coords:', coords);
    
    try {
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
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        })
    }).addTo(map);
        
        previewMaps[eventId] = map;
        
        // Remove "Loading map..." text
        const loadingText = mapElement.querySelector('.text-muted');
        if (loadingText) {
            loadingText.remove();
        }
        
        console.log('Map created successfully for event:', eventId);
    } catch (error) {
        console.error('Error creating map for event:', eventId, error);
        mapElement.innerHTML = '<div class="text-danger" style="padding: 20px; text-align: center;"><i class="bi bi-exclamation-triangle"></i> Map failed to load</div>';
    }
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

// Filter events search
function filterEvents() {
    const input = document.getElementById('searchInput').value.toUpperCase();
    const cards = document.querySelectorAll('.event-card-wrapper');

    cards.forEach(card => {
        const title = card.querySelector('.event-title').textContent.toUpperCase();
        const text = card.textContent.toUpperCase();
        card.style.display = text.indexOf(input) > -1 ? '' : 'none';
    });
}

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

// Smooth scroll to alerts on success
@if(session('success') || session('error') || session('warning'))
    window.scrollTo({ top: 0, behavior: 'smooth' });
@endif
</script>
@endpush
