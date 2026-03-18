<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            margin-top: 50px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #ddd;
        }
        .btn-custom {
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            width: 100%;
        }
        .btn-custom:hover {
            background: linear-gradient(45deg, #44a08d, #4ecdc4);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create New Task</h1>
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <button type="submit" class="btn btn-custom">Create Task</button>
        </form>
        <div class="mt-3 text-center">
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Tasks</a>
        </div>
    </div>
</body>
</html>
