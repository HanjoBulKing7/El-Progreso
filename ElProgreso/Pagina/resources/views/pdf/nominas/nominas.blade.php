<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nómina</title>

    <style>
        p {
            margin: 0;
        }

        @font-face {
            font-family: SourceSansPro
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both
        }

        a {
            color: darkgreen;
            text-decoration: none
        }

        body {
            color: #555;
            background: #fff;
            font-size: 14px;
            font-family: SourceSansPro
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #aaa
        }

        #logo {
            float: left;
            margin-top: 8px
        }

        #logo img {
            height: 70px
        }

        #company {
            text-align: right
        }

        #details {
            margin-bottom: 50px
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid darkgreen;
            float: left
        }

        #client .to {
            color: #777
        }

        h2.name {
            font-size: 1.4em;
            font-weight: 400;
            margin: 0
        }

        h3.rfc {
            font-size: 1.1em;
            font-weight: 400;
            margin: 0
        }

        #invoice {
            text-align: right
        }

        #invoice h1 {
            color: darkgreen;
            font-size: 1.5em;
            line-height: 1em;
            font-weight: 400;
            margin: 0 0 10px 0
        }

        #invoice .date {
            font-size: 1em;
            color: #777
        }

        table#fiscal td,
        table#fiscal th,
        table#payment td,
        table#payment th {
            text-align: center;
        }

        table#items {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px
        }

        table#items td,
        table#items th {
            padding: 5px;
            background: #eee;
            text-align: center;
            border-bottom: 1px solid #fff
        }

        table#items th {
            white-space: nowrap;
            font-weight: 400
        }

        table#items td {
            text-align: right
        }

        table#items td h3 {
            color: darkgreen;
            font-size: 1.2em;
            font-weight: 400;
            margin: 0 0 .2em 0
        }

        table#items .unit {
            font-size: 1.0em;
            background: #ddd
        }

        table#items .desc {
            text-align: left
        }

        table#items .price {
            background: #ddd
        }

        table#items .total {
            background: darkgreen;
            color: #fff
        }

        table#items td.unit,
        table#items td.price,
        table#items td.desc,
        table#items td.qty,
        table#items td.total {
            font-size: 1.0em;
        }

        table#items tbody tr:last-child td {
            border: none
        }

        table#items tfoot td {
            padding: 10px 20px;
            background: #fff;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #aaa
        }

        table#items tfoot tr:first-child td {
            border-top: none
        }

        table#items tfoot tr:last-child td {
            color: darkgreen;
            font-size: 1.4em;
            border-top: 1px solid darkgreen;
        }

        table#items tfoot tr td:first-child {
            border: none
        }

        #qr {
            width: 160px;
            height: 160px;
            float: left;
            margin: 10px;
        }

        #qr img {
            width: 100%;
            height: 100%
        }

        table#identifiers {
            margin-top: 90px;
        }

        table#identifiers .title {
            padding: 5px 0
        }

        table#identifiers .string {
            font-size: 11px
        }

        .bold {
            font-weight: 700
        }

        footer {
            color: #777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #aaa;
            padding: 8px 0;
            text-align: center
        }

        thead {
            display: table-header-group
        }

        tfoot {
            display: table-row-group
        }

        tr {
            page-break-inside: avoid
        }

        #qrTables {
            page-break-inside: avoid
        }

        table#legend {
            margin-top: 90px;
        }

        table#legend .title {
            padding: 5px 0
        }

        table#legend .string {
            font-size: 11px
        }

        /* DivTable.com */
        .divTable {
            display: table;
            width: 100%;
        }

        .divTableRow {
            display: table-row;
        }

        .divTableHeading {
            background-color: #EEE;
            display: table-header-group;
        }

        .divTableCell, .divTableHead {
            display: table-cell;
            padding: 3px 10px;
        }

        .divTableHeading {
            background-color: #EEE;
            display: table-header-group;
            font-weight: bold;
        }

        .divTableFoot {
            background-color: #EEE;
            display: table-footer-group;
            font-weight: bold;
        }

        .divTableBody {
            display: table-row-group;
        }
    </style>
</head>
<body>

<header class="clearfix">
    <div id="logo">

        <img src="{{asset('img/cookie.png')}}">
    </div>
    <div id="company">
        <div>
            <b>Periodo: </b><a>{{'De '.\Carbon\Carbon::parse($data['nomina']['comienza_en'])->format('Y-m-d'). ' al '. \Carbon\Carbon::parse($data['nomina']['termina_en'])->format('Y-m-d')}}</a>
        </div>
        <div>Nómina</div>
    </div>
</header>
<main>
    <div id="details" class="clearfix">
        <div id="client">
            <div class="to">Receptor de nómina:</div>
            <h2 class="name">{{ $data['user_data']['user_name'] }}</h2>
            <div class="phone">{{ $data['user_data']['user_phone'] }}</div>
            <div class="email"><a>{{ $data['user_data']['user_email'] }}</a></div>
        </div>
        <div id="invoice">
            <h1>Nómina: {{ $data['nomina']['id'] }}</h1>
            <div class="date">Fecha y hora de emisión: {{\Carbon\Carbon::now()->format('Y-m-d H:i:s')}}</div>
        </div>
    </div>

    <div class="divTable">
        <div class="divTableBody">
            <div class="divTableRow">
                <div class="divTableCell">
                    <h2>Percepciónes</h2>
                    <table id="items" border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                        <thead>
                        <tr>
                            <th width="10%" class="total">Concepto</th>
                            <th width="10%" class="total">Cantidad</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td class="qty">Sueldo base</td>
                            <td class="qty">${{number_format($data['activos']['sueldo_base'], 2)}}</td>
                        </tr>
                        <tr>
                            <td class="qty">Ayuda de transporte</td>
                            <td class="qty">${{number_format($data['activos']['ayuda_transporte'], 2)}}</td>
                        </tr>
                        <tr>
                            <td class="qty">Ayuada de despensa</td>
                            <td class="qty">${{number_format($data['activos']['ayuda_despensa'], 2)}}</td>
                        </tr>
                        <tr>
                            <td class="qty">Comisión</td>
                            <td class="qty">${{number_format($data['activos']['comision'], 2)}}</td>
                        </tr>
                        <tr>
                            <td class="qty">Bono Servicio cliente</td>
                            <td class="qty">${{number_format($data['activos']['bono_servicio_cliente'], 2)}}</td>
                        </tr>
                        <tr>
                            <td class="qty">Bono personal</td>
                            <td class="qty">${{number_format($data['activos']['bono_personal'], 2)}}</td>
                        </tr>
                        <tr>
                            <td class="qty">Bono devolución</td>
                            <td class="qty">${{number_format($data['activos']['bono_devolucion'], 2)}}</td>
                        </tr>
                        <tr>
                            <td class="qty">Bono mensual</td>
                            <td class="qty">${{number_format($data['activos']['bono_mensual'], 2)}}</td>
                        </tr>
                        <tr>
                            <td class="unit">TOTAL PERCEPCIONES</td>
                            <td class="unit">${{number_format($data['nomina']['total_activos'], 2)}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="divTableCell">
                    <h2>Deducciónes</h2>
                    <table id="items" border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                        <thead>
                        <tr>
                            <th width="10%" class="total">Unidad</th>
                            <th width="10%" class="total">Importe</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td class="qty">Infonavit</td>
                            <td class="qty">${{ number_format($data['pasivos']['infonavit'], 2) }}</td>
                        </tr>
                        <tr>
                            <td class="qty">Préstamo</td>
                            <td class="qty">${{ number_format($data['pasivos']['prestamo'], 2 )}}</td>
                        </tr>
                        <tr>
                            <td class="qty">Faltante</td>
                            <td class="qty">${{ number_format($data['pasivos']['faltante'], 2) }}</td>
                        </tr>
                        <tr>
                            <td class="qty">Devolución</td>
                            <td class="qty">${{ number_format($data['pasivos']['devolucion'], 2) }}</td>
                        </tr>
                        <tr>
                            <td class="qty">Descuento por falta</td>
                            <td class="qty">${{ number_format($data['pasivos']['descuento_por_falta'], 2) }}</td>
                        </tr>
                        <tr>
                            <td class="qty">Descuento extra</td>
                            <td class="qty">${{ number_format($data['pasivos']['descuento_extra'], 2) }}</td>
                        </tr>
                        <tr>
                            <td class="unit">TOTAL DEDUCCIONES</td>
                            <td class="unit">${{number_format($data['nomina']['total_pasivos'], 2)}}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <table id="items" border="0" cellspacing="0" cellpadding="0">
        <tfoot>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="font-size: 0.9em">PERCEPCIONES</td>
            <td style="font-size: 0.9em">${{number_format($data['nomina']['total_activos'], 2)}}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="font-size: 0.9em">DEDUCCIONES</td>
            <td style="font-size: 0.9em">${{number_format($data['nomina']['total_pasivos'], 2)}}</td>
        </tr>
        <tr>
            <td colspan="2"
                style="text-transform: uppercase; font-size: 0.8em">{{(new \NumberToWords\NumberToWords)->getNumberTransformer('es')->toWords($data['nomina']['total']) }}</td>
            <td colspan="2" style="font-size: 0.9em">TOTAL</td>
            <td style="font-size: 0.9em">${{number_format($data['nomina']['total'], 2)}}</td>
        </tr>
        </tfoot>
    </table>

    <div style="padding-top: 200px; color: #000">
        <div style="text-align: center">
            ___________________________
            <br>
            <b>{{$data['user_data']['user_name']}}</b>
        </div>
    </div>


</main>


</body>
</html>
