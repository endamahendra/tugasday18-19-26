<!-- Modal untuk Form Jenjang -->
<div class="modal fade" id="customerFormModal" tabindex="-1" role="dialog" aria-labelledby="customerFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerFormModalLabel">Form Tambah Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> 
            <div class="modal-body">
                <form class="row g-3" id="customerForm">
                    @csrf
                    <input type="hidden" id="id">
                    <div class="col-md-12">
                        <input type="text" id="nama_pelanggan" class="form-control" placeholder="Nama Lengkap Pelanggan">
                    </div>
                    <div class="col-md-12">
                        <input type="text" id="alamat" class="form-control" placeholder="Alamat">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-center">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" onclick="saveCustomer()" id="simpanCustomer" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>