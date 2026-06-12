@extends('layouts.email', ['region' => 'qa'])
@section('title')
    New Proposal - start easy.
@endsection
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding:32px; color:#DBDBDB;" class="content">
                <h5 style="font-size:16px; font-weight:600; margin:0 0 24px 0; line-height:24px;">[Qatar] New Business Setup Proposal Request</h5>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#090D08" style="border-radius:8px;">
                    <tr>
                        <td style="padding: 16px;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0;">Name</th>
                                    <td style="text-align: left; padding-left: 24px; padding: 8px 0;">{{ $proposalData['name'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0;">Email</th>
                                    <td style="text-align: left; padding-left: 24px; padding: 8px 0;">{{ $proposalData['email'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0;">Phone</th>
                                    <td style="text-align: left; padding-left: 24px; padding: 8px 0;">{{ $proposalData['phone'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0;">Business Activity</th>
                                    <td style="text-align: left; padding-left: 24px; padding: 8px 0;">{{ $proposalData['businessActivity'] ?? 'N/A' }}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #222;">
                                    <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0;">Ownership Structure</th>
                                    <td style="text-align: left; padding-left: 24px; padding: 8px 0;">{{ $proposalData['ownershipStructure'] ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; color: #8a8a8a; font-size: 14px; padding: 8px 0; vertical-align: top;">Setup Type</th>
                                    <td style="text-align: left; padding-left: 24px; padding: 8px 0; white-space: pre-wrap;">{{ $proposalData['setupType'] ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <p style="font-size:16px; font-weight:400; margin:16px 0 8px 0; line-height:24px;">Please review the attached PDF for comprehensive details.</p>
            </td>
        </tr>
    </table>
@endsection
