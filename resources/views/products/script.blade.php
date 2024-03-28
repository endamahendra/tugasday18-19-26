<script>
    //fungsi untuk menampilkan data
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $('#tableProduct').DataTable({
            dom: 'Bfrtip', 
            buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'],
            ajax: {
                url: '/product/datatables',
                type: 'GET',
                "serverSide": true,
                "processing": true,
                
            },
            columns: [
                { data: 'nama_product' },
                { data: 'deskripsi' },
                { data: 'harga' },
                { data: 'stok' },
                { 
                    data: 'created_at',
                    render: function (data, type, row) {
                        return moment(data).format('YYYY-MM-DD HH:mm:ss');
                    }
                },

                { 
                    data: 'update_at',
                    render: function (data, type, row) {
                        return moment(data).format('YYYY-MM-DD HH:mm:ss');
                    }
                },
                { 
                    data: null,
                    render: function (data, type, row) {
                        return '<i class="fa-solid fa-pen-to-square" onclick="editProduct(' + row.id + ')"></i> ' +
                            '<span style="margin-right: 10px;"></span>' +    
                            '<i class="fa-solid fa-trash" onclick="deleteProduct(' + row.id + ')"></i>';
                    }
                }
            ],
            order: [[0, 'asc']]
        });
    });

    //fungsi untuk menyimpan data yang diinput
    function saveProduct() {
        var id = $('#id').val();
        var method = (id === '') ? 'POST' : 'PUT';
        var data = {
            nama_product: $('#nama_product').val(),
            deskripsi: $('#deskripsi').val(),
            harga: $('#harga').val(),
            stok: $('#stok').val(),
        };
        $.ajax({
            url: '/product' + (method === 'POST' ? '' : '/' + id),
            type: method,
            data:data,
            success: function (response) {
                Swal.fire({
                    title: 'Sukses',
                    text: 'Data berhasil disimpan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        clearForm();
                        $('#tableProduct').DataTable().ajax.reload();
                        $('#productFormModal').modal('hide');
                    }
                });
            },
            error: function (error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal menyimpan data. Periksa kembali input Anda.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    //edit data product
    function editProduct(id) {
    $.ajax({
        url: '/product/' + id,
        type: 'GET',
        success: function (response) {
            $('#id').val(response.product.id);
            $('#nama_product').val(response.product.nama_product);
            $('#deskripsi').val(response.product.deskripsi);
            $('#harga').val(response.product.harga);
            $('#stok').val(response.product.stok);
            // Mengisi formulir dengan data yang akan diedit
            $('#productFormModalLabel').text('Form Edit Data');
            $('#simpan').text('Simpan Perubahan');
            $('#productFormModal').modal('show');
        },
        error: function (error) {
            Swal.fire({
                    title: 'Error',
                    text: 'Gagal mengambil data Product.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
        }
    });
}


    function deleteProduct(id) {
        // Menampilkan modal konfirmasi penghapusan
        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            text: 'Apakah Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi penghapusan
                $.ajax({
                    url: '/product/' + id,
                    type: 'DELETE',
                    success: function (response) {
                        // Menampilkan notifikasi sukses
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Data berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Memuat ulang data setelah penghapusan
                            $('#tableProduct').DataTable().ajax.reload();
                        });
                    },
                    error: function (xhr, status, error) {
                        // Menampilkan notifikasi kesalahan
                        if (xhr.status == 404) {
                            Swal.fire({
                                title: 'Peringatan',
                                text: 'Data dengan ID tersebut tidak ditemukan.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Gagal menghapus data jenjang.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });
    }

    //fungsi untuk menghapus isi form yang sudah diisi
    function clearForm() {
    $('#nama_product').val('');
    $('#deskripsi').val('');
    $('#harga').val('');
    $('#stok').val('');
 }
</script>