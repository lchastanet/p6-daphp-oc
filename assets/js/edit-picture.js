import { replaceHeaderImg } from "./_utils.js";

export function editPicture(axios) {
  $(".edit-picture-btn").click(function (e) {
    e.preventDefault();
    e.stopPropagation();

    const $this = $(this);
    const target = $this.attr("href");

    $($("#editPictureModal").modal("toggle").find("#picture")).val("");

    $("#pictureErrorFlash").css("display", "none");

    $("#submitPicture").click(function () {
      const updatedPicture = document.getElementById("picture").files[0];
      const btn = $(this);
      let params = new FormData();

      params.append("picture", updatedPicture);

      if (updatedPicture) {
        axios
          .post(target, params)
          .then(function (res) {
            const newImg = res.data;
            const originalImg = $($($this.parents()[2]).children()[0])
              .attr("src")
              .split("/")[3];

            replaceHeaderImg(originalImg, newImg);

            $($($this.parents()[2]).children()[0]).attr(
              "src",
              "/uploads/pictures/" + newImg
            );
            $("#editPictureModal").modal("hide");
            btn.unbind();
          })
          .catch(function (err) {
            $(
              $("#pictureErrorFlash").css("display", "block").children()[1]
            ).text(err.response.data);
          });
      } else {
        $($("#pictureErrorFlash").css("display", "block").children()[1]).text(
          "Veuillez ajouter une image à uploader"
        );
      }
    });
  });
}
