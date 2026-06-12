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
            page-break-inside: auto !important;
        }

        table.answers tr {
            page-break-inside: auto !important;
        }

        table.answers th, table.answers td {
            border: 1px solid #ddd;
            padding: 12px 8px;
            vertical-align: top;
            page-break-inside: auto !important;
        }

        table.answers th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="header">
    @if(isset($logoPath) && file_exists($logoPath))
        <div style="margin-bottom: 20px;">
            <img src="file://{{ $logoPath }}" alt="Start easy" style="width: 220px;">
        </div>
    @endif
    <h1>{{ $pdfLabels['proposal_title'] }}</h1>
</div>

<h2 class="section-title">{{ $pdfLabels['responses_title'] }}</h2>

<table class="answers" style="margin-bottom: 48px;">
    <thead>
    <tr>
        <th width="40%">{{ $pdfLabels['question_field'] }}</th>
        <th width="60%">{{ $pdfLabels['answer_field'] }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($pdfData as $item)
        <tr>
            <td><strong>{{ $item['label'] }}</strong></td>
            <td>{{ $item['value'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@if(isset($logoPath) && file_exists($logoPath))
    <div style="margin-top: 48px; page-break-inside: avoid;">
        <div style="margin-bottom: 20px;">
            <img src="file://{{ $logoPath }}" alt="Start easy" style="width: 150px;">
        </div>
        <p style="font-size:12px; color:#787878; margin:0 0 16px 0; line-height:18px;">
            {{ $pdfLabels['address_line_1'] }}<br/>
            {{ $pdfLabels['address_line_2'] }}
        </p>
        <p style="font-size:14px; color:#3b3b3b; margin:0 0 16px 0; line-height:18px;">
            easy@start-easy.com<br/>
            <strong>+974 6640 0199</strong>
        </p>
    </div>
@endif

</body>
</html>
