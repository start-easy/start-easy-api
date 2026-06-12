@extends('layouts.email', ['region' => $region ?? 'sa'])
@section('title')
    تم تقديم ملاحظات جديدة - ستارت إيزي.
@endsection
@section('content')

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" dir="rtl">

        <tr>
            <td style="padding:32px; color:#DBDBDB; text-align: right;" class="content">
                @php
                    $websiteName = ($region ?? 'sa') === 'qa' ? 'موقع قطر' : 'موقع السعودية';
                    $badgeColor = ($region ?? 'sa') === 'qa' ? '#8B1538' : '#006C35';
                @endphp
                <div style="margin-bottom: 16px; text-align: right;">
                    <span style="background-color: {{ $badgeColor }}; color: #ffffff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                        المصدر: {{ $websiteName }}
                    </span>
                </div>
                <h5 style="font-size:16px; font-weight:600; margin:0 0 16px 0; line-height:24px;">تم تقديم ملاحظات جديدة</h5>

                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#090D08" style="border-radius:8px;">
                    <tr>
                        <td style="padding: 16px;">
                            <p style="font-size:14px; font-weight:400; margin:0 0 8px 0; line-height:24px;color: #8a8a8a">الحالة المزاجية المحددة</p>
                            <img src="{{ config('app.assets_url') }}/moods/{{ $data['selected'] }}.png" alt="selected_mood" width="272"
                                 height="48"/>

                            <p style="font-size:14px; font-weight:400; margin:16px 0 8px 0; line-height:24px;color: #8a8a8a">الملاحظات</p>
                            <p style="font-size:16px; font-weight:400; margin:0 0 8px 0; line-height:24px;color: #fff">{{  $data['feedback']  }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
