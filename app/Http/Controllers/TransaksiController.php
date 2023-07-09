<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon;
class TransaksiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = DB::table('transaksi')->orderBy('created_at','DESC')->paginate(10);
        $item = [];
        foreach ($data as $key => $value) 
        {
            $items = DB::table('transaksi_item as ti')
                    ->join('produk as pd','pd.id','=','ti.produk_id')
                    ->where('ti.transaksi_id',$value->id)
                    ->select('ti.*','pd.nama','pd.kode')
                    ->get();
            $item[$value->id]['qty'] = count($items);
            foreach ($items as $itemKey => $itemValue) 
            {
                $item[$value->id][$itemKey]['produk'] = $itemValue->name.' - '.$itemValue->kode;
                $item[$value->id][$itemKey]['total'] = $itemValue->total; 
            }
        }
        return view('transaksi.index',compact('data','item'));
    }

    public function store(Request $request)
    {
        $createdAt = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $now =  Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $total = 0;
        if($request->produk_id)
        {
            foreach ($request->produk_id as $key => $value) 
            {
               $produk = DB::table('produk')->where('id',$value)->first();
               if($request->tipe_produk[$key] == 'borongan')
               {
                    $borongan = 10 * $produk->harga_satuan;
               }
            }
            $transaksiId = DB::table('transaksi')->insertGetId([
                'customer'=>$request->customer,
                'tanggal'=>$now,
                ''
            ]);
        }else
        {
            return redirect()->back()->with('error','Mohon maaf data produk belum dipilih');
        }
    }
}
