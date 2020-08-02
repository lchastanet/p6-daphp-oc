export function videoFields() {
  const $collectionHolder = $("div.videos");
  const $addButton = $('<div class="btn btn-primary">Ajouter une video</div>');

  $collectionHolder.after($addButton);

  function addTagForm($collectionHolder) {
    const index = $collectionHolder.data("index");
    const $deleteButton = $(
      '<span class="btn btn-danger deleteButton">X</span>'
    ).on("click", (e) => {
      removeTagForm($(e.target, index));
    });
    const $newForm = $(
      $collectionHolder.data("prototype").replace(/__name__/g, index)
    );
    $newForm.css("width", "100%").append($deleteButton);
    $newForm
      .children(":first")
      .addClass("col-10")
      .css("display", "inline-block");

    $collectionHolder.data("index", index + 1).append($newForm);
  }

  function removeTagForm($target, index) {
    $target.parent().remove();

    $collectionHolder.data("index", index - 1);
  }

  $collectionHolder.data("index", $collectionHolder.find("input").length);

  $addButton.on("click", () => {
    addTagForm($collectionHolder);
  });
}
