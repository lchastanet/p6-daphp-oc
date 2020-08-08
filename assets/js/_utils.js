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
