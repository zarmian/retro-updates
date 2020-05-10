<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Models\Accounts\AccountsSummeryDetail;
use App\Http\Models\Accounts\AccountsSummery;
use App\Http\Models\Accounts\AccountsChart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Customlib;
use Carbon\Carbon;
use Storage;
use Auth;
use DB;

class InterbankController extends Controller
{

    public function __construct()
    {
        $this->custom = new Customlib();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $data = [];
            $data['transfers'] = [];

            $data['per_page'] = \Request::get('per_page') ?: 12;

            $qry = AccountsSummery::query();
            if(\Request::has('code'))
            {
                $code = \Request::get('code');
                $qry->where('code', $code); 
            }elseif(\Request::has('date')){
                $date = \Request::get('date');
                $nice_date = Carbon::createFromFormat('m/d/Y', $date)->toDateString();
                $qry->whereDate('date', $nice_date);
            }

            $interbanks = $qry->where('type', '4')->orderBy('code', 'DESC')->paginate($data['per_page']);

            if(isset($interbanks) )
            {
                foreach($interbanks as $interbank)
                {
                    $amount = $interbank->amount->sum('credit');

                    $data['transfers'][] = [
                        'id' => $interbank->id,
                        'code' => $interbank->code,
                        'date' => $this->custom->dateformat($interbank->date),
                        'reference' => $interbank->reference,
                        'description' => $interbank->description,
                        'type' => $interbank->type,
                        'amount' => $this->custom->currenyFormat($amount),
                    ];
                }
            }

            // echo '<pre>';
            // print_r($data);
            // die;
            $data['pages'] = $interbanks->appends(\Input::except('page'))->render();
            return view('accounting/interbank/index', $data);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            $code = $this->custom->getInterBankCode();

            $bank_accounts = AccountsChart::where('type_id','=','22')
            ->orWhere('type_id','=','21')
            ->get();
            if(isset($bank_accounts) )
            {
                foreach($bank_accounts as $bank)
                {
                    $bank_data[] = [
                        'id' => $bank['id'],
                        'code' => $bank['code'],
                        'name' => $bank['name']
                    ];
                }
            }

            return view('accounting/interbank/create', ['ib_code' => $code, 'banks' => $bank_accounts]);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            ;
            $this->validate($request, [
                'code' => 'required|unique:tbl_accounts_summery,code,null,null,type,4',
                'date' => 'required',
                'account_from' => 'required',
                'account_to' => 'required',
                'transfer_amount' => 'required'
            ]);

            $code = $request->input('code');
            $date = $request->input('date');
            $reference = $request->input('ref');
            $description = $request->input('summery');
            $account_from = $request->input('account_from');
            $account_to = $request->input('account_to');
            $create_by = Auth::guard('auth')->user()->id;
            $nice_date =  Carbon::createFromFormat('m/d/Y', $date)->toDateString();

            $id = AccountsSummery::insertGetId([
                'code' => $code, 
                'date' => $nice_date, 
                'reference' => $reference, 
                'description' => $description, 
                'type' => '4', 
                'added_by' => $create_by,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);

            if($id)
            {

                $transfer_amount = $request->input('transfer_amount');
                
                AccountsSummeryDetail::insert([
                    'summery_id' => $id,
                    'account_id' => $account_from,
                    'date' => $nice_date,
                    'debit' => $transfer_amount,
                    'credit' => '0',
                    'added_by' => $create_by
                ]);

                AccountsSummeryDetail::insert([
                    'summery_id' => $id,
                    'account_id' => $account_to,
                    'date' => $nice_date,
                    'debit' => '0',
                    'credit' => $transfer_amount,
                    'description' => $description,
                    'added_by' => $create_by
                ]);
            }


            $request->session()->flash('msg', __('admin/entries.ib_entry_msg'));
            return redirect('accounting/interbank/add');
            
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/interbank');

            $transfer = AccountsSummery::where('type', '4')->findOrFail($id);
            if(isset($transfer))
            {
                
                $dt = Carbon::parse($transfer->date);

                $d['details'] = [];
                $tlt_dr = 0; $tlt_cr = 0;
                if(isset($transfer->details) )
                {
                    foreach($transfer->details as $detail)
                    {
 
                        $d['details'][] = [
                            'summery_id' => $detail->summery_id,
                            'account_id' => $detail->account_id,
                            'date' => $this->custom->dateformat($detail->date),
                            'debit' => $this->custom->currenyFormat($detail->debit),
                            'credit' => $this->custom->currenyFormat($detail->credit),
                            'description' => $detail->description,
                            'ac_name' => $detail->account->name
                        ];

                        $tlt_dr += $detail->debit;
                        $tlt_cr += $detail->credit;
                    }
                    
                }

                $data['journal'] = [
                    'id' => $transfer->id,
                    'code' => $transfer->code,
                    'date' => $dt->format('d M, Y'),
                    'reference' => $transfer->reference,
                    'description' => $transfer->description,
                    'type' => $transfer->type,
                    'tlt_dr' => $this->custom->currenyFormat($tlt_dr),
                    'tlt_cr' => $this->custom->currenyFormat($tlt_cr),
                    'details' => $d['details']
                ];
            }


            $data['business_name'] = $this->custom->getSetting('BUSINESS_NAME');
            $data['business_address'] = $this->custom->getSetting('BUSINESS_ADDRESS');
            $data['business_email'] = $this->custom->getSetting('BUSINESS_EMAIL');
            $data['business_phone'] = $this->custom->getSetting('BUSINESS_PHONE');
            $data['business_mobile'] = $this->custom->getSetting('BUSINESS_MOBILE');
            $data['business_logo_image'] = $this->custom->getSetting('BUSINESS_LOGO_IMAGE');

            $data['business_logo_image'] = Storage::url('app/logo/'.$data['business_logo_image']);
         
            return view('accounting/interbank/view', $data);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/interbank');

            $interbank = AccountsSummery::where('type', '4')->findOrFail($id);
            if(isset($interbank) )
            {
                
                $dt = Carbon::parse($interbank->date);

                $d['details'] = [];
                $tlt_dr = 0; $tlt_cr = 0;
                if(isset($interbank->details) )
                {
                    foreach($interbank->details as $detail)
                    {

                        $d['details'][] = [
                            'summery_id' => $detail->summery_id,
                            'account_id' => $detail->account_id,
                            'date' => $detail->date,
                            'debit' => $detail->debit,
                            'credit' => $detail->credit,
                            'description' => $detail->description,
                            'types' => $detail->account->type_id
                        ];
                        

                        $tlt_dr += $detail->debit;
                        $tlt_cr += $detail->credit;
                    }
                    
                }

                $data['transfer'] = [
                    'id' => $interbank->id,
                    'code' => $interbank->code,
                    'date' => $dt->format('m/d/Y'),
                    'reference' => $interbank->reference,
                    'description' => $interbank->description,
                    'type' => $interbank->type,
                    'tlt_dr' => ($tlt_dr),
                    'tlt_cr' => number_format($tlt_cr, 2),
                    'details' => $d['details'],
                    'account_from_id' => $d['details'][0]['account_id'],
                    'account_to_id' => $d['details'][1]['account_id']
                ];
            }


            $bank_accounts = AccountsChart::where('type_id','=','38')
            ->orWhere('type_id','=','37')
            ->get();
            if(isset($bank_accounts) )
            {
                foreach($bank_accounts as $bank)
                {
                    $bank_data[] = [
                        'id' => $bank['id'],
                        'code' => $bank['code'],
                        'name' => $bank['name']
                    ];
                }
            }

            return view('accounting/interbank/edit', ['transfer' => $data['transfer'], 'banks' => $bank_accounts]);
            
        } catch (ModelNotFoundException $e) {
            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = NULL)
    {
        try {

            if(is_null($id)) return redirect('accounting/interbank');

            $this->validate($request, [
                'code' => 'required|unique:tbl_accounts_summery,code,'.$id.'',
                'date' => 'required',
                'account_from' => 'required',
                'account_to' => 'required',
                'transfer_amount' => 'required'
            ]);

            $summery = AccountsSummery::findOrFail($id);

            $code = $request->input('code');
            $date = $request->input('date');
            $reference = $request->input('ref');
            $description = $request->input('summery');
            $account_from = $request->input('account_from');
            $account_to = $request->input('account_to');
            $create_by = Auth::guard('auth')->user()->id;
            $nice_date =  Carbon::createFromFormat('m/d/Y', $date)->toDateString();
            $amount = $request->input('transfer_amount');

            $transfer_amount = str_replace(',', '',$amount);

            $summery->date = $nice_date;
            $summery->save();

            AccountsSummeryDetail::whereSummeryId($id)->delete();

            AccountsSummeryDetail::insert([
                'summery_id' => $id,
                'account_id' => $account_from,
                'date' => $nice_date,
                'debit' => $transfer_amount,
                'credit' => '0',
                'added_by' => $create_by
            ]);

            AccountsSummeryDetail::insert([
                'summery_id' => $id,
                'account_id' => $account_to,
                'date' => $nice_date,
                'debit' => '0',
                'credit' => $transfer_amount,
                'description' => $description,
                'added_by' => $create_by
            ]);

            $request->session()->flash('msg', __('admin/entries.ib_update_msg'));
            return redirect('accounting/interbank/edit/'.$id);



        } catch (ModelNotFoundException $e) {
            
        }
    }

}
