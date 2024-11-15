@extends('layout.index')
@extends('front.nav')

@section('home')
    {{--  Cuntomer Form   --}}
    <div class="w-[95%] h-auto mx-auto mt-5 p-3 border-2 border-solid rounded">
        <form action="" method="POST">
             <h2 class="text-center font-bold text-xl mb-2">Enter Customer Details</h2>
            @csrf
            <table class="min-w-full table-auto border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="px-4 py-2 border border-gray-300">CUSTOMER NAME</th>
                        <th class="px-4 py-2 border border-gray-300">CUSTOMER NUMBER</th>
                        <th class="px-4 py-2 border border-gray-300">CUSTOMER EMAIL</th>
                        <th class="px-4 py-2 border border-gray-300">PRICE</th>
                        <th class="px-4 py-2 border border-gray-300">REMARKS</th>
                        <th class="px-4 py-2 border border-gray-300">STATUS</th>
                        <th class="px-4 py-2 border border-gray-300">AGENT NAME</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odd:bg-gray-50 even:bg-white">
                        <td class="px-4 py-2 border border-gray-300">
                            <input type="text" name="customer_name[]" id="customer_name_1"
                                placeholder="Enter Customer Name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            <input type="text" name="customer_number[]" id="customer_number_1"
                                placeholder="Enter Customer Number"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            <input type="email" name="customer_email[]" id="customer_email_1"
                                placeholder="Enter Customer Email"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            <input type="text" name="price[]" id="price_1" placeholder="Enter Price"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            <textarea name="remarks[]" id="remarks_1" cols="15" rows="3" placeholder="Enter Remarks"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            <select name="status[]" id="status_1"
                                class="w-full  py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="" selected>Select</option>
                                <option value="sale">Sale</option>
                                <option value="lead">Lead</option>
                                <option value="trial">Trial</option>
                            </select>
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                            <input type="text" name="agent_name[]" id="agent_name_1" placeholder="Enter Agent Name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4 flex justify-end ">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">Submit</button>
            </div>
        </form>

    </div>
    {{--  Cuntomer Form   --}}


    {{-- search customer details --}}
       <div class="w- full h-[80px] flex justify-center place-items-center bg-[#25C3C6] mt-5">
           <input type="text" name="" onkeyup="searchTable()" id="searchInput" placeholder="Search Customer" class="w-[50%] py-2 px-3 outline-none border-0 rounded" >
       </div>
    {{-- search customer details --}}


    {{-- Show Customer Details --}}
       
     <div class="w-[90%] mx-auto mt-5 mb-5">
        <table class="min-w-full table-auto border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-700" >
                    <th class="px-4 py-2 border border-gray-300">S.NO</th>
                    <th class="px-4 py-2 border border-gray-300">CUSTOMER NAME</th>
                    <th class="px-4 py-2 border border-gray-300">CUSTOMER NUMBER</th>
                    <th class="px-4 py-2 border border-gray-300">CUSTOMER EMAIL</th>
                    <th class="px-4 py-2 border border-gray-300">PRICE</th>
                    <th class="px-4 py-2 border border-gray-300">REMARKS</th>
                    <th class="px-4 py-2 border border-gray-300">STATUS</th>
                    <th class="px-4 py-2 border border-gray-300">AGENT NAME</th>
                    <th class="px-4 py-2 border border-gray-300">DATE</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                 <tr class="odd:bg-gray-50 even:bg-white" >
                    <td class="px-4 py-2 border border-gray-300 customer"> 1 </td>
                    <td class="px-4 py-2 border border-gray-300 customer">Mansoor</td>
                    <td class="px-4 py-2 border border-gray-300 customer">123456789</td>
                    <td class="px-4 py-2 border border-gray-300 customer">mansoor@gmail.com</td>
                    <td class="px-4 py-2 border border-gray-300 customer">$333</td>
                    <td class="px-4 py-2 border border-gray-300 customer">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, tenetur?</td>
                    <td class="px-4 py-2 border border-gray-300 customer">sale</td>
                    <td class="px-4 py-2 border border-gray-300 customer">Muhammad</td>
                    <td class="px-4 py-2 border border-gray-300 customer">11-14-2024</td>
                </tr>
                 <tr class="odd:bg-gray-50 even:bg-white" >
                    <td class="px-4 py-2 border border-gray-300 customer"> 2 </td>
                    <td class="px-4 py-2 border border-gray-300 customer">Muhammad</td>
                    <td class="px-4 py-2 border border-gray-300 customer">03333181688</td>
                    <td class="px-4 py-2 border border-gray-300 customer">mansoor@gmail.com</td>
                    <td class="px-4 py-2 border border-gray-300 customer">$333</td>
                    <td class="px-4 py-2 border border-gray-300 customer">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione, tenetur?</td>
                    <td class="px-4 py-2 border border-gray-300 customer">sale</td>
                    <td class="px-4 py-2 border border-gray-300 customer">Muhammad</td>
                    <td class="px-4 py-2 border border-gray-300 customer">11-14-2024</td>
                </tr>
            </tbody>
        </table>
     </div>
    
    {{-- Show Customer Details --}}


    <script>
        function searchTable() {
            const searchInput = document.getElementById("searchInput").value.toLowerCase();
            const tableBody = document.getElementById("tableBody");
            console.log(tableBody);
            const rows = tableBody.getElementsByTagName("tr");
            console.log(rows);

            for (let i = 0; i < rows.length; i++) {
                let customerName = rows[i].getElementsByTagName("td")[1].textContent.toLowerCase();
                let customerNumber = rows[i].getElementsByTagName("td")[2].textContent.toLowerCase();
                console.log(customerNumber);
                if (customerName.includes(searchInput) || customerNumber.includes(searchInput)) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";  // Hide rows that don't match
                }
            }
        }
    </script>


@endsection
