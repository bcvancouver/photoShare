<form name="searchbar" method="get" action="searchFunction.php">
          <input type="text" name="keywords"/> <br>
          <input type="radio" name="order" value="norm" checked />Normal<br>
          <input type="radio" name="order" value="new" />Newest<br>
          <input type="radio" name="order" value="old" />Oldest<br>
          Older Than: <input type="date" name="start"><br>
          Newer Than:<input type="date" name="end"><br>
          <input type="submit" name="validate" value="Search"/>
        </form>

        <!--
        <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="signin.html">Signin</a></li>
                <li><a href="logout.php">Signout</a></li>
                <li><a href="registration.html">Signup</a></li>
              </ul>
            </li>
        -->