<div class="form-group">
    <label for="recipient-name" style="font-size: 16px; " class=" col-form-label">Nama Layanan:</label>
    <input type="text" class="form-control msglayanan" name="layanan" id="layanan">
</div>
@csrf
<div class="form-group">
    <label for="message-text" style="font-size: 16px; " class=" col-form-label">Deskriptsi</label>
    <textarea type="text" class="form-control msgdeskripsi" name="deskripsi" id="deskripsi"> </textarea>
</div>
<div class="form-group">
    <label for="message-text" style="font-size: 16px; " class=" col-form-label">Harga</label>
    <input type="number" class="form-control msgharga" name="harga" id="harga">
</div>
<div class="form-group">
    <label for="message-text" style="font-size: 16px; " class=" col-form-label">Qty</label>
    <input type="number" class="form-control msgqtyoption" name="qtyoption" min="1" value="1" max="99" id="qtyoption">
</div>