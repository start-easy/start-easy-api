@extends('layouts.email', ['region' => $region ?? 'sa'])
@section('title')
    Expert Question - start easy.
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
                <h5 style="font-size:16px; font-weight:600; margin:0 0 24px 0; line-height:24px;">New Expert Question
                    Submitted</h5>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#090D08" style="border-radius:8px;">
                    <tr>
                        <td style="padding: 16px;">
                            <table>
                                <tr>
                                    <th style="text-align: left; color: #8a8a8a">Name</th>
                                    <td  style="text-align: left; padding-left: 24px">{{ $data['name'] }}</td>
                                </tr>
                                <tr>
                                    <td style="height: 16px; color: #8a8a8a"></td>
                                    <td style="height: 16px"></td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; color: #8a8a8a">Email</th>
                                    <td style="text-align: left; padding-left: 24px">{{ $data['email'] }}</td>
                                </tr>
                                <tr>
                                    <td style="height: 16px"></td>
                                    <td style="height: 16px"></td>
                                </tr>
                                <tr>
                                    <th style="text-align: left; vertical-align: top; color: #8a8a8a">Question</th>
                                    <td style="text-align: left; padding-left: 24px; line-height: 24px;">{{ $data['question'] ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
