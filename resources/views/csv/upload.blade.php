<!DOCTYPE html>
<html>
<head>
    <title>Upload CSV</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Upload Product CSV</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('csv.upload.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Choose CSV File</label>
            <input type="file" name="csv_file" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Upload CSV</button>
    </form>
</div>
</body>
</html>