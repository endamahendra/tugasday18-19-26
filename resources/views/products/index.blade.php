@extends('layout.app')

@section('content')
    @include('products.modal')
    <div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Data Product</h3>
                <p class="text-subtitle text-muted"></p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Master Data</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Product</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
            <h6 class="card-title">Data Product</h6>
            <div style="margin-bottom: 10px;">
                <button type="button" class="btn btn-primary" onclick="clearForm(); $('#productFormModal').modal('show');">
                    <i class="bi-plus-circle me-2"></i>Tambah Data
                </button>
            </div>
                <table class="table table-striped" id="tableProduct">
                    <thead>
                        <tr>
                            <th>Nama Product</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    </div>

    @include('products.script')
@endsection
