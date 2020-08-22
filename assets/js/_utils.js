export function cardTitleSpliter(text) {
  if (text.length > 12) {
    const exploded = text.split(" ");
    let title = "";

    exploded.forEach((e) => {
      if (title.length < 9) {
        title += " " + e;
      }
    });

    return (title += "...");
  }
  return text;
}

export function replaceHeaderImg(originalImg, newImg) {
  const currentHeaderImg = $($(".jumbotron")[0])
    .css("background-image")
    .split("/")[5]
    .slice(0, -2);

  if (originalImg === currentHeaderImg) {
    $($(".jumbotron")[0]).css(
      "background-image",
      'url("http://localhost:8000/uploads/pictures/' + newImg + '")'
    );
  }
}
