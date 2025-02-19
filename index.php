<?php
header('Cross-Origin-Opener-Policy: same-origin');
header('Cross-Origin-Embedder-Policy: require-corp');
?>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vim Online Editor - Vim Editor In Browser</title>
        <meta charset="utf-8">
        <meta http-equiv="origin-trial" content="AphUM/Qt5R/jf2M2dWkL/9U8kgJr6a9UcC9gJyF3YQbyw0aDz713tceDbpxlBlIHYiF/jOMywy0Tft4/lWlv2QkAAAB9eyJvcmlnaW4iOiJodHRwczovL3ZpbW9ubGluZWVkaXRvci5jb206NDQzIiwiZmVhdHVyZSI6IlVucmVzdHJpY3RlZFNoYXJlZEFycmF5QnVmZmVyIiwiZXhwaXJ5IjoxNjg4MDgzMTk5LCJpc1N1YmRvbWFpbiI6dHJ1ZX0=">
        <link rel="stylesheet" href="styles/style.css" />
    </head>
    <body>        
          <button id='pastebtn' onclick='paste(event)'>Paste</button>
          <button onclick='loadvimrc(event)'>Load vimrc</button>
          <input id="vim-input" autocomplete="off" />
        </div>
        
        <div id="vim-editor" onclick='focuseditor()'>
          <canvas id="vim-screen"></canvas>
        </div>
        
        <?php require_once "index/ChangeLog.html"; ?>

        <?php require_once "index/TODOs.html"; ?>

        <?php require_once "index/About.html"; ?>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
        <script type="module" src="JavaScript/vimwasm.js" async></script>
        <script type="module" src="JavaScript/main.js"></script>

        <script>

        function getinput() {
          return document.getElementById('vim-input');
        }

        function typekey(letter) {
          // Taken from https://stackoverflow.com/a/71264026
          getinput().dispatchEvent(new KeyboardEvent("keydown", {
            key: letter,
            // key: "e",
            // keyCode: 69,        // example values.
            // code: "KeyE",       // put everything you need in this object.
            // which: 69,
            shiftKey: false,    // you don't need to include values
            ctrlKey: false,     // if you aren't going to use them.
            metaKey: false      // these are here for example's sake.
          }));
          getinput().dispatchEvent(new KeyboardEvent("keyup", {
            key: letter,
            shiftKey: false,    // you don't need to include values
            ctrlKey: false,     // if you aren't going to use them.
            metaKey: false      // these are here for example's sake.
          }));
        }

        function type(s) {
          for (var i = 0; i < s.length; ++i) {
            typekey(s[i]);
          }
        }

        function esc() { typekey('Escape'); }
        function enter() {
          // For some reason, 'enter' REALLY wanted all the rest of the properties here.
          getinput().dispatchEvent(new KeyboardEvent("keydown", {
            key: 'Enter',
            keyCode: 13,
            code: "Enter",
            which: 13,
            isTrusted: true,
            shiftKey: false,    // you don't need to include values
            ctrlKey: false,     // if you aren't going to use them.
            metaKey: false      // these are here for example's sake.
          }));
        }
        function focus() { getinput().focus(); }

        var isFirefox = (navigator.userAgent.indexOf('Firefox') !== -1);

        function paste(e) {
          if (isFirefox) {
            alert('Firefox does not allow web apps to read clipboard.');
            return;
          }
          console.log('event:', e);
          focuseditor();
          esc();
          type('"*p');
          focus();
        }

        function loadvimrc(e) {
          console.log('event:', e);
          focuseditor();
          esc();
          type(':e ~/.vim/vimrc');
          enter();
          focus();
        }

        function focuseditor() {
          // Make it so that the button is top of the viewport.
          document.getElementById('pastebtn').scrollIntoView();
        }

        </script>