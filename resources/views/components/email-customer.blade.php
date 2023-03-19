<div>
    <div class="flex justify-end relative ">
        <button id="emailCustomerButton" type="button" class="btn btn-success z-10 relative bottom-2"
            data-bs-toggle="modal" data-bs-target="#emailCustomerModal">
            Contact customer
        </button>
    </div>

    <!-- Modal -->
    <div id='emailCustomerModal' class="modal fade " tabindex="-1" aria-labelledby="emailCustomerModal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mx-auto">Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='emailCustomerForm'>

                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="emailCustomerFrom" class="form-label">send from</label>
                            <input class="form-control" id="emailCustomerFrom" required></input>
                        </div>

                        <div class="mb-3">
                            <label for="emailCustomerSubject" class="form-label">Subjects</label>
                            <input class="form-control" id="emailCustomerSubject" required></input>
                        </div>

                        <div class="mb-3">
                            <label for="emailCustomerBody" class="form-label">Main Body</label>
                            <input class="form-control" id="emailCustomerBody" required></input>
                        </div>

                        <div class="mb-3">
                            <label for="emailCustomerLink" class="form-label">Link</label>
                            <input class="form-control" id="emailCustomerLink"></input>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button id='closeEmailCustomerButton' type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Cancel</button>
                        <button id='submitEmailCustomerButton' type="submit" class="btn btn-primary">Send</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
