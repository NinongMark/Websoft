<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            min-height: 100vh;
        }
        .profile-container {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin: 2rem auto;
            max-width: 600px;
        }
        .btn-custom {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            border: none;
            color: #333;
        }
        .btn-custom:hover {
            background: linear-gradient(135deg, #98dcd8 0%, #edc6d1 100%);
        }
        .form-control:focus {
            border-color: #a8edea;
            box-shadow: 0 0 0 0.2rem rgba(168, 237, 234, 0.25);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="profile-container">
            <h2 class="text-center mb-4">My Profile</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" action="/profile">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password (optional)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-custom w-100">Update Profile</button>
            </form>
            <div class="text-center mt-3">
                <a href="/tasks" class="btn btn-secondary">Back to Tasks</a>
                <a href="/logout" class="btn btn-danger ms-2">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
