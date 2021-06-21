<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Proposal\BulkDestroyProposal;
use App\Http\Requests\Admin\Proposal\DestroyProposal;
use App\Http\Requests\Admin\Proposal\IndexProposal;
use App\Http\Requests\Admin\Proposal\StoreProposal;
use App\Http\Requests\Admin\Proposal\UpdateProposal;
use App\Models\Proposal;
use App\Models\GadPlan;
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

class ProposalsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexProposal $request
     * @return array|Factory|View
     */
    public function index(IndexProposal $request)
    {

        $status = null ;
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Proposal::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'gad_plans_id', 'prop_no','status',],

            // set columns to searchIn
            ['id', 'status']
        );

        $gad = GadPlan::where([
                ['status', '>', 0],
                ['model_id', '=', Auth::user()->id]
            ])->whereYear('created_at', date('Y'))->first();

        if(!is_null($gad)){ 
            $status = $gad->status; 
        }

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.proposal.index', ['data' => $data, 'status' => $status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        // $this->authorize('admin.proposal.create');

        return view('admin.proposal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProposal $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreProposal $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $proposal = Proposal::first();
        //Find the latest gad plan that is approved by the admin
        $gad = GadPlan::where(['model_id' => Auth::user()->id, 'status' => 2])->whereYear('created_at', date('Y'))->first();

        $sanitized['gad_plans_id'] = $gad->id;
        $tmp = 'PROP'.Auth::user()->id.'-'.date('Y').'-';

        if(is_null($proposal)){ 
            $sanitized['prop_no'] = $tmp.(10000 + 1);
        }else{ 
            $rmb = explode('-', $rb->rmb_no);
            $sanitized['prop_no'] = $tmp.($proposal[1] + 1);
        }

        // Store the Proposal
        $proposal = Proposal::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/proposals'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/proposals');

    }

    /**
     * Display the specified resource.
     *
     * @param Proposal $proposal
     * @throws AuthorizationException
     * @return void
     */
    public function show(Proposal $proposal)
    {
        $this->authorize('admin.proposal.show', $proposal);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Proposal $proposal
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Proposal $proposal)
    {

        return view('admin.proposal.edit', [
            'proposal' => $proposal,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProposal $request
     * @param Proposal $proposal
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateProposal $request, Proposal $proposal)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Proposal
        $proposal->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/proposals'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/proposals');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyProposal $request
     * @param Proposal $proposal
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyProposal $request, Proposal $proposal)
    {
        $proposal->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyProposal $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyProposal $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Proposal::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
