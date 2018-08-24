<div id="add-image" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <form class="search">
        {{ csrf_field() }}
        <input class="form-control mr-sm-2" type="text" id="search" name='search' placeholder="Search" aria-label="Search">
        <button id="search-file" class="btn btn-outline-success my-2 my-sm-0" name="search-file">Search</button>
    </form>
    <div id="result">
    </div>
</div>
@push('scripts')
<script src="{{ asset('js/tinymceAddFiles.js') }}"></script>
@endpush
@push('scripts')
<script src="{{ asset('js/image-picker/image-picker.js') }}"></script>
@endpush
@push('styles')
<link rel="stylesheet" href="{{ asset('js/image-picker/image-picker.css') }}"/>
@endpush