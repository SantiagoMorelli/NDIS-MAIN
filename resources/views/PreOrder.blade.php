@extends('admin.layouts.app')
@section('content')
    <form method="post" action="{{ url('/CreateInvoice') }}">
        @csrf
        <div class="bg-white shadow-sm rounded p-4 mb-4">
            <h2 class="text-lg fw-medium mb-4">Pre-Order Details</h2>
            <div class="row row-cols-1 row-cols-md-2 gap-4">
                <div class="col">
                    <label for="document_type">Document Type:</label>
                    <select name="document_type" id="document_type">
                        <option value="INVOICE">Invoice</option>
                        <option value="QUOTATION">Quote</option>
                    </select>
                </div>
                <div class="col">
                </div>
                <div class="col">

                    <label for="date" class="form-label text-gray-700 mb-2">Date:</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
                <div class="col">
                    <label for="invoiceNro" class="form-label text-gray-700 mb-2">Invoice No:</label>
                    <input type="text" name="invoiceNro" id="invoiceNro" class="form-control" required>
                </div>
                <div class="col">
                    <label for="Attn" class="form-label text-gray-700 mb-2">Attn:</label>
                    <input type="text" name="Attn" id="Attn" class="form-control" required>
                </div>
                <div class="col">
                    <label for="AttnEmail" class="form-label text-gray-700 mb-2">Attn Email:</label>
                    <input type="text" name="AttnEmail" id="AttnEmail" class="form-control" required>
                </div>
                <div class="col">
                    <label for="ShippingAndHandling" class="form-label text-gray-700 mb-2">Shipping And Handling:</label>
                    <input type="text" name="ShippingAndHandling" id="ShippingAndHandling" class="form-control" required>
                </div>
                <div class="col">
                    <label for="Gst" class="form-label text-gray-700 mb-2">10% GST on Shipping:</label>
                    <input type="text" name="Gst" id="Gst" class="form-control" required>
                </div>
            </div>
        </div>



        <div class="bg-white shadow-sm rounded-md p-4 mb-4">
            <h2 class="h5 mb-4">Customer Details</h2>
            <div class="row gx-4">
                <div class="col-12 col-md-6 mb-4">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="ndis" class="form-label">NDIS No:</label>
                    <input type="text" name="ndis" id="ndis" class="form-control" required>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="dob" class="form-label">DoB No:</label>
                    <input type="date" name="dob" id="dob" class="form-control" required>
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="streetname" class="form-label">Street name:</label>
                    <input type="text" name="streetname" id="streetname" class="form-control" required="">
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="suburb" class="form-label">Suburb:</label>
                    <input type="text" name="suburb" id="suburb" class="form-control" required="">
                </div>
                <div class="col-12 col-md-6 mb-4">
                    <label for="postcode" class="form-label">Postcode:</label>
                    <input type="text" name="postcode" id="postcode" class="form-control" required="">
                </div>

                <div class="col-12 col-md-6 mb-4">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                </div>
            </div>
        </div>


        <div class="container mt-5">
            <div class="bg-white shadow rounded p-4">

                <button type="button" class="btn btn-success mb-3" onclick="addProducts()">
                    Add product
                </button>

                <div id="products" class="row row-cols-1 row-cols-md-2 g-4">
                    <div id="product1" class="col">
                        <fieldset>
                            <legend>Product 1</legend>
                            <div class="mb-3">
                                <label for="product_name1" class="form-label">Product Name:</label>
                                <input type="text" name="product_name1" class="form-control" required
                                    id="product_name1">
                            </div>
                            <div class="mb-3">
                                <label for="product_quantity1" class="form-label">Product Quantity:</label>
                                <input type="number" name="product_quantity1" class="form-control" required
                                    id="product_quantity1">
                            </div>
                            <div class="mb-3">
                                <label for="product_price1" class="form-label">Product Price:</label>
                                <input type="text" name="product_price1" class="form-control" required
                                    id="product_price1">
                            </div>
                        </fieldset>
                    </div>

                    <!-- Agrega más campos de producto si es necesario -->
                </div>
            </div>
        </div>






        <div class="bg-white shadow-md rounded-md p-6 mb-6 mt-5">
            <h2 class="text-lg font-medium mb-4">PAYMENT METHOD</h2>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="acct" class="form-label">ACCT NO:</label>
                    <input type="text" name="acct" id="acct" class="form-control" value="17202393" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="bsb" class="form-label">BSB:</label>
                    <input type="text" name="bsb" id="bsb" class="form-control" value="062-000" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="acctName" class="form-label">ACCT NAME:</label>
                    <input type="text" name="acctName" id="acctName" class="form-control"
                        value="BETTERCARE4U PTY LTD" required>
                </div>
            </div>
        </div>









        <button type="submit" class="btn btn-primary">
            Create Invoice
        </button>
    </form>
@endsection
@push('scripts')
    <script>
        let countProducts = 1;

        function addProducts() {
            countProducts++;

            let divProducts = document.getElementById('products');

            let divProduct = document.createElement('div');
            divProduct.setAttribute('id', `product${countProducts}`);
            divProduct.setAttribute('class', `class="col"`);
            divProduct.innerHTML = `
            <fieldset>
                    <legend>Product ${countProducts}</legend>
            <div class="mb-3">
                <label for="product${countProducts}"class="form-label">Product Name:</label>
                <input type="text" name="product_name${countProducts}" class="form-control" id="product_name${countProducts}">
            </div>
            <div class="mb-3">
                    <label for="product_quantity${countProducts}" class="form-label"">Product Quantity:</label>
                    <input type="number" name="product_quantity${countProducts}" class="form-control" id="product_quantity${countProducts} ">
                </div>
                <div class="mb-3">
                    <label for="product_price${countProducts}" class="form-label"">Product Price:</label>
                    <input type="text" name="product_price${countProducts}" class="form-control" id="product_price${countProducts} " >
                </div>
               
                <button type="button" onclick="removeProduct(${countProducts})" class="btn btn-danger">
  Remove
</button>

               
            </fieldset>
            <br>
            
            `;

            divProducts.appendChild(divProduct);
        }

        function removeProduct(id) {

            const product = document.getElementById(`product` + id);

            product.remove();
        }
    </script>
@endpush
