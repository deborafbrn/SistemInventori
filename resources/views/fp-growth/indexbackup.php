@extends('layouts.main')

@section('content')

<div class="content-wrapper">
	<div class="page-header">
		<h3 class="page-title">FP Growth </h3>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">FP Growth</a></li>
				<li class="breadcrumb-item active" aria-current="page">Daftar</li>
			</ol>
		</nav>
	</div>
	<div class="col-lg-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				<form action="{{url('fp-growth')}}" style="display: contents;">
					<div class="row">
						<div class="col-md-5">
							<input type="date" name="start_date" required class="form-control" value="{{$request->start_date}}">
						</div>
						<div class="col-md-5">
							<input type="date" class="form-control" required name="end_date" value="{{$request->end_date}}">
						</div>
						<div class="col-md-2 pt-1" align="right">
							<button class="btn btn-success" type="submit">Filter Data FP-Growth</button>
						</div>
					</div>
				</form>
				<div class="row">
					<div class="col-md-6">
						<p align="center">Itemset</p>
						<div class="table-responsive">
	                      <table class="table table-striped">
	                      	<thead>
	                      		<tr>
		                      		<th>TID</th>
		                      		<th>Itemset (Kode Produk)</th>
	                      		</tr>
	                      	</thead>
	                      	<tbody>
	                      		@foreach($transaksi as $transaksiKey => $transaksiItem)
	                      		<tr>
	                      			<td style="color: white;">TID {{$transaksiKey+1}}</td>
	                      			<td style="color: white;">{{$transaksiItem['item_set']}}</td>
	                      		</tr>
	                      		@endforeach
	                      	</tbody>
	                      </table>
	                  	</div>
					</div>
					<div class="col-md-6">
						<p align="center">Frekuensi Item</p>
						<div class="table-responsive">
	                      <table class="table table-striped">
	                      	<thead>
	                      		<tr>
		                      		<th>Kode Faktur</th>
		                      		<th></th>
		                      		<th>TID</th>
		                      		<th>Nama Produk</th>
		                      		<th>Kode Produk</th>
	                      		</tr>
	                      	</thead>
	                      	<tbody>
	                      		@foreach($transaksi as $transaksiKeyF => $transaksiItemF)
	                      		<tr>
	                      			<td style="color: white;">{{$transaksiItemF['kode']}}</td>
	                      			<td style="color: white;">=></td>
	                      			<td style="color: white;">TID {{$transaksiKeyF+1}}</td>
	                      			@foreach($transaksiItemF['item'] as $trfItemKey => $trfItemValue)
	                      				<td style="color: white;">{{$trfItemValue['nama_produk']}}</td>
	                      				<td style="color: white;">{{$trfItemValue['kode_produk']}}</td>
	                      			@endforeach
	                      		</tr>
	                      		@endforeach
	                      	</tbody>
	                      </table>
	                  	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scriptcustom')

@endsection