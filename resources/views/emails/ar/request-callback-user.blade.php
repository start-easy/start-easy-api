@extends('layouts.email', ['region' => $region ?? 'sa'])
@section('title')
    شكراً لطلبك إعادة الاتصال - ستارت إيزي.
@endsection
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" dir="rtl">
        <tr>
            <td style="padding:32px; color:#DBDBDB; text-align: right;" class="content">
                <h5 style="font-size:16px; font-weight:600; margin:0 0 24px 0; line-height:24px;">أهلاً {{ $data['name'] }}،</h5>
                <p style="font-size:16px; font-weight:400; margin:0 0 8px 0; line-height:24px;">شكراً لطلبك إعادة الاتصال!</p>
                <p style="font-size:16px; font-weight:400; margin:0 0 0 0; line-height:24px;">لقد استلمنا طلبك وسيقوم أحد أعضاء فريقنا بالرد عليك عبر {{ $data['communication'] }} قريباً.</p>
            </td>
        </tr>
        <tr>
            <td style="padding-left:32px; padding-right:32px; padding-bottom:32px; text-align: right;" class="content-no-tp-pd">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" style="padding-left:16px; font-size:16px; font-weight:400; color:#00BC3C; line-height:24px;">
                            نحن لسنا هنا لتحقيق بيع سريع. نحن هنا لنجعل حياتك أسهل — وننمو معك.
                        </td>
                        <td valign="top" style="width:40px;">
                            <img src="{{ config('app.assets_url') }}/mail/smile-heart.png" width="40" height="40" alt="Avatar">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
