<div>
    <div class="flex justify-end relative ">
        <button id="modal_Button" type="button" class="btn btn-primary z-10  " data-bs-toggle="modal"
            data-bs-target="#Modal">
            <i class="fa fa-plus mr-2"></i>create a comment
        </button>
    </div>

    <!-- Modal -->
    <div id='modal_Main' class="modal fade " tabindex="-1" aria-labelledby="Modal" aria-hidden="true"
        style="z-index: 10001;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mx-auto">write down a comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id='createCommentForm'>

                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <i class="text-red-400 pt-2">&#42;</i>
                            <textarea class="form-control" id="comment" rows="4" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer flex justify-between">
                        <button id='close_Button' type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel</button>
                        <button id='submitButton' type="submit" class="btn btn-primary">Create</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
