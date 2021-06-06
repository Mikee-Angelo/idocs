<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Unit\BulkDestroyUnit;
use App\Http\Requests\Admin\Unit\DestroyUnit;
use App\Http\Requests\Admin\Unit\IndexUnit;
use App\Http\Requests\Admin\Unit\StoreUnit;
use App\Http\Requests\Admin\Unit\UpdateUnit;
use App\Models\Unit;
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

class UnitsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexUnit $request
     * @return array|Factory|View
     */
    public function index(IndexUnit $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Unit::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'added_by'],

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

        return view('admin.unit.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.unit.create');

        return view('admin.unit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUnit $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreUnit $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Unit
        $unit = Unit::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/units'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/units');
    }

    /**
     * Display the specified resource.
     *
     * @param Unit $unit
     * @throws AuthorizationException
     * @return void
     */
    public function show(Unit $unit)
    {
        $this->authorize('admin.unit.show', $unit);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Unit $unit
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Unit $unit)
    {
        $this->authorize('admin.unit.edit', $unit);


        return view('admin.unit.edit', [
            'unit' => $unit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUnit $request
     * @param Unit $unit
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateUnit $request, Unit $unit)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Unit
        $unit->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/units'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/units');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUnit $request
     * @param Unit $unit
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyUnit $request, Unit $unit)
    {
        $unit->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyUnit $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyUnit $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Unit::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
