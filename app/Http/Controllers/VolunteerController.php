<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Volunteer;
use App\Models\VolunteerChart;
use App\Models\User;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VolunteerController extends Controller
{
    // Dashboard
    public function index()
    {
        $userId = auth()->id();
        $user = User::find($userId);

        $volunteer = Volunteer::where('vol_id', $userId)->first();
        if (!$volunteer) {
            return redirect()->back()->with('error', 'Volunteer data not found.');
        }
        $volunteer->usr_name = $user->usr_name;

        // Monthly chart data
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        $eventsParticipatedPerMonth = [];
        $trashCollectedPerMonth = [];

        foreach ($months as $index => $monthName) {
            $monthNumber = $index + 1;
            $chartData = VolunteerChart::where('vol_id', $volunteer->vol_id)
                ->whereMonth('created_at', $monthNumber)
                ->first();
            
            $eventsParticipatedPerMonth[] = $chartData ? $chartData->evts_partd_count : 0;
            $trashCollectedPerMonth[] = $chartData ? $chartData->trash_collected_kg ?? 0 : 0;
        }

        // Joined events
        $joinedEvents = Event::with(['organizer', 'location'])
            ->whereHas('participants', function($q) use ($volunteer) {
                $q->where('volunteer.vol_id', $volunteer->vol_id);
            })
            ->orderBy('evt_date')
            ->get();

        return view('dashboard.volunteer.index', [
            'volunteer' => $volunteer,
            'eventsParticipatedPerMonth' => $eventsParticipatedPerMonth,
            'trashCollectedPerMonth' => $trashCollectedPerMonth,
            'joinedEvents' => $joinedEvents
        ]);
    }

    // Join an event
    public function joinEvent($eventId)
    {
        $userId = auth()->id();
        $volunteer = Volunteer::where('vol_id', $userId)->first();
        
        if (!$volunteer) {
            return redirect()->back()->with('error', 'Volunteer data not found.');
        }

        $event = Event::with('organizer')->find($eventId);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        // Check if already joined
        $alreadyJoined = DB::table('event_participation')
            ->where('vol_id', $volunteer->vol_id)
            ->where('evt_id', $event->evt_id)
            ->exists();

        if ($alreadyJoined) {
            return redirect()->back()->with('warning', 'You have already joined this event!');
        }

        // Insert participation
        DB::table('event_participation')->insert([
            'vol_id' => $volunteer->vol_id,
            'evt_id' => $event->evt_id,
            'status' => 'confirmed',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Update volunteer's currently joined events count
        $volunteer->evt_curr_joined = DB::table('event_participation')
            ->where('vol_id', $volunteer->vol_id)
            ->count();
        $volunteer->save();

        // Update organizer's total participants count
        if ($event->organizer) {
            $organizer = $event->organizer;
            $organizer->totl_partpts_overall = DB::table('event_participation')
                ->whereIn('evt_id', function($query) use ($organizer) {
                    $query->select('evt_id')
                          ->from('event')
                          ->where('org_id', $organizer->org_id);
                })
                ->count();
            $organizer->save();
        }

        return redirect()->back()->with([
            'success' => 'Successfully joined the event!',
            'event_name' => $event->evt_name,
            'event_date' => $event->evt_date,
            'organizer_name' => $event->organizer->org_name ?? 'Unknown'
        ]);
    }

    /**
     * Show form to report trash collected for a specific event
     */
    public function showReportTrash($eventId)
    {
        $userId = auth()->id();
        $volunteer = Volunteer::where('vol_id', $userId)->first();
        
        if (!$volunteer) {
            return redirect()->back()->with('error', 'Volunteer data not found.');
        }

        $event = Event::with(['organizer', 'location'])->find($eventId);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        // Check if volunteer joined this event
        $participation = DB::table('event_participation')
            ->where('vol_id', $volunteer->vol_id)
            ->where('evt_id', $event->evt_id)
            ->first();

        if (!$participation) {
            return redirect()->back()->with('error', 'You have not joined this event.');
        }

        // Check if already reported
        $existingReport = DB::table('trash_collection_record')
            ->where('vol_id', $volunteer->vol_id)
            ->where('evt_id', $event->evt_id)
            ->first();

        return view('dashboard.volunteer.reportTrash', compact('event', 'volunteer', 'existingReport'));
    }

    /**
     * Submit trash collection report
     */
    public function submitTrashReport(Request $request, $eventId)
    {
        $userId = auth()->id();
        $volunteer = Volunteer::where('vol_id', $userId)->first();
        
        if (!$volunteer) {
            return redirect()->back()->with('error', 'Volunteer data not found.');
        }

        $request->validate([
            'trash_collected_kg' => 'required|numeric|min:0|max:10000',
        ]);

        $event = Event::find($eventId);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        // Check if volunteer joined this event
        $participation = DB::table('event_participation')
            ->where('vol_id', $volunteer->vol_id)
            ->where('evt_id', $event->evt_id)
            ->exists();

        if (!$participation) {
            return redirect()->back()->with('error', 'You have not joined this event.');
        }

        DB::beginTransaction();
        try {
            // Check if already reported
            $existingReport = DB::table('trash_collection_record')
                ->where('vol_id', $volunteer->vol_id)
                ->where('evt_id', $event->evt_id)
                ->first();

            $trashAmount = $request->trash_collected_kg;

            if ($existingReport) {
                // Update existing report
                $oldAmount = $existingReport->trash_collected_kg;
                $difference = $trashAmount - $oldAmount;

                DB::table('trash_collection_record')
                    ->where('vol_id', $volunteer->vol_id)
                    ->where('evt_id', $event->evt_id)
                    ->update([
                        'trash_collected_kg' => $trashAmount,
                        'updated_at' => now()
                    ]);

                // Update volunteer total
                $volunteer->totl_trash_collected_kg += $difference;
                $volunteer->save();

                // Update event total
                $event->trsh_collected_kg += $difference;
                $event->save();

                $message = 'Trash collection report updated successfully!';
            } else {
                // Create new report
                DB::table('trash_collection_record')->insert([
                    'vol_id' => $volunteer->vol_id,
                    'evt_id' => $event->evt_id,
                    'trash_collected_kg' => $trashAmount,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Update volunteer total
                $volunteer->totl_trash_collected_kg += $trashAmount;
                $volunteer->save();

                // Update event total
                $event->trsh_collected_kg += $trashAmount;
                $event->save();

                // Update volunteer chart for the month
                $month = intval(date('m', strtotime($event->evt_date)));
                $chart = VolunteerChart::firstOrNew([
                    'vol_id' => $volunteer->vol_id,
                    'month' => $month
                ]);
                $chart->trash_collected_kg = ($chart->trash_collected_kg ?? 0) + $trashAmount;
                $chart->save();

                $message = 'Trash collection reported successfully!';
            }

            // Update organizer's total trash collected
            if ($event->organizer) {
                $organizer = $event->organizer;
                $organizer->totl_trsh_collected_kg = DB::table('event')
                    ->where('org_id', $organizer->org_id)
                    ->sum('trsh_collected_kg');
                $organizer->save();
            }

            DB::commit();

            return redirect()->route('dashboard.volunteer')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to submit report: ' . $e->getMessage());
        }
    }
}
