<div class="form-card">
    <div class="mb-4">
        <label class="form-label" for="quote_text">Quote <span class="required">*</span></label>
        <textarea class="form-control @error('quote_text') is-invalid @enderror" id="quote_text" name="quote_text" rows="5" maxlength="2000" placeholder="Write the words you want to remember..." required>{{ old('quote_text', $quote->quote_text ?? '') }}</textarea>
        <div class="form-hint">Keep it under 2,000 characters.</div>
        @error('quote_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
        <label class="form-label" for="author">Author <span class="required">*</span></label>
        <input class="form-control @error('author') is-invalid @enderror" id="author" name="author" type="text" maxlength="255" value="{{ old('author', $quote->author ?? '') }}" placeholder="Who said it?" required>
        @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
        <label class="form-label" for="category_id">Category</label>
        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
            <option value="">No category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $quote->category_id ?? '') == $category->id)>{{ $category->category_name }}</option>
            @endforeach
        </select>
        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @if ($categories->isEmpty())<div class="form-hint">You can add categories from the Categories page.</div>@endif
    </div>
    <div class="form-actions">
        <a class="btn btn-light" href="{{ route('quotes.index') }}">Cancel</a>
        <button class="btn btn-primary" type="submit">{{ $submitLabel }}</button>
    </div>
</div>
