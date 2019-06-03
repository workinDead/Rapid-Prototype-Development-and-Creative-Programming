# Individual Project

# File description
four Screenshots for the browser visiting the EC2 instance serving up the "college.html", "hello.txt", "brookings.jpg" web page on port 3456. 

# Best Practice for node.js 
Before running the individual project, you need to use "npm install" to install mime by package.json. Thus, when you visit "localhost:3456", you will be able to view the files that are in static file.

# Answer to serve PHP file on port 3456 
- Discuss in the README.md why phpinfo.php behaves the way it does when loaded through Node.JS (4 points)

- By browser php file, the php file will not be shown on the page but will be downloaded instead. This is because Node.js only supports JavaScript while for php file, we'll need php server to load it. Previously, we set port 80 rather than 3456 to access it. Besides, when we run node.js, there is no need to reload php server. Thus, if we don't start php server, our nodejs will treat php file as a file that can be downloaded.