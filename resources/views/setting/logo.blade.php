<form action="{{ route('setting.update', $setting->id) }}?pills=logo" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <strong class="d-block text-center">Favicon</strong>
            <div class="text-center">
                <img src="{{ Storage::url($setting->favicon ?? '') }}" alt="" class="img-thumbnail preview-favicon"
                    width="200">
            </div>
            <div class="form-group mt-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="favicon" name="favicon"
                        onchange="preview('.preview-favicon', this.files[0])">
                    <label class="custom-file-label" for="favicon">Choose file</label>
                </div>
            </div>
        </div>
        <div class="col-lg-2"></div>
        <div class="col-lg-4">
            <strong class="d-block text-center">Logo</strong>
            <div class="text-center">
                <img src="{{ Storage::url($setting->logo ?? '') }}" alt="" class="img-thumbnail preview-logo"
                    width="200">
            </div>
            <div class="form-group mt-3">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="logo" name="logo"
                        onchange="preview('.preview-logo', this.files[0])">
                    <label class="custom-file-label" for="logo">Choose file</label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row mt-5 float-right mr-3">
        <div class="offset-sm-2 col-sm-10">
            <button type="submit" class="btn btn-danger">Simpan</button>
        </div>
    </div>
</form>
