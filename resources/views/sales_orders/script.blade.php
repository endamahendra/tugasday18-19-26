<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#tableSalesOrder').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            ajax: {
                url: '/salesorder/datatables',
                type: 'GET',
                "serverSide": true,
                "processing": true,
            },
            columns: [
                { data: 'no_so' },
                { data: 'tanggal' },
                { data: 'customer.nama_pelanggan' }, 
                { data: 'product.nama_product' }, 
                { data: 'total' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<i class="fa-solid fa-eye" onclick="viewSalesOrder(' + row.id + ')"></i>' +
                            '<span style="margin-right: 10px;"></span>' +
                            '<i class="fa-solid fa-pen-to-square" onclick="editSalesOrder(' + row.id + ')"></i> '+
                            '<span style="margin-right: 10px;"></span>' +
                            '<i class="fa-solid fa-trash" onclick="deleteSalesOrder(' + row.id + ')"></i>';
                    }
                }
            ],
            order: [[0, 'asc']]
        });
    });

    function saveSalesOrder() {
        var id = $('#id').val();
        var method = (id === '') ? 'POST' : 'PUT';
        var data = {
            no_so: $('#no_so').val(),
            tanggal: $('#tanggal').val(),
            customer_id: $('#customer_id').val(),
            product_id: $('#product_id').val(),
            qty: $('#qty').val(),
            total: $('#total').val(),
            keterangan: $('#keterangan').val(),
        };
        $.ajax({
            url: '/salesorder' + (method === 'POST' ? '' : '/' + id),
            type: method,
            data: data,
            success: function(response) {
                Swal.fire({
                    title: 'Sukses',
                    text: 'Data berhasil disimpan',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        clearForm();
                        $('#tableSalesOrder').DataTable().ajax.reload();
                        $('#salesOrderFormModal').modal('hide');
                    }
                });
            },
            error: function(error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal menyimpan data. Periksa kembali input Anda.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    function editSalesOrder(id) {
        $.ajax({
            url: '/salesorder/' + id,
            type: 'GET',
            success: function(response) {
                $('#id').val(response.salesOrder.id);
                $('#no_so').val(response.salesOrder.no_so);
                $('#tanggal').val(response.salesOrder.tanggal);
                $('#customer_id').val(response.salesOrder.customer_id);
                $('#product_id').val(response.salesOrder.product_id);
                $('#harga').val(response.salesOrder.product.harga);
                $('#qty').val(response.salesOrder.qty);
                $('#total').val(response.salesOrder.total);
                $('#keterangan').val(response.salesOrder.keterangan);
                $('#salesOrderFormModalLabel').text('Form Edit Data');
                $('#SimpansalesOrder').text('Simpan Perubahan');
                $('#salesOrderFormModal').modal('show');
            },
            error: function(error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal mengambil data Sales Order.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    function viewSalesOrder(id) {
        // Ajax request untuk mendapatkan detail sales order berdasarkan ID
        $.ajax({
            url: '/salesorder/' + id,
            type: 'GET',
            success: function(response) {
                // Mengisi nilai input pada modal detail sales order
                $('#detail_no_so').val(response.salesOrder.no_so);
                $('#detail_tanggal').val(response.salesOrder.tanggal);
                var customerName = response.salesOrder.customer.nama_pelanggan;
                var customerAddress = response.salesOrder.customer.alamat;
                var customerInfo = customerName + ' - ' + customerAddress;
                $('#detail_customer').val(customerInfo);
                // $('#detail_customer').val(response.salesOrder.customer.nama_pemasok);
                var productName = response.salesOrder.product.nama_product;
                var productPrice = response.salesOrder.product.harga;
                var productInfo = productName + ' - ' + productPrice;
                $('#detail_product').val(productInfo);
                // $('#detail_product').val(response.salesOrder.product.nama_product);
                $('#detail_qty').val(response.salesOrder.qty);
                // var total = response.salesOrder.total;
                // var formattedTotal = formatRupiah(total);
                // $('#detail_total').val(formattedTotal);
                $('#detail_total').val(response.salesOrder.total);
                $('#detail_keterangan').val(response.salesOrder.keterangan);

                // Menampilkan modal detail purchase order
                $('#salesOrderDetailModal').modal('show');
            },
            error: function(error) {
                // Menampilkan pesan error jika gagal mengambil data
                alert('Gagal mendapatkan detail Purchase Order.');
            }
        });
    }

    function deleteSalesOrder(id) {
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
                $.ajax({
                    url: '/salesorder/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Data berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#tableSalesOrder').DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
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
                                text: 'Gagal menghapus data Sales Order.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            }
        });
    }

    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + ribuan;
    }

    function clearForm() {
        $('#no_so').val('');
        $('#tanggal').val('');
        $('#customer_id').val('');
        $('#product_id').val('');
        $('#qty').val('');
        $('#total').val('');
        $('#keterangan').val('');
    }
</script>
