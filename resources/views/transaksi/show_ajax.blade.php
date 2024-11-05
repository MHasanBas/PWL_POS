@empty($transaksi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/transaksi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail data Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $transaksi->penjualan_id }}</td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>{{ $transaksi->user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Penjualan kode</th>
                        <td>{{ $transaksi->penjualan_kode }}</td>
                    </tr>
                    <tr>
                        <th>Penjualan tanggal</th>
                        <td>{{ $transaksi->penjualan_tanggal->format('Y-m-d') }}</td>
                    </tr>
                </table>

                <div class="card" style="position: relative; left: 0px; top: 0px;">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="ion ion-clipboard mr-1"></i>
                            Detail Transaksi
                        </h3>
                    </div>

                    <div class="card-body">
                        <ul class="todo-list ui-sortable" data-widget="todo-list">
                            @foreach ($transaksi->transaksiDetail as $detail)
                                <li id="detail-{{ $detail->detail_id }}">
                                    <span class="text">{{ $detail->barang->barang_nama }}</span>

                                    <small class="badge badge-secondary">
                                        Jumlah {{ $detail->jumlah }}
                                    </small>
                                    <small class="badge badge-success">
                                        Harga Rp{{ number_format($detail->harga) }}
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty
