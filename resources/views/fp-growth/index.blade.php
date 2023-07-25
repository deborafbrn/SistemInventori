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
							<button class="btn btn-success" type="submit">Filter Data FP Growth</button>
						</div>
					</div>
				</form>
				<div class="row" style="padding-top: 20px;">
					<p align="center">Perhitungan Data Transaksi Dari {{$request->start_date}} - {{$request->end_date}}</p>
					<div class="col-md-12">
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
					<div class="col-md-12" style="padding-top: 20px;">
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
	                      			
	                      				<td style="color: white;">
	                      					<ul style="line-height: 30px;">
	                      					@foreach($transaksiItemF['item'] as $trfItemKey => $trfItemValue)
	                      						<li>{{$trfItemValue['nama_produk']}}</li>
	                      					@endforeach
	                      					</ul>
	                      				</td>
	                      				<td style="color: white;">
	                      					<ul style="line-height: 30px;">
	                      					@foreach($transaksiItemF['item'] as $trfItemKey => $trfItemValue)
	                      						<li>{{$trfItemValue['kode_produk']}}</li>
	                      					@endforeach
	                      					</ul>
	                      				</td>
	                      			
	                      		</tr>
	                      		@endforeach
	                      	</tbody>
	                      </table>
	                  	</div>
					</div>
					<div class="col-md-12" style="padding-top: 20px;">
						<p align="center">Frekuensi Kemunculan Setiap Item</p>
						<div class="table-responsive">
	                      <table class="table table-striped">
	                      	<thead>
	                      		<tr>
		                      		<th>Item</th>
		                      		<th>Frekuensi</th>
	                      		</tr>
	                      	</thead>
	                      	<tbody>
	                      		@foreach($frekuensi as $produkKey => $produkItem)
	                      		<tr>
	                      			<td style="color: white;">{{$produkItem['kode']}}</td>
	                      			<td style="color: white;">{{$produkItem['total']}}</td>
	                      		</tr>
	                      		@endforeach
	                      	</tbody>
	                      </table>
	                  	</div>
					</div>
					<div class="col-md-12" style="padding-top: 20px;">
						<p align="center">Frekuensi Kemunculan Item Dengan Nilai Support</p>
						<div class="table-responsive">
	                      <table class="table table-striped">
	                      	<thead>
	                      		<tr>
		                      		<th>Item</th>
		                      		<th>Frekuensi</th>
		                      		<th>Nilai Support</th>
	                      		</tr>
	                      	</thead>
	                      	<tbody>
	                      		@foreach($support as $supportKey => $supportItem)
	                      		<tr>
	                      			<td style="color: white;">{{$supportItem['kode']}}</td>
	                      			<td style="color: white;">{{$supportItem['total']}}</td>
	                      			<td style="color: white;">{{$supportItem['support']}}%</td>
	                      		</tr>
	                      		@endforeach
	                      	</tbody>
	                      </table>
	                  	</div>
					</div>
					<div class="col-md-12" style="padding-top: 20px;">
						<p align="center">Frekuensi Kemunculan Item Dengan Support Count Minimal (30%)</p>
						<div class="table-responsive">
	                      <table class="table table-striped">
	                      	<thead>
	                      		<tr>
		                      		<th>Item</th>
		                      		<th>Frekuensi</th>
		                      		<th>Support</th>
	                      		</tr>
	                      	</thead>
	                      	<tbody>
	                      		@foreach($supportFilter as $supportFilterKey => $supportFilterItem)
	                      		<tr>
	                      			<td style="color: white;">{{$supportFilterItem['kode']}}</td>
	                      			<td style="color: white;">{{$supportFilterItem['total']}}</td>
	                      			<td style="color: white;">{{$supportFilterItem['support']}}%</td>
	                      		</tr>
	                      		@endforeach
	                      	</tbody>
	                      </table>
	                  	</div>
					</div>
					<!-- <div class="col-md-12" style="padding-top: 20px;">
						<p align="center">Item Fp Growth & Pointer</p>
						<div class="table-responsive">
	                      <table class="table table-striped">
	                      	<thead>
	                      		<tr>
		                      		<th>Item</th>
		                      		<th>Frekuensi</th>
	                      		</tr>
	                      	</thead>
	                      	<tbody>
	                      		@foreach($supportFilter as $supportFilterKey => $supportFilterItem)
	                      		<tr>
	                      			<td style="color: white;">{{$supportFilterItem['kode']}}</td>
	                      			<td style="color: white;">{{$supportFilterItem['total']}}</td>
	                      		</tr>
	                      		@endforeach
	                      	</tbody>
	                      </table>
	                  	</div>
					</div> -->
					<div class="col-md-12" style="padding-top: 20px;">
						<p align="center">Frekuensi Itemset</p>
						<div class="table-responsive">
	                      <table class="table table-striped">
	                      	<thead>
	                      		<tr>
		                      		<th>Item</th>
		                      		<th>Pattern Frekuensi Itemset</th>
	                      		</tr>
	                      	</thead>
	                      	<tbody>
	                      		@foreach($pattern as $patternKkey => $patternItem)
	                      		<tr>
	                      			<td style="color: white;">{{$patternKkey}}</td>
	                      			<td style="color: white;">{{$patternItem}}</td>
	                      		</tr>
	                      		@endforeach
	                      	</tbody>
	                      </table>
	                  	</div>
					</div>
					<div class="col-md-12" style="padding-top: 20px;">
						<p align="center">Hasil Pattern Frekuensi Itemset</p>
						<div class="table-responsive">
	                      <table class="table table-striped">
	                      	<thead>
	                      		<tr>
		                      		<th>Frekuensi Pattern</th>
		                      		<th>Frekuensi</th>
	                      		</tr>
	                      	</thead>
	                      	<tbody>
	                      		@foreach($patternDetail as $patternDetailKey => $patternDetailItem)
	                      		<tr>
	                      			<td style="color: white;">{{$patternDetailItem['pattern']}}</td>
	                      			<td style="color: white;">{{$patternDetailItem['frekuensi']}}</td>
	                      		</tr>
	                      		@endforeach
	                      	</tbody>
	                      </table>
	                  	</div>
					</div>
					<div class="col-md-12" style="padding-top: 20px;">
						<p align="center">Rules Yang Terbentuk</p>
						<div class="table-responsive">
	                      <table class="table table-striped">
	                      	<thead>
	                      		<tr>
		                      		<th>Rule</th>
		                      		<th>Support</th>
		                      		<th>Confidence</th>
	                      		</tr>
	                      	</thead>
	                      	<tbody>
	                      		@foreach($final as $finalKey => $finalItem)
	                      		<tr>
	                      			<td style="color: white;">{{$finalItem['pattern']}}</td>
	                      			<td style="color: white;">{{$finalItem['support']}}%</td>
	                      			<td style="color: white;">{{$finalItem['conf']}}%</td>
	                      		</tr>
	                      		@endforeach
	                      	</tbody>
	                      </table>
	                  	</div>
					</div>
					<div class="col-md-12" style="padding-top: 20px;">
						<p align="center">Hasil Kombinasi</p>
						<?php echo $word?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scriptcustom')

@endsection