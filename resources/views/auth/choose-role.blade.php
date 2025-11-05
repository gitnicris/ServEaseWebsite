<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Role</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
    <div class="card shadow p-4 text-center" style="width: 400px;">
        <h4 class="mb-3">Select Your Role</h4>
        <form action="{{ url('choose.role.save') }}" method="POST">
            @csrf
            <div class="mb-3">
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>-- Choose Role --</option>
                    <option value="customer">Customer</option>
                    <option value="provider">Provider</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Continue</button>
        </form>
    </div>
</body>
</html>
