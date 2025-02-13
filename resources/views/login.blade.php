<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="{{ asset('css/register.style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="form-container">
        <h2>Giriş Yap</h2>
        <form id="login-form">
            @csrf
            <input type="email" name="email" id="email" placeholder="E-posta" required>
            <input type="password" name="password" id="password" placeholder="Şifre" required>
            <button type="submit">Giriş Yap</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#login-form').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('login') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: "Başarılı!",
                                text: "Giriş başarılı, yönlendiriliyorsunuz...",
                                timer: 1000,
                                icon: "success",
                                confirmButtonText: "Tamam"
                            }).then(() => {
                                window.location.href = response
                                    .redirect; // Ana sayfaya yönlendirme
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = "Bilinmeyen bir hata oluştu.";

                        if (xhr.status === 401) {
                            errorMessage = "E-posta veya şifre hatalı!";
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = "";
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorMessage += value + "\n";
                            });
                        }

                        Swal.fire({
                            title: "Hata!",
                            text: errorMessage,
                            icon: "error",
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
