<!DOCTYPE html>
<html>
<head>
    <title>Create Badge</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Create Badge</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                @if (session('badge_path'))
                    <br>
                    <img src="{{ session('badge_path') }}" alt="Created Badge" width="50" height="50">
                @endif
            </div>
        @endif

        <form method="POST" action="{{ route('badges.store') }}">
            @csrf
            <div class="form-group">
                <label for="text">Badge Text (max 10 chars)</label>
                <input type="text" name="text" id="text" class="form-control" maxlength="10" required>
            </div>

            <div class="form-group">
                <label for="color">Text Color</label>
                <input type="color" name="color" id="color" value="#000000" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Badge</button>
        </form>
    </div>
</body>
</html>