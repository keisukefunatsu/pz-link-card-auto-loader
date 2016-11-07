<?php

  if (! get_option('customcss1')) {
    add_option( 'customcss1' , $value= false, null, $autoload = 'yes');
  }

  if ( isset( $_POST['selectcss'] ) ) {
    update_option('customcss1' , $_POST['selectcss']);
  }

?>
<div class="wrap">
  <h2>Pz LinkCard Auto Loader by <span><a target="_blank" href="https://awe-some.net">Keisuke Funatsu</a></span></h2>
  <form class="" action="" method="post">
    <h2>To enable our custom CSS (imitating hatena blog)</h2>
    <p>
      Please make sure that "指定したCSSファイルを使用する" is checked and it should be blank.
    </p>

    <select class="" name="selectcss">
      <option value='true' >Use our custom CSS</option>
      <option value='false' >Not use our custom CSS</option>
    </select>
    <p>
      <input type="hidden" name="posted" value="yes" />
    </p>
    <p>
      <input type="submit" name="submit" class="button button-primary" value="変更を保存" />
    </p>
  </form>
</div>
