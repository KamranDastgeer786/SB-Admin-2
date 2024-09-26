<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Preferences</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Notification Preferences</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('preferences.update') }}" method="POST">
            @csrf
            @method('POST')

            <div class="list-group">
                @foreach($preferences as $preference)
                    <div class="list-group-item">
                        <div class="form-check">
                            <input 
                                type="checkbox" 
                                id="preference-{{ $preference->id }}" 
                                name="preferences[{{ $loop->index }}][opt_in]" 
                                value="1" 
                                class="form-check-input" 
                                {{ $preference->opt_in ? 'checked' : '' }}>
                            <label 
                                class="form-check-label" 
                                for="preference-{{ $preference->id }}">
                                {{ ucfirst($preference->notification_type) }}
                            </label>
                            <input 
                                type="hidden" 
                                name="preferences[{{ $loop->index }}][id]" 
                                value="{{ $preference->id }}">
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Preferences</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>