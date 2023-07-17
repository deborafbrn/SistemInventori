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
}
