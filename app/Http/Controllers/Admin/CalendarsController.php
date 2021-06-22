<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Http\Requests\Admin\Calendar\BulkDestroyCalendar;
// use App\Http\Requests\Admin\Calendar\DestroyCalendar;
use App\Http\Requests\Admin\Announcement\IndexAnnouncement;
// use App\Http\Requests\Admin\Calendar\StoreCalendar;
// use App\Http\Requests\Admin\Calendar\UpdateCalendar;
use App\Models\Calendar;
use App\Models\Announcement; 
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CalendarsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCalendar $request
     * @return array|Factory|View
     */
    public function index(IndexAnnouncement $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Announcement::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id',  'header_img', 'title', 'description', 'url', 'event_type_id', 'starts_at', 'ends_at'],

            // set columns to searchIn
            ['id', 'header_img', 'title', 'description', 'url'],
            function ($query) use ($request){ 
                $query->with('event_types');
            }
        );
        
        $events = []; 
        foreach($data as $value){ 
            $events[] = \Calendar::event(
                $value->title, //event title
                false, //full day event?
                $value->starts_at, //start time (you can also use Carbon instead of DateTime)
                $value->ends_at, //end time (you can also use Carbon instead of DateTime)
                $value->id, //optionally, you can specify an event ID
                [
                    'description' => $value->description,
                    'type' => $value->event_types->name,
                    'img' => count($value->getMedia('header')) == 0 ? null : $value->getMedia('header')[0]->getUrl(),
                ]
            );
        }

        $calendar = \Calendar::addEvents($events)
        ->setOptions([
            'locale' => 'en',
            'firstDay' => 0,
            'displayEventTime' => true,
            'selectable' => true,
            'initialView' => 'dayGridMonth',
            'headerToolbar' => [
                'end' => 'today prev,next dayGridMonth timeGridWeek timeGridDay'
            ],
            'height' => '90vh',
        ]);
        $calendar->setId('1');
        $calendar->setCallbacks([
            'select' => 'function(selectionInfo){
            }',
            'eventClick' => 'function(event){
                console.log(event.event.extendedProps.img);
                $("#headerImage").css("background-image", "url("+ event.event.extendedProps.img +")");
                $("#modalTitle").html(event.event.title);
                $("#eventStart").html( event.event.start);
                $("#eventEnd").html( event.event.end);
                $("#modalBody").html(event.event.extendedProps.description);
                $("#badge_event").html(event.event.extendedProps.type);
                $("#eventUrl").attr("href",event.event.url);
                $("#calendarModal").modal();
            }'
        ]);

        return view('admin.calendar.index', compact('calendar'));
    }

    /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @throws AuthorizationException
    //  * @return Factory|View
    //  */
    // public function create()
    // {
    //     $this->authorize('admin.calendar.create');

    //     return view('admin.calendar.create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param StoreCalendar $request
    //  * @return array|RedirectResponse|Redirector
    //  */
    // public function store(StoreCalendar $request)
    // {
    //     // Sanitize input
    //     $sanitized = $request->getSanitized();

    //     // Store the Calendar
    //     $calendar = Calendar::create($sanitized);

    //     if ($request->ajax()) {
    //         return ['redirect' => url('admin/calendars'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
    //     }

    //     return redirect('admin/calendars');
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param Calendar $calendar
    //  * @throws AuthorizationException
    //  * @return void
    //  */
    // public function show(Calendar $calendar)
    // {
    //     $this->authorize('admin.calendar.show', $calendar);

    //     // TODO your code goes here
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param Calendar $calendar
    //  * @throws AuthorizationException
    //  * @return Factory|View
    //  */
    // public function edit(Calendar $calendar)
    // {
    //     $this->authorize('admin.calendar.edit', $calendar);


    //     return view('admin.calendar.edit', [
    //         'calendar' => $calendar,
    //     ]);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param UpdateCalendar $request
    //  * @param Calendar $calendar
    //  * @return array|RedirectResponse|Redirector
    //  */
    // public function update(UpdateCalendar $request, Calendar $calendar)
    // {
    //     // Sanitize input
    //     $sanitized = $request->getSanitized();

    //     // Update changed values Calendar
    //     $calendar->update($sanitized);

    //     if ($request->ajax()) {
    //         return [
    //             'redirect' => url('admin/calendars'),
    //             'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
    //         ];
    //     }

    //     return redirect('admin/calendars');
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param DestroyCalendar $request
    //  * @param Calendar $calendar
    //  * @throws Exception
    //  * @return ResponseFactory|RedirectResponse|Response
    //  */
    // public function destroy(DestroyCalendar $request, Calendar $calendar)
    // {
    //     $calendar->delete();

    //     if ($request->ajax()) {
    //         return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    //     }

    //     return redirect()->back();
    // }

    // /**
    //  * Remove the specified resources from storage.
    //  *
    //  * @param BulkDestroyCalendar $request
    //  * @throws Exception
    //  * @return Response|bool
    //  */
    // public function bulkDestroy(BulkDestroyCalendar $request) : Response
    // {
    //     DB::transaction(static function () use ($request) {
    //         collect($request->data['ids'])
    //             ->chunk(1000)
    //             ->each(static function ($bulkChunk) {
    //                 Calendar::whereIn('id', $bulkChunk)->delete();

    //                 // TODO your code goes here
    //             });
    //     });

    //     return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    // }
}
