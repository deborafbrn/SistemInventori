@extends('layouts.main')

@section('content')

	<div class="content-wrapper">
	   <div class="page-header">
	      <h3 class="page-title">Transaksi </h3>
	         <nav aria-label="breadcrumb">
	            <ol class="breadcrumb">
	               <li class="breadcrumb-item"><a href="#">Transaksi</a></li>
	               <li class="breadcrumb-item active" aria-current="page">Tambah</li>
	          </ol>
	      </nav>
	   </div>
	   <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Tambah Transaksi</h4>
                    <form class="form-sample" action="{{url('transaksi_store')}}" method="POST" enctype="multipart/form-data">
                    	@csrf
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kode</label>
                            <div class="col-sm-9">
                              <input type="text" name="kode" value="{{$kode}}" required placeholder="Contoh : TRS-123" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tanggal</label>
                            <div class="col-sm-9">
                              <input type="date" name="tanggal" value="{{date('Y-m-d')}}" required class="form-control"/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Customer</label>
                            <div class="col-sm-9">
                              <input type="text" name="customer"  required class="form-control" placeholder="Cth : Adi Pangabean" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style=";padding-bottom: 1%;">
                        <p align="center">Daftar Produk</p>
                      </div>
                      <div class="row" style="justify-content: center;">
                        @foreach($produk as $key => $item)
                          <div class="col-md-4">
                            <div class="form-group row">
                              <div class="col-auto">
                                <input type="checkbox" name="produk_id[{{$key}}]" id="produk{{$key}}" value="{{$item->id}}"> {{$item->nama}} - {{$item->kategori}}
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                              <div class="col-auto">
                                <input type="radio" onclick="borongan('<?php echo $item->id?>','<?php echo $item->qty_borongan?>')" name="tipe_produk[{{$key}}]"  value="borongan">&nbsp; Borongan &nbsp;
                                <input type="radio" onclick="borongan('<?php echo $item->id?>','0')" name="tipe_produk[{{$key}}]" checked value="tidak">&nbsp; Tidak
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-sm-3 col-form-label">
                                Qty
                              </label>
                              <div class="col-sm-9">
                                <input type="number" name="qty_produk[{{$key}}]" id="qty_produk{{$item->id}}" class="form-control" value="0" placeholder="Cth : 10">
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </div>
                      <div class="col-sm-12" align="right">
                      	<button class="btn btn-primary" type="submit">Simpan</button>
                      	&nbsp;
                      	<button class="btn btn-outline-secondary" type="reset">Reset</button>
                      	&nbsp;
                      	<a class="btn btn-danger" href="{{url('transaksi')}}" style="color: white;">Batal</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
	</div>
@endsection
@section('scriptcustom')
<script type="text/javascript">
  function borongan(id,qty)
  {
    $('#qty_produk'+id).val(qty);
  }
</script>
@endsection