@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-warning">
                    <h3>Modifier la Catégorie</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label>Nom de la catégorie *</label>
                            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $category->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label>Icône (nom Lucide)</label>
                            <input type="text" name="icon" class="form-control" value="{{ $category->icon }}">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" {{ $category->is_active ? 'checked' : '' }}>
                            <label class="form-check-label">Active</label>
                        </div>
                        <button type="submit" class="btn btn-warning">Mettre à jour</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
