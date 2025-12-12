<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Organizer;
use App\Models\OrganizerChart;
use App\Models\Event;
use App\Http\Controllers\EventController;

class OrganizerController extends Controller
{
    public function dashboard()
    {
        $orgId = Auth::id(); // Logged-in user ID

        // Get or create organizer record
        $organizer = Organizer::firstOrCreate(
            ['org_id' => $orgId],
            [
                'org_name' => Auth::user()->name ?? 'Organizer',
                'totl_evts_orgzd' => 0,
                'totl_trsh_collected_kg' => 0,
                'totl_partpts_overall' => 0,
            ]
        );

        // Update event statuses and get upcoming/ongoing events
        $trackedEvents = EventController::trackEvents($orgId);
        
        // Load participants for upcoming and ongoing events
        foreach ($trackedEvents['upcoming'] as $event) {
            $event->load(['participants.user.details']);
        }
        foreach ($trackedEvents['ongoing'] as $event) {
            $event->load(['participants.user.details']);
        }

        // Monthly totals for charts
        $chartData = OrganizerChart::where('org_id', $orgId)
                                   ->orderBy('month')
                                   ->get();

        $eventsPerMonth       = array_fill(1, 12, 0);
        $trashPerMonth        = array_fill(1, 12, 0);
        $participantsPerMonth = array_fill(1, 12, 0);

        foreach ($chartData as $row) {
            $eventsPerMonth[$row->month]       = $row->evts_orgzd_count;
            $participantsPerMonth[$row->month] = $row->totl_partpts_count;
        }

        // Trash collected from events table
        $events = Event::where('org_id', $orgId)->get();
        foreach ($events as $ev) {
            $month = intval(date('m', strtotime($ev->evt_date)));
            $trashPerMonth[$month] += $ev->trsh_collected_kg;
        }

        return view('dashboard.organizer.index', [
            'organizer'          => $organizer,
            'eventsPerMonth'     => array_values($eventsPerMonth),
            'trashPerMonth'      => array_values($trashPerMonth),
            'participantsPerMonth' => array_values($participantsPerMonth),
            'upcomingEvents'     => $trackedEvents['upcoming'],
            'ongoingEvents'      => $trackedEvents['ongoing'],
        ]);
    }

    public function showParticipants($eventId)
    {
        $orgId = Auth::id();

        // Get the event and verify it belongs to this organizer
        $event = Event::with(['organizer', 'location'])
            ->where('evt_id', $eventId)
            ->where('org_id', $orgId)
            ->firstOrFail();

        // Get all participants for this event with their user details
        $participants = \App\Models\Volunteer::whereHas('participation', function($query) use ($eventId) {
            $query->where('evt_id', $eventId);
        })
        ->with(['user.details', 'participation' => function($query) use ($eventId) {
            $query->where('evt_id', $eventId);
        }])
        ->get();

        return view('dashboard.organizer.participants', [
            'event' => $event,
            'participants' => $participants
        ]);
    }
}
