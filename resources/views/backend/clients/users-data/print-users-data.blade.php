<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Users Data</title>

    <style>
        .container {
            width: 100%;
            margin: auto;
            margin-top: 10vh;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            color: #212529;
        }

        th,
        td {
            vertical-align: top;
            border: 0.5px solid #a4a4a4;
            padding: .75rem;
        }

        th.text-center,
        td.text-center {
            text-align: center;
        }

        th[width="4%"] {
            width: 4%;
        }
    </style>
</head>

<body>
    <div class="container">
        <table>
            <thead>
                <tr class="text-center">
                    <th scope="col" width="4%">No.</th>
                    <th scope="col">Guest Name</th>
                    <th scope="col">Email Address</th>
                    <th scope="col">Room Number</th>
                    <th scope="col">Input Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $user)
                <tr>
                    <th scope="row" class="text-center">{{ $key + 1 }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->room_number }}</td>
                    <td>{{ date('Y F d H:i:s', strtotime($user->date)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
