<!-- Modal untuk Form Jenjang -->
<div class="modal fade" id="productFormModal" tabindex="-1" role="dialog" aria-labelledby="productFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productFormModalLabel">Form Tambah Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body">
                <form class="row g-3" id="productForm">
                    @csrf
                    <input type="hidden" id="id">
                    <div class="col-md-12">
                        <input type="text" id="nama_product" class="form-control" placeholder="Product">
                    </div>
                    <div class="col-md-12">
                        <input type="text" id="deskripsi" class="form-control" placeholder="Deskripsi">
                    </div>
                    <div class="col-md-12">
                        <input type="number" id="harga" class="form-control" placeholder="Harga">
                    </div>
                    <div class="col-md-12">
                        <input type="number" id="stok" class="form-control" placeholder="Stok">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" onclick="saveProduct()" id="simpanProduct" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>