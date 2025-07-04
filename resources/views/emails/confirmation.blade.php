<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ $mailData['title'] }}</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f5f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <table align="center" width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <tr style="background-color: #980000;">
            <td style="padding: 20px; text-align: center; color: #ffffff;">
                <h1 style="margin: 0; font-size: 24px;">Konfirmasi Pesanan Pelanggan</h1>
            </td>
        </tr>

        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 16px; color: #333;">Halo <strong>{{ $mailData['seller'] }}</strong>,</p>

                <p style="font-size: 16px; color: #333;">
                    Segera Konfirmasi Pesanan Pelanggan Anda:
                </p>
                <p style="font-size: 16px; color: #333;">
                    {{ $mailData['body'] }}
                </p>

                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ url('/seller/customer_order/' . $mailData['order_id']) }}"
                        style="background-color: #980000; color: #ffffff; padding: 12px 24px; text-decoration: none;
                              font-size: 16px; border-radius: 6px; display: inline-block; font-weight: bold;">
                        Konfirmasi Pesanan
                    </a>
                </div>

                <p style="font-size: 14px; color: #555;">
                    Jangan Kecewakan Pelanggan Anda! Segera Konfirmasi ya.
                </p>

                <p style="font-size: 14px; color: #555;">
                    Jika Anda tidak merasa sebagai Penjual, silakan abaikan email ini.
                </p>

                <p style="margin-top: 30px; font-size: 14px; color: #999;">
                    Hormat kami,<br>
                    <strong>Tim Support</strong><br>
                    <a href="{{ config('app.url') }}"
                        style="color: #980000; text-decoration: none;">{{ config('app.name') }}</a>
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
