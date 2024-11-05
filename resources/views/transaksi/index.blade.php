@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar transaksi</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('transaksi/create') }}">Tambah</a>
                <a href="{{ url('/transaksi/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export
                    Transaksi</a>
                <button onclick="modalAction('{{ url('/transaksi/create_ajax') }}')" class="btn btn-success">Tambah
                    Data(Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-sm table-striped table-hover" id="table-transaksi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Pembeli</th>
                        <th>Penjualan Kode</th>
                        <th>Penjualan Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false"
        data-width="75%"></div>
@endsection

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var dataTransaksi;
        $(document).ready(function() {
            dataTransaksi = $('#table-transaksi').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    "url": "{{ url('transaksi/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.filter_kategori = $('.filter_kategori').val();
                    }
                },
                columns: [{
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "user.nama",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true
                }, {
                    data: "pembeli",
                    className: "",
                    width: "37%",
                    orderable: true,
                    searchable: true,
                }, {
                    data: "penjualan_kode",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: true,
                }, {
                    data: "penjualan_tanggal",
                    className: "",
                    width: "10%",
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                        if (data) {
                            var date = new Date(data);
                            var year = date.getFullYear();
                            var month = ("0" + (date.getMonth() + 1)).slice(-
                                2);
                            var day = ("0" + date.getDate()).slice(-2);
                            return year + "-" + month + "-" + day;
                        }
                        return data;
                    }
                }, {
                    data: "aksi",
                    className: "text-center",
                    width: "25%",
                    orderable: false,
                    searchable: false
                }]
            });

            $('#table-transaksi_filter input').unbind().bind().on('keyup', function(e) {
                if (e.keyCode == 13) { 
                    dataTransaksi.search(this.value).draw();
                }
            });

            $('.filter_kategori').change(function() {
                dataTransaksi.draw();
            });
        });
    </script>
@endpush
