@extends('layouts.main')

@section('content')

	<div class="content-wrapper">
	   <div class="page-header">
	      <h3 class="page-title">Produk </h3>
	         <nav aria-label="breadcrumb">
	            <ol class="breadcrumb">
	               <li class="breadcrumb-item"><a href="#">Produk</a></li>
	               <li class="breadcrumb-item active" aria-current="page">Daftar</li>
	          </ol>
	      </nav>
	   </div>
	   <div class="col-lg-12 grid-margin stretch-card">
	                <div class="card">
	                  <div class="card-body">
	                  	<div class="row">
	                  		<div class="col-md-6">
	                  			<a class="btn btn-primary" style="color: white;" href="{{url('produk_create')}}">
	                  				<i class="mdi mdi-plus-circle-outline"></i> Tambah Produk
	                  			</a>
	                  		</div>
	                  		
	                    	<div class="col-md-6" >
	                    		<form action="{{url('produk')}}">
	                    		<div class="input-group mb-3">
								  <input type="text" class="form-control" placeholder="Cari Nama atau Kode Poduk" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{$request->search}}" name="search">
								  <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="mdi mdi-account-search"></i></button>
								</div>
								</form>
	                  		</div>
	                  		
	                	</div>
	                    <div class="table-responsive">
	                      <table class="table table-striped">
	                        <thead>
	                          <tr>
	                            <th> No </th>
	                            <th> Nama </th>
	                            <th> Kode </th>
	                            <th> Kemasan </th>
	                            <th> Harga Satuan </th>
	                            <th> Harga Borongan</th>
	                            <th> Qty Borongan</th>
	                            <th> Stock</th>
	                            <th> Action </th>
	                          </tr>
	                        </thead>
	                        <tbody>
	                          @foreach($data as $key => $item)
	                          	<tr>
	                          		<td style="color: white;">{{$data->firstItem() + $key}}</td>
	                          		<td style="color: white;">{{$item->nama}}</td>
	                          		<td style="color: white;">{{$item->kode}}</td>
	                          		<td style="color: white;">{{$item->kemasan}}</td>
	                          		<td style="color: white;">Rp {{$item->harga_satuan}}</td>
	                          		<td style="color: white;">Rp {{$item->harga_borongan}}</td>
	                          		<td style="color: white;">{{$item->qty_borongan}}</td>
	                          		<td style="color: white;">{{$item->stock}}</td>
	                          		<td>
	                          			<a href="{{url('produk_edit/'.$item->id)}}" class="btn btn-info btn-sm"><i class="mdi mdi-table-edit"></i></a>
	                          			&nbsp;
	                          			<a href="{{url('produk_delete/'.$item->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau menghapus data?')">
	                          				<i class="mdi mdi-delete"></i>
	                          			</a>
	                          		</td>
	                          	</tr>
	                          @endforeach
	                        </tbody>
	                      </table>
	                    </div>
	                    <div class="col-md-12" align="right" style="padding-top: 10px;">
	                    	{{ $data->links() }}
	                    </div>
	                  </div>
	                </div>
	              </div>
	</div>
@endsection
@section('scriptcustom')

@endsection