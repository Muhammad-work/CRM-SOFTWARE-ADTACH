@extends('layout.index')
@extends('front.nav')
@section('home')
    {{-- search customer details --}}
    <div class="w- full h-[80px] flex justify-center place-items-center bg-[#1D4ED8] ">
        <input type="text" name="" onkeyup="searchTable()" id="searchInput" placeholder="Search Customer"
            class="w-[50%] py-2 px-3 outline-none border-0 rounded">
    </div>
    {{-- search customer details --}}



    {{-- Show Customer Details --}}

    <a href="{{ route('viewCustomerResponseForm') }}" class="inline-block p-2 bg-[blue] mt-2 ms-10 text-white rounded">Add
        Customer Response</a>
    <div class="w-full mx-auto mt-3 mb-5 overflow-x-auto">
        <table class="min-w-[600px] table-auto border-collapse border border-gray-200 mx-auto">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{session('success')}}
                </div>
            @endif
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 border border-gray-300">CUSTOMER NUMBER</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach ($customerNumbers as $index => $customer)
                    <tr class="odd:bg-gray-50 even:bg-white">
                        <td class="px-4 py-2 border border-gray-300 customer">{!! nl2br(e($customer->customer_number)) !!}</td>
                    </tr>
                @endforeach
                @if ($customerNumbers->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">No Calling Number Record Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    {{-- Show Customer Details --}}


    <script>
        function searchTable() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase();
            const tableBody = document.getElementById("tableBody");
            const rows = tableBody.getElementsByTagName("tr");

            for (let i = 0; i < rows.length; i++) {
                let customerName = rows[i].getElementsByTagName("td")[1].textContent.toLowerCase();
                let customerNumber = rows[i].getElementsByTagName("td")[2].textContent.toLowerCase();
                if (customerName.includes(searchInput) || customerNumber.includes(searchInput)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none"; // Hide rows that don't match
                }
            }
        }
    </script>
@endsection
