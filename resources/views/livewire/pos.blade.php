<div class="py-12 " x-data="orderApp({{ $product->toJson() }})">
    <body class="flex items-center justify-center h-screen overflow-hidden" style="background: #edf2f7;">
        <div class="container px-0 mx-auto bg-white">
            <div class="flex flex-col-reverse shadow-lg lg:flex-row">
                <!-- Left Section -->
                <div class="w-full min-h-screen shadow-lg lg:w-[57%]">
                {{-- <div class="w-full min-h-screen shadow-lg lg:w-[57%]"> --}}

                    <h1>Product</h1>

                    <div class="grid grid-cols-3 gap-3 px-5 mt-5 overflow-y-auto h-3/4">
                        <!-- Products List -->

                        <template x-for="product in products" :key="product.id">
                            <button
                                class="flex flex-col items-center justify-center h-32 px-3 py-3 text-center transition-shadow border border-gray-200 rounded-md hover:shadow-lg "
                                @click="addToOrder(product)">
                                <div class="mb-2">
                                    <span class="block font-bold text-gray-800" x-text="product.name"></span>
                                    <span class="block font-medium text-blue-500" x-text="product.description"></span>
                                </div>
                                <div>
                                    <span class="text-lg font-bold text-red-500" x-text="`${product.price} DA`"></span>
                                </div>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="w-full lg:w-2/5">
                    <div class="flex flex-row items-center justify-between px-5 mt-5">
                        <div class="text-xl font-bold">Current Order</div>
                        <div class="font-semibold">
                            <button
                            class="px-4 py-2 text-red-500 bg-red-200 rounded-md hover:bg-red-600 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300"
                            @click="clearOrder; $event.target.blur()">
                            Clear All
                        </button>

                        </div>
                    </div>

                    <div class="h-64 pt-4 overflow-y-scroll no-scrollbar">
                        <!-- Order Items List -->
                        <template x-for="(item, index) in orderItems" :key="item.id">
                            <div class="flex items-center justify-between ">
                                <!-- Item Name and Description -->
                                <div class="flex flex-col items-center w-1/2">
                                    <span class="ml-2 font-semibold " x-text="item.name"></span>
                                    <span class="ml-2 font-semibold text-blue-500 " x-text="item.description"></span>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center justify-between w-32">
                                    <button
                                        class="px-3 py-1 bg-gray-300 rounded-md"
                                        @click="updateQuantity(index, -1)">
                                        -
                                    </button>
                                    <span class="px-2 text-sm font-semibold" x-text="item.quantity"></span>
                                    <button
                                        class="px-3 py-1 bg-gray-300 rounded-md"
                                        @click="updateQuantity(index, 1)">
                                        +
                                    </button>
                                </div>

                                <!-- Price -->
                                <div class="w-20 font-semibold text-right">
                                    <span x-text="`${(item.price * item.quantity).toFixed(2)}`"></span>
                                </div>
                            </div>
                        </template>
                    </div>



                    <div class="relative px-4 py-8">
                        <!-- Buttons for adding fixed amounts -->
                        <div class="flex justify-center mb-4 space-x-4">
                            <button
                                class="px-4 py-2 font-semibold text-white bg-green-500 rounded-md hover:bg-green-600"
                                @click="addExtraCharge(2000)">
                                +2000 DA
                            </button>
                            <button
                                class="px-4 py-2 font-semibold text-white bg-green-500 rounded-md hover:bg-green-600"
                                @click="addExtraCharge(1000)">
                                +1000 DA
                            </button>
                            <button
                                class="px-4 py-2 font-semibold text-white bg-green-500 rounded-md hover:bg-green-600"
                                @click="addExtraCharge(500)">
                                +500 DA
                            </button>
                        </div>

                        <!-- Buttons for subtracting fixed amounts -->
                        <div class="flex justify-center mb-4 space-x-4">
                            <button
                                class="px-4 py-2 font-semibold text-white bg-red-500 rounded-md hover:bg-red-600"
                                @click="subtractExtraCharge(2000)">
                                -2000 DA
                            </button>
                            <button
                                class="px-4 py-2 font-semibold text-white bg-red-500 rounded-md hover:bg-red-600"
                                @click="subtractExtraCharge(1000)">
                                -1000 DA
                            </button>
                            <button
                                class="px-4 py-2 font-semibold text-white bg-red-500 rounded-md hover:bg-red-600"
                                @click="subtractExtraCharge(500)">
                                -500 DA
                            </button>
                        </div>

                        <!-- Total Price and Validation Button -->
                        <div class="mt-5 rounded-md shadow-lg">
                            <div class="flex items-center justify-between px-4 py-2">
                                <span class="text-xl font-semibold">Total:</span>
                                <span class="text-xl font-bold" x-text="(totalPrice() + extraCharge).toFixed(2) + ' DA'"></span>
                                <button
                                    class="px-8 py-4 font-semibold text-center text-white bg-blue-600 rounded-md shadow-lg"
                                    @click="validateOrder">
                                    Validate
                                </button>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </body>
</div>

<script>
function orderApp(products) {
    return {
        products: products, // Dynamic data passed from Laravel
        orderItems: [],
        extraCharge: 0, // Additional amount to add/subtract from the total price

        // Add product to order
        addToOrder(product) {
            const existingItem = this.orderItems.find(item => item.id === product.id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                this.orderItems.push({
                    ...product,
                    quantity: 1
                });
            }
        },

        // Update quantity of an item in the order
        updateQuantity(index, change) {
            if (this.orderItems[index].quantity + change <= 0) {
                // Remove the item if the quantity becomes 0
                this.orderItems.splice(index, 1);
            } else {
                this.orderItems[index].quantity += change;
            }
        },

        // Clear the order
        clearOrder() {
            this.orderItems = [];
            this.extraCharge = 0; // Reset extra charge when clearing the order
        },

        // Add extra charge
        addExtraCharge(amount) {
            this.extraCharge += amount;
        },

        // Subtract extra charge
        subtractExtraCharge(amount) {
            this.extraCharge -= amount;
        },

        // Calculate the total price (ensure it doesn't drop below 0)
        displayedTotal() {
            return Math.max(0, this.totalPrice() + this.extraCharge);
        },

        // Calculate the base total price
        totalPrice() {
            return this.orderItems.reduce((total, item) => total + item.price * item.quantity, 0);
        },

        // Handle order validation
        validateOrder() {
            alert('Order validated! Total: ' + this.displayedTotal().toFixed(2) + ' DA');
        }
    }
}





</script>
