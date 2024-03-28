<!-- Modal untuk inputan Sales Order -->
<div class="modal fade" id="salesOrderFormModal" tabindex="-1" role="dialog" aria-labelledby="salesOrderFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesOrderFormModalLabel">Form Tambah Sales Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="salesOrderForm">
                    @csrf
                    <input type="hidden" id="id">
                    <div class="col-md-12">
                        <input type="text" id="no_so" class="form-control" placeholder="Nomor Sales Order">
                    </div>
                    <div class="col-md-12">
                        <input type="date" id="tanggal" class="form-control" placeholder="Tanggal">
                    </div>
                    <div class="col-md-12">
                        <select id="customer_id" class="form-control">
                            <option value="">Pilih Pelanggan</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->nama_pelanggan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <select id="product_id" class="form-control">
                            <option value="">Pilih Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->harga }}">{{ $product->nama_product }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <input type="text" id="harga" class="form-control" placeholder="Harga" readonly>
                    </div>
                    <div class="col-md-12">
                        <input type="number" id="qty" class="form-control" placeholder="Kuantitas">
                    </div>
                    <div class="col-md-12">
                        <input type="number" id="total" class="form-control" placeholder="Total" readonly>
                    </div>
                    <div class="col-md-12">
                        <textarea id="keterangan" class="form-control" placeholder="Keterangan"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" onclick="saveSalesOrder()" id="simpanSalesOrder" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk menampilkan detail Purchase Order by id-->
<div class="modal fade" id="salesOrderDetailModal" tabindex="-1" role="dialog" aria-labelledby="salesOrderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="salesOrderDetailModalLabel">Detail Sales Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="detail_no_so" class="form-label">Nomor Sales Order</label>
                        <input type="text" id="detail_no_so" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="detail_tanggal" class="form-label">Tanggal</label>
                        <input type="date" id="detail_tanggal" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6"> 
                        <label for="detail_customer" class="form-label">Customer</label>
                        <input type="text" id="detail_customer" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="detail_product" class="form-label">Product</label>
                        <input type="text" id="detail_product" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="detail_qty" class="form-label">Kuantitas</label>
                        <input type="number" id="detail_qty" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="detail_total" class="form-label">Total</label>
                        <input type="number" id="detail_total" class="form-control" readonly>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="detail_keterangan" class="form-label">Keterangan</label>
                        <textarea id="detail_keterangan" class="form-control" readonly></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#product_id').change(function() {
            var productId = $(this).val();
            var productPrice = $(this).find(':selected').data('price');
            $('#harga').val(productPrice);
        });

        $('#qty').on('input', function() {
            var qty = parseFloat($(this).val());
            var price = parseFloat($('#product_id option:selected').data('price'));
            if (!isNaN(qty) && !isNaN(price)) {
                $('#total').val((qty * price).toFixed(2));
            } else {
                $('#total').val('');
            }
        });
     });
</script>