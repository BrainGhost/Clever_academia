$(document).ready(function () {
  $("#typingArea").on("submit", function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    formData.append("send", "send");
    if ($("#typingField").val())
      $.ajax({
        type: "POST",
        url: "./sendPeer_message.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {},
      });
    $("#mainSection").scrollTop($("#mainSection")[0].scrollHeight);
    $("#typingField").val("");
  });

  setInterval(function () {
    let incomingid = $("#incoming").val();
    $.ajax({
      type: "post",
      url: "./retrievePeer_message.php",
      data: { incomingid: incomingid },
      success: function (response) {
        $("#mainSection").html(response);
      },
    });
  }, 10);
});
