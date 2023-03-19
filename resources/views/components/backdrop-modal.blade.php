<div>
    <div>
        <button id="modalButton" type="button" class="btn btn-secondary mr-4" data-bs-toggle="modal"
            data-bs-target="#shippingModal">
            <i class="fa fa-plus mr-2"></i>create tracking info
        </button>
    </div>

    <!-- Modal -->
    <div id='modalMain' class="modal fade " tabindex="-1" aria-labelledby="shippingModal" aria-hidden="true"
        style="z-index: 10001;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mx-auto">Add tracking information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='createTrackingForm'>


                    @csrf
                    <div class="modal-body">

                        <div class="mb-3 hidden">
                            <label for="orderId" class="form-label">Order Id</label>
                            <input type="text" class="form-control" id="orderId" value="{{ $orderId }}">
                        </div>
                        <div id="modalData"></div>
                        {{-- @if (isset($item_name))

                            @foreach ($item_name as $name)
                                <div class="mb-3 ">
                                    <label for="itemName" class="form-label">Item Name</label>
                                    <input type="text" class="form-control" id="itemName" name="itemName[]"
                                        value="{{ $name }}">
                                </div>
                            @endforeach
                            @foreach ($product_sku as $sku)
                                <input type="hidden" class="form-control" id="product_sku" name="product_sku[]"
                                    value=" {{ $sku }}">
                            @endforeach
                            @foreach ($SupplierId as $sid)
                                <div class="mb-3 ">
                                    <label for="SupplierId" class="form-label">Supplier Id</label>
                                    <input type="text" class="form-control" id="SupplierId" name="product_sku[]"
                                        value="{{ $sid }}">
                                </div>
                            @endforeach
                        @endif --}}
                        <div class="mb-3">
                            <label for="trackingNumber" class="form-label">Tracking Id</label>
                            <i class="text-red-400 pt-2">&#42;</i>
                            <input type="text" class="form-control" id="trackingNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="courierCompany" class="form-label">Courier Company</label>
                            <i class="text-red-400 pt-1">&#42;</i>
                            <input type="text" class="form-control" id="courierCompany" required>
                        </div>
                        <div class="mb-3">
                            <label for="eta" class="form-label">Expected to Arrive</label>
                            <input type="date" class="form-control" id="eta">
                        </div>
                        <div class="mb-3">
                            <label for="dispatchTime" class="form-label">Dispatch Date</label>
                            <input type="date" class="form-control" id="dispatchTime">
                        </div>
                        <div class="mb-3">
                            <label for="tracking_notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="tracking_notes" rows="2"></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button id='closeButton' type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close</button>
                        <button id='submitButton' type="submit" class="btn btn-primary">Save changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
