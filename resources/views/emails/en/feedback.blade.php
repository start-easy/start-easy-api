@extends('layouts.email', ['region' => $region ?? 'sa'])
@section('title')
    New Feedback Submitted - start easy.
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
                <h5 style="font-size:16px; font-weight:600; margin:0 0 16px 0; line-height:24px;">New Feedback
                    Submitted</h5>

                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#090D08" style="border-radius:8px;">
                    <tr>
                        <td style="padding: 16px;">
                            <p style="font-size:14px; font-weight:400; margin:0 0 8px 0; line-height:24px;color: #8a8a8a">Selected Mood</p>
                            <img src="{{ config('app.assets_url') }}/moods/{{ $data['selected'] }}.png" alt="selected_mood" width="272"
                                 height="48"/>

                            <p style="font-size:14px; font-weight:400; margin:16px 0 8px 0; line-height:24px;color: #8a8a8a">Feedback</p>
                            <p style="font-size:16px; font-weight:400; margin:0 0 8px 0; line-height:24px;color: #fff">{{  $data['feedback']  }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
