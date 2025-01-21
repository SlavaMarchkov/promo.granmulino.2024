<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 0.7em;
            padding: 0;
            margin: 0;
        }
        p {
            margin: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table tr td {
            border: 1px solid #444;
            padding: 5px 10px;
            text-align: left;
        }
        table tr th.text-center,
        table tr td.text-center {
            text-align: center;
        }
        table tr th {
            text-align: left;
            border: 1px solid #444;
            padding: 5px 10px;
            background-color: #eeeeee;
        }
        .badge {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
        .warning {
            background-color: #ffc107;
        }
        .danger {
            background-color: #dc3545;
        }
        .success {
            background-color: #198754;
        }
        .secondary {
            background-color: #6c757d;
        }

        table {
            width: 95%;
            border-collapse: collapse;
            margin: 50px auto;
        }

        /* Zebra striping */
        tr:nth-of-type(odd) {
            background: #eee;
        }

        th {
            background: #3498db;
            color: white;
            font-weight: bold;
        }

        td,
        th {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 18px;
        }


    </style>

</head>

<body>

<div style="width: 95%; margin: 0 auto;">
    <div style="width: 10%; float:left; margin-right: 20px;">
        <img src="{{ public_path('assets/images/logo.png') }}" width="100%"  alt="">
    </div>
    <div style="width: 50%; float: left;">
        <h1>All User Details</h1>
    </div>
</div>

<table style="position: relative; top: 50px;">
    <thead>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Date Of Joining</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td data-column="First Name">{{ $user->first_name }}</td>
            <td data-column="Last Name">{{ $user->last_name }}</td>
            <td data-column="Email" style="color: dodgerblue;">
                {{ $user->email }}
            </td>
            <td data-column="Date">
                {{ date('F j, Y', strtotime($user->create_at)) }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>

</html>
