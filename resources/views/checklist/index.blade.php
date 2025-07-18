@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Laravel Coding Checklist</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('submit.checklist') }}">
        @csrf
        @foreach($checklists as $check)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="checklist[]" value="{{ $check->id }}" id="check{{ $check->id }}">
                <label class="form-check-label" for="check{{ $check->id }}">{{ $check->item }} @if($check->is_required) <span class="text-danger">*</span> @endif</label>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary mt-3">Sahkan & Commit</button>
    </form>
</div>
@endsection