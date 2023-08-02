<!-- resources/views/transactions/index.blade.php -->

@extends('adminlte::page')

@section('title', 'List Transaksi')

@section('content_header')
    <h1>List Transaksi</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">Tambah Transaksi</a>

            <table class="table table-bordered">
                <!-- Tabel Daftar Transaksi -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal Transaksi</th>
                        <th>Pembeli</th>
                        <th>Nama Produk</th>
                        <th>Jumlah</th>
                        <th>Nominal</th>
                        {{-- <th>Aksi</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($data_penjualan as $penjualan)
                        <tr>
                            <td>{{ $penjualan->id }}</td>
                            <td>{{ $penjualan->tanggal }}</td>
                            <td>{{ $penjualan->pembeli }}</td>
                            <td>{{ $penjualan->nama_barang }}</td>
                            <td>{{ $penjualan->jumlah }}</td>
                            <td>{{ $penjualan->nominal }}</td>
                            {{-- <td>
                                <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalEdit{{ $transaction->id }}">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modalHapus{{ $transaction->id }}">Hapus</a>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>

            </table>
            {!! $data_penjualan->links() !!}
        </div>
    </div>

    <!-- Modal Tambah Transaksi -->
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('penjualan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tanggal_transaksi">Tanggal Transaksi</label>
                            <input type="date" name="tanggal_transaksi" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pembeli">Nama Pembeli</label>
                            <input type="text" name="pembeli" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <select name="nama_produk" class="form-control" id="nama_produk">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-harga="{{ $product->harga_produk }}" data-stok="{{ $product->stok_produk }}">{{ $product->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah" min="1" max="{{ $product->stok_produk }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nominal">Nominal</label>
                            <input type="number" name="nominal" class="form-control" id="nominal" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Ketika pilihan produk berubah, perbarui nilai stok dan hitung nominal
        $('#nama_produk').on('change', function () {
            const selectedOption = $(this).find(':selected');
            const hargaProduk = selectedOption.data('harga');
            const stokProduk = selectedOption.data('stok');
            $('#jumlah').attr('max', stokProduk);
            hitungNominal(hargaProduk);
        });

        // Ketika input jumlah berubah, hitung kembali nominal
        $('#jumlah').on('input', function () {
            const hargaProduk = $('#nama_produk').find(':selected').data('harga');
            hitungNominal(hargaProduk);
        });

        // Fungsi untuk menghitung nominal dan menampilkan pada input nominal
        function hitungNominal(hargaProduk) {
            const jumlah = $('#jumlah').val();
            const nominal = hargaProduk * jumlah;
            $('#nominal').val(nominal);
        }
    </script>
@stop
