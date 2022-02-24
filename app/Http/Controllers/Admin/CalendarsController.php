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
            ['id', 'model_id',  'header_img', 'title', 'description', 'url', 'event_type_id', 'starts_at', 'ends_at'],

            // set columns to searchIn
            ['id', 'header_img', 'title', 'description', 'url'],
            function ($query) use ($request){ 
                $query->with(['admin_user', 'admin_user.user_school' ,'event_types']);
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
                    'created_by' => (is_null($value->admin_user->user_school)) ? 'Administrator' : $value->admin_user->user_school->name,
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
                if( event.event.extendedProps.img != null){
                    $("#headerImage").css("background-image", "url("+ event.event.extendedProps.img +")");
                }else{
                    $("#headerImage").remove();
                }
                
                $("#modalTitle").html(event.event.title);
                $("#createdBy").html( event.event.extendedProps.created_by);
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
}
