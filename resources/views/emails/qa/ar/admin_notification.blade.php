@extends('layouts.email', ['region' => 'qa'])
@section('title')
    طلب عرض أسعار جديد - ابدأ سهل.
@endsection
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" dir="rtl">
        <tr>
            <td style="padding:32px; color:#DBDBDB; text-align: right;" class="content">
                <h5 style="font-size:16px; font-weight:600; margin:0 0 24px 0; line-height:24px;">[قطر] طلب عرض أسعار جديد لتأسيس عمل</h5>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#090D08" style="border-radius:8px;">
                    <tr>
                        <td style="padding: 16px;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0;">الاسم</th>
                                    <td style="text-align: right; padding-right: 24px; padding: 8px 0;">{{ $proposalData['name'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0;">البريد الإلكتروني</th>
                                    <td style="text-align: right; padding-right: 24px; padding: 8px 0;">{{ $proposalData['email'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0;">الهاتف</th>
                                    <td style="text-align: right; padding-right: 24px; padding: 8px 0;">{{ $proposalData['phone'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0;">نشاط العمل</th>
                                    <td style="text-align: right; padding-right: 24px; padding: 8px 0;">{{ $proposalData['businessActivity'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0;">هيكل الملكية</th>
                                    <td style="text-align: right; padding-right: 24px; padding: 8px 0;">{{ $proposalData['ownershipStructure'] ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: right; color: #8a8a8a; font-size: 14px; padding: 8px 0; vertical-align: top;">نوع التأسيس المفضل</th>
                                    <td style="text-align: right; padding-right: 24px; padding: 8px 0; white-space: pre-wrap;">{{ $proposalData['setupType'] ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <p style="font-size:16px; font-weight:400; margin:16px 0 8px 0; line-height:24px;">يرجى مراجعة ملف PDF المرفق للحصول على التفاصيل الشاملة.</p>
            </td>
        </tr>
    </table>
@endsection
