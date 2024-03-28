<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#tablePurchaseOrder').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            ajax: {
                url: '/purchaseorder/datatables',
                type: 'GET',
                "serverSide": true,
                "processing": true,
            },
            columns: [
                { data: 'no_po' },
                { data: 'tanggal' },
                { data: 'supplier.nama_pemasok' }, 
                { data: 'product.nama_product' }, 
                { data: 'total' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<i class="fa-solid fa-eye" onclick="viewPurchaseOrder(' + row.id + ')"></i>' +
                            '<span style="margin-right: 10px;"></span>' +
                            '<i class="fa-solid fa-pen-to-square" onclick="editPurchaseOrder(' + row.id + ')"></i> '+
                            '<span style="margin-right: 10px;"></span>' +
                            '<i class="fa-solid fa-trash" onclick="deletePurchaseOrder(' + row.id + ')"></i>';
                    }
                }
            ],
            order: [[0, 'asc']]
        });
    });

    function savePurchaseOrder() {
        var id = $('#id').val();
        var method = (id === '') ? 'POST' : 'PUT';
        var data = {
            no_po: $('#no_po').val(),
            tanggal: $('#tanggal').val(),
            supplier_id: $('#supplier_id').val(),
            product_id: $('#product_id').val(),
            qty: $('#qty').val(),
            total: $('#total').val(),
            keterangan: $('#keterangan').val(),
        };
        $.ajax({
            url: '/purchaseorder' + (method === 'POST' ? '' : '/' + id),
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
                        $('#tablePurchaseOrder').DataTable().ajax.reload();
                        $('#purchaseOrderFormModal').modal('hide');
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

    function editPurchaseOrder(id) {
        $.ajax({
            url: '/purchaseorder/' + id,
            type: 'GET',
            success: function(response) {
                $('#id').val(response.purchaseOrder.id);
                $('#no_po').val(response.purchaseOrder.no_po);
                $('#tanggal').val(response.purchaseOrder.tanggal);
                $('#supplier_id').val(response.purchaseOrder.supplier_id);
                $('#product_id').val(response.purchaseOrder.product_id);
                $('#harga').val(response.purchaseOrder.product.harga);
                $('#qty').val(response.purchaseOrder.qty);
                $('#total').val(response.purchaseOrder.total);
                $('#keterangan').val(response.purchaseOrder.keterangan);
                $('#purchaseOrderFormModalLabel').text('Form Edit Data');
                $('#simpanPurchaseOrder').text('Simpan Perubahan');
                $('#purchaseOrderFormModal').modal('show');
            },
            error: function(error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Gagal mengambil data Purchase Order.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    function viewPurchaseOrder(id) {
        // Ajax request untuk mendapatkan detail purchase order berdasarkan ID
        $.ajax({
            url: '/purchaseorder/' + id,
            type: 'GET',
            success: function(response) {
                // Mengisi nilai input pada modal detail purchase order
                $('#detail_no_po').val(response.purchaseOrder.no_po);
                $('#detail_tanggal').val(response.purchaseOrder.tanggal);
                var supplierName = response.purchaseOrder.supplier.nama_pemasok;
                var supplierAddress = response.purchaseOrder.supplier.alamat;
                var supplierInfo = supplierName + ' - ' + supplierAddress;
                $('#detail_supplier').val(supplierInfo);
                // $('#detail_supplier').val(response.purchaseOrder.supplier.nama_pemasok);
                var productName = response.purchaseOrder.product.nama_product;
                var productPrice = response.purchaseOrder.product.harga;
                var productInfo = productName + ' - ' + productPrice;
                $('#detail_product').val(productInfo);
                // $('#detail_product').val(response.purchaseOrder.product.nama_product);
                $('#detail_qty').val(response.purchaseOrder.qty);
                // var total = response.purchaseOrder.total;
                // var formattedTotal = formatRupiah(total);
                // $('#detail_total').val(formattedTotal);
                $('#detail_total').val(response.purchaseOrder.total);
                $('#detail_keterangan').val(response.purchaseOrder.keterangan);

                // Menampilkan modal detail purchase order
                $('#purchaseOrderDetailModal').modal('show');
            },
            error: function(error) {
                // Menampilkan pesan error jika gagal mengambil data
                alert('Gagal mendapatkan detail Purchase Order.');
            }
        });
    }

    function deletePurchaseOrder(id) {
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
                    url: '/purchaseorder/' + id,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Data berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#tablePurchaseOrder').DataTable().ajax.reload();
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
                                text: 'Gagal menghapus data Purchase Order.',
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
        $('#no_po').val('');
        $('#tanggal').val('');
        $('#supplier_id').val('');
        $('#product_id').val('');
        $('#qty').val('');
        $('#total').val('');
        $('#keterangan').val('');
    }
</script>
