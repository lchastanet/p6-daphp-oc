export function editVideo(axios) {
  $(".edit-video-btn").click(function (e) {
    e.preventDefault();
    e.stopPropagation();

    const $this = $(this);
    const target = $this.attr("href");
    const $iframe = $($($this.parents()[2]).children()[0]);
    const currentURL = $iframe.attr("src");
    const $input = $($("#editVideoModal").modal("toggle").find("#videoURL"));
    const token = $("#videoToken").val();

    $input.css("display", "inline-flex").val(currentURL);
    $("#videoErrorFlash").css("display", "none");

    $("#submitVideoURL").click(function () {
      const $this = $(this);

      const updatedURL = $input.val();
      let params = new URLSearchParams();

      params.append("videoURL", updatedURL);
      params.append("_token", token);

      axios
        .post(target, params)
        .then(function (res) {
          $iframe.attr("src", updatedURL);
          $('input[value="' + currentURL + '"]').val(updatedURL);
          $("#editVideoModal").modal("hide");
          $this.unbind();
        })
        .catch(function (err) {
          $($("#videoErrorFlash").css("display", "block").children()[1]).text(
            err.response.data
          );
        });
    });
  });
}
