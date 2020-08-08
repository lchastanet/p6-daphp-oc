import { cardTitleSpliter } from "./_utils.js";

export function homeTricksLoader(axios) {
  $("#homeTricksLoaderButton").click(function () {
    const $this = $(this);
    const index = parseInt($this.val());

    axios
      .get("/charger-tricks/" + index)
      .then(function (res) {
        const tricks = res.data;
        tricks.forEach(layoutCard);
        $this.val(index + 8);
      })
      .catch(function (err) {
        console.log(err);
      });
  });
}

function layoutCard(trick) {
  const $template = $(document.getElementsByClassName("card")[0]).clone(true);
  const $headerLink = $($template.find(".card-header-link"));
  const $img = $($template.find(".card-img-index"));
  const $cardTitle = $($template.find(".card-title-index"));
  const $editLink = $($template.find(".edit-link"));

  $headerLink.attr("href", "/trick/" + trick.id);
  $img.attr("src", "/uploads/pictures/" + trick.pictureOne);
  $cardTitle
    .attr("href", "/trick/" + trick.id)
    .text(cardTitleSpliter(trick.title));

  if ($editLink.length === 1) {
    $editLink.attr("href", "/admin/trick/" + trick.id + "/modifier");

    $template.find("form").attr("action", "/admin/trick/" + trick.id);
  }

  $("#homeTricksContainer").append($template);
}

$(".card-title-index").each((i, e) => {
  $(e).text(cardTitleSpliter($(e).text()));
});
