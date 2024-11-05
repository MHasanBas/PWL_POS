@empty($transaksi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan.
                </div>
                <a href="{{ url('/transaksi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/transaksi/' . $transaksi->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>User</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">- Pilih User -</option>
                            @foreach ($user as $l)
                                <option {{ $l->user_id == $transaksi->user_id ? 'selected' : '' }}
                                    value="{{ $l->user_id }}">
                                    {{ $l->nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-user_id" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Pembeli</label>
                        <input type="text" name="pembeli" id="pembeli" class="form-control"
                            value="{{ $transaksi->pembeli }}" required>
                        <small id="error-pembeli" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Penjualan Kode</label>
                        <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control"
                            value="{{ $transaksi->penjualan_kode }}" required>
                        <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label>Penjualan Tanggal</label>
                        <input type="date" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control"
                            value="{{ $transaksi->penjualan_tanggal->format('Y-m-d') }}" required>
                        <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="ion ion-clipboard mr-1"></i> Detail Transaksi</h3>
                        </div>
                        <div class="card-body">
                            <ul class="todo-list" data-widget="todo-list" id="transaction-detail-list">
                                @foreach ($transaksi->transaksiDetail as $detail)
                                    <li id="detail-{{ $detail->detail_id }}">
                                        <span class="text">{{ $detail->barang->barang_nama }}</span>
                                        <small class="badge badge-secondary">Jumlah: {{ $detail->jumlah }}</small>
                                        <small class="badge badge-success">Harga:
                                            Rp{{ number_format($detail->harga) }}</small>
                                        <button type="button" class="btn btn-info btn-sm float-right edit-detail ml-2"
                                            data-id="{{ $detail->detail_id }}" data-barang-id="{{ $detail->barang_id }}"
                                            data-jumlah="{{ $detail->jumlah }}"
                                            data-harga="{{ $detail->harga }}">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm float-right remove-detail"
                                            data-id="{{ $detail->detail_id }}">Remove</button>
                                        <input type="hidden" name="transaksi_details[{{ $detail->detail_id }}][barang_id]"
                                            value="{{ $detail->barang_id }}">
                                        <input type="hidden" name="transaksi_details[{{ $detail->detail_id }}][jumlah]"
                                            value="{{ $detail->jumlah }}">
                                        <input type="hidden" name="transaksi_details[{{ $detail->detail_id }}][harga]"
                                            value="{{ $detail->harga }}">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer clearfix">
                            <button type="button" id="add-barang" class="btn btn-primary float-right"><i
                                    class="fas fa-plus"></i> Add
                                Barang</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>

        <div id="modal-edit-detail" class="modal fade animate shake" tabindex="-1" data-backdrop="static"
            data-keyboard="false" data-width="25%">
            <div id="modal-edit" class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Detail Transaksi</h5>
                        <button type="button" class="close" id="close-edit" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_barang_id">Barang</label>
                            <select name="edit_barang_id" id="edit_barang_id" class="form-control">
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-edit_barang_id" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label for="edit_jumlah">Jumlah</label>
                            <input type="number" name="edit_jumlah" id="edit_jumlah" class="form-control"
                                min="1">
                            <small id="error-edit_jumlah" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group ">
                            <label for="edit_harga">Harga</label>
                            <input type="number" name="edit_harga" id="edit_harga" class="form-control"
                                min="0">
                            <small id="error-edit_harga" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="update-detail">Update</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="modal-tambah-barang" class="modal fade animate shake" tabindex="-1"
            data-backdrop="static"data-keyboard="false" data-width="25%">
            <div id="modal-tambah" class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Barang</h5>
                        <button type="button" class="close" id="close-tambah" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="barang_id">Barang</label>
                            <select name="barang_id" id="barang_id" class="form-control">
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                                @endforeach
                            </select>
                            <small id="error-barang_id" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1">
                            <small id="error-jumlah" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control" min="0">
                            <small id="error-harga" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="save-barang">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
    <script>
        $(document).ready(function() {
            // Add listener for the second modal
            $(document).on('click', '#close-edit', function() {
                // Show the edit modal
                $("#modal-edit-detail").modal('hide');
            });

            // Add listener for the third modal
            $(document).on('click', '#close-tambah', function() {
                // Show the edit modal
                $("#modal-tambah-barang").modal('hide');
            });

            // Add listener for the third modal
            $(document).on('click', '#add-barang', function() {
                // Show the edit modal
                $("#modal-tambah-barang").modal('show');
            });


            // Handle form submission for editing transaction
            $("#form-edit").submit(function(e) {
                e.preventDefault();

                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status) {
                            $("#myModal").modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataTransaksi.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
            });

            // Handle item removal for the edit page
            $(document).on("click", ".remove-detail", function() {
                let detailId = $(this).data('id');
                $("#detail-" + detailId).remove();
                // Optionally, send an AJAX request to the server to remove this detail
            });

            // Handle item editing
            $(document).on("click", ".edit-detail", function() {
                let detailId = $(this).data('id');
                let barangId = $(this).data('barang-id');
                let jumlah = $(this).data('jumlah');
                let harga = $(this).data('harga');

                // Set the values in the edit modal
                $("#edit_barang_id").val(barangId);
                $("#edit_jumlah").val(jumlah);
                $("#edit_harga").val(harga);

                // Show the edit modal
                $("#modal-edit-detail").modal('show');

                // Save the detail id to the button for updating
                $("#update-detail").data('id', detailId);
            });

            // Update the detail when the update button is clicked
            $("#update-detail").on("click", function() {
                let detailId = $(this).data('id');
                let newBarangId = $("#edit_barang_id").val();
                let newJumlah = $("#edit_jumlah").val();
                let newHarga = $("#edit_harga").val();

                // Update the displayed details
                $("#detail-" + detailId + " .text").text($("#edit_barang_id option:selected").text());
                $("#detail-" + detailId + " small.badge-secondary").text("Jumlah: " + newJumlah);
                $("#detail-" + detailId + " small.badge-success").text("Harga: " + new Intl.NumberFormat()
                    .format(newHarga));

                // Update the hidden inputs for the specific detail
                $("input[name='transaksi_details[" + detailId + "][barang_id]']").val(newBarangId);
                $("input[name='transaksi_details[" + detailId + "][jumlah]']").val(newJumlah);
                $("input[name='transaksi_details[" + detailId + "][harga]']").val(newHarga);

                // Hide the edit modal
                $("#modal-edit-detail").modal('hide');
            });

            // Handle adding new item (barang) to the transaction detail
            $("#save-barang").on("click", function() {
                let barangId = $("#barang_id").val();
                let barangText = $("#barang_id option:selected").text();
                let jumlah = $("#jumlah").val();
                let harga = $("#harga").val();

                // Validate input
                if (!barangId || !jumlah || !harga) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validation Error',
                        text: 'Please fill all fields correctly.'
                    });
                    return;
                }

                // Create a new list item for the transaction detail
                let newDetailId = Date.now(); // Unique ID based on timestamp
                let newItem = `
                    <li id="detail-${newDetailId}">
                        <span class="text">${barangText}</span>
                        <small class="badge badge-secondary">Jumlah: ${jumlah}</small>
                        <small class="badge badge-success">Harga: ${new Intl.NumberFormat().format(harga)}</small>
                        <button type="button" class="btn btn-info btn-sm float-right edit-detail" data-id="${newDetailId}" data-barang-id="${barangId}" data-jumlah="${jumlah}" data-harga="${harga}">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm float-right remove-detail" data-id="${newDetailId}">Remove</button>
                        <input type="hidden" name="transaksi_details[${newDetailId}][barang_id]" value="${barangId}">
                        <input type="hidden" name="transaksi_details[${newDetailId}][jumlah]" value="${jumlah}">
                        <input type="hidden" name="transaksi_details[${newDetailId}][harga]" value="${harga}">
                    </li>
                `;

                // Append the new item to the list
                $("#transaction-detail-list").append(newItem);

                // Clear the input fields
                $("#barang_id").val('');
                $("#jumlah").val('');
                $("#harga").val('');

                // Hide the add item modal
                $("#modal-tambah-barang").modal('hide');
            });
        });
    </script>
@endempty