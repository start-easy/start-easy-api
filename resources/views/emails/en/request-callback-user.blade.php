@extends('layouts.email', ['region' => $region ?? 'sa'])
@section('title')
    Thanks for requesting a callback - start easy.
@endsection
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding:32px; color:#DBDBDB;" class="content">
                <h5 style="font-size:16px; font-weight:600; margin:0 0 24px 0; line-height:24px;">Hello {{ $data['name'] }},</h5>
                <p style="font-size:16px; font-weight:400; margin:0 0 8px 0; line-height:24px;">Thanks for requesting a callback!</p>
                <p style="font-size:16px; font-weight:400; margin:0 0 0 0; line-height:24px;">We’ve received your request and one of our team members will get back to you via {{ $data['communication'] }} shortly.</p>
            </td>
        </tr>
        <tr>
            <td style="padding-left:32px; padding-right:32px; padding-bottom:32px;" class="content-no-tp-pd">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" style="width:40px;">
                            <img src="{{ config('app.assets_url') }}/mail/smile-heart.png" width="40" height="40" alt="Avatar">
                        </td>
                        <td valign="top" style="padding-left:16px; font-size:16px; font-weight:400; color:#00BC3C; line-height:24px;">
                            We’re not here to make a quick sale. We’re here to make your life easier — and grow with you.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
