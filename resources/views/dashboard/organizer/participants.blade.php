@extends('layouts.logged')

@section('title', 'Event Participants')

@push('styles')
<style>
body { background: #1a1a1a; }
.page-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    padding: 40px 20px;
    border-radius: 12px;
    color: #fff;
    margin-bottom: 30px;
}
.page-header h1 { font-size: 2rem; font-weight: 700; margin-bottom: 10px; }
.event-details { background: #2c2c2c; padding: 25px; border-radius: 12px; margin-bottom: 30px; color: #fff; }
.event-details .detail-item { margin-bottom: 12px; font-size: 1rem; }
.event-details .detail-item i { width: 24px; color: #3b82f6; }
.participant-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}
.participant-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(59,130,246,0.2);
}
.participant-header {
    display: flex;
    align-items: center;
    margin-bottom: 12px;
}
.participant-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.5rem;
    font-weight: 700;
    margin-right: 15px;
}
.participant-info h5 { margin: 0; font-size: 1.2rem; font-weight: 700; color: #1e293b; }
.participant-info p { margin: 0; color: #64748b; font-size: 0.9rem; }
.participant-details {
    padding-top: 12px;
    border-top: 1px solid #e2e8f0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
}
.detail-badge {
    background: #f1f5f9;
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 0.85rem;
    color: #475569;
}
.detail-badge i { color: #3b82f6; margin-right: 6px; }
.stats-summary {
    background: linear-gradient(135deg, #2c2c2c 0%, #1e1e1e 100%);
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 30px;
}
.stat-item {
    text-align: center;
    color: #fff;
}
.stat-item .stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #3b82f6;
}
.stat-item .stat-label {
    font-size: 1rem;
    color: #cbd5e1;
}
.no-participants {
    text-align: center;
    padding: 60px 20px;
    background: #2c2c2c;
    border-radius: 12px;
    color: #fff;
}
.no-participants i { font-size: 4rem; color: #64748b; margin-bottom: 20px; }
.btn-back {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: #fff;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s;
}
.btn-back:hover {
    background: linear-gradient(135deg, #495057 0%, #343a40 100%);
    color: #fff;
    transform: translateY(-2px);
}
</style>
@endpush

@section('content')
<div class="container py-4" style="max-width: 1200px;">
    <!-- Page Header -->
    <div class="page-header">
        <a href="{{ route('dashboard.organizer') }}" class="btn-back mb-3">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
        <h1><i class="bi bi-people-fill"></i> Event Participants</h1>
        <p class="mb-0">Volunteers who joined this event</p>
    </div>

    <!-- Event Details -->
    <div class="event-details">
        <h4 class="mb-3" style="color: #3b82f6;">
            <i class="bi bi-calendar-event"></i> {{ $event->evt_name }}
        </h4>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-item">
                    <i class="bi bi-calendar3"></i>
                    <strong>Date:</strong> {{ date('F d, Y', strtotime($event->evt_date)) }}
                    @if($event->end_date && $event->end_date != $event->evt_date)
                        - {{ date('F d, Y', strtotime($event->end_date)) }}
                    @endif
                </div>
                <div class="detail-item">
                    <i class="bi bi-flag"></i>
                    <strong>Status:</strong> 
                    <span class="badge bg-{{ $event->status === 'upcoming' ? 'info' : ($event->status === 'ongoing' ? 'success' : 'secondary') }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </div>
            </div>
            <div class="col-md-6">
                @if($event->location)
                    <div class="detail-item">
                        <i class="bi bi-geo-alt"></i>
                        <strong>Location:</strong> {{ $event->location->evt_loctn_name }}
                    </div>
                @endif
                <div class="detail-item">
                    <i class="bi bi-trash"></i>
                    <strong>Trash Collected:</strong> {{ $event->trsh_collected_kg ?? 0 }} kg
                </div>
            </div>
        </div>
        @if($event->evt_details)
            <div class="detail-item mt-2 pt-2" style="border-top: 1px solid #495057;">
                <i class="bi bi-info-circle"></i>
                <strong>Description:</strong> {{ $event->evt_details }}
            </div>
        @endif
    </div>

    <!-- Stats Summary -->
    <div class="stats-summary">
        <div class="row">
            <div class="col-md-4 stat-item">
                <div class="stat-number">{{ $participants->count() }}</div>
                <div class="stat-label">Total Volunteers</div>
            </div>
            <div class="col-md-4 stat-item">
                <div class="stat-number">{{ $participants->where('participation.0.status', 'confirmed')->count() }}</div>
                <div class="stat-label">Confirmed</div>
            </div>
            <div class="col-md-4 stat-item">
                <div class="stat-number">{{ $participants->sum('totl_evts_partd') }}</div>
                <div class="stat-label">Combined Experience</div>
            </div>
        </div>
    </div>

    <!-- Participants List -->
    <div class="mb-3">
        <h4 style="color: #fff;">
            <i class="bi bi-person-lines-fill"></i> Volunteer List ({{ $participants->count() }})
        </h4>
    </div>

    @forelse($participants as $index => $volunteer)
        <div class="participant-card">
            <div class="participant-header">
                <div class="participant-avatar">
                    {{ strtoupper(substr($volunteer->user->usr_name ?? 'V', 0, 1)) }}
                </div>
                <div class="participant-info">
                    <h5>{{ $volunteer->user->usr_name ?? 'Volunteer' }}</h5>
                    <p>
                        <i class="bi bi-trophy-fill" style="color: #f59e0b;"></i>
                        {{ $volunteer->totl_evts_partd }} events participated
                    </p>
                </div>
                <div class="ms-auto">
                    <span class="badge bg-success px-3 py-2">
                        <i class="bi bi-check-circle-fill"></i> 
                        {{ ucfirst($volunteer->participation->first()->status ?? 'Joined') }}
                    </span>
                </div>
            </div>
            
            <div class="participant-details">
                @if($volunteer->user->details)
                    <div class="detail-badge">
                        <i class="bi bi-envelope"></i>
                        {{ $volunteer->user->details->email_add ?? 'N/A' }}
                    </div>
                    @if($volunteer->user->details->contact_num)
                        <div class="detail-badge">
                            <i class="bi bi-telephone"></i>
                            {{ $volunteer->user->details->contact_num }}
                        </div>
                    @endif
                @endif
                <div class="detail-badge">
                    <i class="bi bi-recycle"></i>
                    {{ $volunteer->totl_trash_collected_kg ?? 0 }} kg trash collected
                </div>
                <div class="detail-badge">
                    <i class="bi bi-calendar-check"></i>
                    Joined: {{ $volunteer->participation->first()->created_at->format('M d, Y') }}
                </div>
            </div>
        </div>
    @empty
        <div class="no-participants">
            <i class="bi bi-inbox"></i>
            <h3>No Volunteers Yet</h3>
            <p class="text-muted">No volunteers have joined this event yet. Share your event to get participants!</p>
        </div>
    @endforelse

</div>
@endsection
