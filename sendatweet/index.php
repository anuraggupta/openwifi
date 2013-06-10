<?php

// include our libraries
include 'lib/tmhOAuth.php';
include 'lib/TwitterApp.php';
include 'lib/TwitterAvatars.php';

// set the consumer key and secret
define('CONSUMER_KEY',      'qSkJum23MqlG6greF8Z76A');
define('CONSUMER_SECRET',   'Bs738r5UY2R7e5mwp1ilU0voe8OtXAtifgtZe9EhXw');

try {

    // our tmhOAuth settings
    $config = array(
        'consumer_key'      => CONSUMER_KEY,
        'consumer_secret'   => CONSUMER_SECRET
    );

    // create a new TwitterAvatars object
    $ta = new TwitterAvatars(new tmhOAuth($config));

    // check for stale files
    $ta->cleanupFiles();

    // check our authentication status
    if($ta->isAuthed()) {

        // has the user selected an option?
        if(isset($_POST['filter'])) {

            // is the user sure?
            if(isset($_POST['confirm'])) {

                // change the user's avatar
                $ta->commitAvatar($_POST['filter']);

                // tweet if the user chose to
                if(isset($_POST['tweet'])) {
                    $ta->sendTweet('I just updated my avatar using Avatar Effects...');
                }

                $success = true;
            }

            // get the image paths for display
            $original = $ta->getPreview();
            $newimage = $ta->getPreview($_POST['filter']);
        }
        // generate previews if the user has not chosen
        else {

            // $previews will be a list of images
            $previews = $ta->generatePreviews();
        }
    }
    // did the user request authorization?
    elseif(isset($_POST['auth'])) {

        // start authentication process
        $ta->auth();
    }
} catch(Exception $e) {

    // catch any errors that may occur
    $error = $e;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Twitter Avatar Effects</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
      <h1>Twitter Avatar Effects</h1>
  <?php if(isset($previews)): ?>
      <h2>Choose your weapon...</h2>
      <form action="index.php" method="post">
      <?php foreach($previews as $filter => $path): ?>
          <input type="image" src="<?php echo $path; ?>"
                 alt="<?php echo ucfirst($filter); ?>"
                  width="73" height="73"
                 name="filter" value="<?php echo $filter; ?>">
      <?php endforeach; ?>
      </form>
      <p>Select one of the images above to change your Twitter avatar.</p>
  <?php elseif(isset($success)): ?>
      <h2>Success! Your Twitter avatar is now:</h2>
      <img src="<?php echo $newimage; ?>" alt="Your Avatar" width="73" height="73">
      <p><a href="http://twitter.com/<?php echo $ta->userdata->screen_name; ?>">Go see it</a></p>
  <?php elseif(isset($newimage)): ?>
      <h2>Are you sure?</h2>
      <img src="<?php echo $original; ?>" alt="Original" width="73" height="73">
      <span class="arrow">&rArr;</span>
      <img src="<?php echo $newimage; ?>" alt="<?php echo ucfirst($_POST['filter']); ?>">
      <form action="index.php" method="post">
          <input type="hidden" name="filter" value="<?php echo $_POST['filter']; ?>">
          <input type="submit" name="confirm" value="Confirm">
          <a href="index.php">Cancel</a>
          <p><label>Tweet about your new avatar?
                  <input type="checkbox" name="tweet" value="true"></label></p>
      </form>
  <?php elseif(isset($error)): ?>
      <p>Error. <a href="index.php">Try again?</a></p>
  <?php else: ?>
      <form action="index.php" method="post">
          <input type="image" src="img/sign-in-with-twitter-l.png"
                 alt="Connect to Twitter" name="auth" value="1">
      </form>
      <p>Connect to Twitter to use this app.</p>
  <?php endif; ?>
  </body>
</html>