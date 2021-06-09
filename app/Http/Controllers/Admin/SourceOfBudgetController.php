<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SourceOfBudget\BulkDestroySourceOfBudget;
use App\Http\Requests\Admin\SourceOfBudget\DestroySourceOfBudget;
use App\Http\Requests\Admin\SourceOfBudget\IndexSourceOfBudget;
use App\Http\Requests\Admin\SourceOfBudget\StoreSourceOfBudget;
use App\Http\Requests\Admin\SourceOfBudget\UpdateSourceOfBudget;
use App\Models\SourceOfBudget;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SourceOfBudgetController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSourceOfBudget $request
     * @return array|Factory|View
     */
    public function index(IndexSourceOfBudget $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(SourceOfBudget::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

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

        return view('admin.source-of-budget.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.source-of-budget.create');

        return view('admin.source-of-budget.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSourceOfBudget $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSourceOfBudget $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        
        $sanitized['added_by'] = Auth::user()->id;
        // Store the SourceOfBudget
        $sourceOfBudget = SourceOfBudget::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/source-of-budgets'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/source-of-budgets');
    }

    /**
     * Display the specified resource.
     *
     * @param SourceOfBudget $sourceOfBudget
     * @throws AuthorizationException
     * @return void
     */
    public function show(SourceOfBudget $sourceOfBudget)
    {
        $this->authorize('admin.source-of-budget.show', $sourceOfBudget);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SourceOfBudget $sourceOfBudget
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(SourceOfBudget $sourceOfBudget)
    {
        $this->authorize('admin.source-of-budget.edit', $sourceOfBudget);


        return view('admin.source-of-budget.edit', [
            'sourceOfBudget' => $sourceOfBudget,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSourceOfBudget $request
     * @param SourceOfBudget $sourceOfBudget
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSourceOfBudget $request, SourceOfBudget $sourceOfBudget)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SourceOfBudget
        $sourceOfBudget->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/source-of-budgets'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/source-of-budgets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySourceOfBudget $request
     * @param SourceOfBudget $sourceOfBudget
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySourceOfBudget $request, SourceOfBudget $sourceOfBudget)
    {
        $sourceOfBudget->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySourceOfBudget $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySourceOfBudget $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    SourceOfBudget::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
