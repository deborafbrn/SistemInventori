<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class HomeController extends Controller
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
        $produk = DB::table('produk')->count();
        $transaksi = DB::table('transaksi')->count();
        $transaksiToday = DB::table('transaksi')->where('tanggal',Carbon::now('Asia/Jakarta')->format('Y-m-d'))->count();
        $transaksiBulan =DB::table('transaksi')->whereMonth('tanggal',Carbon::now('Asia/Jakarta')->format('m'))->count();
        return view('home',compact('produk','transaksi','transaksiToday','transaksiBulan'));
    }

    public function dataDummy()
    {
        // $trs = DB::table('transaksi')->get();
        // foreach ($trs as $trsKey => $trsValue) 
        // {
        //     $temp = DB::table('trs_item_temp')->get();
        //     $totalProduk = 0;
        //     $totalHarga = 0;
        //     foreach ($temp as $tempKey => $tempValue) 
        //     {
        //         if($tempValue->kode == $trsValue->kode)
        //         {
        //             $totalProduk += $tempValue->total_produk;

        //             $produk = DB::table('produk')->where('kode',$tempValue->item)->first();
        //             //dd($tempValue->item);
        //             if($produk)
        //             {
        //                 $total = str_replace('Rp', '', $tempValue->harga);
        //                 $total = str_replace('.', '', $total);
        //                 $total = str_replace(',', '', $total);
        //                 $totalHarga += $total * $tempValue->total_produk;
        //                 DB::table('transaksi_item')->insert([
        //                     'transaksi_id'=>$trsValue->id,
        //                     'produk_id'=>$produk->id,
        //                     'qty'=>$tempValue->total_produk,
        //                     'qty_real'=>$tempValue->total_produk,
        //                     'total'=>$total,

        //                 ]);

        //                 $harga_satuan = str_replace('Rp', '', $produk->harga_satuan);
        //                 $harga_satuan = str_replace('.', '', $harga_satuan);
        //                 $harga_satuan = str_replace(',', '', $harga_satuan);

        //                 $harga_borongan = str_replace('Rp', '', $produk->harga_borongan);
        //                 $harga_borongan = str_replace('.', '', $harga_borongan);
        //                 $harga_borongan = str_replace(',', '', $harga_borongan);
        //                 DB::table('produk')->where('id',$produk->id)->update([
        //                     'harga_borongan'=>$harga_borongan,
        //                     'harga_satuan'=>$harga_satuan
        //                 ]);

        //             }
        //         }
        //     }
        //     DB::table('transaksi')->where('id',$trsValue->id)->update(['total_produk'=>$totalProduk,'grandtotal'=>$totalHarga]);
        // }
        $produk = DB::table('produk')->get();
        foreach ($produk as $key => $value) {
            $harga_satuan = str_replace('Rp', '', $value->harga_satuan);
                        $harga_satuan = str_replace('.', '', $harga_satuan);
                        $harga_satuan = str_replace(',', '', $harga_satuan);

                        $harga_borongan = str_replace('Rp', '', $value->harga_borongan);
                        $harga_borongan = str_replace('.', '', $harga_borongan);
                        $harga_borongan = str_replace(',', '', $harga_borongan);
                        DB::table('produk')->where('id',$value->id)->update([
                            'harga_borongan'=>$harga_borongan,
                            'harga_satuan'=>$harga_satuan
                        ]);
        }
        return 'done';
    }
}
