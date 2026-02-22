<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Security Check</title>
    <style>
        body { background: #f8fafc; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; width: 300px; }
        input { width: 100%; padding: 12px; margin: 15px 0; border: 1px solid #ddd; border-radius: 4px; font-size: 20px; text-align: center; letter-spacing: 10px; }
        button { background: #2563eb; color: white; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold; }
        .error { color: #dc2626; font-size: 14px; margin-bottom: 10px; }

        .alert-success {
            color: #166534;
            background-color: #d1fae5;
            border: 1px solid #a7f3d0;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h3>Enter Security PIN</h3>
        <p>Please enter your 4-digit PIN to continue.</p>
        <div class="alert-success">
            <b>يرجى تعيين أربعة أرقام الخاص بك لتأمين حسابك</b>
            <br>
            <b style="color:#dc2626;">قم بحفظ هذه الأرقام لتستعملها في الدخول دائما</b>
        </div>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('pin.create.store') }}" method="POST">
            @csrf
            <input type="password" name="pin" maxlength="4" required autofocus autocomplete="off">
            <button type="submit">إدخال</button>
        </form>
        <br>
        <a href="{{ route('absence-logout') }}">خروج</a>
    </div>
</body>
</html>

