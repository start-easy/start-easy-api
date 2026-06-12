@extends('layouts.email', ['region' => $region ?? 'sa'])
@section('title')
    Ask Question - start easy.
@endsection
@section('content')
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

        <tr>
            <td style="padding:32px; color:#DBDBDB;" class="content">
                <h5 style="font-size:16px; font-weight:600; margin:0 0 24px 0; line-height:24px;">Hello {{ $data['name'] }},</h5>
                <p style="font-size:16px; font-weight:400; margin:0 0 8px 0; line-height:24px;">Thanks for Reaching Out — We’re Here to Make It <span style="color: #09C645">Easy.</span></p>
                <p style="font-size:16px; font-weight:400; margin:0 0 0 0; line-height:24px;">We’ve received your request and one of our team members will get back to you.</p>
            </td>
        </tr>

        <tr>
            <td style="padding-left:32px; padding-right:32px; padding-bottom:32px;"  class="content-no-tp-pd">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">

                    <tr>
                        <td align="center" bgcolor="#090D08" style="padding:0; border-radius:8px;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: separate; border-spacing:0;">
                                <tr>
                                    <td bgcolor="#090D08" style="padding:1px; border-radius:8px; border:1px solid #004717;">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#090D08" style="border-radius:8px;">
                                            <tr>
                                                <td style="padding:24px;">
                                                    <h5 style="font-size:15px; font-weight:600; margin:0 0 16px 0; line-height:24px;color: #fff">Here’s What You Can Expect:</h5>
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        @php
                                                            $listItems = [
                                                              "Simple steps, no confusion",
                                                              "Transparent pricing, no hidden fees",
                                                              "Straight answers, no fluff",
                                                              "Fast replies from real people",
                                                              "And if we don’t do what we promised — you get your money back."
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
