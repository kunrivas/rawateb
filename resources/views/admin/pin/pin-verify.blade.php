<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Security Check</title>
    <style>
        body { background: #f8fafc; font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; width: 300px; }
        input { width: 100%; padding: 12px; margin: 15px 0; border: 1px solid #ddd; border-radius: 4px; font-size: 20px; text-align: center; letter-spacing: 10px; }
        button { background: #2563eb; color: white; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold; }
        .error { color: #dc2626; font-size: 14px; margin-bottom: 10px; }
        .pin-gap {
            width: 40px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            -webkit-text-security: disc;
            border: 2px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h3>Admin PIN Verification</h3>
        <p>Please enter your 4-digit PIN to continue.</p>

        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.pin.check') }}" method="POST" id="pin-form">
            @csrf
            <div class="pin-wrapper" style="direction: ltr; display: flex; gap: 10px; justify-content: center;">
                <input type="tel" class="pin-gap" maxlength="1" required autofocus autocomplete="one-time-code" pattern="[0-9]*">
                <input type="tel" class="pin-gap" maxlength="1" required autocomplete="one-time-code" pattern="[0-9]*">
                <input type="tel" class="pin-gap" maxlength="1" required autocomplete="one-time-code" pattern="[0-9]*">
                <input type="tel" class="pin-gap" maxlength="1" required autocomplete="one-time-code" pattern="[0-9]*">
            </div>
            <input type="hidden" name="pin" id="full-pin">

            <button type="submit" style="margin-top: 20px;">Verify</button>
        </form>

        <br>
        <a href="{{ route('admin-logout') }}"
           onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">Logout</a>
        <form id="admin-logout-form" action="{{ route('admin-logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

    <script>
        window.onload = () => document.getElementById('pin-form').reset();

        document.querySelectorAll('.pin-gap').forEach((input, index, inputs) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }

                let combined = "";
                inputs.forEach(i => combined += i.value);
                document.getElementById('full-pin').value = combined;
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === "Backspace" && input.value === "" && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        window.onpageshow = () => {
            document.querySelectorAll('.pin-gap').forEach((input) => {
                input.value = '';
            });
        };
    </script>
</body>
</html>
