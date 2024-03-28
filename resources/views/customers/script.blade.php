<script>

    //fungsi untuk menampilkan data
    $(document).ready(function() {
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $('#tableCustomer').DataTable({
            dom: 'Bfrtip', 
            buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print'],
            ajax: {
                url: '/customer/datatables',
                type: 'GET',
                "serverSide": true,
                "processing": true,
                
            },
            columns: [
                { data: 'nama_pelanggan' },
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
                        return '<i class="fa-solid fa-pen-to-square" onclick="editCustomer(' + row.id + ')"></i> ' +
                            '<span style="margin-right: 10px;"></span>' +    
                            '<i class="fa-solid fa-trash" onclick="deleteCustomer(' + row.id + ')"></i>';
                    }
                }
            ],
            order: [[0, 'asc']]
        });
    });

    //fungsi untuk menyimpan data yang diinput
    function saveCustomer() {
        var id = $('#id').val();
        var method = (id === '') ? 'POST' : 'PUT';
        var data = {
            nama_pelanggan: $('#nama_pelanggan').val(),
            alamat: $('#alamat').val(),
        };
        $.ajax({
            url: '/customer' + (method === 'POST' ? '' : '/' + id),
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
                        $('#tableCustomer').DataTable().ajax.reload();
                        $('#customerFormModal').modal('hide');
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
    function editCustomer(id) {
    $.ajax({
        url: '/customer/' + id,
        type: 'GET',
        success: function (response) {
            $('#id').val(response.customer.id);
            $('#nama_pelanggan').val(response.customer.nama_pelanggan);
            $('#alamat').val(response.customer.alamat);
            // Mengisi formulir dengan data yang akan diedit
            $('#customerFormModalLabel').text('Form Edit Data Pelanggan');
            $('#simpan').text('Simpan Perubahan');
            $('#customerFormModal').modal('show');
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


    function deleteCustomer(id) {
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
                    url: '/customer/' + id,
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
                            $('#tableCustomer').DataTable().ajax.reload();
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
    $('#nama_pelanggan').val('');
    $('#alamat').val('');
 }
</script>