<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Akun</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f5f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <table align="center" width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <tr style="background-color: #ff4b2b;">
            <td style="padding: 20px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px;">Verifikasi Akun Anda</h1>
            </td>
        </tr>

        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 16px; color: #333;">Halo <strong>{{ $name }}</strong>,</p>

                <p style="font-size: 16px; color: #333;">
                    Terima kasih telah mendaftar. Untuk menyelesaikan proses registrasi, silakan klik verifikasi
                    berikut:
                </p>

                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ url('/verify/' . $verification_code) }}"
                        style="background-color: #ff4b2b; color: #ffffff; padding: 12px 24px; text-decoration: none;
                              font-size: 16px; border-radius: 6px; display: inline-block; font-weight: bold;">
                        Verifikasi Akun
                    </a>
                </div>

                <p style="font-size: 14px; color: #555;">
                    Verifikasi akun untuk mengaktifkan akun Anda. Berlaku selama
                    15 menit.
                </p>

                <p style="font-size: 14px; color: #555;">
                    Jika Anda tidak merasa mendaftar, silakan abaikan email ini.
                </p>

                <p style="margin-top: 30px; font-size: 14px; color: #999;">
                    Hormat kami,<br>
                    <strong>Tim Support</strong><br>
                    <a href="{{ config('app.url') }}"
                        style="color: #ff4b2b; text-decoration: none;">{{ config('app.name') }}</a>
                </p>
            </td>
        </tr>

        <tr>
            <td style="background-color: #f0f0f0; padding: 15px; text-align: center; font-size: 12px; color: #999;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </td>
        </tr>
    </table>

</body>

</html>
