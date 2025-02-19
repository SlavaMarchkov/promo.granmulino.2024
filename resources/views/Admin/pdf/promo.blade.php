<!DOCTYPE html>
<html lang="ru">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Promo #{{ $promo['id'] }}</title>

    <style>
        @page {
            margin: 4px;
        }

        body {
            font-size: 0.6em;
        }

        .page-break {
            page-break-after: always;
        }

        h3, h4 {
            text-align: center;
        }

        p {
            margin-bottom: 10px;
        }

        ol li {
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .intro {
            margin-bottom: 30px;
        }

        .intro p {
            text-align: right;
            font-style: italic;
        }

        table {
            margin: 0 0 15px 0;
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        table th {
            padding: 5px;
        }

        table td {
            padding: 5px;
        }

        table.info {
            width: 50%;
        }

        table.info tr td {
            padding: 2px 10px;
            text-align: left;
        }

        table.info tr td.title {
            font-weight: bold;
        }

        table.address td {
            width: 50%;
            border: 1px solid #444;
            padding: 8px;
            vertical-align: top;
        }

        table.address td p {
            margin: 0;
        }

        .list thead,
        .list tbody {
            border: 1px solid #3b3b3b;
            vertical-align: middle;
            line-height: 1.2;
        }

        .list thead th {
            padding: 5px 2px;
            border: 1px solid #3b3b3b;
            text-align: center;
        }

        .list tbody td {
            padding: 5px 2px;
            border: 1px solid #3b3b3b;
            text-align: center;
        }

        .list tfoot th {
            padding: 5px 2px;
            border: none;
            text-align: right;
        }
    </style>

</head>

<body>

<table class="info">
    <tbody>
    <tr>
        <td class="title">Название промо-акции</td>
        <td>{{ $promo['type'] }}</td>
    </tr>
    <tr>
        <td class="title">Дистрибутор</td>
        <td>{{ $promo['distributor'] }}</td>
    </tr>
    <tr>
        <td class="title">Город</td>
        <td>{{ $promo['city'] }}</td>
    </tr>
    <tr>
        <td class="title">Канал продаж</td>
        <td>{{ $promo['channel'] }}</td>
    </tr>
    <tr>
        <td class="title">Начало промо-акции</td>
        <td>{{ $promo['start_date'] }}</td>
    </tr>
    <tr>
        <td class="title">Окончание промо-акции</td>
        <td>{{ $promo['end_date'] }}</td>
    </tr>
    <tr>
        <td class="title">Планируемый бюджет</td>
        <td>{{ $promo['total_budget_plan'] }} руб.</td>
    </tr>
    <tr>
        <td class="title">Планируемая прибыль</td>
        <td>{{ $promo['total_promo_profit_plan'] }} руб.</td>
    </tr>
    </tbody>
</table>

@if($products)
    <table class="list">
        <thead>
        <tr>
            <th>#</th>
            <th>Наименование</th>
            <th>Цена во время акции, руб.</th>
            <th>Скидка, %</th>
            <th>Норма ЧП, %</th>
            <th>Продажи ДО, шт.</th>
            <th>План продаж, шт.</th>
            <th>План прироста, %</th>
            <th>Продажи ВО ВРЕМЯ, шт.</th>
            <th>Бюджет (план), руб.</th>
            <th>Бюджет (факт), руб.</th>
        </tr>
        </thead>
        @foreach($products as $product)
            <tr>
                <td class="number">1</td>
                <td class="title">{{ $product['name'] }}</td>
                <td class="value">{{ $product['promo_price'] }}</td>
                <td class="value">{{ $product['discount'] }}</td>
                <td class="value">{{ $product['net_profit'] }}</td>
                <td class="value">{{ $product['sales_before'] }}</td>
                <td class="value">{{ $product['sales_plan'] }}</td>
                <td class="value">00</td>
                <td class="value">{{ $product['sales_on_time'] }}</td>
                <td class="value">{{ $product['budget_plan'] }}</td>
                <td class="value">{{ $product['budget_actual'] }}</td>
            </tr>
        @endforeach
    </table>
@endif

@if($sellers)
    <table class="list">
        <thead>
        <tr>
            <th style="width: 3%;">#</th>
            <th>ФИО</th>
            <th style="width: 10%;">Мотивация, %</th>
            <th style="width: 10%;">Продажи ДО, шт.</th>
            <th style="width: 10%;">План продаж, шт.</th>
            <th style="width: 10%;">Продажи ВО ВРЕМЯ, шт.</th>
            <th style="width: 10%;">План прироста, %</th>
            <th style="width: 10%;">Факт прироста, %</th>
            <th style="width: 10%;">Бюджет (план), руб.</th>
            <th style="width: 10%;">Бюджет (факт), руб.</th>
        </tr>
        </thead>
        @foreach($sellers as $seller)
            @if($seller['supervisor'])
                <tr>
                    <td>1</td>
                    <td style="text-align: left;">{{ $seller['supervisor']['name'] }}</td>
                    <td>{{ $seller['supervisor']['compensation'] }}</td>
                    <td>{{ $seller['supervisor']['sales_before'] }}</td>
                    <td>{{ $seller['supervisor']['sales_plan'] }}</td>
                    <td>{{ $seller['supervisor']['sales_after'] }}</td>
                    <td>{{ $seller['supervisor']['surplus_plan'] }}</td>
                    <td>{{ $seller['supervisor']['surplus_actual'] }}</td>
                    <td>{{ $seller['supervisor']['budget_plan'] }}</td>
                    <td>{{ $seller['supervisor']['budget_actual'] }}</td>
                </tr>
            @endif
            @if($seller['sellers'])
                    @foreach($seller['sellers'] as $item)
                        <tr>
                            <td>1</td>
                            <td style="text-align: left;">{{ $item['name'] }}</td>
                            <td>{{ $item['compensation'] }}</td>
                            <td>{{ $item['sales_before'] }}</td>
                            <td>{{ $item['sales_plan'] }}</td>
                            <td>{{ $item['sales_after'] }}</td>
                            <td>{{ $item['surplus_plan'] }}</td>
                            <td>{{ $item['surplus_actual'] }}</td>
                            <td>{{ $item['budget_plan'] }}</td>
                            <td>{{ $item['budget_actual'] }}</td>
                        </tr>
                    @endforeach
            @endif
        @endforeach
    </table>
@endif

</body>
</html>
