<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
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
    public function index(Request $request)
    {
        $get = DB::table('transaksi');
        if($request->search)
        {
            if($request->search != null)
            {
                $get->where('kode',$request->search);
                $get->Orwhere('customer',$request->search);
            }
        }
        $get->orderBy('created_at','DESC');
        $data =$get->paginate(5);
        $itemTrs = [];
        foreach ($data as $key => $value) 
        {
            $items = DB::table('transaksi_item as ti')
                    ->join('produk as pd','pd.id','=','ti.produk_id')
                    ->where('ti.transaksi_id',$value->id)
                    ->select('ti.*','pd.nama','pd.kode')
                    ->get();
            foreach ($items as $itemKey => $itemValue) 
            {
                $itemTrs[$value->id][$itemKey]['produk'] = $itemValue->nama.' - '.$itemValue->kode;
                if($itemValue->borongan)
                {
                    $itemTrs[$value->id][$itemKey]['qty'] = $itemValue->qty.' (Borongan)';
                }else
                {
                    $itemTrs[$value->id][$itemKey]['qty'] = $itemValue->qty;
                }
            }
        }
        return view('transaksi.index',compact('data','itemTrs','request'));
    }

    public function create()
    {
        $produk = DB::table('produk')->get();
        $ccPy=DB::table('transaksi')->count();
        $noPy = $ccPy+1;
        $arrPy = array_map('intval', str_split($noPy));
        if(count($arrPy)==1){
                $gnrPy = '00'.strval($noPy);
            }elseif(count($arrPy)==2){
                $gnrPy = '0'.strval($noPy);
            }else{
                 $gnrPy=strval($noPy);
            }
        $kode = 'TRS-'.$gnrPy; 
        return view('transaksi.add',compact('produk','kode'));
    }

    public function edit($id)
    {
        $data = DB::table('transaksi')->where('id',$id)->first();
        $item = DB::table('transaksi_item')->where('transaksi_id',$id)->get();
        $itemArr = [];
        $borongan = [];
        foreach ($item as $key => $value) 
        {
            array_push($itemArr, $value->produk_id);
            //array_push($borongan, $value->borongan);
            $borongan[$value->produk_id]['borongan'] = $value->borongan;
            $borongan[$value->produk_id]['qty'] = $value->qty;
            $borongan[$value->produk_id]['qty_real'] = $value->qty_real;
        }
        $produk = DB::table('produk')->get();
        return view('transaksi.edit',compact('produk','item','itemArr','data','borongan'));
    }

    public function store(Request $request)
    {
        $createdAt = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $now =  Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $total = 0;
        $qty_trs = 0;
        if($request->produk_id)
        {
            foreach ($request->produk_id as $key => $value) 
            {
               $produk = DB::table('produk')->where('id',$value)->first();
               if($request->tipe_produk[$key] == 'borongan')
               {
                    $borongan = intval(str_replace('.', '', $produk->harga_borongan));
                    $qty = $produk->qty_borongan * $request->qty_produk[$key];
                    $borongan += $qty * $borongan;
                    $total += $borongan;
               }else
               {
                    $satuan = intval(str_replace('.', '', $produk->harga_satuan));
                    $qty = $request->qty_produk[$key];
                    $satuan += $qty * $satuan;
                    $total += $satuan;
               }

               $qty_trs += $qty;
            }

            $transaksiId = DB::table('transaksi')->insertGetId([
                'customer'=>$request->customer,
                'tanggal'=>$request->tanggal,
                'kode'=>$request->kode,
                'grandtotal'=>$total,
                'total_produk'=>$qty_trs,
                'created_at'=>$createdAt
            ]);

            foreach ($request->produk_id as $key => $value) 
            {
               $boronganQty = 0;
               $boronganQtyNya = 0;
               $qtyReal = $request->qty_produk[$key];
               $produk = DB::table('produk')->where('id',$value)->first();
               if($request->tipe_produk[$key] == 'borongan')
               {
                    $total_item_paid = intval(str_replace('.', '', $produk->harga_borongan));
                    $qty = $produk->qty_borongan * $request->qty_produk[$key];
                    $total_item_paid += $qty * $total_item_paid;
                    $boronganQty = 1;
                    $boronganQtyNya = $produk->qty_borongan;
               }else
               {
                    $total_item_paid = intval(str_replace('.', '', $produk->harga_satuan));
                    $qty = $request->qty_produk[$key];
                    $total_item_paid += $qty * $total_item_paid;
               }

                DB::table('transaksi_item')->insert([
                    'transaksi_id'=>$transaksiId,
                    'produk_id'=>$value,
                    'borongan'=>$boronganQty,
                    'qty'=>$qty,
                    'qty_borongan'=>$boronganQtyNya,
                    'qty_real'=>$qtyReal,
                    'total'=>$total_item_paid,
                    'created_at'=>$createdAt
                ]);

            }
            return redirect('transaksi')->with('success','Berhasil menambahkan data transaksi');
        }else
        {
            return redirect()->back()->with('error','Mohon maaf data produk belum dipilih');
        }
    }

    public function update(Request $request,$id)
    {
       // dd($request->all());
        $createdAt = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $now =  Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $total = 0;
        $qty_trs = 0;
        if($request->produk_id)
        {
            foreach ($request->produk_id as $key => $value) 
            {
               $produk = DB::table('produk')->where('id',$value)->first();
               if($request->tipe_produk[$key] == 'borongan')
               {
                    $borongan = $produk->harga_borongan;
                    $qty = $produk->qty_borongan * $request->qty_produk[$key];
                    $borongan += $qty * $borongan;
                    $total += $borongan;
               }else
               {
                    $satuan = $produk->harga_satuan;
                    $qty = $request->qty_produk[$key];
                    $satuan += $qty * $satuan;
                    $total += $satuan;
               }

               $qty_trs += $qty;
            }
            //dd($total);
            $transaksiId = DB::table('transaksi')->where('id',$id)->update([
                'customer'=>$request->customer,
                'tanggal'=>$request->tanggal,
                'kode'=>$request->kode,
                'grandtotal'=>$total,
                'total_produk'=>$qty_trs,
                'updated_at'=>$createdAt
            ]);

            DB::table('transaksi_item')->where('transaksi_id',$id)->delete();

            foreach ($request->produk_id as $key => $value) 
            {
               $boronganQty = 0;
               $boronganQtyNya = 0;
               $qtyReal = $request->qty_produk[$key];
               $produk = DB::table('produk')->where('id',$value)->first();
               if($request->tipe_produk[$key] == 'borongan')
               {
                    $total_item_paid = intval(str_replace('.', '', $produk->harga_borongan));
                    $qty = $produk->qty_borongan * $request->qty_produk[$key];
                    $total_item_paid += $qty * $total_item_paid;
                    $boronganQty = 1;
                    $boronganQtyNya = $produk->qty_borongan;
               }else
               {
                    $total_item_paid = intval(str_replace('.', '', $produk->harga_satuan));
                    $qty = $request->qty_produk[$key];
                    $total_item_paid += $qty * $total_item_paid;
               }

                DB::table('transaksi_item')->insert([
                    'transaksi_id'=>$id,
                    'produk_id'=>$value,
                    'borongan'=>$boronganQty,
                    'qty'=>$qty,
                    'qty_borongan'=>$boronganQtyNya,
                    'qty_real'=>$qtyReal,
                    'total'=>$total_item_paid,
                    'created_at'=>$createdAt
                ]);
            }
            return redirect('transaksi')->with('success','Berhasil mengubah data transaksi');
        }else
        {
            return redirect()->back()->with('error','Mohon maaf data produk belum dipilih');
        }
    }

    public function delete($id)
    {
        DB::table('transaksi')->where('id',$id)->delete();
        return redirect('transaksi')->with('success','Berhasil menghapus data transaksi');
    }
}
