<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class ProdukController extends Controller
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
        $get = DB::table('produk');
        $get->orderBy('created_at','DESC');
        if($request->search)
        {
            if($request->search != null)
            {
                $get->where('kode',$request->search);
                $get->Orwhere('nama', 'like', '%' . $request->search . '%');
            }
        }
        $data = $get->paginate(5);
        return view('produk.index',compact('data','request'));
    }

    public function create()
    {
        return view('produk.add');
    }

    public function edit($id)
    {
        $data = DB::table('produk')->where('id',$id)->first();
        return view('produk.edit',compact('data'));
    }

    public function store(Request $request)
    {
        $createdAt = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $check = DB::table('produk')->where('kode',$request->kode)->first();
        if($check)
        {
            return redirect()->back()->with('error','Mohon maaf data produk dengan kode '.$request->kode.' sudah terdaftar');
        }
        DB::table('produk')->insert([
            'kategori'=>$request->kategori,
            'nama'=>$request->nama,
            'kode'=>$request->kode,
            'stock'=>$request->stock,
            'kemasan'=>$request->kemasan,
            'qty_borongan'=>$request->qty_borongan,
            'harga_satuan'=>$request->harga_satuan,
            'harga_borongan'=>$request->harga_borongan,
            'created_at'=>$createdAt
        ]);

        return redirect('produk')->with('success','Data produk berhasil ditambahkan');
    }

    public function update(Request $request,$id)
    {
        $createdAt = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $check = DB::table('produk')->where('kode',$request->kode)->first();
        if($check)
        {
            if($check->id != $id)
            {
               // dd($check->id.' '.$id);
                return redirect()->back()->with('error','Mohon maaf data produk dengan kode '.$request->kode.' sudah terdaftar');
            }
        }
        DB::table('produk')->where('id',$id)->update([
            'kategori'=>$request->kategori,
            'nama'=>$request->nama,
            'kode'=>$request->kode,
            'stock'=>$request->stock,
            'kemasan'=>$request->kemasan,
            'harga_satuan'=>$request->harga_satuan,
            'harga_borongan'=>$request->harga_borongan,
            'qty_borongan'=>$request->qty_borongan,
            'updated_at'=>$createdAt
        ]);

        return redirect('produk')->with('success','Data produk berhasil diubah');
    }

    public function delete($id)
    {
        DB::table('produk')->where('id',$id)->delete();
        return redirect()->back()->with('success','Data produk berhasil dihapus');
    }
}
