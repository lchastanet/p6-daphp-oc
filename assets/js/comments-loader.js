const axios = require("axios").default;

export function commentsLoader() {
  $("#commentsLoaderButton").click(function () {
    const $this = $(this);
    const index = parseInt($this.val());
    const idTrick = parseInt($("#commentsLoaderButton").attr("data-id-trick"));

    axios
      .get("/trick/" + idTrick + "/comments/" + index)
      .then(function (res) {
        const comments = res.data;
        comments.forEach(layoutCard);
        $this.val(index + 5);
      })
      .catch(function (err) {
        console.log(err);
      });
  });

  function layoutCard(comment) {
    const $template = $(
      document.getElementsByClassName("comment-card")[0]
    ).clone(true);
    const $img = $($template.find(".comment-user-avatar"));
    const $userName = $($template.find(".comment-username"));
    const $content = $($template.find(".comment-content"));

    $img.attr("src", "/uploads/avatars/" + comment.userAvatar);
    $userName.text(comment.userName);
    $content.text(comment.content);

    console.log($template);
    $("#comment-form-container").append($template);
  }
}
