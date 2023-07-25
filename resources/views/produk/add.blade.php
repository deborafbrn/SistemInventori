@extends('layouts.main')

@section('content')

	<div class="content-wrapper">
	   <div class="page-header">
	      <h3 class="page-title">Produk </h3>
	         <nav aria-label="breadcrumb">
	            <ol class="breadcrumb">
	               <li class="breadcrumb-item"><a href="#">Produk</a></li>
	               <li class="breadcrumb-item active" aria-current="page">Tambah</li>
	          </ol>
	      </nav>
	   </div>
	   <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Tambah Produk</h4>
                    <form class="form-sample" action="{{url('produk_store')}}" method="POST" enctype="multipart/form-data">
                    	@csrf
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                              <input type="text" name="nama" required placeholder="Contoh: Pupuk" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kode</label>
                            <div class="col-sm-9">
                              <input type="text" name="kode" required class="form-control" placeholder="Contoh: PPK001" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kategori</label>
                            <div class="col-sm-9">
                              <select class="form-control" name="kategori" required>
                              	<option value="" selected disabled>Pilih</option>
                                <option value="pestisida">Pestisida</option>
                                <option value="pupuk">Pupuk</option>
                                <option value="alat">Alat</option>
                                <option value="bibit">Bibit</option>
                                <option value="vitamin">Vitamin</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kemasan</label>
                            <div class="col-sm-9">
                              <input type="text" name="kemasan" required class="form-control" placeholder="Contoh: Plastik" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                         <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Qty Borongan</label>
                            <div class="col-sm-9">
                              <input type="number" name="qty_borongan" required class="form-control" placeholder="Contoh: 10" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Harga Satuan</label>
                            <div class="col-sm-9">
                              <input type="number" step="any" required name="harga_satuan" class="form-control" placeholder="Contoh: 10.000" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Harga Borongan</label>
                            <div class="col-sm-9">
                              <input type="number" step="any" required name="harga_borongan" class="form-control" placeholder="Contoh: 100.000" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-9">
                              <input type="number" required name="stock" class="form-control" placeholder="Contoh: 100" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12" align="right">
                      	<button class="btn btn-primary" type="submit">Simpan</button>
                      	&nbsp;
                      	<button class="btn btn-outline-secondary" type="reset">Reset</button>
                      	&nbsp;
                      	<a class="btn btn-danger" href="{{url('produk')}}" style="color: white;">Batal</a>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
	</div>
@endsection
@section('scriptcustom')

@endsection