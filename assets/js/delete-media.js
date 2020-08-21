export function deleteMedia(axios) {
  $(".delete-media-btn").click(function (e) {
    e.preventDefault();
    e.stopPropagation();

    const confirmation = confirm(
      "Êtes-vous sûr de vouloir supprimer ce media ?"
    );

    if (confirmation) {
      const $form = $($(this).parent());
      const token = $($form.find("input")[1]).val();
      const params = new URLSearchParams();

      params.append("_method", "DELETE");
      params.append("_token", token);

      axios
        .post($form.attr("action"), params)
        .then(function (res) {
          $($form.parents()[2]).remove();
          const videoUrl = $($($form.parents()[2]).children()[0]).attr("src");

          $("input")
            .filter(function () {
              return this.value == videoUrl;
            })
            .remove();

          console.log(res);
        })
        .catch(function (err) {
          console.log(err);
        });
    }
  });
}
