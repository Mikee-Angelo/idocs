<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reimbursement\BulkDestroyReimbursement;
use App\Http\Requests\Admin\Reimbursement\DestroyReimbursement;
use App\Http\Requests\Admin\Reimbursement\IndexReimbursement;
use App\Http\Requests\Admin\Reimbursement\StoreReimbursement;
use App\Http\Requests\Admin\Reimbursement\UpdateReimbursement;
use App\Models\Reimbursement;
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
use PDF;
class ReimbursementsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexReimbursement $request
     * @return array|Factory|View
     */
    public function index(IndexReimbursement $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Reimbursement::class)
        ->modifyQuery(function($query) use ($request){

            if (Auth::user()->roles()->pluck('id')[0] == 2) {
                $query->where('admin_user_id', Auth::user()->id);    
            }
        })
        ->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'admin_user_id', 'status' , 'rmb_no'],

            // set columns to searchIn
            ['id', 'letter_body'],
            function($query) use ($request) {
                $query->with(['admin_user']);
            }
        );
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.reimbursement.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.reimbursement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReimbursement $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreReimbursement $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        
        $rb = Reimbursement::first();

        $tmp = 'RMB'.Auth::user()->id.'-'.date('Y').'-';
        $sanitized['admin_user_id'] = Auth::user()->id;

        if(is_null($rb)){ 
            $sanitized['rmb_no'] = $tmp.(10000 + 1);
        }else{ 
            $rmb = explode('-', $rb->rmb_no);
            $sanitized['rmb_no'] = $tmp.($rmb[2] + 1);
        }

        // Store the Reimbursement
        $reimbursement = Reimbursement::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/reimbursements'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/reimbursements');
    }

    /**
     * Display the specified resource.
     *
     * @param Reimbursement $reimbursement
     * @throws AuthorizationException
     * @return void
     */
    public function show($id)
    {
        // $this->authorize('admin.reimbursement.show', $reimbursement);
        $data = Reimbursement::where([
            ['id', '=', $id],
         ])->first();

        if(Auth::user()->roles()->pluck('id')[0] == 2){ 
            $data->where('admin_user_id', Auth::user()->id);
        }

         if(is_null($data)){ 
             abort(404);
         }
         
        return view('admin.reimbursement.show' , ['data' => $data]);
        // TODO your code goes here
    }

    public function export($id){ 
        $data = Reimbursement::where([
            ['id', '=', $id],
         ])->first();

        if(Auth::user()->roles()->pluck('id')[0] == 2){ 
            $data->where('admin_user_id', Auth::user()->id);
        }

        $pdf = PDF::loadView('admin.reimbursement.pdf', ['data' => $data])
        ->setPaper('a4');

        return $pdf->stream();
        // return $pdf->download(Auth::user()->id.'- GADPLAN -'.$data[0]->gad_plan['implement_year'].'.pdf');
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reimbursement $reimbursement
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Reimbursement $reimbursement)
    {


        return view('admin.reimbursement.edit', [
            'reimbursement' => $reimbursement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReimbursement $request
     * @param Reimbursement $reimbursement
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateReimbursement $request, Reimbursement $reimbursement)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Reimbursement
        $reimbursement->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/reimbursements'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/reimbursements');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyReimbursement $request
     * @param Reimbursement $reimbursement
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyReimbursement $request, Reimbursement $reimbursement)
    {
        $reimbursement->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyReimbursement $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyReimbursement $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Reimbursement::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }


}
