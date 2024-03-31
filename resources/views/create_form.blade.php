<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Short Link</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="container mt-5">
    @php
//        dd(session()->all());
    @endphp
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Create a New Short Link</h2>

        <form action="{{ route('link.create') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="original_link" class="form-label">Original Link</label>
                <input type="url" class="form-control @error('original_link') is-invalid @enderror" id="original_link" name="original_link" value="{{ old('original_link') }}">
                @error('original_link')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="max_visits" class="form-label">Max Visits (0 for unlimited)</label>
                <input type="number" class="form-control @error('max_visits') is-invalid @enderror" id="max_visits" name="max_visits" value="{{ old('max_visits', 0) }}">
                @error('max_visits')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="expires_at" class="form-label">Expires At</label>
                <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror" id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                @error('expires_at')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
