<nav class="navbar navbar-expand-sm bg-primary navbar-dark">
	<ul class="navbar-nav">
		<li class="nav-item">
	    <a class="nav-link" href=<?='http://' . $_ENV['HTTP_HOST'] ?>>System</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href=<?='http://' . $_ENV['HTTP_HOST'] . '/worker/show.php' ?>>Pracownicy</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href=<?='http://' . $_ENV['HTTP_HOST'] . '/log/show.php' ?>>Logs</a>
	  </li>
	  <li class="nav-item">
	    <a class="nav-link" href=<?='http://' . $_ENV['HTTP_HOST'] . '/token/show.php' ?>>Token</a>
	  </li>
	</ul>
</nav>