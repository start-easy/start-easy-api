@extends('layouts.email', ['region' => $region ?? 'sa'])
@section('title')
    اسأل سؤالاً - ستارت إيزي.
@endsection
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" dir="rtl">

        <tr>
            <td style="padding:32px; color:#DBDBDB; text-align: right;" class="content">
                <h5 style="font-size:16px; font-weight:600; margin:0 0 24px 0; line-height:24px;">أهلاً {{ $data['name'] }}،</h5>
                <p style="font-size:16px; font-weight:400; margin:0 0 8px 0; line-height:24px;">شكراً لتواصلك معنا — نحن هنا لنجعل الأمر <span style="color: #09C645">سهلاً.</span></p>
                <p style="font-size:16px; font-weight:400; margin:0 0 0 0; line-height:24px;">لقد استلمنا طلبك وسيقوم أحد أعضاء فريقنا بالرد عليك.</p>
            </td>
        </tr>

        <tr>
            <td style="padding-left:32px; padding-right:32px; padding-bottom:32px; text-align: right;"  class="content-no-tp-pd">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                    <tr>
                        <td align="center" bgcolor="#090D08" style="padding:0; border-radius:8px;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: separate; border-spacing:0;">
                                <tr>
                                    <td bgcolor="#090D08" style="padding:1px; border-radius:8px; border:1px solid #004717;">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#090D08" style="border-radius:8px;">
                                            <tr>
                                                <td style="padding:24px;">
                                                    <h5 style="font-size:15px; font-weight:600; margin:0 0 16px 0; line-height:24px;color: #fff">إليك ما يمكن أن تتوقعه:</h5>
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        @php
                                                            $listItems = [
                                                              "خطوات بسيطة، بدون تعقيد",
                                                              "أسعار شفافة، بدون رسوم خفية",
                                                              "إجابات واضحة، بدون حشو",
                                                              "ردود سريعة من أشخاص حقيقيين",
                                                              "وإذا لم نلتزم بما وعدنا به — تسترد أموالك."
                                                            ];
                                                        @endphp
                                                        @foreach($listItems as $index => $item)
                                                            <tr>
                                                                <td valign="top" style="padding-bottom: {{ $index === count($listItems)-1 ? '0' : '16px' }};">
                                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td valign="top" style="width:24px;">
                                                                                <img src="{{ config('app.assets_url') }}/mail/checkbox.png" width="24" height="24" alt="✔">
                                                                            </td>
                                                                            <td valign="top" style="padding-left:16px; font-size:16px; font-weight:400; color:#DBDBDB; line-height:24px;">
                                                                                {{ $item }}
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
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
