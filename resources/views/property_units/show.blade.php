<x-app-layout>
    <div class="container">
    <h2 class="text-2xl mt-10 font-bold mb-4">Property Unit</h2>
        <div class="mb-8 p-6 bg-gray-50 shadow-md rounded-lg">
            <h2 class="text-2xl font-semibold mb-4">Property Name: <span
                    class="text-blue-600">{{ $property->property_name }}</span></h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <p class="text-gray-700"><strong>District/City:</strong> {{ $property->district_city }}</p>
                <p class="text-gray-700"><strong>Address:</strong> {{ $property->address }}</p>
            </div>
        </div>
        <button data-modal-target="static-modal" data-modal-toggle="static-modal"
            class="block mb-5 float-right text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Add New
        </button>
        @if ($property->property_uinit->isEmpty())
            <p>No units found for this property.</p>
        @else
            <table id="example" class="table table-striped">
                <thead>
                    <tr>
                        <th>Unit No</th>
                        <th>Unit Name</th>
                        <th>Unit Type</th>
                        <th>Person Allowed</th>
                        <th>Additional Bed</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($property->property_uinit as $unit)
                        <tr>
                            <td>{{ $unit->unit_no }}</td>
                            <td>{{ $unit->unit_name }}</td>
                            <td>{{ $unit->unit_type }}</td>
                            <td>{{ $unit->person_allowed }}</td>
                            <td>{{ $unit->additional_bed ? 'Yes' : 'No' }}</td>
                            <td>{{ $unit->isactive ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <button data-modal-target="add-price-modal" data-modal-toggle="add-price-modal"
                                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105"
                                    onclick="setUnitForPrice('{{ $unit->unit_id }}')">
                                    <span>Add Price</span>
                                </button>

                                <!-- Add Discount Button -->
                                <button data-modal-target="add-discount-modal" data-modal-toggle="add-discount-modal"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105"
                                    onclick="setUnitForDiscount('{{ $unit->unit_id }}')">
                                    <span>Add Discount</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Modal for adding unit -->
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add New Unit
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="static-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4">
                    <form action="{{ route('property-units.store', $property_id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <input required type="number" name="property_id" value="{{ $property_id }}" readonly
                                class="hidden">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="unit_category" class="block text-sm font-medium text-gray-700">Unit
                                        Category</label>
                                    <select name="unit_category" id="unit_category"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                        <option value="room">Room</option>
                                        <option value="seat">Seat</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="unit_name" class="block text-sm font-medium text-gray-700">Unit
                                        Name</label>
                                    <select name="unit_name" id="unit_name"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                        <option value="Deluxe Suite">Deluxe Suite</option>
                                        <option value="Business Class">Business Class</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="unit_type" class="block text-sm font-medium text-gray-700">Unit
                                        Type</label>
                                    <select name="unit_type" id="unit_type"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                        <option value="Double Bed">Double Bed</option>
                                        <option value="Single Bed">Single Bed</option>
                                        <option value="Couple Cabin">Couple Cabin</option>
                                        <option value="Family Connecting Cabin"> Family Connecting Cabin</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="unit_no" class="block text-sm font-medium text-gray-700">Unit
                                        Number</label>
                                    <input type="text" required name="unit_no" id="unit_no"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="person_allowed" class="block text-sm font-medium text-gray-700">Persons
                                        Allowed</label>
                                    <input required type="number" name="person_allowed" id="person_allowed"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                </div>

                                <div>
                                    <label for="additionalbed"
                                        class="block text-sm font-medium text-gray-700">Additional Bed</label>
                                    <select name="additionalbed" id="additionalbed"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="mainimg" class="block text-sm font-medium text-gray-700">Main Image</label>
                                <input required type="file" name="mainimg" id="mainimg"
                                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    accept="image/*">
                            </div>
                            <div class="mt-4">
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" id="description" rows="4"
        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
</div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="isactive" class="block text-sm font-medium text-gray-700">Active
                                        Status</label>
                                    <select name="isactive" id="isactive"
                                        class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit"
                                class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 focus:outline-none">Save</button>
                            <button type="button"
                                class="ml-3 py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                                data-modal-hide="static-modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Price -->
    <!-- Modal for Adding Price -->
    <div id="add-price-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add Price
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="add-price-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4">
                    <form action="{{ route('price.store') }}" method="POST">
                        @csrf
                        <div class="mb-4 hidden">
                            <input type="number" name="unit_id" id="unit_no1" value="" readonly>
                        </div>

                        <!-- Price input -->
                        <div class="mb-4">
                            <label for="price"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                            <input required type="number" id="price" name="price"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                placeholder="Enter price" required>
                        </div>

                        <!-- Effective From date input -->
                        <div class="mb-4">
                            <label for="effectfrom"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Effective
                                From</label>
                            <input required type="datetime-local" id="effectfrom" name="effectfrom"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                        </div>

                        <!-- Effective Till date input -->
                        <div class="mb-4">
                            <label for="effective_till"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Effective
                                Till</label>
                            <input required type="datetime-local" id="effective_till" name="effective_till"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <button type="button" data-modal-hide="add-price-modal"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:ring-2 focus:ring-green-500">
                                Save Price
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal for Adding Discount -->
    <div id="add-discount-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add Discount
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="add-discount-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4">
                    <form action="{{ route('discount.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="unit_id" id="unit_id_discount">

                        <!-- Discount Percentage or Amount -->
                        <div class="mb-4">
                            <label for="discount_percent"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount Percentage
                                (%)</label>
                            <input required type="number" id="discount_percent" name="discount_percent"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                placeholder="Enter discount percentage" step="0.01">
                        </div>

                        <div class="mb-4">
                            <label for="discount_amount"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Discount
                                Amount</label>
                            <input required type="number" id="discount_amount" name="discount_amount"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                placeholder="Enter discount amount">
                        </div>

                        <!-- Effective From Date -->
                        <div class="mb-4">
                            <label for="effectfrom"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Effective
                                From</label>
                            <input required type="datetime-local" id="effectfrom" name="effectfrom"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                                required>
                        </div>

                        <!-- Effective Till Date -->
                        <div class="mb-4">
                            <label for="effective_till"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300">Effective
                                Till</label>
                            <input required type="datetime-local" id="effective_till" name="effective_till"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <button type="button" data-modal-hide="add-discount-modal"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 dark:bg-gray-600 dark:text-white dark:hover:bg-gray-500">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                Save Discount
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Function to set unit_no for the Add Price Modal
        function setUnitForPrice(unitNo) {
            // Set the unit_no field for the price modal
            document.getElementById('unit_no1').value = unitNo;

            // Show the Add Price Modal
            const priceModal = document.getElementById('add-price-modal');
            priceModal.classList.remove('hidden');
        }

        // Function to set unit_id for the Add Discount Modal
        function setUnitForDiscount(unitNo) {
            // Set the unit_id field for the discount modal
            document.getElementById('unit_id_discount').value = unitNo;

            // Show the Add Discount Modal
            const discountModal = document.getElementById('add-discount-modal');
            discountModal.classList.remove('hidden');
        }
    </script>

</x-app-layout>
