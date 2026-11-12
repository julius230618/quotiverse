<div class="form-card">
    <div class="mb-4">
        <label class="form-label" for="category_name">Category name <span class="required">*</span></label>
        <input class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" type="text" maxlength="100" value="{{ old('category_name', $category->category_name ?? '') }}" placeholder="For example, Motivation" required autofocus>
        @error('category_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-hint">Choose a short name that describes a theme.</div>
    </div>
    <div class="form-actions">
        <a class="btn btn-light" href="{{ route('categories.index') }}">Cancel</a>
        <button class="btn btn-primary" type="submit">{{ $submitLabel }}</button>
    </div>
</div>
