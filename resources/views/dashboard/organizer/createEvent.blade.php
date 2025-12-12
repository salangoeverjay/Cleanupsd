@extends('layouts.logged')

@section ('title', 'Organizer Dashboard')

@section ('dashboard', 'active')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .card {
    border: none;
    border-radius: 18px;
    background: #ffffff;
    box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.12);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

#map {
    height: 400px;
    width: 100%;
    border-radius: 10px;
    border: 1px solid #d0d4d8;
    margin-bottom: 15px;
}

/* Hover zoom effect */
.card:hover {
    transform: scale(1.02);
    box-shadow: 0px 10px 28px rgba(0, 0, 0, 0.18);
}

/* Title */
.card-body h3 {
    font-weight: 700;
    color: #2c3e50;
}

/* --- Form Styling --- */
.form-label {
    font-weight: 600;
    color: #34495e;
}

.form-control {
    border-radius: 10px;
    padding: 10px 14px;
    border: 1px solid #d0d4d8;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.15rem rgba(30, 64, 175, 0.3);
}
.btn-success {
    background: linear-gradient(135deg, #3b82f6, #1e40af); /* Changed to blue gradient */
    border: none;
    padding: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 12px;
    color: #ffffff;
    transition: transform .2s ease, box-shadow .2s ease;
}
.btn-success:hover {
    transform: scale(1.03);
    box-shadow: 0px 8px 20px rgba(30, 64, 175, 0.3); /* Adjusted shadow to match blue */
}

/* Back link styling */
a {
    color: #2980b9;
    font-weight: 600;
}
a:hover {
    color: #1d6fa5;
}

.btn-create-event {
    background-color: #3b82f6;
    border: none;
    padding: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 12px;
    color: #ffffff;
    transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
}

.btn-create-event:hover {
    background-color: #1d74f2;
    transform: scale(1.03);
    box-shadow: 0px 8px 22px rgba(59, 130, 246, 0.35);
}
</style>
@endpush
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Create New Event</h3>

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

                    <form method="POST" action="{{ route('organizer.createEvent') }}">
    @csrf

    <div class="mb-3">
        <label class="form-label">Event Name</label>
        <input type="text" name="evt_name" 
               class="form-control @error('evt_name') is-invalid @enderror" 
               value="{{ old('evt_name') }}" required>
        @error('evt_name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Event Details</label>
        <textarea name="evt_details" 
                  class="form-control @error('evt_details') is-invalid @enderror" 
                  rows="4" required>{{ old('evt_details') }}</textarea>
        @error('evt_details')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Event Date</label>
        <input type="date" name="evt_date" 
               class="form-control @error('evt_date') is-invalid @enderror" 
               value="{{ old('evt_date') }}" required>
        @error('evt_date')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <hr>
    <h5 class="form-label mb-3">Location</h5>

    <div class="mb-3">
        <label class="form-label">Click on the map to select event location</label>
        <div id="map"></div>
        <small class="text-muted">
            <i class="bi bi-info-circle"></i> Click anywhere on the map to set the event location. You can also search for a location using the controls.
        </small>
    </div>

    <div class="mb-3">
        <label class="form-label">Location Name</label>
        <input type="text" id="evt_loctn_name" name="evt_loctn_name" 
               class="form-control @error('evt_loctn_name') is-invalid @enderror" 
               value="{{ old('evt_loctn_name') }}" required 
               placeholder="e.g., Central Park, Manila Bay">
        @error('evt_loctn_name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Coordinates</label>
        <input type="text" id="map_details" name="map_details" 
               class="form-control @error('map_details') is-invalid @enderror" 
               value="{{ old('map_details') }}" readonly
               placeholder="Click on map to set coordinates">
        @error('map_details')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        <small class="text-muted">Latitude, Longitude (auto-filled when you click the map)</small>
    </div>

    <button type="submit" class="btn-create-event w-100">Create Event</button>

    <div class="text-center mt-3">
                            <a href="{{ route('dashboard.organizer') }}">Back to Dashboard</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialize map centered on Philippines (default location)
    var map = L.map('map').setView([14.5995, 120.9842], 11);
    
    // Add OpenStreetMap tiles (free, no API key needed)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);
    
    var marker = null;
    
    // Try to get user's current location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            map.setView([lat, lng], 13);
            
            // Add marker at current location
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng], {
                draggable: true
            }).addTo(map);
            
            updateCoordinates(lat, lng);
            
            // Update coordinates when marker is dragged
            marker.on('dragend', function(e) {
                var position = marker.getLatLng();
                updateCoordinates(position.lat, position.lng);
            });
        }, function(error) {
            console.log('Geolocation error:', error);
        });
    }
    
    // Click on map to set location
    map.on('click', function(e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        
        // Remove existing marker if any
        if (marker) {
            map.removeLayer(marker);
        }
        
        // Add draggable marker
        marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);
        
        updateCoordinates(lat, lng);
        
        // Update coordinates when marker is dragged
        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
        });
    });
    
    function updateCoordinates(lat, lng) {
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
</script>
@endpush
