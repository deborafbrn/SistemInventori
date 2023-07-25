<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon;
class FpGrowthController extends Controller
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
        $data = $this->getTransaksi($request->start_date,$request->end_date);
        $transaksi = $data['arr'];
        $produk = $data['produk'];
        $frekuensi = $data['frekuensi'];
        $support = $data['support'];
        $supportFilter = $data['support_filter'];
        $pattern = $data['pattern'];
        $patternDetail = $data['pattern_detail'];
        $final = $data['final'];
        $word = $data['word'];
        //dd($frekuensi);
        return view('fp-growth.index',compact('request','transaksi','produk','frekuensi','support','supportFilter','pattern','patternDetail','final','word'));
    }

    public function getTransaksi($start,$end)
    {
        $data = DB::table('transaksi')->whereBetween('tanggal',[$start,$end])->get();
        $arr = [];
        $produkArr = [];
        $tiId = [];
        $kombinasi = [];
        foreach ($data as $key => $value) 
        {
            $arr[$key]['id'] = $value->id;
            $arr[$key]['kode'] = $value->kode;
            $arr[$key]['tanggal'] = $value->tanggal;
            $arr[$key]['customer'] = $value->customer;
            $arr[$key]['grandtotal'] = $value->grandtotal;
            $arr[$key]['total_produk'] = $value->total_produk;
            $item = DB::table('transaksi_item')->where('transaksi_id',$value->id)->get();
            $itemSet = [];
            array_push($tiId, $value->id);
            $produkArrSet = [];
            foreach ($item as $itemKey => $itemValue) 
            {
                $produk = DB::table('produk')->where('id',$itemValue->produk_id)->first();
                if($produk)
                {
                    array_push($itemSet, $produk->kode);
                    array_push($produkArr, $produk->id);
                    array_push($produkArrSet, $produk->id);
                    $arr[$key]['item'][$itemKey]['produk_id'] = $produk->id;
                    $arr[$key]['item'][$itemKey]['kode_produk'] = $produk->kode;
                    $arr[$key]['item'][$itemKey]['nama_produk'] = $produk->nama;
                }
            }
            $itemSet = implode(',', $itemSet);
            $itemSet = '{'.$itemSet.'}';
            $arr[$key]['item_set'] = $itemSet;
            $arr[$key]['item_set_arr'] = $produkArrSet;
        }
        $produkArr = array_unique($produkArr);
        $itemFrekuensi = DB::table('transaksi_item as ti')
                        ->join('produk as pd','pd.id','=','ti.produk_id')
                        ->whereIn('ti.transaksi_id',$tiId)
                        ->select(DB::raw('COUNT(ti.transaksi_id) as total'),'pd.kode','ti.transaksi_id','ti.produk_id')
                        ->groupBy('ti.produk_id')
                        ->get();
        $itemFrekuensi = json_decode(json_encode($itemFrekuensi),true);
        $support = [];
        foreach ($itemFrekuensi as $key => $value) 
        {
            $support[$key]['transaksi_id'] = $value['transaksi_id'];
            $support[$key]['produk_id'] = $value['produk_id'];
            $support[$key]['total'] = $value['total'];
            $support[$key]['kode'] = $value['kode'];
            $support[$key]['support'] = round($value['total'] / count($data) * 100);
        }
        //dd($support);
        $supportFilter = [];
        $noSupportFilter = -1;
        $supportFilterTrsId = [];
        $supportFilterProdukId = [];
        foreach ($support as $key => $value) 
        {
            if($value['support'] >= 30)
            {
                $noSupportFilter++;
                $supportFilter[$noSupportFilter]['transaksi_id'] = $value['transaksi_id'];
                $supportFilter[$noSupportFilter]['produk_id'] = $value['produk_id'];
                $supportFilter[$noSupportFilter]['kode'] = $value['kode'];
                $supportFilter[$noSupportFilter]['total'] = $value['total'];
                $supportFilter[$noSupportFilter]['support'] = $value['support'];
                array_push($supportFilterTrsId, $value['transaksi_id']);
                array_push($supportFilterProdukId, $value['produk_id']);
            }
        }
        $supportFilterProdukId = array_unique($supportFilterProdukId);
        $supportFilter = $this->array_sort_by_column($supportFilter,'total');
        $tempKombinasi = [];
        foreach ($supportFilter as $i => $v) 
        {
            $kombinasi[$v['produk_id']] = [];
            $tempKombinasi[$v['produk_id']] = [];
            foreach ($arr as $x => $w) 
            {
                if(in_array($v['produk_id'], $w['item_set_arr']))
                {
                    $imp = implode(',', $w['item_set_arr']);
                    array_push($kombinasi[$v['produk_id']], $imp);
                }
            }
        }
        $kombinasiFlat = [];
        foreach ($kombinasi as $key => $value) 
        {
            foreach ($value as $i => $v) {
                array_push($kombinasiFlat, $v);
            }
        }
        $fatKombinasi = array_count_values($kombinasiFlat);
        $firstArrItem = [];
        foreach ($fatKombinasi as $key => $value) 
        {
           $exp = explode(',', $key);
           if(count($exp) > 0)
           {
               $produkId = end($exp);
               $firstId = $exp[0];
               array_push($firstArrItem, $firstId);
               if(isset($tempKombinasi[$produkId]))
               {
                   $tempKombinasi[$produkId][$key] = $value;
               }
           }
        }
        $firstArrItem = array_unique($firstArrItem);
        $firstArrItemFix = [];
        foreach ($firstArrItem as $key => $value) {
         $itemFrekuensi_ini = DB::table('transaksi_item as ti')
                        ->join('produk as pd','pd.id','=','ti.produk_id')
                        ->whereIn('ti.transaksi_id',$tiId)
                        ->where('ti.produk_id',$value)
                        ->count();
           $pdNya = DB::table('produk')->where('id',$value)->select('kode')->first();
           $firstArrItemFix[$pdNya->kode] = $itemFrekuensi_ini;
        }
        //dd($firstArrItemFix);
        $finalKombinasi = [];
        $pattern = [];
        $patternNo = 0;
        foreach ($tempKombinasi as $key => $value) 
        {
           if(count($value) > 0)
           {
                $pdIM = DB::table('produk')->where('id',$key)->select('kode')->first();
                $finalKombinasi[$pdIM->kode] = [];
                foreach ($value as $i => $v) 
                {
                   $pi = null;
                   $iExp = explode(',', $i);
                   $pdI = DB::table('produk')->whereIn('id',$iExp)->select('kode')->get();
                   $pdIArr = [];
                   foreach ($pdI as $pdIArrKey => $pdIArrValue) 
                   {
                        array_push($pdIArr, $pdIArrValue->kode);
                   }
                   $pi = implode(',', $pdIArr);
                   $isi = '{'.$pi.':'.$v.'}';
                   array_push($finalKombinasi[$pdIM->kode], $isi);
                   $pattern[$patternNo]['pattern'] = $pi;
                   $pattern[$patternNo]['frekuensi'] = $v;
                   $patternNo++;
                }
                $finalKombinasi[$pdIM->kode] = implode(',', $finalKombinasi[$pdIM->kode]);
           }
        }
        $finalSupport = [];
        foreach ($pattern as $key => $value) 
        {
            $freq = $value['frekuensi'];
            $totalTrs = count($itemFrekuensi);
            //dd($data);
            $resultSupport = round($freq / $totalTrs * 100);
            $finalSupport[$key]['pattern'] = $value['pattern'];
            $finalSupport[$key]['support'] = $resultSupport;

            $expP = explode(',', $value['pattern']);
            $finalSupport[$key]['conf'] = 0;
            if(isset($firstArrItemFix[$expP[0]]))
            {
                $totalA = $firstArrItemFix[$expP[0]];
                //dd($totalA);
                $resultConf = round($freq / $totalA * 100);
                $finalSupport[$key]['conf'] = $resultConf;
            }
            
        }
        $finalSupport = $this->array_sort_by_column_desc($finalSupport,'conf');
        
        $wordFinal = '';
        foreach ($finalSupport as $key => $value) 
        {
           $expP = explode(',', $value['pattern']);
           if(count($expP) > 2)
           {
                $pd1 = DB::table('produk')->where('kode',$expP[0])->first();
                $wordFinal .= '<p>Jika membeli <m style="color:red;">'.$pd1->nama.'</m> maka akan membeli ';
                unset($expP[0]);
                $pd = DB::table('produk')->whereIn('kode',$expP)->get();
                $wrd2 = [];
                foreach ($pd as $pdKey => $pdV) 
                {
                    array_push($wrd2, $pdV->nama);
                }
                $wordFinal .= '<m style="color:green;">'.implode(',', $wrd2).'</m>';
           }else
           {
                if(isset($expP[1]))
                {
                     $pd1 = DB::table('produk')->where('kode',$expP[1])->first();
                     $pd2 = DB::table('produk')->where('kode',$expP[0])->first();
                     $wordFinal .= '<p>Jika membeli <m style="color:red;">'.$pd1->nama.'</m> maka akan membeli <m style="color:green;">'.$pd2->nama.'</m></p>';
                }
           }
        }
       // dd($wordFinal);
        $data = [
                    'arr'=>$arr
                    ,'produk'=>$produkArr
                    ,'frekuensi'=>$itemFrekuensi
                    ,'support'=>$support
                    ,'support_filter'=>$supportFilter
                    ,'pattern'=>$finalKombinasi
                    ,'pattern_detail'=>$pattern
                    ,'final'=>$finalSupport
                    ,'word'=>$wordFinal
                ];
        return $data;
    }

    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
        return $arr;
    }

    function array_sort_by_column_desc(&$arr, $col, $dir = SORT_DESC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
        return $arr;
    }
}
