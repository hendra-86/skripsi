<!-- resources/views/products/index.blade.php -->

@extends('adminlte::page')

@section('title', 'List Stok Produk')

@section('content_header')
    <h1>List Stok Produk</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">Tambah Barang</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->nama_produk }}</td>
                            <td>{{ $product->harga_produk }}</td>
                            <td>{{ $product->stok_produk }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit{{ $product->id }}">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus{{ $product->id }}">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_produk">Harga</label>
                            <input type="number" name="harga_produk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="stok_produk">Stok</label>
                            <input type="number" name="stok_produk" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit dan Hapus (perulangan untuk setiap produk) -->
    @foreach($products as $product)
        <div class="modal fade" id="modalEdit{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEdit{{ $product->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEdit{{ $product->id }}Label">Edit Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_produk">Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control" value="{{ $product->nama_produk }}" required>
                            </div>
                            <div class="form-group">
                                <label for="harga_produk">Harga</label>
                                <input type="number" name="harga_produk" class="form-control" value="{{ $product->harga_produk }}" required>
                            </div>
                            <div class="form-group">
                                <label for="stok_produk">Stok</label>
                                <input type="number" name="stok_produk" class="form-control" value="{{ $product->stok_produk }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Hapus (perulangan untuk setiap produk) -->
        <div class="modal fade" id="modalHapus{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="modalHapus{{ $product->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalHapus{{ $product->id }}Label">Hapus Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus produk "{{ $product->nama_produk }}"?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@stop
