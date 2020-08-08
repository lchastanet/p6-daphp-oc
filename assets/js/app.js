import "../css/app.css";
import { videoFields } from "./video-fields.js";
import { homeTricksLoader } from "./home-tricks-loader.js";
import { commentsLoader } from "./comments-loader.js";

$(() => {
  videoFields();
  homeTricksLoader();
  commentsLoader();
});
