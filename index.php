<?php

declare( strict_types=1 );

// TODO A: Improve the readability of this file through refactoring and documentation.
/// DONE. It is not require to have a documentation as soon as for
/// now code is operating with classes and code become self explanatory
/// more over this file was responsible for too much functionality
/// now we have controller and service for word counting

// TODO B: Review the HTML structure and make sure that it is valid and contains
// required elements. Edit and re-organize the HTML as needed.
/// DONE

// TODO C: Review the index.php entrypoint for security and performance concerns
// and provide fixes. Note any issues you don't have time to fix.
/// Major concern is sanitation of user input.
/// Obviously some one can use '../someFile' as article title and iterate over file system.
/// Now path is locked to '/articles' folder

// TODO D: The list of available articles is hardcoded. Add code to get a
// dynamically generated list.
/// DONE. All necessary data now is accumulated in class Page

// TODO E: Are there performance problems with the word count function? How
// could you optimize this to perform well with large amounts of data? Code
// comments / psuedo-code welcome.
/// DONE. It is heavy computational task to iterate over all files.
/// Ideally that information should be built on to of some extra meta data stored dependently
/// And updates for this metadata should happens on write events only
/// but as temporary solution I simply cached that

// TODO F (optional): Implement a unit test that operates on part of App.php

use App\App;
use App\Controller\IndexController;

require_once __DIR__ . '/vendor/autoload.php';

$page = ( new IndexController( new App() ) )->action();

echo "
<!DOCTYPE html>
<html lang='en'>
<head>
   <link rel='stylesheet' href='https://design.wikimedia.org/style-guide/css/build/wmui-style-guide.min.css'>
   <link rel='stylesheet' href='styles.css'>
   <title>$page->title</title>
   <script src='main.js'></script>
</head>
<body>
   <div id=header class=header>
      <a href='/'>Article editor</a>
      <div>$page->wordCount words written</div>
   </div>
   <div class='page'>
      <div class='main'>
         <h2>Create/Edit Article</h2>
         <p>
         	Create a new article by filling out the fields below.
         	Edit an article by typing the beginning of the title in the title field,
         	selecting the title from the auto-complete list, and changing the text in the textfield.
		</p>
         <form action='index.php' method='post'>
			<input name='title' type='text' placeholder='Article title...' value='$page->title' >
			<textarea name='body' placeholder='Article body...' >$page->body</textarea>
            <button type='submit' class='submit-button'>Submit</button>
         </form>
         <article>
			 <h2>Preview</h2>
			 <h3>$page->title</h3>
			 <p>$page->body</p>
		 </article>
		 <div>
			<h2>Articles</h2>
			<ul>$page->articlesList</ul>
		 </div>
      </div>
   </div>
</body>
</html>
";
