
//Package
$(function () {

  $('#editPackageModal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);

    var id     = button.data('id');
    var name   = button.data('name');
    var price  = button.data('price');
    var status = button.data('status');
    var game   = button.data('game');

    $('#editPackageId').val(id);
    $('#editPackageName').val(name);
    $('#editPackagePrice').val(price);
    $('#editPackageStatus').val(status);
    $('#editPackageGame').val(game);

    $('#deletePackageBtn').attr(
      'href',
      'delete_package.php?id=' + id
    );

  });

});

//Order
$(function () {

    $('#statusModal').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);

        var orderId = button.data('id');
        var status = button.data('status');

        $('#modalOrderId').text('#' + orderId);
        $('#modalInputId').val(orderId);

        $('input[name="status"]').prop('checked', false);
        $('input[name="status"][value="' + status + '"]').prop('checked', true);
    });

});

//Games
$(function () {

    // EDIT
    $('#editGameModal').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);

        $('#editGameId').val(button.data('id'));
        $('#editGameName').val(button.data('name'));
        $('#editGameStatus').val(button.data('status'));
    });

    // DELETE
    $('#deleteGameModal').on('show.bs.modal', function (event) {

        var button = $(event.relatedTarget);

        $('#deleteGameId').val(button.data('id'));
        $('#deleteGameName').text(button.data('name'));
    });

});

$('#editRewardModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);

  $('#editRewardId').val(button.data('id'));
  $('#editRewardName').val(button.data('name'));
  $('#editRewardType').val(button.data('type'));
  $('#editRewardPackage').val(button.data('package_id'));
  $('#editRewardModal input[name="point_cost"]').val(button.data('point_cost'));
  $('#editAmount').val(button.data('amount'));
});

$('#editUserModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);

  $('#editUserId').val(button.data('id'));
  $('#editUsername').val(button.data('username'));
  $('#editEmail').val(button.data('email'));
  $('#editStatus').val(button.data('status'));
});

$('#editGameModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);

  $('#editGameCategory').val(button.data('category'));
});