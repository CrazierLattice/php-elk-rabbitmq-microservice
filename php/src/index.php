<?php
echo "<h1>Hello from PHP!</h1>";
echo "<h2>Send a message to RabbitMQ:</h2>";
echo "<ul>";
echo "<li><a href='send.php?level=info'>Send INFO log</a></li>";
echo "<li><a href='send.php?level=warning'>Send WARNING log</a></li>";
echo "<li><a href='send.php?level=error'>Send ERROR log</a></li>";
echo "</ul>";
