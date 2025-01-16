<div class="form-group">
    <label for="">No Kartu</label>
    <div class="row">
        <div class="col-lg-9">
            <input type="text" name="no_rfid" class="form-control mb-3" placeholder="Tempelkan Kartu!" value="{{ $scan }}" readonly>
        </div>
    </div>
    <div class="text-danger">
                    @error('no_rfid')
                        {{$message}}
                    @enderror
                </div>
</div>
