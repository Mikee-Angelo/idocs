@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.calendar.title'))
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.2/main.css"  />
<script type="application/javascript" src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.2/main.min.js" ></script>

@section('body')

    {!! $calendar->calendar() !!}

<div id="calendarModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-block">                
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
   
            </div>
            <div class="modal-body">                
                <h4 id="modalTitle" class="modal-title text-left mb-1"></h4>
                <h4><span class="badge badge-primary mb-2" id="badge_event"></span></h4>
                <span class="font-weight-bold">Starts At : <p id="eventStart" class="modal-title text-left mb-3 font-weight-normal"></p></span>
                <span class="font-weight-bold">Ends At : <p id="eventEnd" class="modal-title text-left font-weight-normal"></p></span>
                <hr>
                
                <h5 >Description</h5 >
                <div id="modalBody"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    {!! $calendar->script() !!}

@endsection 