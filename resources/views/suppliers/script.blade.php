<script>

    //fungsi untuk menampilkan data
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $('#tableSupplier').DataTable({
            dom: 'Bfrtip', 
            buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'],
            ajax: {
                url: '/supplier/datatables',
                type: 'GET',
                "serverSide": true,
                "processing": true,
                
            },
            columns: [
                { data: 'nama_pemasok' },
                { data: 'alamat' },
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
                        return '<i class="fa-solid fa-pen-to-square" onclick="editSupplier(' + row.id + ')"></i> ' +
                            '<span style="margin-right: 10px;"></span>' +    
                            '<i class="fa-solid fa-trash" onclick="deleteSupplier(' + row.id + ')"></i>';
                    }
                }
            ],
            order: [[0, 'asc']]
        });
    });

    //fungsi untuk menyimpan data yang diinput
    function saveSupplier() {
        var id = $('#id').val();
        var method = (id === '') ? 'POST' : 'PUT';
        var data = {
            nama_pemasok: $('#nama_pemasok').val(),
            alamat: $('#alamat').val(),
        };
        $.ajax({
            url: '/supplier' + (method === 'POST' ? '' : '/' + id),
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
                        $('#tableSupplier').DataTable().ajax.reload();
                        $('#supplierFormModal').modal('hide');
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
    function editSupplier(id) {
    $.ajax({
        url: '/supplier/' + id,
        type: 'GET',
        success: function (response) {
            $('#id').val(response.supplier.id);
            $('#nama_pemasok').val(response.supplier.nama_pemasok);
            $('#alamat').val(response.supplier.alamat);
            // Mengisi formulir dengan data yang akan diedit
            $('#supplierFormModalLabel').text('Form Edit Data Supplier');
            $('#simpan').text('Simpan Perubahan');
            $('#supplierFormModal').modal('show');
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


    function deleteSupplier(id) {
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
                    url: '/supplier/' + id,
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
                            $('#tableSupplier').DataTable().ajax.reload();
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
    $('#nama_pemasok').val('');
    $('#alamat').val('');
 }
</script>