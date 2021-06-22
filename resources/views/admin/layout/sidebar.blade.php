<div class="sidebar">
    <nav class="sidebar-nav">
    <div class="d-flex justify-content-center">

        <img src="{{ url('images/gad_xl.png')}}" style="width: 9rem; height: 9rem" class="mt-3 mb-3 mr-2" alt="PRMSU Logo">
    </div>
        <h5 class="text-dark text-center">{{Auth::user()->school->name}}</h5>
        <hr class="mt-4 ">
        <ul class="nav">
         <li class="nav-title text-black">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/gad-plans') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.gad-plan.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/proposals') }}"><i class="nav-icon icon-compass"></i> {{ trans('admin.proposal.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/liquidations') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.liquidation.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/reimbursements') }}"><i class="nav-icon icon-compass"></i> {{ trans('admin.reimbursement.title') }}</a></li>
               <li class="nav-item"><a class="nav-link" href="{{ url('admin/accomplishments') }}"><i class="nav-icon icon-drop"></i> {{ trans('admin.accomplishment.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/calendar') }}"><i class="nav-icon icon-energy"></i> {{ trans('admin.calendar.title') }}</a></li>
            
            @if(Auth::user()->roles()->pluck('id')[0] == 1)
                <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.others') }}</li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/schools') }}"><i class="nav-icon icon-compass"></i> {{ trans('admin.school.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/relevant-agencies') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.relevant-agency.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/source-of-budgets') }}"><i class="nav-icon icon-diamond"></i> {{ trans('admin.source-of-budget.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/suppliers') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.supplier.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/units') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.unit.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/event-types') }}"><i class="nav-icon icon-graduation"></i> {{ trans('admin.event-type.title') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/announcements') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.announcement.title') }}</a></li>

           {{-- Do not delete me :) I'm used for auto-generation menu items --}}
       
                <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
                <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            @endif
        </ul>
    </nav>
    {{-- <button class="sidebar-minimizer brand-minimizer" type="button"></button> --}}
</div>
