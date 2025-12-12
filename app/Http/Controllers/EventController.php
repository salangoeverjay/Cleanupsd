<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventLocation;
use App\Models\Organizer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Show all events page
     */
    public function index()
    {
        $user = auth()->user();
        $isVolunteer = $user && $user->registered_as === 'Volunteer';
        $volunteerId = null;

        if ($isVolunteer) {
            $volunteer = \App\Models\Volunteer::where('vol_id', $user->usr_id)->first();
            $volunteerId = $volunteer ? $volunteer->vol_id : null;
        }

        // Get ALL events first (for debugging)
        $allEvents = Event::count();
        \Log::info('Total events in database: ' . $allEvents);
        \Log::info('Today date: ' . Carbon::today());
        
        // Get upcoming events (not yet passed)
        $upcomingEvents = Event::with(['organizer', 'location'])
            ->where('evt_date', '>=', Carbon::today())
            ->orderBy('evt_date', 'asc')
            ->get();

        \Log::info('Upcoming events found: ' . $upcomingEvents->count());
        \Log::info('Events: ' . $upcomingEvents->pluck('evt_name'));

        // If volunteer, show ALL events (don't filter joined ones for now)
        // Comment out the filter to debug
        /*
        if ($volunteerId) {
            $upcomingEvents = $upcomingEvents->filter(function($event) use ($volunteerId) {
                return !DB::table('event_participation')
                    ->where('vol_id', $volunteerId)
                    ->where('evt_id', $event->evt_id)
                    ->exists();
            });
        }
        */

        return view('dashboard.events', compact('upcomingEvents', 'isVolunteer'));
    }

    /**
     * Optional: AJAX search
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $events = Event::with(['organizer', 'location'])
            ->when($query, function($q) use ($query) {
                $q->where('evt_name', 'LIKE', "%$query%")
                  ->orWhere('evt_details', 'LIKE', "%$query%")
                  ->orWhere('evt_date', 'LIKE', "%$query%")
                  ->orWhereHas('location', function($q2) use ($query) {
                      $q2->where('evt_loctn_name', 'LIKE', "%$query%")
                         ->orWhere('map_details', 'LIKE', "%$query%");
                  })
                  ->orWhereHas('organizer', function($q3) use ($query) {
                      $q3->where('org_name', 'LIKE', "%$query%");
                  });
            })
            ->orderBy('evt_date', 'desc')
            ->get();

        return view('dashboard.partials.event_cards', compact('events'))->render();
    }

    public static function trackEvents($orgId)
{
    $today = now()->startOfDay();

    // Fetch events for this organizer
    $events = Event::where('org_id', $orgId)->get();

    $upcoming = [];
    $ongoing  = [];

    foreach ($events as $event) {

        $eventStart = Carbon::parse($event->evt_date)->startOfDay();
        $eventEnd   = Carbon::parse($event->end_date)->endOfDay();

        // Update status automatically
        if ($today < $eventStart) {
            $event->status = 'upcoming';
        } elseif ($today >= $eventStart && $today <= $eventEnd) {
            $event->status = 'ongoing';
        } else {
            $event->status = 'completed';
        }

        $event->save();

        // Push into the arrays for the dashboard
        if ($event->status == 'upcoming') {
            $upcoming[] = $event;
        } elseif ($event->status == 'ongoing') {
            $ongoing[] = $event;
        }
    }

    return [
        'upcoming' => $upcoming,
        'ongoing'  => $ongoing
    ];
}

}
