<h5>Customer Details</h5> <br>
<label> First Name : </label>
<input type="text" placeholder="enter first name" class="h-6 rounded mx-1 w-48" name="customer_first_name"
    value="{{ $orderData[0]['customer_first_name'] }}" required>
<br>

<label> Last Name :</label>
<input type="text" placeholder="enter last name" class="h-6 rounded mx-1 w-48" name="customer_last_name"
    value=" {{ $orderData[0]['customer_last_name'] }}" required>
<br>
<label> Phone Number :</label>
<input type="text" placeholder="enter phone number" class="h-6 rounded mx-1 w-48" name="customer_phone_number"
    value="  {{ $orderData[0]['customer_phone_number'] }}" required>
<br>
<label>Shipping Adress : </label><br>
<label><input type="text" placeholder="enter shipping address street" class="h-6 rounded mx-1 w-48"
        name="shipping_address_street" value="  {{ $orderData[0]['shipping_address_street'] }}" required></label><br>
<label><input type="text" placeholder="enter shipping address city" class="h-6 rounded mx-1 w-48"
        name="shipping_address_city" value="  {{ $orderData[0]['shipping_address_city'] }}" required></label> ,
<label><input type="text" placeholder="enter shipping address state" class="h-6 rounded mx-1 w-48"
        name="shipping_address_state" value="  {{ $orderData[0]['shipping_address_state'] }}" required></label><br>
<label><input type="text" placeholder="enter pin code" class="h-6 rounded mx-1 w-48"
        name="shipping_address_post_code" value="  {{ $orderData[0]['shipping_address_post_code'] }}" required></label>
<br>
<label>Order Date :<input type="text" placeholder="enter phone number" class="h-6 rounded mx-1 w-48"
        name="order_date" value="  {{ $orderData[0]['order_date'] }}" required></label><br><br>

<h5>Order Item details</h5>
<div style="overflow-x:auto;">
    <table id="orderData" class="table dt-responsive nowrap w-100 mt-2 border-2">
        <thead>
            <tr>
                <th> Order No. </th>
                <th> Product Name </th>
                <th> Quantity </th>
                <th> Product Sku</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($orderData as $data)
                <tr>
                    <td> <input type="text" class="h-6 rounded mx-1 w-36" name="order_number"
                            value=" {{ $data['order_number'] }}" required> </td>
                    <td><input type="text" placeholder="enter item name" class="h-6 rounded mx-1 w-48" name="item[]"
                            value="{{ $data['item_name'] }}" required> </td>
                    <td><input type="text" placeholder="enter quantity" class="h-6 rounded mx-1 w-36" name="item[]"
                            value=" {{ $data['item_quantity'] }}" required> </td>
                    <td><input type="text" placeholder="enter product sku" class="h-6 rounded mx-1 w-48"
                            name="item[]" value="{{ $data['product_sku'] }}" required> </td>
                </tr>
            @endforeach

        </tbody>

    </table>
</div>
<br>
@if (isset($orderData[0]['order_comment']))
    <label>Order Note : <input type="text" placeholder="enter phone number" class="h-6 rounded mx-1 w-48"
            name="product_sku" value=" {{ $orderData[0]['order_comment'] }}" required> </label>
@endif
<br>
