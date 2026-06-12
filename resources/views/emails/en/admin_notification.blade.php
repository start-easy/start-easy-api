@extends('layouts.email', ['region' => $region ?? 'sa'])
@section('title')
    New Proposal - start easy.
@endsection
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding:32px; color:#DBDBDB;" class="content">
                @php
                    $websiteName = ($region ?? 'sa') === 'qa' ? 'Qatar Website' : 'Saudi Arabia Website';
                    $badgeColor = ($region ?? 'sa') === 'qa' ? '#8B1538' : '#006C35';
                @endphp
                <div style="margin-bottom: 16px;">
                    <span style="background-color: {{ $badgeColor }}; color: #ffffff; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                        Source: {{ $websiteName }}
                    </span>
                </div>
                <h5 style="font-size:16px; font-weight:600; margin:0 0 24px 0; line-height:24px;">New Business Setup
                    Proposal Request</h5>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#090D08"
                       style="border-radius:8px;">
                    <tr>
                        <td style="padding: 16px;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0;">Name</th>
                                    <td style="text-align: left; padding-left: 24px; padding: 8px 0;">{{ $proposalData['full_name'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0;">Email</th>
                                    <td style="text-align: left; padding-left: 24px; padding: 8px 0;">{{ $proposalData['email'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0;">Phone</th>
                                    <td style="text-align: left; padding-left: 24px; padding: 8px 0;">{{ $proposalData['phone'] ?? 'N/A' }}</td>
                                </tr>
                                @if(isset($proposalData['name_en']) && $proposalData['name_en'])
                                    <tr style="border-bottom: 1px solid #222;">
                                        <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0;">Trade Name (EN)</th>
                                        <td style="text-align: left; padding-left: 24px; padding: 8px 0;">{{ $proposalData['name_en'] }}</td>
                                    </tr>
                                @endif
                                @if(isset($proposalData['name_ar']) && $proposalData['name_ar'])
                                    <tr style="border-bottom: 1px solid #222;">
                                        <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0;">Trade Name (AR)</th>
                                        <td style="text-align: left; padding-left: 24px; padding: 8px 0;">{{ $proposalData['name_ar'] }}</td>
                                    </tr>
                                @endif
                                @if(isset($proposalData['note']) && $proposalData['note'])
                                    <tr>
                                        <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0; vertical-align: top;">Notes</th>
                                        <td style="text-align: left; padding-left: 24px; padding: 8px 0; white-space: pre-wrap;">{{ $proposalData['note'] }}</td>
                                    </tr>
                                @endif
                            </table>
                        </td>
                    </tr>
                </table>
                <p style="font-size:16px; font-weight:400; margin:16px 0 8px 0; line-height:24px;">Please review the
                    attached PDF for comprehensive details.</p>
            </td>
        </tr>
    </table>
@endsection
