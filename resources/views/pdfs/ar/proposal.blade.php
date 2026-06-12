<!DOCTYPE html>
<html>
<head>
    <title>Business Setup Proposal</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ public_path('fonts/DejaVuSans.ttf') }}') format('truetype');
            font-weight: normal;
        }

        @font-face {
            font-family: 'DejaVu Sans';
            src: url('{{ public_path('fonts/DejaVuSans-Bold.ttf') }}') format('truetype');
            font-weight: bold;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 40px;
            font-size: 10pt;
            direction: rtl;
            unicode-bidi: bidi-override;
            text-align: right;
        }

        .header {
            text-align: left;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #09C645;
        }

        .header h1 {
            color: #09C645;
            font-size: 20pt;
            margin-bottom: 10px;
            text-align: right;
        }

        .header p {
            margin: 5px 0;
            font-size: 10pt;
            text-align: right;
        }
        .header table {
            direction: rtl;
        }

        .section-title {
            color: #09C645;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 14pt;
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            direction: rtl;
        }
        table td, table th {
            text-align: right;
        }

        table.answers {
            margin-bottom: 20px;
            page-break-inside: auto !important;
        }

        table.answers tr {
            page-break-inside: auto !important;
        }

        table.answers th, table.answers td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
            page-break-inside: auto !important;
        }

        table.answers th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        table.answers ul {
            margin: 0;
            padding: 0;
            padding-right: 16px; /* RTL padding */
            list-style: none;
            direction: rtl;
        }

        table.answers li {
            margin-bottom: 5px;
            text-align: right;
        }

        /* We will use <p> tags for the separated list, but keep this for the table <ul> */
        table.answers li::before {
            content: "•";
            display: inline-block;
            margin-left: 5px; /* space after bullet */
        }

        table.answers p {
            text-align: right;
        }

        p {
            margin: 0;
            text-align: right;
        }
    </style>
</head>
<body>
<div class="header">

    @if(isset($logoPath) && file_exists($logoPath))
        <div style="text-align: right; margin-bottom: 20px; direction: rtl">
            <img src="file://{{ $logoPath }}" alt="Start easy" style="width: 220px;">
        </div>
    @endif

    <h1>{{ $pdfLabels['proposal_title'] }}</h1>
    <table dir="rtl">
        <tr>
            <td width="60%">
                {{ $emailData['full_name'] ?? 'N/A' }}
            </td>
            <td width="3%" style="text-align: center">:</td>
            <td width="40%">
                <p><strong>{{ $pdfLabels['name'] }}</strong></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>{{ $emailData['email'] ?? 'N/A' }}</p>
            </td>
            <td width="3%" style="text-align: center">:</td>
            <td>
                <p><strong>{{ $pdfLabels['email'] }}</strong></p>
            </td>

        </tr>
        <tr>
            <td><p>{{ $emailData['phone'] ?? 'N/A' }}</p></td>
            <td width="3%" style="text-align: center">:</td>
            <td>
                <p><strong>{{ $pdfLabels['phone'] }}</strong></p>
            </td>
        </tr>
        @if(isset($emailData['name_en']) && $emailData['name_en'])
            <tr>
                <td>
                    <p>{{ $emailData['name_en'] }}</p>
                </td>
                <td width="3%" style="text-align: center">:</td>
                <td>
                    <p><strong>{{ $pdfLabels['trade_name_en'] }}</strong></p>
                </td>
            </tr>
        @endif

        @if(isset($emailData['name_ar']) && $emailData['name_ar'])
            <tr>
                <td>
                    <p dir="rtl">{{ $emailData['name_ar'] }}</p>
                </td>
                <td width="3%" style="text-align: center">:</td>
                <td>
                    <p><strong>{{ $pdfLabels['trade_name_ar'] }}</strong></p>
                </td>
            </tr>
        @endif

        @if(isset($emailData['note']) && $emailData['note'])
            <tr>
                <td>
                    <p>{{ $emailData['note'] }}</p>
                </td>
                <td width="3%" style="text-align: center">:</td>
                <td>
                    <p><strong>{{ $pdfLabels['special_requests'] }}</strong></p>
                </td>
            </tr>
        @endif

    </table>


</div>

<h2 class="section-title">{{ $pdfLabels['responses_title'] }}</h2>

<table class="answers" style="margin-bottom: 48px;">
    <thead>
    <tr>
        <th>{{ $pdfLabels['answer_field'] }}</th>
        <th>{{ $pdfLabels['question_field'] }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($pdfData as $item)
        <tr>
            <td>
                @if (is_array($item['value']))
                    @if (array_keys($item['value']) === range(0, count($item['value']) - 1))
                        {{ implode(', ', $item['value']) }}
                    @else
                        @foreach ($item['value'] as $subLabel => $subValue)
                            @if (is_array($subValue))
                                <strong>{{ $subLabel }}:</strong>
                                <ul>
                                    @foreach ($subValue as $activity)
                                        <li>{{ $activity }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p><strong>{{ $subLabel }}:</strong></p> {{ $subValue }}<br/>
                            @endif
                        @endforeach
                    @endif
                @else
                    {{ $item['value'] }}
                @endif
            </td>
            <td><strong>{{ $item['label'] }}</strong></td>
        </tr>
    @endforeach
    </tbody>
</table>

@if(isset($sectorData) && !empty($sectorData['value']))
    <h2 class="section-title">{{ $sectorData['label'] }}</h2>

    @foreach ($sectorData['value'] as $subLabel => $subValue)
        @if (is_array($subValue) && !empty($subValue))
            <p style="margin-top: 10px; page-break-inside: avoid; page-break-after: avoid;">
                <strong>{{ $subLabel }}:</strong>
            </p>

            {{-- Activity list --}}
            @foreach ($subValue as $activity)
                <p style="padding-right: 32px; page-break-inside: auto;">{{ $activity }}</p>
            @endforeach
        @endif
    @endforeach
@endif
@if(isset($logoPath) && file_exists($logoPath))
    <div style="margin-top: 48px; page-break-inside: avoid; text-align: right; direction: rtl">
        <div style="margin-bottom: 20px; ">
            <img src="file://{{ $logoPath }}" alt="Start easy" style="width: 150px;">
        </div>
        <p style="font-size:12px; color:#787878; margin:0 0 16px 0; line-height:18px;">
            {{ $pdfLabels['address_line_1'] }}<br/>
            {{ $pdfLabels['address_line_2'] }}
        </p>
        <p style="font-size:14px; color:#3b3b3b; margin:0 0 16px 0; line-height:18px;">
            easy@start-easy.com<br/>
            <strong>+966 53 54 55 461</strong>
        </p>
    </div>
@endif

</body>
</html>
