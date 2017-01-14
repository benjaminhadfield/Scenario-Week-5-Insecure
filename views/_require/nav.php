<nav class="navbar navbar-toggleable-sm navbar-inverse bg-primary pc-bg">
  <a class="navbar-brand font-weight-bold" href="?">Hackify</a>
  <div class="navbar-nav navbar-collapse">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="?controller=blog&action=index">Blog</a>
    </div>
    <form class="form-inline navbar-toggler-right" method="get" onsubmit="return checkForm()">
      <input id="search-input" type="text" name="search" value="<?php echo $_GET['search'] ?>" class="form-control mr-sm-2" placeholder="Search blog...">
    </form>
  </div>
</nav>

<script>
  function checkForm() {
    var searchValue = document.getElementById('search-input').value.trim();
    if (searchValue === '') {
      console.log(window.location.pathname);
      return false;
    }
  }
</script>