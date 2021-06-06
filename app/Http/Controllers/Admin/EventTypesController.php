<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventType\BulkDestroyEventType;
use App\Http\Requests\Admin\EventType\DestroyEventType;
use App\Http\Requests\Admin\EventType\IndexEventType;
use App\Http\Requests\Admin\EventType\StoreEventType;
use App\Http\Requests\Admin\EventType\UpdateEventType;
use App\Models\EventType;
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

class EventTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexEventType $request
     * @return array|Factory|View
     */
    public function index(IndexEventType $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(EventType::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'admin_user_id'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.event-type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.event-type.create');

        return view('admin.event-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEventType $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreEventType $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the EventType
        $eventType = EventType::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/event-types'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/event-types');
    }

    /**
     * Display the specified resource.
     *
     * @param EventType $eventType
     * @throws AuthorizationException
     * @return void
     */
    public function show(EventType $eventType)
    {
        $this->authorize('admin.event-type.show', $eventType);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EventType $eventType
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(EventType $eventType)
    {
        $this->authorize('admin.event-type.edit', $eventType);


        return view('admin.event-type.edit', [
            'eventType' => $eventType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEventType $request
     * @param EventType $eventType
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateEventType $request, EventType $eventType)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values EventType
        $eventType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/event-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/event-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyEventType $request
     * @param EventType $eventType
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyEventType $request, EventType $eventType)
    {
        $eventType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyEventType $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyEventType $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    EventType::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
