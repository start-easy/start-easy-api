@extends('layouts.email')
@section('title')
    طلب عرض أسعار جديد - ابدأ سهل.
@endsection
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" dir="rtl">
        <tr>
            <td style="padding:32px; color:#DBDBDB; text-align: right;" class="content">
                <h5 style="font-size:16px; font-weight:600; margin:0 0 24px 0; line-height:24px;">طلب عرض أسعار جديد لتأسيس عمل</h5>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#090D08"
                       style="border-radius:8px;">
                    <tr>
                        <td style="padding: 16px;">
                            {{-- Static table structure, translated --}}
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0;">الاسم</th>
                                    <td style="text-align: right; padding-right: 24px; padding: 8px 0;">{{ $proposalData['full_name'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0;">البريد الإلكتروني</th>
                                    <td style="text-align: right; padding-right: 24px; padding: 8px 0;">{{ $proposalData['email'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0;">الهاتف</th>
                                    <td style="text-align: right; padding-right: 24px; padding: 8px 0;">{{ $proposalData['phone'] ?? 'N/A' }}</td>
                                </tr>
                                @if(isset($proposalData['name_en']) && $proposalData['name_en'])
                                    <tr style="border-bottom: 1px solid #222;">
                                        <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0;">الاسم التجاري (EN)</th>
                                        <td style="text-align: right; padding-right: 24px; padding: 8px 0;">{{ $proposalData['name_en'] }}</td>
                                    </tr>
                                @endif
                                @if(isset($proposalData['name_ar']) && $proposalData['name_ar'])
                                    <tr style="border-bottom: 1px solid #222;">
                                        <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0;">الاسم التجاري (AR)</th>
                                        <td style="text-align: right; padding-right: 24px; padding: 8px 0;">{{ $proposalData['name_ar'] }}</td>
                                    </tr>
                                @endif
                                @if(isset($proposalData['note']) && $proposalData['note'])
                                    <tr>
                                        <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0; vertical-align: top;">ملاحظات</th>
                                        <td style="text-align: right; padding-right: 24px; padding: 8px 0; white-space: pre-wrap;">{{ $proposalData['note'] }}</td>
                                    </tr>
                                @endif
                            </table>
                        </td>
                    </tr>
                </table>
                <p style="font-size:16px; font-weight:400; margin:16px 0 8px 0; line-height:24px;">يرجى مراجعة
                    ملف PDF المرفق للحصول على التفاصيل الشاملة.</p>
            </td>
        </tr>
    </table>
@endsection
