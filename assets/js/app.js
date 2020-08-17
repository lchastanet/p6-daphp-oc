const axios = require("axios").default;

import "../css/app.css";
import { videoFields } from "./video-fields.js";
import { homeTricksLoader } from "./home-tricks-loader.js";
import { commentsLoader } from "./comments-loader.js";
import { deleteMedia } from "./delete-media.js";
import { editVideo } from "./edit-video.js";

$(() => {
  videoFields();
  homeTricksLoader(axios);
  commentsLoader(axios);
  deleteMedia(axios);
  editVideo(axios);
});
