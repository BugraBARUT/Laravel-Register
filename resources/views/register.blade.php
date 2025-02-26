<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="{{ asset('css/register.style.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        Swal.fire({
                            title: "Başarılı!",
                            text: "Kayıt işlemi başarıyla tamamlandı.",
                            icon: "success",
                            confirmButtonText: "Tamam"
                        }).then(() => {
                            location
                                .reload(); // Başarılı kayıt sonrası sayfayı yenileyebiliriz.
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = "Bilinmeyen bir hata oluştu.";

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = "";
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                errorMessage += value + "\n";
                            });
                        }

                        Swal.fire({
                            title: "Hata!",
                            text: errorMessage,
                            icon: "error",
                            confirmButtonText: "Tamam"
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
