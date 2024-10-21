@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">

        @if (session('errors'))
        <div class="mb-4 font-medium text-sm text-green-600 alert alert-danger">
            {{ session('errors') }}
        </div>
        @endif
        @if (session('success'))
        <div class="mb-4 font-medium text-sm text-green-600 alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required>
            <button type="submit">Upload</button>
        </form>

    </div>
</div>
@endsection