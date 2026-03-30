
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
  const btn = $(event.relatedTarget);

  $('#editRewardId').val(btn.data('id'));
  $('#editRewardName').val(btn.data('name'));
  $('#editRewardType').val(btn.data('type'));
  $('#editRewardValue').val(btn.data('value'));
  $('#editRewardPackage').val(btn.data('package'));

  $('#deleteRewardBtn').attr('href', 'delete_reward.php?id=' + btn.data('id'));
});