@extends('layout.index')
@extends('front.nav')

@section('home')
    {{-- Search customer details --}}
    <div class="w-full h-[80px] flex justify-center items-center bg-[#1D4ED8]">
        <input type="text" name="" onkeyup="searchTable()" id="searchInput" placeholder="Search Customer"
            class="w-[50%] py-2 px-3 outline-none border-0 rounded">
    </div>
    {{-- Search customer details --}}

    
    <div class="w-full mx-auto mt-3 mb-5 overflow-x-auto">
        <table class="w-full table-auto border-collapse border border-gray-200 mx-auto">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 border border-gray-300">CUSTOMER NAME</th>
                    <th class="px-4 py-2 border border-gray-300">PHONE NUMBER</th>
                    <th class="px-4 py-2 border border-gray-300">STATUS</th>
                    <th class="px-4 py-2 border border-gray-300">REMARKS</th>
                    <th class="px-4 py-2 border border-gray-300">AGENT NAME</th>
                    <th class="px-4 py-2 border border-gray-300">DATE</th>
                    <th class="px-4 py-2 border border-gray-300">ACTION</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @foreach ($customerNumbers as $customer)
                    <form action="{{ route('storeCustomerNumbersDetails', $customer->id) }}" method="POST">
                        @csrf
                        <tr class="odd:bg-gray-50 even:bg-white">
                            <td class="px-4 py-2 border border-gray-300">
                                @if ($customer->status === 'pending')
                                    <input type="text" class="form-control" placeholder="Enter Customer Name"
                                        aria-label="Username" name="customer_name" aria-describedby="basic-addon1">
                                    @error('customer_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @else
                                    {{ $customer->customer_name }}
                                @endif
                            </td>
                            <td class="px-4 py-2 border border-gray-300 "><span
                                    class="number">{{ $customer->customer_number }}</span> <span
                                    class="px-2 py-1 bg-[blue] text-white rounded cursor-pointer copy"><i
                                        class="fa-regular fa-copy"></i></span></td>
                            <td class="px-4 py-2 border border-gray-300 ">
                                @if ($customer->status === 'pending')
                                    <select class="form-select" name="status" aria-label="Default select example">
                                        <option selected>-- Select Status --</option>
                                        <option value="vm">vm</option>
                                        <option value="not int">Not Interested</option>
                                        <option value="hung up">Hung Up</option>
                                        <option value="not ava">Not Available</option>
                                        <option value="not in service">Not In Service</option>
                                        <option value="trial">ON Trial</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @else
                                    @if ($customer->status === 'pending')
                                        <span class="px-2 py-1 bg-warning rounded text-white ">Pendding</span>
                                    @elseif($customer->status === 'not int')
                                        <span class="px-2 py-1 bg-danger rounded text-white">Not Intersted</span>
                                    @elseif($customer->status === 'vm')
                                        <span class="px-2 py-1 bg-dark  rounded text-white">VM</span>
                                    @elseif($customer->status === 'hung up')
                                        <span class="px-2 py-1 bg-primary rounded text-white">Hung Up</span>
                                    @elseif($customer->status === 'not ava')
                                        <span class="px-2 py-1 bg-secondary rounded text-white">Not Available</span>
                                    @elseif($customer->status === 'not in service')
                                        <span class="px-2 py-1 bg-info rounded text-white">Not In Service</span>
                                    @else
                                        <span class="px-2 py-1 bg-success rounded text-white">ON Trial</span>
                                    @endif
                                @endif
                            </td>

                            @if ($customer->remarks === null)
                                <td class="px-2 py-2 border border-gray-300">
                                    <textarea name="remarks" id="remarks_1" cols="15" rows="1" placeholder="Enter Remarks"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <span class="text-danger"> {{ $message }} </span>
                                    @enderror
                                </td>
                            @else
                                <td class="px-2 py-2 border border-gray-300 w-[10px]">
                                    <span class="w-[10px]"> {{ $customer->remarks }}</span>
                                </td>
                            @endif

                            <td class="px-4 py-2 border border-gray-300">{{ $customer['user']->name }}</td>
                            <td class="px-4 py-2 border border-gray-300">
                                {{ \Carbon\Carbon::parse($customer->date)->format('d M, Y') }}</td>
                            <td class="px-4 py-2 border border-gray-300">
                                @if ($customer->customer_name === 'pending')
                                    <button class="px-3 py-2 bg-[blue] text-white rounded"><i
                                            class="fa-solid fa-plus"></i></button>
                                @endif
                                @if ($customer->customer_name !== 'pending')
                                   <a href="{{ route('viewCustomerNumberEditForm',$customer->id) }}" class="px-3 py-2 bg-[blue] text-white rounded"><i
                                      class="fa-solid fa-pen-to-square"></i></a>   
                                @endif
                            </td>
                        </tr>
                    </form>
                @endforeach
                @if ($customerNumbers->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">No Calling Number Record Found</td>
                    </tr>
                @endif
            </tbody>
        </table>
        {{-- <form action="" method="POST">
            <input type="c_name" name="" id="name">
            <input type="status" name="" id="status">
            <input type="remarks" name="" id="remarks">
        </form> --}}
    </div>
    {{-- Show Customer Details --}}

    <script>
        function searchTable() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase(); // Get input text
            const tableBody = document.getElementById("tableBody"); // Get the table body
            const rows = tableBody.getElementsByTagName("tr"); // Get all rows in the table body

            for (let i = 0; i < rows.length; i++) {
                const customerNameCell = rows[i].getElementsByTagName("td")[0]; // Get the customer name (1st column)
                const customerNumberCell = rows[i].getElementsByTagName("td")[1]; // Get the customer number (2nd column)
                if (customerNameCell && customerNumberCell) {
                    const customerName = customerNameCell.textContent.toLowerCase(); // Get customer name text
                    const customerNumber = customerNumberCell.textContent.toLowerCase(); // Get customer number text

                    // Check if either the customer name or number contains the search input
                    if (customerName.includes(searchInput) || customerNumber.includes(searchInput)) {
                        rows[i].style.display = ""; // Show row if there's a match
                    } else {
                        rows[i].style.display = "none"; // Hide row if there's no match
                    }
                }
            }
        }

        let copyNumbers = document.querySelectorAll('.copy');
        let clientNumbers = document.querySelectorAll('.number');

        copyNumbers.forEach((copyNumber, index) => {
            copyNumber.addEventListener('click', () => {
                let range = document.createRange();
                range.selectNode(clientNumbers[index]);
                window.getSelection().removeAllRanges();
                window.getSelection().addRange(range);

                document.execCommand('copy');

                document.addEventListener('copy', (event) => {
                    let copiedText = event.clipboardData.getData('text');
                    console.log(copiedText);
                });
            });
        });
    </script>
@endsection