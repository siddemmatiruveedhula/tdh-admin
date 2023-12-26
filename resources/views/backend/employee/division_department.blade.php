
<label for="division_id" class="form-label">Division <span class="text-danger">*</span></label>
<div class="form-group">
    <select name="division_id" id="division_id" class="form-select select2" aria-label="Select Division">
        <option value="" disabled selected>--Select Division--</option>
        @foreach ($divisions as $division)
            <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                {{ $division->name }}</option>
        @endforeach
    </select>
    <span id="division_id_error" class="d-none con-error text-danger"></span><br />
</div>

<!--  For Select2 -->
<script src="{{ asset('backend/assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/pages/form-advanced.init.js') }}"></script>
<!-- end  For Select2 -->
