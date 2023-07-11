<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Hotel Rooms</title>

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
                    <th width="4%">No</th>
                    <th width="5%">Room Number</th>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Service</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hotelRooms as $key => $hotelRoom)
                <tr>
                    <th scope="row" class="text-center">{{ $key + 1 }}</th>
                    <td class="text-center">{{ $hotelRoom->room_number }}</td>
                    <td>{{ $hotelRoom->name }}</td>
                    <td>{{ $hotelRoom->password }}</td>
                    <td>{{ $hotelRoom->service->service_name }}</td>
                    <td>{{ ucwords($hotelRoom->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
