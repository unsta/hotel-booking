<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Booking</title>
    <style>
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    </style>
</head>
<body class="bg-gray-100 p-4">
<div class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
    <h2 class="text-2xl font-semibold mb-4">New Booking for Room {{ $roomNumber }}</h2>

    <br />

    <table class="table-auto">
        <tbody>
            <tr>
                <td>Booking #</td>
                <td>{{ $bookingId }}</td>
            </tr>
            <tr>
                <td>Room</td>
                <td>{{ $roomNumber }}</td>
            </tr>
            <tr>
                <td>Check In</td>
                <td>{{ $checkInDate }}</td>
            </tr>
            <tr>
                <td>Check Out</td>
                <td>{{ $checkOutDate }}</td>
            </tr>
            <tr>
                <td>Total Price</td>
                <td>{{ $totalPrice }}</td>
            </tr>
            <tr>
                <td>Customer Name</td>
                <td>{{ $customerName }}</td>
            </tr>
            <tr>
                <td>Customer Email</td>
                <td>{{ $customerEmail }}</td>
            </tr>
            <tr>
                <td>Customer Phone</td>
                <td>{{ $customerPhoneNumber }}</td>
            </tr>
        </tbody>
    </table>
</div>
</body>
</html>
