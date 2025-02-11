<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="form-container">
        <h2>Kayıt Ol</h2>
        <form id="register-form">
            @csrf
            <input type="email" name="email" id="email" placeholder="E-posta" required>
            <input type="password" name="password" id="password" placeholder="Şifre" required>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Şifre Tekrar"
                required>
            <button type="submit">Kayıt Ol</button>
        </form>
        <div id="error-message" style="color: red; display: none;"></div>
        <div id="success-message" style="color: green; display: none;"></div>
    </div>

    <script>
        $(document).ready(function() {
            $('#register-form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('register') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#success-message').text('Kayıt başarılı!').show();
                            $('#error-message').hide();
                        } else {
                            $('#error-message').text(response.error).show();
                            $('#success-message').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#error-message').text('Bir hata oluştu. Lütfen tekrar deneyin.')
                            .show();
                        $('#success-message').hide();
                    }
                });
            });
        });
    </script>

</body>

</html>
