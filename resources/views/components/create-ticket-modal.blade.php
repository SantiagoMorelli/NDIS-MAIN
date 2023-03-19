<div>
    <div class="flex justify-center relative ">
        {{-- z-10 absolute top-0 mr-4 --}}
        <button id="ticketModalButton" type="button" class="btn btn-primary " data-bs-toggle="modal"
            data-bs-target="#shippingModal">
            <i class="fa fa-plus mr-2"></i>create a ticket
        </button>
    </div>

    <!-- Modal -->
    <div id='modalTicket' class="modal fade " tabindex="-1" aria-labelledby="shippingModal" aria-hidden="true"
        style="z-index: 10001;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mx-auto">Ticket Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='createTicketForm'>

                    @csrf
                    <div class="modal-body">


                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <i class="text-red-400 pt-2">&#42;</i>
                            <input type="text" class="form-control" id="subject" required>
                        </div>
                        <div class="mb-3">

                            <label for="due_date" class="form-label">Schedule a Notice</label>
                            <i class="text-red-400 pt-2">&#42;</i>
                            <input type="date" class="form-control" id="due_date" required>
                        </div>
                        <div class="mb-3 hidden">
                            <input type="text" class="form-control" id="status" value="open">
                        </div>
                        <div class="mb-3">
                            <label for="orderId" class="form-label">Order Number</label>
                            @if (isset($orderNum))
                                <input type="text" class="form-control" value={{ $orderNum }} id="orderId">
                            @else
                                <input type="text" class="form-control" id="orderId">
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" rows="2"></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <div class="flex justify-start">
                            <button id='ticketCloseButton' type="button" class="btn btn-secondary mr-4"
                                data-bs-dismiss="modal">
                                Cancel</button>
                            <button id='ticketSubmitButton' type="submit" class="btn btn-primary">Create</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
