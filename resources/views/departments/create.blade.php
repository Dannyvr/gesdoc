<div class="modal fade" id="create">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="text-center">{{ __('app.departments.create.title') }}</h3>
        <button type="close" class="close" data-dismiss="modal">
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST" onkeydown="return event.key != 'Enter';">
          <input type="hidden" id="idCreate">
           <div class="form-group">
             <label for="name">{{ __('app.departments.create.name') }}</label>
             <input type="text" class="form-control" id="nameCreate" placeholder="Nombre Departamento" name="nameCreate">
           </div>

         </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="ajaxCreate() "id="CreateSubmit" class="btn btn-success">{{ __('app.buttons.add') }}</button>
      </div>
    </div>
 </div>
</div>
