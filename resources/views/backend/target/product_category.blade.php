<label for="product_id" class="form-label">Product <span
    class="text-danger">*</span></label>
<div class="form-group">
    <select name="product_id" id="product_id" class="form-select select2" aria-label="Select Product">
        <option value="" disabled selected>--Select Product--</option>
        @foreach ($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
        @endforeach
    </select>
</div>
<!--  For Select2 -->
<script src="{{ asset('backend/assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/pages/form-advanced.init.js') }}"></script>
<!-- end  For Select2 -->