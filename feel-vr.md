# Feel VR API

Feel VR is an application which can play a VR wideo along with device subtitles.
Please see https://github.com/dulta/feel-subs-api/blob/master/README.md for
more information on subtitles.

To play a video in Feel VR application user should click a special URL using
mobile browser. The URL format is described below.

## URL format

The URL link should contain the following parameters:

* Video URL (`url` parameter)
* Video format (`format` parameter). See https://delight-vr.com/documentation/dl8-video/ for the list of possible video formats.
* Video ID in Feel Subtitles system (`video-id` parameter)
* Subtitles ID in Feel Subtitles system (`sub-id` parameter)
* Application token (`token` parameter)

Please see https://github.com/dulta/feel-subs-api/blob/master/README.md for
more information on video ID, subtitles ID and application token and where to
get them.

The link should start with `feelapp://vr` or `feelapp://vr-download`. In the
first case the video will start playing in the Feel VR app immediately when user
clicked the link. In the second case the video will be downloaded to the
phone internal memory and can be played later.

All parameters should be url-encoded.

## Examples

Play online sample link:

feelapp://vr?url=https%3A%2F%2Fdelight-vr.com%2Fexamples%2Finvasion.mp4&video-id=test&sub-id=2352&format=STEREO_360_TB&token=eyJleHAiOjE0ODQ3NTQ1ODgsImlhdCI6MTQ4NDY2ODE4OCwiYWxnIjoiSFMyNTYifQ.eyJpZCI6M30.s88TqEjECb2sAuAbmJsHuVExzbe2esfcKt8N8c7bhn1

Download sample link:

feelapp://vr-download?url=https%3A%2F%2Fdelight-vr.com%2Fexamples%2Finvasion.mp4&video-id=test&sub-id=2352&format=STEREO_360_TB&token=eyJleHAiOjE0ODQ3NTQ1ODgsImlhdCI6MTQ4NDY2ODE4OCwiYWxnIjoiSFMyNTYifQ.eyJpZCI6M30.s88TqEjECb2sAuAbmJsHuVExzbe2esfcKt8N8c7bhn1

(Please note that these example links don't actually work because application token
is valid for 24 hours only and has already expired)