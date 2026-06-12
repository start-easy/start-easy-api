@php
    // Safe fallback to 'sa' to prevent errors before Phase 3 is fully implemented
    $region = $region ?? 'sa';
    $transPrefix = ($region === 'qa') ? 'qa/mail.' : 'mail.';
    $domain = ($region === 'qa') ? 'https://start-easy.qa' : 'https://start-easy.com';
@endphp
    <!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __($transPrefix . 'default_title'))</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body, table, td, a {
            margin: 0;
            padding: 0;
            text-decoration: none;
            direction: {{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }};
        }

        table {
            border-collapse: collapse;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            background-color: #0B0B0B;
            color: #DBDBDB;
            font-family: 'Inter', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* Responsive */
        @media screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }

            .p-32 {
                padding: 16px !important;
            }

            .main-content {
                padding-bottom: 0 !important;
            }

            .footer-logo {
                width: 140px !important;
                height: auto !important;
                margin-bottom: 12px !important;
            }

            .footer, .content {
                padding: 24px !important;
            }

            .content-no-tp-pd {
                padding-left: 24px !important;
                padding-right: 24px !important;
                padding-bottom: 24px !important;
            }
        }
    </style>
</head>
<body bgcolor="#0B0B0B">

<table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#0B0B0B">
    <tr>
        <td align="center" style="padding-bottom: 64px" class="main-content">

            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" class="container"
                   bgcolor="#0B0B0B" style="max-width:600px; width:100%;">

                <tr>
                    <td align="center" style="padding-top:40px; padding-bottom:24px;">
                        <a href="{{ $domain }}">
                            <img src="{{ asset('assets/mail/logo.png') }}" alt="Logo"
                                 width="198" height="56"
                                 style="display:block;" class="logo">
                        </a>
                    </td>
                </tr>

                <tr>
                    <td bgcolor="#171717" style="border-top-left-radius:8px; border-top-right-radius: 8px; padding:0;">
                        @yield('content')
                    </td>
                </tr>

                <tr>
                    <td bgcolor="#1C1C1C"
                        class="footer"
                        style="padding:32px; border-top:1px solid #353535; color:#DBDBDB; border-bottom-left-radius:8px; border-bottom-right-radius:8px;"
                    >
                        <p style="font-size:16px; font-weight:400; margin:0 0 16px 0; line-height:24px; text-align: {{ App::getLocale() == 'ar' ? 'right' : 'left' }};">
                            {!! __($transPrefix . 'footer_tagline') !!}
                        </p>
                        <a href="{{ $domain }}">
                            <img src="{{ asset('assets/mail/logo.png') }}" width="170"
                                 height="48"
                                 style="display:block; margin-bottom: 16px"
                                 class="footer-logo" alt="start easy logo">
                        </a>
                        <p style="font-size:12px; color:#787878; margin:0 0 16px 0; line-height:18px; text-align: {{ App::getLocale() == 'ar' ? 'right' : 'left' }};">
                            {!! __($transPrefix . 'footer_address') !!}
                        </p>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center">
                            <tr>
                                <td>
                                    <a href="https://www.linkedin.com/company/start-easy-official" target="_blank">
                                        <img src="{{ asset('assets/mail/linkedin.png') }}" width="16"
                                             height="16" alt="linkedin">
                                    </a>
                                </td>
                                <td style="width:8px;"></td>

                                <td>
                                    <a href="https://x.com/starteasy_" target="_blank">
                                        <img src="{{ asset('assets/mail/icon-x.png') }}" width="16"
                                             height="16" alt="x">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
