<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">O'chirmoqchimisiz?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="user-delete-form" method="post" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body">Tasdiqlash uchun "O'chirish" tugmasini bosing!</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Bekor qilish</button>
                    <button class="btn btn-danger" type="submit">O'chirish</button>
                </div>
            </form>
        </div>
    </div>
</div>
