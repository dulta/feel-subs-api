<?php
  // Obtain application token
  // This operation should be performed on the server side to avoid
  // exposing the application key to the client.

  $appKey = 'PUT YOUR KEY HERE';

  $feelServerPath = 'https://api.pibds.com';
  $url = $feelServerPath . '/api/v1/app/' . $appKey . '/token';

  // Perform GET request
  $json = file_get_contents($url);

  // Parse JSON response
  $result = json_decode($json);
  if (property_exists($result, 'error')) {
    // Handle possible errors
    die('Error obtaining apptoken: ' . $result->error);
  }

  $apptoken = $result->apptoken;
  //print($url)
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>

  <div class="bg-primary p-y-3 section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 p-y-3 text-xs-center">
          <h1 class="display-2 m-y-2">Feel Subtitles example 2</h1>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="<?php echo $feelServerPath; ?>/static/public/js/1.2/feelsubs.js"></script>
  <script>
    // Initialize the JS SDK. Set the REST API URL and application token.
    $feelsubs.init('<?php echo $feelServerPath; ?>/api/v1', '<?php echo $apptoken; ?>')

    // initialize Kiiroo devices connection
    $feelsubs.devices.connect()
  </script>


  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1>Subtitles management APIs</h1>

          <div class="card">
            <div class="card-block">
              <h2>Video list</h2>
              <p>API method: <code>$feelsubs.manager.getVideos</code></p>
              <p>Example usage:</p>
              <pre>
    $feelsubs.manager.getVideos()
      .then(function(videoListStructure){
        console.log('Video list: ', videoListStructure)
      }).catch(function(error){
        console.log('Cannot get video list: ', error)
      })</pre>
              <button class="btn btn-primary" id="getvideolist">Try it</button>
              <p>Result:</p>
              <pre id="getvideolist-result"></pre>
              <script type="text/javascript">
                $('#getvideolist').click(function(){
                  $feelsubs.manager.getVideos()
                    .then(function(videoListStructure){
                      $('#getvideolist-result').text(JSON.stringify(
                        videoListStructure, null, 2))
                    }).catch(function(error){
                      $('#getvideolist-result').text(
                        'Cannot get video list:\n' +
                        JSON.stringify(error, null, 2))
                    })
                })
              </script>
            </div>
          </div>

          <div class="card">
            <div class="card-block">
              <h2>Subtitles list for video</h2>
              <p>API method: <code>$feelsubs.manager.getSubtitles</code></p>
              <p>Example usage:</p>
              <pre>
    $feelsubs.manager.getSubtitles(videoId)
      .then(function(subtitles){
          console.log('list of subtitles: ', subtitles)
      }).catch(function(error) {
          console.log('error getting the list of subtitles: ', error)
      })</pre>

              <div class="form-group row">
                <label for="getsubtitleslist-videoid" class="col-sm-2 form-control-label">Video ID</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="getsubtitleslist-videoid" placeholder="Video ID">
                </div>
              </div>
              <button class="btn btn-primary" id="getsubtitleslist">Try it</button>
              <p>Result:</p>
              <pre id="getsubtitleslist-result"></pre>

              <script type="text/javascript">
                $('#getsubtitleslist').click(function(){
                  var videoId = $('#getsubtitleslist-videoid').val()
                  $feelsubs.manager.getSubtitles(videoId)
                    .then(function(subtitles){
                      $('#getsubtitleslist-result').text(
                        JSON.stringify(subtitles, null, 2))
                    }).catch(function(error) {
                      $('#getsubtitleslist-result').text(
                        'error getting the list of subtitles:\n' +
                        JSON.stringify(error, null, 2))
                    })
                })
              </script>
            </div>
          </div>

          <div class="card">
            <div class="card-block">
              <h2>Creating a new subtitle</h2>
              <p>API method: <code>$feelsubs.manager.addSubtitle</code></p>
              <p>Example usage:</p>
              <pre>
    var subtitle = {
      name: 'Subtitle name',
      text: '{"0": 1, "1": 2}', // Valid JSON object, time (secs) as keys, device command as value
      type: 'penetration', // 'vibration' or 'penetration'
      description: 'Subtitle description'
    }

    $feelsubs.manager.addSubtitle(videoId, subtitle)
      .then(function(newSubtitle){
        console.log('Subtitle has been submitted. Subtitle ID is ' +
          newSubtitle.id)
      }).catch(function(error) {
        console.log('error: ', error)
      })</pre>

              <div class="form-group row">
                <label for="addsubtitle-videoid" class="col-sm-2 form-control-label">Video ID</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="addsubtitle-videoid" placeholder="Video ID">
                </div>
              </div>
              <div class="form-group row">
                <label for="addsubtitle-name" class="col-sm-2 form-control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="addsubtitle-name" placeholder="Name">
                </div>
              </div>
              <div class="form-group row">
                <label for="addsubtitle-type" class="col-sm-2 form-control-label">Type</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="addsubtitle-type" placeholder="e.g. vibration or penetration">
                </div>
              </div>
              <div class="form-group row">
                <label for="addsubtitle-description" class="col-sm-2 form-control-label">Description</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="addsubtitle-description"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="addsubtitle-text" class="col-sm-2 form-control-label">Text</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="addsubtitle-text"></textarea>
                </div>
              </div>
              <button class="btn btn-primary" id="addsubtitle">Try it</button>
              <p>Result:</p>
              <pre id="addsubtitle-result"></pre>

              <script type="text/javascript">
                $('#addsubtitle').click(function(){
                  // Submit new subtitle to the server
                  var subtitle = {
                    name: $('#addsubtitle-name').val(),
                    text: $('#addsubtitle-text').val(),
                    type: $('#addsubtitle-type').val(),
                    description: $('#addsubtitle-description').val(),
                  }
                  var videoId = $('#addsubtitle-videoid').val()

                  $feelsubs.manager.addSubtitle(videoId, subtitle)
                    .then(function(newSubtitle){
                      $('#addsubtitle-result').text(
                        JSON.stringify(newSubtitle, null, 2))
                    }).catch(function(error) {
                      $('#addsubtitle-result').text('Error:\n' +
                        JSON.stringify(error, null, 2))
                    })
                })
              </script>
            </div>
          </div>


          <div class="card">
            <div class="card-block">
              <h2>Modify subtitle</h2>
              <p>API method: <code>$feelsubs.manager.modifySubtitle</code></p>
              <p>Example usage:</p>
              <pre>
    var subtitle = {
      name: 'Subtitle name',
      text: '{"0": 1, "1": 2}', // Valid JSON object, time (secs) as keys, device command as value
      type: 'penetration', // 'vibration' or 'penetration'
      description: 'Subtitle description'
    }

    $feelsubs.manager.modifySubtitle(videoId, subtitleId, subtitle)
      .then(function(newSubtitle){
        console.log('Subtitle has been modified')
      }).catch(function(error) {
        console.log('error: ', error)
      })</pre>

              <div class="form-group row">
                <label for="modifysubtitle-videoid" class="col-sm-2 form-control-label">Video ID</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="modifysubtitle-videoid" placeholder="Video ID">
                </div>
              </div>
              <div class="form-group row">
                <label for="modifysubtitle-subtitleid" class="col-sm-2 form-control-label">Subtitle ID</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="modifysubtitle-subtitleid" placeholder="Subtitle ID (integer number)">
                </div>
              </div>
              <div class="form-group row">
                <label for="modifysubtitle-name" class="col-sm-2 form-control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="modifysubtitle-name" placeholder="Name">
                </div>
              </div>
              <div class="form-group row">
                <label for="modifysubtitle-type" class="col-sm-2 form-control-label">Type</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="modifysubtitle-type" placeholder="e.g. vibration or penetration">
                </div>
              </div>
              <div class="form-group row">
                <label for="modifysubtitle-description" class="col-sm-2 form-control-label">Description</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="modifysubtitle-description"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="modifysubtitle-text" class="col-sm-2 form-control-label">Text</label>
                <div class="col-sm-10">
                  <textarea class="form-control" id="modifysubtitle-text"></textarea>
                </div>
              </div>
              <button class="btn btn-primary" id="modifysubtitle">Try it</button>
              <p>Result:</p>
              <pre id="modifysubtitle-result"></pre>

              <script type="text/javascript">
                $('#modifysubtitle').click(function(){
                  // Submit new subtitle to the server
                  var subtitle = {
                    name: $('#modifysubtitle-name').val(),
                    text: $('#modifysubtitle-text').val(),
                    type: $('#modifysubtitle-type').val(),
                    description: $('#modifysubtitle-description').val(),
                  }
                  var videoId = $('#modifysubtitle-videoid').val()
                  var subtitleId = $('#modifysubtitle-subtitleid').val()

                  $feelsubs.manager.modifySubtitle(videoId, subtitleId, subtitle)
                    .then(function(subtitle){
                      $('#modifysubtitle-result').text(
                        JSON.stringify(subtitle, null, 2))
                    }).catch(function(error) {
                      $('#modifysubtitle-result').text('Error:\n' +
                        JSON.stringify(error, null, 2))
                    })
                })
              </script>
            </div>
          </div>


          <div class="card">
            <div class="card-block">
              <h2>Delete subtitle</h2>
              <p>API method: <code>$feelsubs.manager.deleteSubtitle</code></p>
              <p>Example usage:</p>
              <pre>
    $feelsubs.manager.deleteSubtitle(videoId, subtitleId)
      .then(function(){
          console.log('Subtitle deleted')
      }).catch(function(error) {
          console.log('Error deleting subtitle: ', error)
      })</pre>


              <div class="form-group row">
                <label for="deletesubtitle-videoid" class="col-sm-2 form-control-label">Video ID</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="deletesubtitle-videoid" placeholder="Video ID">
                </div>
              </div>
              <div class="form-group row">
                <label for="deletesubtitle-subtitileid" class="col-sm-2 form-control-label">Name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="deletesubtitle-subtitileid" placeholder="Subtitle ID">
                </div>
              </div>
              <button class="btn btn-primary" id="deletesubtitle">Try it</button>
              <p>Result:</p>
              <pre id="deletesubtitle-result"></pre>

              <script type="text/javascript">
                $('#deletesubtitle').click(function(){
                  var videoId = $('#deletesubtitle-videoid').val()
                  var subtitleId = $('#deletesubtitle-subtitileid').val()

                  $feelsubs.manager.deleteSubtitle(videoId, subtitleId)
                    .then(function(){
                      $('#deletesubtitle-result').text('Subtitle deleted')
                    }).catch(function(error) {
                      $('#deletesubtitle-result').text('Error:\n' +
                        JSON.stringify(error, null, 2))
                    })
                })
              </script>
            </div>
          </div>

          <h1>Subtitles player</h1>

          <div class="card">
            <div class="card-block">
              <h2>Player initialization</h2>
              <p>API method: <code>$feelsubs.player.connect()</code></p>
              <p>Connects to Kiiroo device through desktop application</p>
              <p>Example usage:</p>
              <pre>
$feelsubs.player.connect()</pre>
            </div>
          </div>


          <div class="card">
            <div class="card-block">
              <h2>Playing subtitles</h2>
              <p>API methods:
                <code>$feelsubs.player.play()</code>,
                <code>$feelsubs.player.timeupdate(currentTime)</code>,
                <code>$feelsubs.player.stop()</code>
              </p>
              <p>This methods should be bound to the DOM <code>video</code>
                element events as shown in the example.</p>
              <p>Example usage:</p>
              <pre>
&lt;video id="video"&gt;..&lt;/video&gt;
...
$('#video').on('play', function() {
  $feelsubs.player.play()
}).on('timeupdate', function() {
  var currentTime = this.currentTime
  $feelsubs.player.timeupdate(currentTime)
}).on('pause', function() {
  $feelsubs.player.stop()
})</pre>
            </div>
          </div>

          <div class="card">
            <div class="card-block">
              <h2>Player connection to the Kiiroo device</h2>
              <p>API methods:
                <code>$feelsubs.player.onConnectionStatusChange</code>,
                <code>$feelsubs.player.getConnectionStatus</code>
              </p>
              <p>Example usage:</p>
              <pre>
$feelsubs.devices.onConnectionStatusChange(function(){
  var status = $feelsubs.devices.getConnectionStatus()
  if (status == $feelsubs.devices.STATUS.DISCONNECTED) {
    // Kiiroo app is not running. You can prompt to click the link to open the app
    // This event can be fired multiple times
    console.log('Kiiroo desktop is not running, please run it')
  } else if (status == $feelsubs.devices.STATUS.CONNECTING) {
    // Browser is connected to the Kiiroo app, Kiiroo app is connecting to
    // the device. Event can be fired multiple times
    console.log('Connected to the Kiiroo desktop app, connecting to the device...')
  } else if (status == $feelsubs.devices.STATUS.CONNECTED) {
    // Kiiroo app is connected to the device. Event can be fired multiple times
    console.log('Connected to the Kiiroo device')
  }
})</pre>
            </div>
          </div>

          <div class="card">
            <div class="card-block">
              <h2>Try it!</h2>

              <div class="form-group row">
                <label for="player-videoid" class="col-sm-2 form-control-label">Video ID</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="player-videoid" placeholder="Video ID">
                </div>
              </div>
              <div class="form-group row">
                <label for="player-subtitileid" class="col-sm-2 form-control-label">Subtitle ID (integer)</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="player-subtitileid" placeholder="Subtitle ID">
                </div>
              </div>
              <button class="btn btn-primary" id="player-load">Load subtitle</button>

              <pre id="player-result"></pre>

              <div id="player-launch-mobile" style="display:none;">
                <p>Mobile platform detected. You need to launch this page
                in the mobile app.</p>

                <a href="#" class="btn btn-primary" role="button" id="player-launch-mobile-link">
                  Launch mobile app
                </a>
              </div>

              <div id="player-mobile-settings" style="display:none;">
                <a class="btn btn-primary" role="button" id="player-mobile-settings-link">
                  Select Kiiroo devices to connect
                </a>
              </div>


              <div id="player-launch-desktop" style="display:none;">
                <p>Desktop app doesn't seem to run.</p>

                <a href="kiiroo://url" class="btn btn-primary" role="button">
                  Launch desktop app
                </a>
              </div>


              <video id="video" style="width:600px;max-width:100%;" controls="">
                <source src="http://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4">
                <source src="http://www.w3schools.com/html/mov_bbb.ogg" type="video/ogg">
                Your browser does not support HTML5 video.
              </video>

              <script type="text/javascript">
                $('#video').hide()
                $('#player-load').click(function(){
                  $('#video').hide()
                  var videoId = $('#player-videoid').val()
                  var subtitleId = $('#player-subtitileid').val()

                  // If you are tracking your users, you can provide us with
                  // user id, it can be any string up to 160 characters long.
                  // Otherwiser you can just omit it.
                  var userId = ''

                  // Load the subtitles
                  $feelsubs.player.load(videoId, subtitleId, userId)
                    .then(function(){
                      $('#video').show()
                        $('#player-result').append('Subtitles loaded\n')
                    }).catch(function(error) {
                        $('#player-result').append('Error loading subtitles: ' + error + '\n')
                    })
                })

                $('#player-mobile-settings-link').click(function() {
                  $feelsubs.devices.setup()
                })

                function handleConnectionStatus() {
                  var status = $feelsubs.devices.getConnectionStatus()
                  $('#player-result').append('Status: ' + status + '\n')
                  if (status == $feelsubs.devices.STATUS.DESKTOP_DISCONNECTED) {
                    // Kiiroo app is not running. You can prompt to click the link to open the app
                    // This event can be fired multiple times
                    $('#player-launch-desktop').show();
                  } else if (status == $feelsubs.devices.STATUS.DESKTOP_CONNECTING) {
                    // Browser is connected to the Kiiroo app, Kiiroo app is connecting to
                    // the device. Event can be fired multiple times
                    $('#player-launch-desktop').hide();
                    $('#player-result').append('Connected to the Kiiroo desktop ' +
                      'app, connecting to the device...\n')
                  } else if (status == $feelsubs.devices.STATUS.DESKTOP_CONNECTED) {
                    // Kiiroo app is connected to the device. Event can be fired multiple times
                    $('#player-result').append('Connected to the Kiiroo device\n')
                  } else if (status == $feelsubs.devices.STATUS.MOBILE_NOT_IN_APP) {
                    // Web page is running in the mobile browser. Need to open
                    // this page in the app
                    $('#player-launch-mobile').show();
                    var url = $feelsubs.devices.getAppLaunchUrl(window.location.href)
                    $('#player-launch-mobile-link').attr('href', url);
                  } else if (status == $feelsubs.devices.STATUS.MOBILE_IN_APP_DISCONNECTED ||
                             status == $feelsubs.devices.STATUS.MOBILE_IN_APP_CONNECTING ||
                             status == $feelsubs.devices.STATUS.MOBILE_IN_APP_CONNECTED) {
                    $('#player-launch-mobile').hide();
                    // Show button to cinfigure Kiiroo devices on mobile
                    $('#player-mobile-settings').show();
                  }
                }

                // Device connection events
                $feelsubs.devices.onConnectionStatusChange(function(){
                  handleConnectionStatus()
                })

                handleConnectionStatus()

                // Video player DOM events
                $('#video').on('play', function() {
                  var currentTime = this.currentTime
                  $feelsubs.player.play(currentTime)
                }).on('timeupdate', function() {
                  var currentTime = this.currentTime
                  $feelsubs.player.timeupdate(currentTime)
                }).on('pause', function() {
                  $feelsubs.player.stop()
                })
              </script>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>