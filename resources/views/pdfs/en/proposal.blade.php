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
        }

        .header p {
            margin: 5px 0;
            font-size: 10pt;
        }

        .section-title {
            color: #09C645;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 14pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table.answers {
            margin-bottom: 20px;
            /* Allow the table itself to break if it's long, though it shouldn't be now */
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
            padding-left: 16px;
        }

        table.answers li {
            margin-bottom: 5px;
        }

        p {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="header">

    @if(isset($logoPath) && file_exists($logoPath))
        <div style="margin-bottom: 20px; ">
            <img src="file://{{ $logoPath }}" alt="Start easy" style="width: 220px;">
        </div>
    @endif

    <h1>{{ $pdfLabels['proposal_title'] }}</h1>
    <table>
        <tr>
            <td width="40%">
                <p><strong>{{ $pdfLabels['name'] }}</strong></p>
            </td>
            <td width="3%" style="text-align: center">:</td>
            <td width="60%">
                {{ $emailData['full_name'] ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <td>
                <p><strong>{{ $pdfLabels['email'] }}</strong></p>
            </td>
            <td width="3%" style="text-align: center">:</td>
            <td>
                <p>{{ $emailData['email'] ?? 'N/A' }}</p>
            </td>
        </tr>
        <tr>
            <td>
                <p><strong>{{ $pdfLabels['phone'] }}</strong></p>
            </td>
            <td width="3%" style="text-align: center">:</td>
            <td><p>{{ $emailData['phone'] ?? 'N/A' }}</p></td>
        </tr>
        @if(isset($emailData['name_en']) && $emailData['name_en'])
            <tr>
                <td>
                    <p><strong>{{ $pdfLabels['trade_name_en'] }}</strong></p>
                </td>
                <td width="3%" style="text-align: center">:</td>
                <td>
                    <p>{{ $emailData['name_en'] }}</p>
                </td>
            </tr>
        @endif

        @if(isset($emailData['name_ar']) && $emailData['name_ar'])
            <tr>
                <td>
                    <p><strong>{{ $pdfLabels['trade_name_ar'] }}</strong></p>
                </td>
                <td width="3%" style="text-align: center">:</td>
                <td>
                    <p>{{ $emailData['name_ar'] }}</p>
                </td>
            </tr>
        @endif

        @if(isset($emailData['note']) && $emailData['note'])
            <tr>
                <td>
                    <p><strong>{{ $pdfLabels['special_requests'] }}</strong></p>
                </td>
                <td width="3%" style="text-align: center">:</td>
                <td>
                    <p>{{ $emailData['note'] }}</p>
                </td>
            </tr>
        @endif

    </table>


</div>

<h2 class="section-title">{{ $pdfLabels['responses_title'] }}</h2>

<table class="answers" style="margin-bottom: 48px;">
    <thead>
    <tr>
        <th>{{ $pdfLabels['question_field'] }}</th>
        <th>{{ $pdfLabels['answer_field'] }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($pdfData as $item)
        <tr>
            <td><strong>{{ $item['label'] }}</strong></td>
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
                                <p style="page-break-inside: avoid;"><strong>{{ $subLabel }}:</strong> {{ $subValue }}</p>
                            @endif
                        @endforeach
                    @endif
                @else
                    {{ $item['value'] }}
                @endif
            </td>
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
                {{-- These p tags can be broken across pages easily --}}
                <p style="padding-left: 32px; page-break-inside: auto;">&bull; {{ $activity }}</p>
            @endforeach
        @endif
    @endforeach
@endif
@if(isset($logoPath) && file_exists($logoPath))
    <div style="margin-top: 48px; page-break-inside: avoid;">
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
