<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="pure JS WiFi QR Code Generator">
    <meta name="author" content="Evgeni Golov">
    <meta name="flattr:id" content="menw3k">
    <title>pure JS WiFi QR Code Generator</title>
    <link rel="stylesheet" type="text/css" media="all" href="style.css">
    <link rel="stylesheet" type="text/css" media="print" href="print.css">
    <link rel="icon" href="qifi.png" type="image/x-icon">
    <link rel="manifest" href="manifest.json">

    <link rel="stylesheet" type="text/css" media="all" href="bootstrap/css/bootstrap.min.css">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">QiFi</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
              <li id="history-drop" class="dropdown">
                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">History <b class="caret"></b></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="history-drop">
                </ul>
              </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
    <section id="generator">
    <div class="page-header"><h1 id="title">pure JS WiFi QR Code Generator</h1>
      <p>From <a href="https://qifi.org" target="_blank">qifi.org</a></p>
    </div>
    <div id="history"></div>
    <form id="form">
        <div class="form-group has-feedback">
            <label for="ssid" class="control-label">SSID</label>
            <div class="input-group">
                <span id="basic-addon-ssid" class="input-group-addon"><i class="glyphicon glyphicon-signal"></i></span>
                <input type="text" id="ssid" name="ssid" class="form-control" placeholder="SSID" aria-describedby="basic-addon-ssid" required>
            </div>
        </div>

        <div class="form-group">
            <label for="enc" class="control-label">Encryption</label>
            <div class="input-group">
                <select name="enc" id="enc" class="form-control">
                    <option value="WPA">WPA/WPA2</option>
                    <option value="WEP">WEP</option>
                    <option value="nopass">None</option>
                </select>
            </div>
        </div>

        <div class="form-group has-feedback" id="key-p">
            <label class="control-label">Key</label>
            <div class="input-group">
                <span id="basic-addon1" class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" id="key" name="key" class="form-control" placeholder="key" aria-describedby="basic-addon1" required>
                <span class="input-group-btn"><button class="btn btn-default" type="button" id="display-key"><i class="glyphicon glyphicon-eye-open" id="display-key-icon"></i></button></span>
           </div>
        </div>

        <div class="form-group">
            <label class="pull-left control-label" for="hidden">Hidden</label>
            <div class="input-group">
                <input type="checkbox" name="hidden" id="hidden" data-toggle="tooltip" title="Is your SSID hidden?">
            </div>
        </div>

        <div class="form-group">
            <button id="generate" class="btn btn-primary">Generate!</button>
            <button id="save" type="button" class="btn" data-toggle="tooltip" title="Save the credentials for the WiFi in HTML5 localStorage for later use.">Save!</button>
            <a href="#" id="export" class="btn" target="_blank" data-toggle="tooltip" title="Export the QR code as a PNG.">Export!</a>
            <a href="javascript:window.print()" id="print" class="btn" data-toggle="tooltip" title="Print the QR code.">Print!</a>
        </div>
    </form>
    <h1 id="showssid">SSID: none</h1>
    <h1 id="showkey">Passphrase: none</h1>
    <div id="qrcode"></div>
    </section>
    <section id="about">
        <div class="page-header"><h1 class="anchor">About</h1></div>
        <p>
        Ever wanted to create a cool QR code for your guests? But never wanted to type in your WiFi credentials into a form that submits them to a remote webserver to render the QR code? <i>QiFi</i> for the rescue! It will render the code in your browser, on your machine, so the WiFi stays as secure as it was before (read the code if you do not trust text on the internet :-))!
        </p>
        <p>
        If you use the Save-button to store a code, this is still secure, as the data is stored in HTML5 localStorage and is never transmitted to the server (in contrast to cookie-based solutions).
        </p>
        <p>
        Don't trust your browser either? Just pipe the string
        <code>WIFI:S:&lt;SSID&gt;;T:&lt;WPA|WEP|&gt;;P:&lt;password&gt;;;</code>
        through the QR code generator of your choice after <a href="https://github.com/zxing/zxing/wiki/Barcode-Contents#wi-fi-network-config-android-ios-11">reading the documentation</a>.
        </p>

        <h2>Supported Scanners</h2>
        <h3>Android</h3>
        <p>
            <a href="https://play.google.com/store/apps/details?id=com.google.zxing.client.android">Barcode Scanner</a> from ZXing.
        </p>
        <p>
            <a href="https://play.google.com/store/apps/details?id=de.gavitec.android">NeoReader</a>.
        </p>
        <p>
            Huawei phones have a QR code scanner in HiVision mode. This mode has an eye-shaped icon and can be lauched from the lock screen by swiping up or from the camera.
        </p>
        <p>
            Every other Android Barcode Scanner based on the <a href="https://code.google.com/p/zxing/">ZXing library</a>.
        </p>
        <h3>Maemo</h3>
        <p>
            <a href="http://maemo.org/packages/view/mbarcode/">mbarcode</a> with the <a href="http://maemo.org/packages/view/mbarcode-plugin-wifi/">mbarcode wifi plugin</a> on Maemo 5.
        </p>
        <h3>iOS</h3>
        <p>
            The iOS Camera App has <a href="https://www.macrumors.com/2017/06/06/iphone-can-scan-qr-codes-ios-11/">support for WiFi QR codes since iOS 11</a>.
        </p>
        <p>
            <a href="https://itunes.apple.com/app/qr-reader-for-iphone/id368494609">QR Reader for iPhone</a> from TapMedia and <a href="https://itunes.apple.com/in/app/avira-insight-qr-code-scanner/id1151086651">Avira Insight QR Code Scanner</a> by Avira Holding GmbH &amp; Co. KG also support WiFi QR codes. Please note: Due to iOS design, third-party apps cannot modify WiFi settings directly and you'll have to copy&amp;paste the details. The only alternative would be downloading a mobile profile from the Internet, but that would mean leaking your credentials to a third-party.
        </p>
        <h3>Other</h3>
        <p>
            Every other QR scanner out there should be able to scan the code too, but probably won't interpret it as intended. If your scanner supports WiFi QR codes, please send me a mail!
        </p>
    </section>
    <section id="contact">
        <div class="page-header"><h1 class="anchor">Contact</h1></div>
        <p>QiFi was written by <a href="https://www.die-welt.net">Evgeni Golov</a>, using <a href="http://jquery.com/">jQuery</a>, <a href="http://jeromeetienne.github.io/jquery-qrcode/">jQuery QRCode</a>, <a href="http://yckart.github.io/jquery.storage.js/">jQuery Storage</a> and <a href="https://getbootstrap.com/">Bootstrap</a>.</p>
        <p>If you have any comments, suggestions, bugs or complaints: please write to: <a href="mailto:evgeni+qifi@golov.de">evgeni+qifi@golov.de</a>.</p>
    </section>
    </div>
    <footer class="footer">
      <div class="container">
        <img src="qifi-small.png" alt="qifi logo"/> by <a href="https://github.com/evgeni">@evgeni</a><br/>
        <span style="color: #999999;">QR Code is a registered trademark of DENSO WAVE INCORPORATED in the United States and other countries.</span>
      </div>
    </footer>
    <script src="jquery/jquery-3.5.1.slim.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="jquery-qrcode/jquery.qrcode.min.js"></script>
    <script src="jquery.storage.js/jquery.storage.js"></script>
    <script type="text/javascript">
        function escape_string (string) {
            var to_escape = ['\\', ';', ',', ':', '"'];
            var hex_only = /^[0-9a-f]+$/i;
            var output = "";
            for (var i=0; i<string.length; i++) {
                if($.inArray(string[i], to_escape) != -1) {
                    output += '\\'+string[i];
                }
                else {
                    output += string[i];
                }
            }
            //if (hex_only.test(output)) {
            //    output = '"'+output+'"';
            //}
            return output;
        };

        function generate () {
            var ssid = $('#ssid').val();
            var hidden = $('#hidden').is(':checked');
            var enc = $('#enc').val();
            if (enc != 'nopass') {
                var key = $('#key').val();
                $('#showkey').text(enc+' Passphrase: '+key);
            } else {
                var key = '';
                $('#showkey').text('');
            }
            // https://github.com/zxing/zxing/wiki/Barcode-Contents#wi-fi-network-config-android-ios-11
            var qrstring = 'WIFI:S:'+escape_string(ssid)+';T:'+enc+';P:'+escape_string(key)+';';
            if (hidden) {
                qrstring += 'H:true';
            }
            qrstring += ';';
            $('#qrcode').empty();
            $('#qrcode').qrcode(qrstring);
            $('#showssid').text('SSID: '+ssid);
            $('#save').show();
            $('#print').css('display', 'inline-block');

            var canvas = $('#qrcode canvas');
            if (canvas.length == 1) {
                var data = canvas[0].toDataURL('image/png');
                var e = $('#export');
                e.attr('href', data);
                e.attr('download', ssid+'-qrcode.png');
                // e.show() sets display:inline, but we need inline-block
                e.css('display', 'inline-block');
            }
        };

        function save () {
            var ssid = $('#ssid').val();
            if (!ssid) return;
            var hidden = $('#hidden').is(':checked');
            var enc = $('#enc').val();
            var key = $('#key').val();
            var storage = $.localStorage('qificodes');
            if (!storage) storage = {};
            storage[ssid] = {'hidden': hidden, 'enc': enc, 'key': key};
            $.localStorage('qificodes', storage);
            loadhistory();
        };

        function load(ssid) {
            var storage = $.localStorage('qificodes');
            if (ssid in storage) {
                $('#ssid').val(ssid);
                $('#enc').val(storage[ssid]['enc']);
                $('#key').val(storage[ssid]['key']);
                $('#hidden').prop('checked', storage[ssid]['hidden']);
                generate();
            }
        };

        function loadhistory () {
            var storage = $.localStorage('qificodes');
            if (storage) {
                var history = $('#history-drop ul.dropdown-menu');
                var ssids = Object.keys(storage);
                history.empty();
                for (var i=0; i<ssids.length; i++) {
                    history.append('<li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="history-item">'+ssids[i]+'</a></li>');
                }
                history.append('<li role="presentation" class="divider"></li>');
                history.append('<li role="presentation"><a role="menuitem" tabindex="-1" href="#" class="history-clear">clear history</a></li>');

                history.on('click', 'a.history-item', function(e) {
                    e.preventDefault();
                    load($(this).text());
                });
                history.on('click', 'a.history-clear', function(e) {
                    e.preventDefault();
                    clearhistory();
                });
                $('#history-drop').show();
            }
        };

        function clearhistory () {
            $.localStorage('qificodes', null);
            $('#history-drop').hide();
        };

        $(document).ready(function(){
            $('#form').submit(function() {
                generate();
                return false;
            });
            $('#save').click(function() {
                save();
            });
            $('#display-key').click(function() {
                var $key = $("#key");
                if ($key.attr('type') === 'password') {
                    $key.attr('type', 'text');
                    $("#display-key-icon").attr("class", "glyphicon glyphicon-eye-close");
                } else {
                    $key.attr('type', 'password');
                    $("#display-key-icon").attr("class", "glyphicon glyphicon-eye-open");
                }
            });
            $('#enc').change(function() {
                if($(this).val() != 'nopass') {
                   $('#key-p').show();
                   $('#key').attr('required','required');
                }
                else {
                   $('#key-p').hide();
                   $('#key').removeAttr('required');
                }
            });
            $('#form').tooltip({
                selector: "[data-toggle=tooltip]"
            });
            loadhistory();
        });

        // Service Worker installation
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js', {scope: './'}).then(function(registration) {
                    console.log('[Service Worker] Successfully installed');
                }).catch(function(error) {
                    console.log('[Service Worker] Installation failed:', error);
                })
            });
        }
    </script>
</body>
</html>
