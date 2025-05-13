@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($discount) ? 'Edit' : 'Create' }} Discount</h2>
    
    <form action="{{ isset($discount) ? route('discounts.update', $discount) : route('discounts.store') }}" method="POST">
        @csrf
        @if(isset($discount)) @method('PUT') @endif
        
        <div class="mb-3">
            <label for="name" class="form-label">Discount Name</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('name', $discount->name ?? '') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="type" class="form-label">Discount Type</label>
            <select class="form-select" id="type" name="type" required>
                <option value="fixed" {{ old('type', $discount->type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                <option value="percentage" {{ old('type', $discount->type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="value" class="form-label">Discount Value</label>
            <input type="number" step="0.01" class="form-control" id="value" name="value" 
                   value="{{ old('value', $discount->value ?? '') }}" required>
        </div>
        
        <div class="mb-3 form-check">
            <input type="hidden" name="is_active" value="0">
           <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                   {{ old('is_active', $discount->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('discounts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection