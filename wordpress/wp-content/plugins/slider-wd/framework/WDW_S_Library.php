<?php
class WDW_S_Library {

  public function __construct() {
  }

  public static function get($key, $default_value = '') {
    if (isset($_GET[$key])) {
      $value = $_GET[$key];
    }
    elseif (isset($_POST[$key])) {
      $value = $_POST[$key];
    }
    else {
      $value = '';
    }
    if (!$value) {
      $value = $default_value;
    }
    return esc_html($value);
  }

  /**
   * Generate message container by message id or directly by message.
   *
   * @param int $message_id
   * @param string $message If message_id is 0
   * @param string $type
   *
   * @return mixed|string|void
   */
  public static function message_id($message_id, $message = '', $type = 'updated') {
    if ($message_id) {
      switch ( $message_id ) {
        case 1: {
          $message = __('Item Succesfully Saved.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 2: {
          $message = __('Error. Please install plugin again.', 'wds');
          $type = 'wd_error';
          break;
        }
        case 3: {
          $message = __('Item Succesfully Deleted.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 4: {
          $message = __("You can't delete default theme", 'wds');
          $type = 'wd_error';
          break;
        }
        case 5: {
          $message = __('Items Succesfully Deleted.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 6: {
          $message = __('You must select at least one item.', 'wds');
          $type = 'wd_error';
          break;
        }
        case 7: {
          $message = __('The item is successfully set as default.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 8: {
          $message = __('Options Succesfully Saved.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 9: {
          $message = __('Item Succesfully Published.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 10: {
          $message = __('Items Succesfully Published.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 11: {
          $message = __('Item Succesfully Unpublished.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 12: {
          $message = __('Items Succesfully Unpublished.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 13: {
          $message = __('Ordering Succesfully Saved.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 14: {
          $message = __('A term with the name provided already exists.', 'wds');
          $type = 'wd_error';
          break;
        }
        case 15: {
          $message = __('Name field is required.', 'wds');
          $type = 'wd_error';
          break;
        }
        case 16: {
          $message = __('The slug must be unique.', 'wds');
          $type = 'wd_error';
          break;
        }
        case 17: {
          $message = __('Changes must be saved.', 'wds');
          $type = 'wd_error';
          break;
        }
        case 18: {
          $message = __('You must set watermark type.', 'wds');
          $type = 'wd_error';
          break;
        }
        case 19: {
          $message = __('Watermark Succesfully Set.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 20: {
          $message = __('Watermark Succesfully Reset.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 21: {
          $message = __('Settings Succesfully Reset.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 22: {
          $message = __('Items Succesfully Set.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 23: {
          $message = __('Slider successfully imported.', 'wds');
          $type = 'wd_updated';
          break;
        }
        case 24: {
          $message = __('Unexpected error occurred.', 'wds');
          $type = 'wd_error';
          break;
        }
        case 25: {
          $message = __('You can include only posts with featured image.', 'wds');
          $type = 'wd_updated';
          break;
        }
        default: {
          $message = '';
          break;
        }
      }
    }

    if ( $message ) {
      ob_start();
      ?><div style="width: 99%;"><div class="<?php echo $type; ?> inline">
      <p>
        <strong><?php echo $message; ?></strong>
      </p>
      </div></div><?php
      $message = ob_get_clean();
    }

    return $message;
  }

  public static function message($message, $type) {
    return '<div style="width: 99%" class="spider_message"><div class="' . $type . '"><p><strong>'. $message .'</strong></p></div></div>';
  }

  public static function search($search_by, $search_value, $form_id) {
    $search_position = ($form_id == 'posts_form') ? 'alignleft' : 'alignright';
    ?>
    <div class="<?php echo $search_position; ?> actions" style="clear: both;">
      <script>
        function spider_search(event) {
          if (typeof event != 'undefined') {
            var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
            if (keyCode != 13) {
              return false;
            }
          }
          document.getElementById("page_number").value = "1";
          document.getElementById("search_or_not").value = "search";
          document.getElementById("<?php echo $form_id; ?>").submit();
          if (typeof event != 'undefined') {
            if (event.preventDefault) {
              event.preventDefault();
            }
            else {
              event.returnValue = false;
            }
          }
        }
        function spider_reset() {
          if (document.getElementById("search_value")) {
            document.getElementById("search_value").value = "";
          }
          if (document.getElementById("category_id")) {
            document.getElementById("category_id").value = -1;
          }
          document.getElementById("<?php echo $form_id; ?>").submit();
        }
      </script>
      <div class="alignleft actions">
        <input type="search"
               id="search_value"
               name="search_value"
               value="<?php echo esc_html($search_value); ?>"
               onkeypress="spider_search(event)" />
        <input type="button" value="<?php _e('Search', 'wds'); ?>" onclick="spider_search()" class="button" />
      </div>
    </div>
    <?php
  }

  public static function search_select($search_by, $search_select_id = 'search_select_value', $search_select_value, $playlists, $form_id) {
    ?>
    <div class="alignleft actions" style="clear:both;">
      <script>
        function spider_search_select() {
          document.getElementById("page_number").value = "1";
          document.getElementById("search_or_not").value = "search";
          document.getElementById("<?php echo $form_id; ?>").submit();
        }
      </script>
      <div class="alignleft actions" >
        <label for="<?php echo $search_select_id; ?>" style="font-size:14px; width:50px; display:inline-block;"><?php echo $search_by; ?>:</label>
        <select id="<?php echo $search_select_id; ?>" name="<?php echo $search_select_id; ?>" onchange="spider_search_select();" style="float: none; width: 150px;">
        <?php
          foreach ($playlists as $id => $playlist) {
            ?>
            <option value="<?php echo $id; ?>" <?php echo (($search_select_value == $id) ? 'selected="selected"' : ''); ?>><?php echo $playlist; ?></option>
            <?php
          }
        ?>
        </select>
      </div>
    </div>
    <?php
  }
  
  public static function html_page_nav($count_items, $page_number, $form_id, $items_per_page = 20) {
    $limit = 20;
    if ($count_items) {
      if ($count_items % $limit) {
        $items_county = ($count_items - $count_items % $limit) / $limit + 1;
      }
      else {
        $items_county = ($count_items - $count_items % $limit) / $limit;
      }
    }
    else {
      $items_county = 1;
    }
    ?>
    <script type="text/javascript">
      var items_county = <?php echo $items_county; ?>;
      function spider_page(x, y) {       
        switch (y) {
          case 1:
            if (x >= items_county) {
              document.getElementById('page_number').value = items_county;
            }
            else {
              document.getElementById('page_number').value = x + 1;
            }
            break;
          case 2:
            document.getElementById('page_number').value = items_county;
            break;
          case -1:
            if (x == 1) {
              document.getElementById('page_number').value = 1;
            }
            else {
              document.getElementById('page_number').value = x - 1;
            }
            break;
          case -2:
            document.getElementById('page_number').value = 1;
            break;
          default:
            document.getElementById('page_number').value = 1;
        }
        document.getElementById('<?php echo $form_id; ?>').submit();
      }
      function check_enter_key(e) {
        var key_code = (e.keyCode ? e.keyCode : e.which);
        if (key_code == 13) { /*Enter keycode*/
          if (jQuery('#current_page').val() >= items_county) {
           document.getElementById('page_number').value = items_county;
          }
          else {
           document.getElementById('page_number').value = jQuery('#current_page').val();
          }
          document.getElementById('<?php echo $form_id; ?>').submit();
        }
        return true;
      }
    </script>
    <div class="tablenav-pages" style="text-align:right">
      <span class="displaying-num">
        <?php
        if ($count_items != 0) {
          echo $count_items;
          _e(' item', 'wds');
          echo (($count_items == 1) ? '' : __('s', 'wds'));
        }
        ?>
      </span>
      <?php
      if ($count_items > $items_per_page) {
        $first_page = "first-page";
        $prev_page = "prev-page";
        $next_page = "next-page";
        $last_page = "last-page";
        if ($page_number == 1) {
          $first_page = "first-page disabled";
          $prev_page = "prev-page disabled";
          $next_page = "next-page";
          $last_page = "last-page";
        }
        if ($page_number >= $items_county) {
          $first_page = "first-page ";
          $prev_page = "prev-page";
          $next_page = "next-page disabled";
          $last_page = "last-page disabled";
        }
      ?>
      <span class="pagination-links">
        <a class="<?php echo $first_page; ?>" title="<?php _e('Go to the first page', 'wds'); ?>" href="javascript:spider_page(<?php echo $page_number; ?>,-2);">«</a>
        <a class="<?php echo $prev_page; ?>" title="<?php _e('Go to the previous page', 'wds'); ?>" href="javascript:spider_page(<?php echo $page_number; ?>,-1);">‹</a>
        <span class="paging-input">
          <span class="total-pages">
          <input class="current_page" id="current_page" name="current_page" value="<?php echo $page_number; ?>" onkeypress="return check_enter_key(event)" title="Go to the page" type="text" size="1" />
        </span> of 
        <span class="total-pages">
            <?php echo $items_county; ?>
          </span>
        </span>
        <a class="<?php echo $next_page ?>" title="<?php _e('Go to the next page', 'wds'); ?>" href="javascript:spider_page(<?php echo $page_number; ?>,1);">›</a>
        <a class="<?php echo $last_page ?>" title="<?php _e('Go to the last page', 'wds'); ?>" href="javascript:spider_page(<?php echo $page_number; ?>,2);">»</a>
        <?php
      }
      ?>
      </span>
    </div>
    <input type="hidden" id="page_number" name="page_number" value="<?php echo ((isset($_POST['page_number'])) ? (int) $_POST['page_number'] : 1); ?>" />
    <input type="hidden" id="search_or_not" name="search_or_not" value="<?php echo ((isset($_POST['search_or_not'])) ? esc_html($_POST['search_or_not']) : ''); ?>"/>
    <?php
  }

  public static function ajax_html_page_nav($count_items, $page_number, $form_id) {
    $limit = 20;
    if ($count_items) {
      if ($count_items % $limit) {
        $items_county = ($count_items - $count_items % $limit) / $limit + 1;
      }
      else {
        $items_county = ($count_items - $count_items % $limit) / $limit;
      }
    }
    else {
      $items_county = 1;
    }
    ?>
    <script type="text/javascript">
      var items_county = <?php echo $items_county; ?>;
      function spider_page(x, y) {
        switch (y) {
          case 1:
            if (x >= items_county) {
              document.getElementById('page_number').value = items_county;
            }
            else {
              document.getElementById('page_number').value = x + 1;
            }
            break;
          case 2:
            document.getElementById('page_number').value = items_county;
            break;
          case -1:
            if (x == 1) {
              document.getElementById('page_number').value = 1;
            }
            else {
              document.getElementById('page_number').value = x - 1;
            }
            break;
          case -2:
            document.getElementById('page_number').value = 1;
            break;
          default:
            document.getElementById('page_number').value = 1;
        }
      }
      function check_enter_key(e) { 	  
        var key_code = (e.keyCode ? e.keyCode : e.which);
        if (key_code == 13) { /*Enter keycode*/
          if (jQuery('#current_page').val() >= items_county) {
           document.getElementById('page_number').value = items_county;
          }
          else {
           document.getElementById('page_number').value = jQuery('#current_page').val();
          }
          return false;
        }
       return true;		 
      }
    </script>
    <div id="tablenav-pages" class="tablenav-pages">
      <span class="displaying-num">
        <?php
        if ($count_items != 0) {
            echo $count_items;
            _e('item', 'wds');
            echo (($count_items == 1) ? '' : __('s', 'wds'));
       }
        ?>
      </span>
      <?php
      if ($count_items > $limit) {
        $first_page = "first-page";
        $prev_page = "prev-page";
        $next_page = "next-page";
        $last_page = "last-page";
        if ($page_number == 1) {
          $first_page = "first-page disabled";
          $prev_page = "prev-page disabled";
          $next_page = "next-page";
          $last_page = "last-page";
        }
        if ($page_number >= $items_county) {
          $first_page = "first-page ";
          $prev_page = "prev-page";
          $next_page = "next-page disabled";
          $last_page = "last-page disabled";
        }
      ?>
      <span class="pagination-links">
        <a class="<?php echo $first_page; ?>" title="<?php _e('Go to the first page', 'wds'); ?>" onclick="spider_page(<?php echo $page_number; ?>,-2)">«</a>
        <a class="<?php echo $prev_page; ?>" title="<?php _e('Go to the previous page', 'wds'); ?>" onclick="spider_page(<?php echo $page_number; ?>,-1)">‹</a>
        <span class="paging-input">
          <span class="total-pages">
          <input class="current_page" id="current_page" name="current_page" value="<?php echo $page_number; ?>" onkeypress="return check_enter_key(event)" title="Go to the page" type="text" size="1" />
        </span> of 
        <span class="total-pages">
            <?php echo $items_county; ?>
          </span>
        </span>
        <a class="<?php echo $next_page ?>" title="<?php _e('Go to the next page', 'wds'); ?>" onclick="spider_page(<?php echo $page_number; ?>,1)">›</a>
        <a class="<?php echo $last_page ?>" title="<?php _e('Go to the last page', 'wds'); ?>" onclick="spider_page(<?php echo $page_number; ?>,2)">»</a>
        <?php
      }
      ?>
      </span>
    </div>
    <input type="hidden" id="page_number" name="page_number" value="<?php echo ((isset($_POST['page_number'])) ? (int) $_POST['page_number'] : 1); ?>" />
    <input type="hidden" id="search_or_not" name="search_or_not" value="<?php echo ((isset($_POST['search_or_not'])) ? esc_html($_POST['search_or_not']) : ''); ?>"/>
    <?php
  }

  public static function spider_hex2rgb($colour) {
    if ($colour[0] == '#') {
      $colour = substr( $colour, 1 );
    }
    if (strlen($colour) == 6) {
      list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
    }
    else if (strlen($colour) == 3) {
      list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
    }
    else {
      return FALSE;
    }
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);
    return array('red' => $r, 'green' => $g, 'blue' => $b);
  }

  public static function spider_hex2rgba($colour, $transparent = 1) {
    if ($colour[0] == '#') {
      $colour = substr( $colour, 1 );
    }
    if (strlen($colour) == 6) {
      list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
    }
    else if (strlen($colour) == 3) {
      list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
    }
    else {
      return FALSE;
    }
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);
    return 'rgba(' . $r . ', ' . $g . ', ' . $b . ', ' . number_format($transparent, 2, ".", "") . ')';
  }

  public static function spider_redirect($url) {
    $url = html_entity_decode(wp_nonce_url($url, 'nonce_wd', 'nonce_wd'));
    ?>
    <script>
      window.location = "<?php echo $url; ?>";
    </script>
    <?php
    exit();
  }

  public static function verify_nonce($page){
    $nonce_verified = FALSE;
    if (isset($_GET['nonce_wd']) && wp_verify_nonce($_GET['nonce_wd'], $page)) {
      $nonce_verified = TRUE;
    }
    if (!$nonce_verified) {
      die('Sorry, your nonce did not verify.');
    }
  }

  public static function get_google_fonts() {
    $wds_global_options = get_option("wds_global_options", 0);
    $global_options = json_decode($wds_global_options);
    $possib_add_ffamily_google = isset($global_options->possib_add_ffamily_google) ? $global_options->possib_add_ffamily_google : '';
    $google_fonts = array('ABeeZee' => 'ABeeZee', 'Abel' => 'Abel', 'Abril Fatface' => 'Abril Fatface', 'Aclonica' => 'Aclonica', 'Acme' => 'Acme', 'Actor' => 'Actor', 'Adamina' => 'Adamina', 'Advent Pro' => 'Advent Pro', 'Aguafina Script' => 'Aguafina Script', 'Akronim' => 'Akronim', 'Aladin' => 'Aladin', 'Aldrich' => 'Aldrich', 'Alef' => 'Alef', 'Alegreya' => 'Alegreya', 'Alegreya SC' => 'Alegreya SC', 'Alegreya Sans' => 'Alegreya Sans', 'Alex Brush' => 'Alex Brush', 'Alfa Slab One' => 'Alfa Slab One', 'Alice' => 'Alice', 'Alike' => 'Alike', 'Alike Angular' => 'Alike Angular', 'Allan' => 'Allan', 'Allerta' => 'Allerta', 'Allerta Stencil' => 'Allerta Stencil', 'Allura' => 'Allura', 'Almendra' => 'Almendra', 'Almendra display' => 'Almendra Display', 'Almendra sc' => 'Almendra SC', 'Amarante' => 'Amarante', 'Amaranth' => 'Amaranth', 'Amatic sc' => 'Amatic SC', 'Amethysta' => 'Amethysta', 'Amiri' => 'Amiri', 'Amita' => 'Amita', 'Anaheim' => 'Anaheim', 'Andada' => 'Andada', 'Andika' => 'Andika', 'Angkor' => 'Angkor', 'Annie Use Your Telescope' => 'Annie Use Your Telescope', 'Anonymous Pro' => 'Anonymous Pro', 'Antic' => 'Antic', 'Antic Didone' => 'Antic Didone', 'Antic Slab' => 'Antic Slab', 'Anton' => 'Anton', 'Arapey' => 'Arapey', 'Arbutus' => 'Arbutus', 'Arbutus slab' => 'Arbutus Slab', 'Architects daughter' => 'Architects Daughter', 'Archivo black' => 'Archivo Black', 'Archivo narrow' => 'Archivo Narrow', 'Arimo' => 'Arimo', 'Arizonia' => 'Arizonia', 'Armata' => 'Armata', 'Artifika' => 'Artifika', 'Arvo' => 'Arvo', 'Arya' => 'Arya', 'Asap' => 'Asap', 'Asar' => 'Asar', 'Asset' => 'Asset', 'Astloch' => 'Astloch', 'Asul' => 'Asul', 'Atomic age' => 'Atomic Age', 'Aubrey' => 'Aubrey', 'Audiowide' => 'Audiowide', 'Autour one' => 'Autour One', 'Average' => 'Average', 'Average Sans' => 'Average Sans', 'Averia Gruesa Libre' => 'Averia Gruesa Libre', 'Averia Libre' => 'Averia Libre', 'Averia Sans Libre' => 'Averia Sans Libre', 'Averia Serif Libre' => 'Averia Serif Libre', 'Bad Script' => 'Bad Script', 'Balthazar' => 'Balthazar', 'Bangers' => 'Bangers', 'Basic' => 'Basic', 'Battambang' => 'Battambang', 'Baumans' => 'Baumans', 'Bayon' => 'Bayon', 'Belgrano' => 'Belgrano', 'BenchNine' => 'BenchNine', 'Bentham' => 'Bentham', 'Berkshire Swash' => 'Berkshire Swash', 'Bevan' => 'Bevan', 'Bigelow Rules' => 'Bigelow Rules', 'Bigshot One' => 'Bigshot One', 'Bilbo' => 'Bilbo', 'Bilbo Swash Caps' => 'Bilbo Swash Caps', 'Biryani' => 'Biryani', 'Bitter' => 'Bitter', 'Black Ops One' => 'Black Ops One', 'Bokor' => 'Bokor', 'Bonbon' => 'Bonbon', 'Boogaloo' => 'Boogaloo', 'Bowlby One' => 'Bowlby One', 'bowlby One SC' => 'Bowlby One SC', 'Brawler' => 'Brawler', 'Bree Serif' => 'Bree Serif', 'Bubblegum Sans' => 'Bubblegum Sans', 'Bubbler One' => 'Bubbler One', 'Buda' => 'Buda', 'Buda Light 300' => 'Buda Light 300', 'Buenard' => 'Buenard', 'Butcherman' => 'Butcherman', 'Butterfly Kids' => 'Butterfly Kids', 'Cabin' => 'Cabin', 'Cabin Condensed' => 'Cabin Condensed', 'Cabin Sketch' => 'Cabin Sketch', 'Caesar Dressing' => 'Caesar Dressing', 'Cagliostro' => 'Cagliostro', 'Calligraffitti' => 'Calligraffitti', 'Cambay' => 'Cambay', 'Cambo' => 'Cambo', 'Candal' => 'Candal', 'Cantarell' => 'Cantarell', 'Cantata One' => 'Cantata One', 'Cantora One' => 'Cantora One', 'Capriola' => 'Capriola', 'Cardo' => 'Cardo', 'Carme' => 'Carme', 'Carrois Gothic' => 'Carrois Gothic', 'Carrois Gothic SC' => 'Carrois Gothic SC', 'Carter One' => 'Carter One', 'Caudex' => 'Caudex', 'Caveat Brush' => 'Caveat Brush', 'Cedarville cursive' => 'Cedarville Cursive', 'Ceviche One' => 'Ceviche One', 'Changa One' => 'Changa One', 'Chango' => 'Chango', 'Chau philomene One' => 'Chau Philomene One', 'Chela One' => 'Chela One', 'Chelsea Market' => 'Chelsea Market', 'Chenla' => 'Chenla', 'Cherry Cream Soda' => 'Cherry Cream Soda', 'Chewy' => 'Chewy', 'Chicle' => 'Chicle', 'Chivo' => 'Chivo', 'Chonburi' => 'Chonburi', 'Cinzel' => 'Cinzel', 'Cinzel Decorative' => 'Cinzel Decorative', 'Clicker Script' => 'Clicker Script', 'Coda' => 'Coda', 'Coda Caption' => 'Coda Caption', 'Codystar' => 'Codystar', 'Combo' => 'Combo', 'Comfortaa' => 'Comfortaa', 'Coming soon' => 'Coming Soon', 'Concert One' => 'Concert One', 'Condiment' => 'Condiment', 'Content' => 'Content', 'Contrail One' => 'Contrail One', 'Convergence' => 'Convergence', 'Cookie' => 'Cookie', 'Copse' => 'Copse', 'Corben' => 'Corben', 'Courgette' => 'Courgette', 'Cousine' => 'Cousine', 'Coustard' => 'Coustard', 'Covered By Your Grace' => 'Covered By Your Grace', 'Crafty Girls' => 'Crafty Girls', 'Creepster' => 'Creepster', 'Crete Round' => 'Crete Round', 'Crimson Text' => 'Crimson Text', 'Croissant One' => 'Croissant One', 'Crushed' => 'Crushed', 'Cuprum' => 'Cuprum', 'Cutive' => 'Cutive', 'Cutive Mono' => 'Cutive Mono', 'Damion' => 'Damion', 'Dancing Script' => 'Dancing Script', 'Dangrek' => 'Dangrek', 'Dawning of a New Day' => 'Dawning of a New Day', 'Days One' => 'Days One', 'Dekko' => 'Dekko', 'Delius' => 'Delius', 'Delius Swash Caps' => 'Delius Swash Caps', 'Delius Unicase' => 'Delius Unicase', 'Della Respira' => 'Della Respira', 'Denk One' => 'Denk One', 'Devonshire' => 'Devonshire', 'Dhurjati' => 'Dhurjati', 'Didact Gothic' => 'Didact Gothic', 'Diplomata' => 'Diplomata', 'Diplomata SC' => 'Diplomata SC', 'Domine' => 'Domine', 'Donegal One' => 'Donegal One', 'Doppio One' => 'Doppio One', 'Dorsa' => 'Dorsa', 'Dosis' => 'Dosis', 'Dr Sugiyama' => 'Dr Sugiyama', 'Droid Sans' => 'Droid Sans', 'Droid Sans Mono' => 'Droid Sans Mono', 'Droid Serif' => 'Droid Serif', 'Duru Sans' => 'Duru Sans', 'Dynalight' => 'Dynalight', 'Eb Garamond' => 'EB Garamond', 'Eagle Lake' => 'Eagle Lake', 'Eater' => 'Eater', 'Economica' => 'Economica', 'Eczar' => 'Eczar', 'Ek Mukta' => 'Ek Mukta', 'Electrolize' => 'Electrolize', 'Elsie' => 'Elsie', 'Elsie Swash Caps' => 'Elsie Swash Caps', 'Emblema One' => 'Emblema One', 'Emilys Candy' => 'Emilys Candy', 'Engagement' => 'Engagement', 'Englebert' => 'Englebert', 'Enriqueta' => 'Enriqueta', 'Erica One' => 'Erica One', 'Esteban' => 'Esteban', 'Euphoria Script' => 'Euphoria Script', 'Ewert' => 'Ewert', 'Exo' => 'Exo', 'Exo 2' => 'Exo 2', 'Expletus Sans' => 'Expletus Sans', 'Fanwood Text' => 'Fanwood Text', 'Fascinate' => 'Fascinate', 'Fascinate Inline' => 'Fascinate Inline', 'Faster One' => 'Faster One', 'Fasthand' => 'Fasthand', 'Fauna One' => 'Fauna One', 'Federant' => 'Federant', 'Federo' => 'Federo', 'Felipa' => 'Felipa', 'Fenix' => 'Fenix', 'Finger Paint' => 'Finger Paint', 'Fira Mono' => 'Fira Mono', 'Fjalla One' => 'Fjalla One', 'Fjord One' => 'Fjord One', 'Flamenco' => 'Flamenco', 'Flavors' => 'Flavors', 'Fondamento' => 'Fondamento', 'Fontdiner swanky' => 'Fontdiner Swanky', 'Forum' => 'Forum', 'Francois One' => 'Francois One', 'Freckle Face' => 'Freckle Face', 'Fredericka the Great' => 'Fredericka the Great', 'Fredoka One' => 'Fredoka One', 'Freehand' => 'Freehand', 'Fresca' => 'Fresca', 'Frijole' => 'Frijole', 'Fruktur' => 'Fruktur', 'Fugaz One' => 'Fugaz One', 'GFS Didot' => 'GFS Didot', 'GFS Neohellenic' => 'GFS Neohellenic', 'Gabriela' => 'Gabriela', 'Gafata' => 'Gafata', 'Galdeano' => 'Galdeano', 'Galindo' => 'Galindo', 'Gentium Basic' => 'Gentium Basic', 'Gentium Book Basic' => 'Gentium Book Basic', 'Geo' => 'Geo', 'Geostar' => 'Geostar', 'Geostar Fill' => 'Geostar Fill', 'Germania One' => 'Germania One', 'Gidugu' => 'Gidugu', 'Gilda Display' => 'Gilda Display', 'Give You Glory' => 'Give You Glory', 'Glass Antiqua' => 'Glass Antiqua', 'Glegoo' => 'Glegoo', 'Gloria Hallelujah' => 'Gloria Hallelujah', 'Goblin One' => 'Goblin One', 'Gochi Hand' => 'Gochi Hand', 'Gorditas' => 'Gorditas', 'Goudy Bookletter 1911' => 'Goudy Bookletter 1911', 'Graduate' => 'Graduate', 'Grand Hotel' => 'Grand Hotel', 'Gravitas One' => 'Gravitas One', 'Great Vibes' => 'Great Vibes', 'Griffy' => 'Griffy', 'Gruppo' => 'Gruppo', 'Gudea' => 'Gudea', 'Gurajada' => 'Gurajada', 'Habibi' => 'Habibi', 'Halant' => 'Halant', 'Hammersmith One' => 'Hammersmith One', 'Hanalei' => 'Hanalei', 'Hanalei Fill' => 'Hanalei Fill', 'Handlee' => 'Handlee', 'Hanuman' => 'Hanuman', 'Happy Monkey' => 'Happy Monkey', 'Headland One' => 'Headland One', 'Henny Penny' => 'Henny Penny', 'Herr Von Muellerhoff' => 'Herr Von Muellerhoff', 'Hind' => 'Hind', 'Holtwood One  SC' => 'Holtwood One SC', 'Homemade Apple' => 'Homemade Apple', 'Homenaje' => 'Homenaje', 'IM Fell DW Pica' => 'IM Fell DW Pica', 'IM Fell DW Pica SC' => 'IM Fell DW Pica SC', 'IM Fell Double Pica' => 'IM Fell Double Pica', 'IM Fell Double Pica SC' => 'IM Fell Double Pica SC', 'IM Fell English' => 'IM Fell English', 'IM Fell English SC' => 'IM Fell English SC', 'IM Fell French Canon' => 'IM Fell French Canon', 'IM Fell French Canon SC' => 'IM Fell French Canon SC', 'IM Fell Great Primer' => 'IM Fell Great Primer', 'IM Fell Great Primer SC' => 'IM Fell Great Primer SC', 'Iceberg' => 'Iceberg', 'Iceland' => 'Iceland', 'Imprima' => 'Imprima', 'Inconsolata' => 'Inconsolata', 'Inder' => 'Inder', 'Indie Flower' => 'Indie Flower', 'Inika' => 'Inika', 'Inknut Antiqua' => 'Inknut Antiqua', 'Irish Grover' => 'Irish Grover', 'Istok Web' => 'Istok Web', 'Italiana' => 'Italiana', 'Italianno' => 'Italianno', 'Itim' => 'Itim', 'Jacques Francois' => 'Jacques Francois', 'Jacques Francois Shadow' => 'Jacques Francois Shadow', 'Jaldi' => 'Jaldi', 'Jim Nightshade' => 'Jim Nightshade', 'Jockey One' => 'Jockey One', 'Jolly Lodger' => 'Jolly Lodger', 'Josefin Sans' => 'Josefin Sans', 'Josefin Slab' => 'Josefin Slab', 'Joti One' => 'Joti One', 'Judson' => 'Judson', 'Julee' => 'Julee', 'Julius Sans One' => 'Julius Sans One', 'Junge' => 'Junge', 'Jura' => 'Jura', 'Just Another Hand' => 'Just Another Hand', 'Just Me Again Down Here' => 'Just Me Again Down Here', 'Kadwa' => 'Kadwa', 'Kameron' => 'Kameron', 'Kanit' => 'Kanit', 'Karla' => 'Karla', 'Kaushan Script' => 'Kaushan Script', 'Kavoon' => 'Kavoon', 'Keania One' => 'Keania One', 'kelly Slab' => 'Kelly Slab', 'Kenia' => 'Kenia', 'Khand' => 'Khand', 'Khmer' => 'Khmer', 'Khula' => 'Khula', 'Kite One' => 'Kite One', 'Knewave' => 'Knewave', 'Kotta One' => 'Kotta One', 'Koulen' => 'Koulen', 'Kranky' => 'Kranky', 'Kreon' => 'Kreon', 'Kristi' => 'Kristi', 'Krona One' => 'Krona One', 'Kurale' => 'Kurale', 'La Belle Aurore' => 'La Belle Aurore', 'Laila' => 'Laila', 'Lakki Reddy' => 'Lakki Reddy', 'Lancelot' => 'Lancelot', 'Lateef' => 'Lateef', 'Lato' => 'Lato', 'League Script' => 'League Script', 'Leckerli One' => 'Leckerli One', 'Ledger' => 'Ledger', 'Lekton' => 'Lekton', 'Lemon' => 'Lemon', 'Libre Baskerville' => 'Libre Baskerville', 'Life Savers' => 'Life Savers', 'Lilita One' => 'Lilita One', 'Lily Script One' => 'Lily Script One', 'Limelight' => 'Limelight', 'Linden Hill' => 'Linden Hill', 'Lobster' => 'Lobster', 'Lobster Two' => 'Lobster Two', 'Londrina Outline' => 'Londrina Outline', 'Londrina Shadow' => 'Londrina Shadow', 'Londrina Sketch' => 'Londrina Sketch', 'Londrina Solid' => 'Londrina Solid', 'Lora' => 'Lora', 'Love Ya Like A Sister' => 'Love Ya Like A Sister', 'Loved by the King' => 'Loved by the King', 'Lovers Quarrel' => 'Lovers Quarrel', 'Luckiest Guy' => 'Luckiest Guy', 'Lusitana' => 'Lusitana', 'Lustria' => 'Lustria', 'Macondo' => 'Macondo', 'Macondo Swash Caps' => 'Macondo Swash Caps', 'Magra' => 'Magra', 'Maiden Orange' => 'Maiden Orange', 'Mako' => 'Mako', 'Mandali' => 'Mandali', 'Marcellus' => 'Marcellus', 'Marcellus SC' => 'Marcellus SC', 'Marck Script' => 'Marck Script', 'Margarine' => 'Margarine', 'Marko One' => 'Marko One', 'Marmelad' => 'Marmelad', 'Martel' => 'Martel', 'Martel Sans' => 'Martel Sans', 'Marvel' => 'Marvel', 'Mate' => 'Mate', 'Mate SC' => 'Mate SC', 'Maven Pro' => 'Maven Pro', 'McLaren' => 'McLaren', 'Meddon' => 'Meddon', 'MedievalSharp' => 'MedievalSharp', 'Medula One' => 'Medula One', 'Megrim' => 'Megrim', 'Meie Script' => 'Meie Script', 'Merienda' => 'Merienda', 'Merienda One' => 'Merienda One', 'Merriweather' => 'Merriweather', 'Merriweather Sans' => 'Merriweather Sans', 'Metal' => 'Metal', 'Metal mania' => 'Metal Mania', 'Metamorphous' => 'Metamorphous', 'Metrophobic' => 'Metrophobic', 'Michroma' => 'Michroma', 'Milonga' => 'Milonga', 'Miltonian' => 'Miltonian', 'Miltonian Tattoo' => 'Miltonian Tattoo', 'Miniver' => 'Miniver', 'Miss Fajardose' => 'Miss Fajardose', 'Modak' => 'Modak', 'Modern Antiqua' => 'Modern Antiqua', 'Molengo' => 'Molengo', 'Molle' => 'Molle:400i', 'Monda' => 'Monda', 'Monofett' => 'Monofett', 'Monoton' => 'Monoton', 'Monsieur La Doulaise' => 'Monsieur La Doulaise', 'Montaga' => 'Montaga', 'Montez' => 'Montez', 'Montserrat' => 'Montserrat', 'Montserrat Alternates' => 'Montserrat Alternates', 'Montserrat Subrayada' => 'Montserrat Subrayada', 'Moul' => 'Moul', 'Moulpali' => 'Moulpali', 'Mountains of Christmas' => 'Mountains of Christmas', 'Mouse Memoirs' => 'Mouse Memoirs', 'Mr Bedfort' => 'Mr Bedfort', 'Mr Dafoe' => 'Mr Dafoe', 'Mr De Haviland' => 'Mr De Haviland', 'Mrs Saint Delafield' => 'Mrs Saint Delafield', 'Mrs Sheppards' => 'Mrs Sheppards', 'Muli' => 'Muli', 'Mystery Quest' => 'Mystery Quest', 'NTR' => 'NTR', 'Neucha' => 'Neucha', 'Neuton' => 'Neuton', 'New Rocker' => 'New Rocker', 'News Cycle' => 'News Cycle', 'Niconne' => 'Niconne', 'Nixie One' => 'Nixie One', 'Nobile' => 'Nobile', 'Nokora' => 'Nokora', 'Norican' => 'Norican', 'Nosifer' => 'Nosifer', 'Nothing You Could Do' => 'Nothing You Could Do', 'Noticia Text' => 'Noticia Text', 'Noto Sans' => 'Noto Sans', 'Noto Serif' => 'Noto Serif', 'Nova Cut' => 'Nova Cut', 'Nova Flat' => 'Nova Flat', 'Nova Mono' => 'Nova Mono', 'Nova Oval' => 'Nova Oval', 'Nova Round' => 'Nova Round', 'Nova Script' => 'Nova Script', 'Nova Slim' => 'Nova Slim', 'Nova Square' => 'Nova Square', 'Numans' => 'Numans', 'Nunito' => 'Nunito', 'Odor Mean Chey' => 'Odor Mean Chey', 'Offside' => 'Offside', 'Old standard tt' => 'Old Standard TT', 'Oldenburg' => 'Oldenburg', 'Oleo Script' => 'Oleo Script', 'Oleo Script Swash Caps' => 'Oleo Script Swash Caps', 'Open Sans' => 'Open Sans', 'Open Sans Condensed' => 'Open Sans Condensed:300', 'Oranienbaum' => 'Oranienbaum', 'Orbitron' => 'Orbitron', 'Oregano' => 'Oregano', 'Orienta' => 'Orienta', 'Original Surfer' => 'Original Surfer', 'Oswald' => 'Oswald', 'Over the Rainbow' => 'Over the Rainbow', 'Overlock' => 'Overlock', 'Overlock SC' => 'Overlock SC', 'Ovo' => 'Ovo', 'Oxygen' => 'Oxygen', 'Oxygen Mono' => 'Oxygen Mono', 'PT Mono' => 'PT Mono', 'PT Sans' => 'PT Sans', 'PT Sans Caption' => 'PT Sans Caption', 'PT Sans Narrow' => 'PT Sans Narrow', 'PT Serif' => 'PT Serif', 'PT Serif Caption' => 'PT Serif Caption', 'Pacifico' => 'Pacifico', 'Palanquin' => 'Palanquin', 'Palanquin Dark' => 'Palanquin Dark', 'Paprika' => 'Paprika', 'Parisienne' => 'Parisienne', 'Passero One' => 'Passero One', 'Passion One' => 'Passion One', 'Pathway Gothic One' => 'Pathway Gothic One', 'Patrick Hand' => 'Patrick Hand', 'Patrick Hand SC' => 'Patrick Hand SC', 'Patua One' => 'Patua One', 'Paytone One' => 'Paytone One', 'Peddana' => 'Peddana', 'Peralta' => 'Peralta', 'Permanent Marker' => 'Permanent Marker', 'Petit Formal Script' => 'Petit Formal Script', 'Petrona' => 'Petrona', 'Philosopher' => 'Philosopher', 'Piedra' => 'Piedra', 'Pinyon Script' => 'Pinyon Script', 'Pirata One' => 'Pirata One', 'Plaster' => 'Plaster', 'Play' => 'Play', 'Playball' => 'Playball', 'Playfair Display' => 'Playfair Display', 'Playfair Display SC' => 'Playfair Display SC', 'Podkova' => 'Podkova', 'Poiret One' => 'Poiret One', 'Poller One' => 'Poller One', 'Poly' => 'Poly', 'Pompiere' => 'Pompiere', 'Pontano Sans' => 'Pontano Sans', 'Poppins' => 'Poppins', 'Port Lligat Sans' => 'Port Lligat Sans', 'Port Lligat Slab' => 'Port Lligat Slab', 'Pragati Narrow' => 'Pragati Narrow', 'Prata' => 'Prata', 'Preahvihear' => 'Preahvihear', 'Press start 2P' => 'Press Start 2P', 'Princess Sofia' => 'Princess Sofia', 'Prociono' => 'Prociono', 'Prosto One' => 'Prosto One', 'Puritan' => 'Puritan', 'Purple Purse' => 'Purple Purse', 'Quando' => 'Quando', 'Quantico' => 'Quantico', 'Quattrocento' => 'Quattrocento', 'Quattrocento Sans' => 'Quattrocento Sans', 'Questrial' => 'Questrial', 'Quicksand' => 'Quicksand', 'Quintessential' => 'Quintessential', 'Qwigley' => 'Qwigley', 'Racing sans One' => 'Racing Sans One', 'Radley' => 'Radley', 'Rajdhani' => 'Rajdhani', 'Raleway' => 'Raleway', 'Raleway Dots' => 'Raleway Dots', 'Ramabhadra' => 'Ramabhadra', 'Ramaraja' => 'Ramaraja', 'Rambla' => 'Rambla', 'Rammetto One' => 'Rammetto One', 'Ranchers' => 'Ranchers', 'Rancho' => 'Rancho', 'Ranga' => 'Ranga', 'Rationale' => 'Rationale', 'Ravi Prakash' => 'Ravi Prakash', 'Redressed' => 'Redressed', 'Reenie Beanie' => 'Reenie Beanie', 'Revalia' => 'Revalia', 'Rhodium Libre' => 'Rhodium Libre', 'Ribeye' => 'Ribeye', 'Ribeye Marrow' => 'Ribeye Marrow', 'Righteous' => 'Righteous', 'Risque' => 'Risque', 'Roboto' => 'Roboto', 'Roboto Condensed' => 'Roboto Condensed', 'Roboto Mono' => 'Roboto Mono', 'Roboto Slab' => 'Roboto Slab', 'Rochester' => 'Rochester', 'Rock Salt' => 'Rock Salt', 'Rokkitt' => 'Rokkitt', 'Romanesco' => 'Romanesco', 'Ropa Sans' => 'Ropa Sans', 'Rosario' => 'Rosario', 'Rosarivo' => 'Rosarivo', 'Rouge Script' => 'Rouge Script', 'Rozha One' => 'Rozha One', 'Rubik' => 'Rubik', 'Rubik Mono One' => 'Rubik Mono One', 'Rubik One' => 'Rubik One', 'Ruda' => 'Ruda', 'Rufina' => 'Rufina', 'Ruge Boogie' => 'Ruge Boogie', 'Ruluko' => 'Ruluko', 'Rum Raisin' => 'Rum Raisin', 'Ruslan Display' => 'Ruslan Display', 'Russo One' => 'Russo One', 'Ruthie' => 'Ruthie', 'Rye' => 'Rye', 'Sacramento' => 'Sacramento', 'Sahitya' => 'Sahitya', 'Sail' => 'Sail', 'Salsa' => 'Salsa', 'Sanchez' => 'Sanchez', 'Sancreek' => 'Sancreek', 'Sansita One' => 'Sansita One', 'Sarina' => 'Sarina', 'Sarpanch' => 'Sarpanch', 'Satisfy' => 'Satisfy', 'Scada' => 'Scada', 'Schoolbell' => 'Schoolbell', 'Seaweed Script' => 'Seaweed Script', 'Sevillana' => 'Sevillana', 'Seymour One' => 'Seymour One', 'Shadows Into Light' => 'Shadows Into Light', 'Shadows Into Light Two' => 'Shadows Into Light Two', 'Shanti' => 'Shanti', 'Share' => 'Share', 'Share Tech' => 'Share Tech', 'Share Tech Mono' => 'Share Tech Mono', 'Shojumaru' => 'Shojumaru', 'Short Stack' => 'Short Stack', 'Siemreap' => 'Siemreap', 'Sigmar One' => 'Sigmar One', 'Signika' => 'Signika', 'Signika Negative' => 'Signika Negative', 'Simonetta' => 'Simonetta', 'Sintony' => 'Sintony', 'Sirin Stencil' => 'Sirin Stencil', 'Six Caps' => 'Six Caps', 'Skranji' => 'Skranji', 'Slabo 13px' => 'Slabo 13px', 'Slackey' => 'Slackey', 'Smokum' => 'Smokum', 'Smythe' => 'Smythe', 'Sniglet' => 'Sniglet', 'Snippet' => 'Snippet', 'Snowburst One' => 'Snowburst One', 'Sofadi One' => 'Sofadi One', 'Sofia' => 'Sofia', 'Sonsie One' => 'Sonsie One', 'Sorts Mill Goudy' => 'Sorts Mill Goudy', 'Source Code Pro' => 'Source Code Pro', 'Source Sans Pro' => 'Source Sans Pro', 'Source Serif Pro' => 'Source Serif Pro', 'Special Elite' => 'Special Elite', 'Spicy Rice' => 'Spicy Rice', 'Spinnaker' => 'Spinnaker', 'Spirax' => 'Spirax', 'Squada One' => 'Squada One', 'Sree Krushnadevaraya' => 'Sree Krushnadevaraya', 'Stalemate' => 'Stalemate', 'Stalinist One' => 'Stalinist One', 'Stardos Stencil' => 'Stardos Stencil', 'Stint Ultra Condensed' => 'Stint Ultra Condensed', 'Stint Ultra Expanded' => 'Stint Ultra Expanded', 'Stoke' => 'Stoke', 'Strait' => 'Strait', 'Sue Ellen Francisco' => 'Sue Ellen Francisco', 'Sumana' => 'Sumana', 'Sunshiney' => 'Sunshiney', 'Supermercado One' => 'Supermercado One', 'Sura' => 'Sura', 'Suranna' => 'Suranna', 'Suravaram' => 'Suravaram', 'Suwannaphum' => 'Suwannaphum', 'Swanky and Moo Moo' => 'Swanky and Moo Moo', 'Syncopate' => 'Syncopate', 'Tangerine' => 'Tangerine', 'Taprom' => 'Taprom', 'Tauri' => 'Tauri', 'Teko' => 'Teko', 'Telex' => 'Telex', 'Tenali Ramakrishna' => 'Tenali Ramakrishna', 'Tenor Sans' => 'Tenor Sans', 'Text Me One' => 'Text Me One', 'The Girl Next Door' => 'The Girl Next Door', 'Tienne' => 'Tienne', 'Tillana' => 'Tillana', 'Timmana' => 'Timmana', 'Tinos' => 'Tinos', 'Titan One' => 'Titan One', 'Titillium Web' => 'Titillium Web', 'Trade Winds' => 'Trade Winds', 'Trocchi' => 'Trocchi', 'Trochut' => 'Trochut', 'Trykker' => 'Trykker', 'Tulpen One' => 'Tulpen One', 'Ubuntu' => 'Ubuntu', 'Ubuntu Condensed' => 'Ubuntu Condensed', 'Ubuntu Mono' => 'Ubuntu Mono', 'Ultra' => 'Ultra', 'Uncial Antiqua' => 'Uncial Antiqua', 'Underdog' => 'Underdog', 'Unica One' => 'Unica One', 'UnifrakturCook' => 'UnifrakturCook', 'UnifrakturMaguntia' => 'UnifrakturMaguntia', 'Unkempt' => 'Unkempt', 'Unlock' => 'Unlock', 'Unna' => 'Unna', 'VT323' => 'VT323', 'Vampiro One' => 'Vampiro One', 'Varela' => 'Varela', 'Varela Round' => 'Varela Round', 'Vast Shadow' => 'Vast Shadow', 'Vibur' => 'Vibur', 'Vidaloka' => 'Vidaloka', 'Viga' => 'Viga', 'Voces' => 'Voces', 'Volkhov' => 'Volkhov', 'Vollkorn' => 'Vollkorn', 'Voltaire' => 'Voltaire', 'Waiting for the Sunrise' => 'Waiting for the Sunrise', 'Wallpoet' => 'Wallpoet', 'Walter Turncoat' => 'Walter Turncoat', 'Warnes' => 'Warnes', 'Wellfleet' => 'Wellfleet', 'Wendy One' => 'Wendy One', 'Wire One' => 'Wire One', 'Work Sans' => 'Work Sans', 'Yanone Kaffeesatz' => 'Yanone Kaffeesatz', 'Yantramanav' => 'Yantramanav', 'Yellowtail' => 'Yellowtail', 'Yeseva One' => 'Yeseva One', 'Yesteryear' => 'Yesteryear', 'Zeyada' => 'Zeyada');
    if ($possib_add_ffamily_google != '') {
      $possib_add_ffamily_google = explode("*WD*", $possib_add_ffamily_google);
        foreach($possib_add_ffamily_google as $possib_add_value_google) {
          if ($possib_add_value_google) {
            $google_fonts[$possib_add_value_google] = $possib_add_value_google;
          }
        }
    }
    return $google_fonts;
  }

  public static function no_items($title) {
    $title = ($title != '') ? strtolower($title) : 'items';
    ob_start();
    ?>
    <tr class="no-items">
      <td class="colspanchange" colspan="0"><?php echo sprintf(__('No %s found.', 'wds'), $title); ?></td>
    </tr>
    <?php
    return ob_get_clean();
  }

  public static function get_font_families() {
    $wds_global_options = get_option("wds_global_options", 0);
    $global_options = json_decode($wds_global_options);
    $possib_add_ffamily = isset($global_options->possib_add_ffamily) ? $global_options->possib_add_ffamily : '';
    $font_families = array(
      'arial' => 'Arial',
      'lucida grande' => 'Lucida grande',
      'segoe ui' => 'Segoe ui',
      'tahoma' => 'Tahoma',
      'trebuchet ms' => 'Trebuchet ms',
      'verdana' => 'Verdana',
      'cursive' =>'Cursive',
      'fantasy' => 'Fantasy',
      'monospace' => 'Monospace',
      'serif' => 'Serif',
    );
    if ($possib_add_ffamily != '') {
      $possib_add_ffamily = explode("*WD*", $possib_add_ffamily);
      foreach($possib_add_ffamily as $possib_add_value) {
        if ($possib_add_value) {
          $font_families[strtolower($possib_add_value)] = $possib_add_value;
        }
      }
    }
    return $font_families;
  }

  public static function validate_audio_file( $tmp ) {
    if ( !empty($tmp) ) {
      if ( preg_match('/^(http|https):\/\/([a-z0-9-]\.+)*/i', $tmp) ) {
        // check external link
        $pos = strpos($tmp, site_url());
        if ( $pos === FALSE ) {
          $ext = substr(strrchr($tmp, '.'), 1);
          switch ( $ext ) {
            case 'aac':
            case 'm4a':
            case 'f4a':
            case 'mp3':
            case 'ogg':
            case 'oga':
              return TRUE;
              break;
            default:
              return FALSE;
              break;
          }
        }
        else {
          if ( !class_exists('finfo') ) {
            return TRUE;
          }
          $allowed = array(
            'audio/mp4', // .aac,.m4a,.f4a,
            'audio/mpeg',
            'audio/x-mpeg',
            'audio/mpeg3',
            'audio/x-mpeg-3', // mp3
            'audio/ogg' // .ogg,.oga
          );
          $filePath = str_replace(site_url() . '/', ABSPATH, $tmp);
          if ( file_exists($filePath) ) {
            $filePath = str_replace(site_url() . '/', ABSPATH, $tmp);
            if ( file_exists($filePath) ) {
              $info = new finfo(FILEINFO_MIME);
              $type = $info->buffer(file_get_contents($tmp));
              if ( !empty($type) ) {
                $mime_t = explode(';', $type);
                $mime_type = $mime_t[0];
                // check to see if REAL MIME type is inside $allowed array
                if ( !empty($mime_type) && in_array($mime_type, $allowed) ) {
                  return TRUE;
                }
              }
            }
          }
        }
      }
    }

    return FALSE;
  }

  /**
   * Return option values.
   *
   * @return array
   */
  public static function get_values() {
    $values = array();
    $values['aligns'] = array(
      'left' => __('Left', 'wds'),
      'center' => __('Center', 'wds'),
      'right' => __('Right', 'wds'),
    );
    $values['border_styles'] = array(
      'none' => __('None', 'wds'),
      'solid' => __('Solid', 'wds'),
      'dotted' => __('Dotted', 'wds'),
      'dashed' => __('Dashed', 'wds'),
      'double' => __('Double', 'wds'),
      'groove' => __('Groove', 'wds'),
      'ridge' => __('Ridge', 'wds'),
      'inset' => __('Inset', 'wds'),
      'outset' => __('Outset', 'wds'),
    );
    $values['button_styles'] = array(
      'fa-chevron' => __('Chevron', 'wds'),
      'fa-angle' => __('Angle', 'wds'),
      'fa-angle-double' => __('Double', 'wds'),
    );
    $values['bull_styles'] = array(
      'fa-circle-o' => __('Circle O', 'wds'),
      'fa-circle' => __('Circle', 'wds'),
      'fa-minus' => __('Minus', 'wds'),
      'fa-square-o' => __('Square O', 'wds'),
      'fa-square' => __('Square', 'wds'),
    );
    $values['font_families'] = WDW_S_Library::get_font_families();
    $values['google_fonts'] = WDW_S_Library::get_google_fonts();
    $values['font_weights'] = array(
      'lighter' => __('Lighter', 'wds'),
      'normal' => __('Normal', 'wds'),
      'bold' => __('Bold', 'wds'),
    );
    $values['social_buttons'] = array(
      'facebook' => __('Facebook', 'wds'),
      'google-plus' => __('Google+', 'wds'),
      'twitter' => __('Twitter', 'wds'),
      'pinterest' => __('Pinterest', 'wds'),
      'tumblr' => __('Tumblr', 'wds'),
    );
    $values['effects'] = array(
      'none' => __('None', 'wds'),
      'zoomFade' => __('Zoom Fade', 'wds'),
      'parallelSlideH' => __('Parallel Slide Horizontal', 'wds'),
      'parallelSlideV' => __('Parallel Slide Vertical', 'wds'),
      'slic3DH' => __('Slice 3D Horizontal', 'wds'),
      'slic3DV' => __('Slice 3D Vertical', 'wds'),
      'slicR3DH' => __('Slice 3D Horizontal Random', 'wds'),
      'slicR3DV' => __('Slice 3D Vertical Random', 'wds'),
      'blindR' => __('Blind', 'wds'),
      'tilesR' => __('Tiles', 'wds'),
      'blockScaleR' => __('Block Scale Random', 'wds'),
      'cubeH' => __('Cube Horizontal', 'wds'),
      'cubeV' => __('Cube Vertical', 'wds'),
      'cubeR' => __('Cube Random', 'wds'),
      'fade' => __('Fade', 'wds'),
      'sliceH' => __('Slice Horizontal', 'wds'),
      'sliceV' => __('Slice Vertical', 'wds'),
      'slideH' => __('Slide Horizontal', 'wds'),
      'slideV' => __('Slide Vertical', 'wds'),
      'scaleOut' => __('Scale Out', 'wds'),
      'scaleIn' => __('Scale In', 'wds'),
      'blockScale' => __('Block Scale', 'wds'),
      'kaleidoscope' => __('Kaleidoscope', 'wds'),
      'fan' => __('Fan', 'wds'),
      'blindH' => __('Blind Horizontal', 'wds'),
      'blindV' => __('Blind Vertical', 'wds'),
      'random' => __('Random', 'wds'),
      '3Drandom' => __('3D Random', 'wds'),
    );
    $values['layer_effects_in'] = array(
      'none' => __('None', 'wds'),
      'bounce' => __('Bounce', 'wds'),
      'flash' => __('Flash', 'wds'),
      'pulse' => __('Pulse', 'wds'),
      'rubberBand' => __('RubberBand', 'wds'),
      'shake' => __('Shake', 'wds'),
      'swing' => __('Swing', 'wds'),
      'tada' => __('Tada', 'wds'),
      'wobble' => __('Wobble', 'wds'),
      'hinge' => __('Hinge', 'wds'),

      'lightSpeedIn' => __('LightSpeedIn', 'wds'),
      'rollIn' => __('RollIn', 'wds'),

      'bounceIn' => __('BounceIn', 'wds'),
      'bounceInDown' => __('BounceInDown', 'wds'),
      'bounceInLeft' => __('BounceInLeft', 'wds'),
      'bounceInRight' => __('BounceInRight', 'wds'),
      'bounceInUp' => __('BounceInUp', 'wds'),

      'fadeIn' => __('FadeIn', 'wds'),
      'fadeInDown' => __('FadeInDown', 'wds'),
      'fadeInDownBig' => __('FadeInDownBig', 'wds'),
      'fadeInLeft' => __('FadeInLeft', 'wds'),
      'fadeInLeftBig' => __('FadeInLeftBig', 'wds'),
      'fadeInRight' => __('FadeInRight', 'wds'),
      'fadeInRightBig' => __('FadeInRightBig', 'wds'),
      'fadeInUp' => __('FadeInUp', 'wds'),
      'fadeInUpBig' => __('FadeInUpBig', 'wds'),

      'flip' => __('Flip', 'wds'),
      'flipInX' => __('FlipInX', 'wds'),
      'flipInY' => __('FlipInY', 'wds'),

      'rotateIn' => __('RotateIn', 'wds'),
      'rotateInDownLeft' => __('RotateInDownLeft', 'wds'),
      'rotateInDownRight' => __('RotateInDownRight', 'wds'),
      'rotateInUpLeft' => __('RotateInUpLeft', 'wds'),
      'rotateInUpRight' => __('RotateInUpRight', 'wds'),

      'zoomIn' => __('ZoomIn', 'wds'),
      'zoomInDown' => __('ZoomInDown', 'wds'),
      'zoomInLeft' => __('ZoomInLeft', 'wds'),
      'zoomInRight' => __('ZoomInRight', 'wds'),
      'zoomInUp' => __('ZoomInUp', 'wds'),
    );
    $values['layer_effects_out'] = array(
      'none' => __('None', 'wds'),
      'bounce' => __('Bounce', 'wds'),
      'flash' => __('Flash', 'wds'),
      'pulse' => __('Pulse', 'wds'),
      'rubberBand' => __('RubberBand', 'wds'),
      'shake' => __('Shake', 'wds'),
      'swing' => __('Swing', 'wds'),
      'tada' => __('Tada', 'wds'),
      'wobble' => __('Wobble', 'wds'),
      'hinge' => __('Hinge', 'wds'),

      'lightSpeedOut' => __('LightSpeedOut', 'wds'),
      'rollOut' => __('RollOut', 'wds'),

      'bounceOut' => __('BounceOut', 'wds'),
      'bounceOutDown' => __('BounceOutDown', 'wds'),
      'bounceOutLeft' => __('BounceOutLeft', 'wds'),
      'bounceOutRight' => __('BounceOutRight', 'wds'),
      'bounceOutUp' => __('BounceOutUp', 'wds'),

      'fadeOut' => __('FadeOut', 'wds'),
      'fadeOutDown' => __('FadeOutDown', 'wds'),
      'fadeOutDownBig' => __('FadeOutDownBig', 'wds'),
      'fadeOutLeft' => __('FadeOutLeft', 'wds'),
      'fadeOutLeftBig' => __('FadeOutLeftBig', 'wds'),
      'fadeOutRight' => __('FadeOutRight', 'wds'),
      'fadeOutRightBig' => __('FadeOutRightBig', 'wds'),
      'fadeOutUp' => __('FadeOutUp', 'wds'),
      'fadeOutUpBig' => __('FadeOutUpBig', 'wds'),

      'flip' => __('Flip', 'wds'),
      'flipOutX' => __('FlipOutX', 'wds'),
      'flipOutY' => __('FlipOutY', 'wds'),

      'rotateOut' => __('RotateOut', 'wds'),
      'rotateOutDownLeft' => __('RotateOutDownLeft', 'wds'),
      'rotateOutDownRight' => __('RotateOutDownRight', 'wds'),
      'rotateOutUpLeft' => __('RotateOutUpLeft', 'wds'),
      'rotateOutUpRight' => __('RotateOutUpRight', 'wds'),

      'zoomOut' => __('ZoomOut', 'wds'),
      'zoomOutDown' => __('ZoomOutDown', 'wds'),
      'zoomOutLeft' => __('ZoomOutLeft', 'wds'),
      'zoomOutRight' => __('ZoomOutRight', 'wds'),
      'zoomOutUp' => __('ZoomOutUp', 'wds'),
    );
    $values['hotp_text_positions'] = array(
      'top' => __('Top', 'wds'),
      'left' => __('Left', 'wds'),
      'bottom' => __('Bottom', 'wds'),
      'right' => __('Right', 'wds'),
    );
    $values['slider_callbacks'] = array(
      'onSliderI' => __('On slider Init', 'wds'),
      'onSliderCS' => __('On slide change start', 'wds'),
      'onSliderCE' => __('On slide change end', 'wds'),
      'onSliderPlay' => __('On slide play', 'wds'),
      'onSliderPause' => __('On slide pause', 'wds'),
      'onSliderHover' => __('On slide hover', 'wds'),
      'onSliderBlur' => __('On slide blur', 'wds'),
      'onSliderR' => __('On slider resize', 'wds'),
      'onSwipeS' => __('On swipe start', 'wds'),
    );
    $values['layer_callbacks'] = array(
      '' => __('Select action', 'wds'),
      'SlidePlay' => __('Play', 'wds'),
      'SlidePause' => __('Pause', 'wds'),
      'SlidePlayPause' => __('Play/Pause', 'wds'),
      'SlideNext' => __('Next slide', 'wds'),
      'SlidePrevious' => __('Previous slide', 'wds'),
      'SlideLink' => __('Link to slide', 'wds'),
      'PlayMusic' => __('Play music', 'wds'),
    );
    $values['text_alignments'] = array(
      'left' => __('Left', 'wds'),
      'center' => __('Center', 'wds'),
      'right' => __('Right', 'wds')
    );
    $values['built_in_watermark_fonts'] = array();
    foreach (scandir(path_join(WD_S_DIR, 'fonts')) as $filename) {
      if (strpos($filename, '.') === 0) {
        continue;
      }
      else {
        $values['built_in_watermark_fonts'][] = $filename;
      }
    }

    return $values;
  }

   /**
   * Get slider by id.
   *
   * @param  int      $id
   * @return object   $slider
   */
	public static function get_slider_by_id( $id ) {
		require_once WD_S_DIR . "/frontend/models/WDSModelSlider.php";
		$model = new WDSModelSlider();
		$slider = $model->get_slider_row_data( $id );
		return $slider;
	}

	/**
	* Get slides by slider id.
	*
	* @param  int      $slider_id
	* @param  string   $order
	* @return object   $slides
    */
	public static function get_slides_by_slider_id( $id , $order) {
		require_once WD_S_DIR . "/frontend/models/WDSModelSlider.php";
		$model = new WDSModelSlider();
		$slider = $model->get_slide_rows_data( $id , $order );
		return $slider;
	}

	/**
	* Get layers by slider id and slide_ids.
	*
	* @param  int      $slider_id
	* @param  array    $slide_ids
	* @return object   $layers
    */
	public static function get_layers_by_slider_id_slide_ids( $slider_id, $slide_ids ) {
		require_once WD_S_DIR . "/frontend/models/WDSModelSlider.php";
		$model = new WDSModelSlider();
		$layers = $model->get_layers_by_slider_id_slide_ids( $slider_id, $slide_ids );
		return $layers;
	}

   /**
   * Create frontend js file.
   *
   * @param int    $slider_id
   * @param bool   $bool
   */
	public static function create_frontend_js_file( $slider_id ) {
		global $wpdb;
		$wp_upload_dir = wp_upload_dir();
		if ( !is_dir($wp_upload_dir['basedir'] . '/slider-wd-scripts')) {
			mkdir($wp_upload_dir['basedir'] . '/slider-wd-scripts', 0755);
		}
		$error = false;
		$bool  = false;
		$slider = array();
		$slides = array();
		$layers_rows = array();
		// Get slider.
		$slider = WDW_S_Library::get_slider_by_id( $slider_id );
		if ( !empty($slider) ) {
			// Get slider slides.
			$order_dir = isset($slider->order_dir) ? $slider->order_dir : 'asc';
			$slides = WDW_S_Library::get_slides_by_slider_id( $slider_id, $order_dir );
			if ( !empty($slides) ) {
				foreach ( $slides as $slide ) {
					$slide_ids[] = $slide->id;
				}
				// Get slider slides layers.
				$layers_rows = WDW_S_Library::get_layers_by_slider_id_slide_ids( $slider_id, $slide_ids );
			}
		}
		$content = WDW_S_Library::create_js( $slider, $slides, $layers_rows );
		$file = $wp_upload_dir['basedir'] . '/slider-wd-scripts/script-' . $slider_id . '.js';
		$file_put = file_put_contents($file, $content);
		if ( is_file($file) ) {
			$bool = true;
		}
		return $bool;
	}

	/**
	*
	* @param array   $slider
	* @param array 	 $slides
	* @param array 	 $layers_rows
	* @param int 	 $wds
	* @return string $js_content
	*
	*/
	public static function create_js( $slider, $slides, $layers_rows, $wds ) {
		$image_right_click = $slider->image_right_click;
		$callback_items = isset($slider->javascript) ? json_decode(htmlspecialchars_decode($slider->javascript, ENT_COMPAT | ENT_QUOTES), TRUE) : array();
		$bull_hover = isset($slider->bull_hover) ? $slider->bull_hover : 1;
		$bull_position = $slider->bull_position;
		$bull_style_active = str_replace('-o', '', $slider->bull_style);
		$bull_style_deactive = $slider->bull_style;

		$image_width = $slider->width;
		$image_height = $slider->height;

		$slides_count = count($slides);
		$slideshow_effect = $slider->effect == 'zoomFade' ? 'fade' : $slider->effect;
		$slideshow_interval = $slider->time_intervval;

		$enable_slideshow_shuffle = $slider->shuffle;
		$enable_prev_next_butt = $slider->prev_next_butt;
		$mouse_swipe_nav = isset($slider->mouse_swipe_nav) ? $slider->mouse_swipe_nav : 0;
		$touch_swipe_nav = isset($slider->touch_swipe_nav) ? $slider->touch_swipe_nav : 1;
		$mouse_wheel_nav = isset($slider->mouse_wheel_nav) ? $slider->mouse_wheel_nav : 0;
		$keyboard_nav = isset($slider->keyboard_nav) ? $slider->keyboard_nav : 0;
		$enable_play_paus_butt = $slider->play_paus_butt;

		if (!$enable_prev_next_butt && !$enable_play_paus_butt) {
		  $enable_slideshow_autoplay = 1;
		}
		else {
		  $enable_slideshow_autoplay = $slider->autoplay;
		}

		$autoplay = FALSE;
		if ($enable_slideshow_autoplay && !$enable_play_paus_butt && ($slides_count > 1)) {
		  $autoplay = TRUE;
		}

		$navigation = 4000;
		if ($slider->navigation == 'always') {
		  $navigation = 0;
		}

		$enable_slideshow_music = $slider->music;
		$slideshow_music_url = $slider->music_url;
		$filmstrip_direction = ($slider->film_pos == 'right' || $slider->film_pos == 'left') ? 'vertical' : 'horizontal';
		$filmstrip_position = $slider->film_pos;
		$filmstrip_thumb_margin_hor = $slider->film_tmb_margin;
		if ($filmstrip_position != 'none') {
		  if ($filmstrip_direction == 'horizontal') {
			$filmstrip_width = $slider->film_thumb_width;
			$filmstrip_height = $slider->film_thumb_height;
		  }
		  else {
			$filmstrip_width = $slider->film_thumb_width;
			$filmstrip_height = $slider->film_thumb_height;
		  }
		}
		else {
		  $filmstrip_width = 0;
		  $filmstrip_height = 0;
		}
		$left_or_top = 'left';
		$width_or_height = 'width';
		$outerWidth_or_outerHeight = 'outerWidth';
		if (!($filmstrip_direction == 'horizontal')) {
		  $left_or_top = 'top';
		  $width_or_height = 'height';
		  $outerWidth_or_outerHeight = 'outerHeight';
		}

		$slide_ids = array();
		foreach ($slides as $slide) {
			$slide_ids[] = $slide->id;
		}

		if ($enable_slideshow_shuffle || ($slider->start_slide_num == 0)) {
			$current_image_id = $slide_ids[array_rand($slide_ids)];
			$start_slide_num = array_search($current_image_id, $slide_ids);
		}
		else {
		  if ($slider->start_slide_num > 0 && $slider->start_slide_num <= $slides_count) {
			$start_slide_num = $slider->start_slide_num - 1;
		  }
		  else {
			$start_slide_num = 0;
		  }
		}
		$parallax_effect = $slider->parallax_effect;

		$carousel = isset($slider->carousel) ? $slider->carousel : FALSE;
		$carousel_image_parameters = $slider->carousel_image_parameters;
		$carousel_image_counts = $slider->carousel_image_counts;
		$carousel_fit_containerWidth = $slider->carousel_fit_containerWidth;
		$carousel_width = $slider->carousel_width;
		$preload_images = $slider->carousel ? FALSE : $slider->preload_images;
		$smart_crop = isset($slider->smart_crop) ? $slider->smart_crop : 0;
		$crop_image_position = isset($slider->crop_image_position) ? $slider->crop_image_position : 'center center';
		$carousel_degree = isset($slider->carousel_degree) ? $slider->carousel_degree : 0;
		$carousel_grayscale = isset($slider->carousel_grayscale) ? $slider->carousel_grayscale : 0;
		$carousel_transparency = isset($slider->carousel_transparency) ? $slider->carousel_transparency : 0;
		$slider_loop = isset($slider->slider_loop) ? $slider->slider_loop : 1;
		$twoway_slideshow = isset($slider->twoway_slideshow) ? (int) $slider->twoway_slideshow : 0;
		$fixed_bg = (isset($slider->fixed_bg) && !$carousel) ? $slider->fixed_bg : 0;
		$current_image_url = '';
		ob_start();
?>
	var wds_glb_margin_<?php echo $wds; ?> = parseInt(<?php echo $slider->glb_margin; ?>);
	var wds_data_<?php echo $wds; ?> = [];
	var wds_event_stack_<?php echo $wds; ?> = [];
	var wds_clear_layers_effects_in_<?php echo $wds; ?> = [];
	var wds_clear_layers_effects_out_<?php echo $wds; ?> = [];
	var wds_clear_layers_effects_out_before_change_<?php echo $wds; ?> = [];
	<?php if ( $slider->layer_out_next ) { ?>
	var wds_duration_for_change_<?php echo $wds; ?> = 500;
	var wds_duration_for_clear_effects_<?php echo $wds; ?> = 530;
	<?php } else { ?>
	var wds_duration_for_change_<?php echo $wds; ?> = 0;
	var wds_duration_for_clear_effects_<?php echo $wds; ?> = 0;
	<?php }
	foreach ($slides as $key => $slide_row) { ?>
		wds_clear_layers_effects_in_<?php echo $wds; ?>["<?php echo $key; ?>"] = [];
		wds_clear_layers_effects_out_<?php echo $wds; ?>["<?php echo $key; ?>"] = [];
		wds_clear_layers_effects_out_before_change_<?php echo $wds; ?>["<?php echo $key; ?>"] = [];
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"] = [];
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["id"] = "<?php echo $slide_row->id; ?>";
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["image_url"] = "<?php echo addslashes(htmlspecialchars_decode($slide_row->image_url, ENT_QUOTES)); ?>";
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["thumb_url"] = "<?php echo addslashes(htmlspecialchars_decode($slide_row->thumb_url, ENT_QUOTES)); ?>";
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["is_video"] = "<?php echo $slide_row->type; ?>";
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["slide_layers_count"] = 0;
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["target_attr_slide"] = "<?php echo $slide_row->target_attr_slide; ?>";
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["link"] = "<?php echo $slide_row->link; ?>";
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["bg_fit"] = "<?php echo $slider->bg_fit; ?>";
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["bull_position"] = "<?php echo $bull_position; ?>";
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["width"] = "<?php echo $slide_row->att_width; ?>";
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["height"] = "<?php echo $slide_row->att_height; ?>";
		wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["image_thumb_url"] = "<?php echo is_numeric($slide_row->thumb_url) ? (wp_get_attachment_url(get_post_thumbnail_id($slide_row->thumb_url)) ? wp_get_attachment_url(get_post_thumbnail_id($slide_row->thumb_url)) : WD_S_URL . '/images/no-video.png' ): htmlspecialchars_decode($slide_row->thumb_url,ENT_QUOTES) ?>";
		<?php
		if (isset($layers_rows[$slide_row->id]) && !empty($layers_rows[$slide_row->id])) {
		  foreach ($layers_rows[$slide_row->id] as $layer_key => $layer) {
			if (!isset($layer->align_layer)) {
			  $layer->align_layer = 0;
			}
			if (!isset($layer->infinite_in)) {
			  $layer->infinite_in = 1;
			}
			if (!isset($layer->infinite_out)) {
			  $layer->infinite_out = 1;
			}
			if (!isset($layer->min_size)) {
			  $layer->min_size = 11;
			}
			?>
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_id"] = "<?php echo $layer->id; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_layer_effect_in"] = "<?php echo $layer->layer_effect_in; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_duration_eff_in"] = "<?php echo $layer->duration_eff_in; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_layer_effect_out"] = "<?php echo $layer->layer_effect_out; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_duration_eff_out"] = "<?php echo $layer->duration_eff_out; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_social_button"] = "<?php echo $layer->social_button; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_start"] = "<?php echo $layer->start; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_end"] = "<?php echo $layer->end; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_type"] = "<?php echo $layer->type; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_video_autoplay"] = "<?php echo $layer->image_scale; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_controls"] = "<?php echo $layer->target_attr_layer; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_attr_width"] = "<?php echo $layer->attr_width; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_attr_height"] = "<?php echo $layer->attr_height; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_align_layer"] = "<?php echo $layer->align_layer; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["slide_layers_count"] ++;
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_infinite_in"] = "<?php echo $layer->infinite_in; ?>";
			wds_data_<?php echo $wds; ?>["<?php echo $key; ?>"]["layer_<?php echo $layer_key; ?>_infinite_out"] = "<?php echo $layer->infinite_out; ?>";
			<?php
			}
		}
	}
	?>
	var wds_global_btn_<?php echo $wds; ?> = "right";
	var wds_trans_in_progress_<?php echo $wds; ?> = false;
	var video_is_playing_<?php echo $wds; ?> = false;
	var iframe_message_sent_<?php echo $wds; ?> = 0;
	var iframe_message_received_<?php echo $wds; ?> = 0;
	var wds_transition_duration_<?php echo $wds; ?> = <?php echo $slider->effect_duration; ?>;
	var youtube_iframes_<?php echo $wds; ?> = [];
	var youtube_iframes_ids_<?php echo $wds; ?> = [];
	if (<?php echo $slideshow_interval; ?> < 4) {
	if (<?php echo $slideshow_interval; ?> != 0) {
	  wds_transition_duration_<?php echo $wds; ?> = (<?php echo $slideshow_interval; ?> * 1000) / 4;
	}
	}
	var wds_playInterval_<?php echo $wds; ?>;
	var progress = 0;
	var bottom_right_deggree_<?php echo $wds; ?>;
	var bottom_left_deggree_<?php echo $wds; ?>;
	var top_left_deggree_<?php echo $wds; ?>;
	var curent_time_deggree_<?php echo $wds; ?> = 0;
	var circle_timer_animate_<?php echo $wds; ?>;
	function circle_timer_<?php echo $wds; ?>(angle) {
	circle_timer_animate_<?php echo $wds; ?> = jQuery({deg: angle}).animate({deg: 360}, {
	  duration: <?php echo $slideshow_interval * 1000; ?>,
	  step: function(now) {
		curent_time_deggree_<?php echo $wds; ?> = now;
		if (now >= 0) {
		  if (now < 271) {
			jQuery('#top_right_<?php echo $wds; ?>').css({
			  '-moz-transform':'rotate('+now+'deg)',
			  '-webkit-transform':'rotate('+now+'deg)',
			  '-o-transform':'rotate('+now+'deg)',
			  '-ms-transform':'rotate('+now+'deg)',
			  'transform':'rotate('+now+'deg)',
			  '-webkit-transform-origin': 'left bottom',
			  '-ms-transform-origin': 'left bottom',
			  '-moz-transform-origin': 'left bottom',
			  'transform-origin': 'left bottom'
			});
		  }
		}
		if (now >= 90) {
		  if (now < 271) {
			bottom_right_deggree_<?php echo $wds; ?> = now - 90;
			jQuery('#bottom_right_<?php echo $wds; ?>').css({
			  '-moz-transform':'rotate('+bottom_right_deggree_<?php echo $wds; ?> +'deg)',
			'-webkit-transform':'rotate('+bottom_right_deggree_<?php echo $wds; ?> +'deg)',
			'-o-transform':'rotate('+bottom_right_deggree_<?php echo $wds; ?> +'deg)',
			'-ms-transform':'rotate('+bottom_right_deggree_<?php echo $wds; ?> +'deg)',
			'transform':'rotate('+bottom_right_deggree_<?php echo $wds; ?> +'deg)',
			'-webkit-transform-origin': 'left top',
			'-ms-transform-origin': 'left top',
			'-moz-transform-origin': 'left top',
			'transform-origin': 'left top'
			});
		  }
		}
		if (now >= 180) {
		  if (now < 361) {
			bottom_left_deggree_<?php echo $wds; ?> = now - 180;
			jQuery('#bottom_left_<?php echo $wds; ?>').css({
			  '-moz-transform':'rotate('+bottom_left_deggree_<?php echo $wds; ?> +'deg)',
			  '-webkit-transform':'rotate('+bottom_left_deggree_<?php echo $wds; ?> +'deg)',
			  '-o-transform':'rotate('+bottom_left_deggree_<?php echo $wds; ?> +'deg)',
			  '-ms-transform':'rotate('+bottom_left_deggree_<?php echo $wds; ?> +'deg)',
			  'transform':'rotate('+bottom_left_deggree_<?php echo $wds; ?> +'deg)',
			  '-webkit-transform-origin': 'right top',
			  '-ms-transform-origin': 'right top',
			  '-moz-transform-origin': 'right top',
			  'transform-origin': 'right top'
			});
		  }
		}
		if (now >= 270) {
		  if (now < 361) {
			top_left_deggree_<?php echo $wds; ?>  = now - 270;
			jQuery('#top_left_<?php echo $wds; ?>').css({
			  '-moz-transform':'rotate('+top_left_deggree_<?php echo $wds; ?> +'deg)',
			  '-webkit-transform':'rotate('+top_left_deggree_<?php echo $wds; ?> +'deg)',
			  '-o-transform':'rotate('+top_left_deggree_<?php echo $wds; ?> +'deg)',
			  '-ms-transform':'rotate('+top_left_deggree_<?php echo $wds; ?> +'deg)',
			  'transform':'rotate('+top_left_deggree_<?php echo $wds; ?> +'deg)',
			  '-webkit-transform-origin': 'right bottom',
			  '-ms-transform-origin': 'right bottom',
			  '-moz-transform-origin': 'right bottom',
			  'transform-origin': 'right bottom'
			});
		  }
		}
	  }
	});
	}
	/* Stop autoplay.*/
	window.clearInterval(wds_playInterval_<?php echo $wds; ?>);
	var wds_current_key_<?php echo $wds; ?> = '<?php echo (isset($current_key) ? $current_key : ''); ?>';
	var wds_current_filmstrip_pos_<?php echo $wds; ?> = wds_current_key_<?php echo $wds; ?> * jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").<?php echo $width_or_height; ?>() / <?php echo $slides_count; ?>;
	/* Set filmstrip initial position.*/
	function wds_set_filmstrip_pos_<?php echo $wds; ?>(filmStripWidth) {
	var selectedImagePos = -(wds_current_key_<?php echo $wds; ?> * jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").<?php echo $width_or_height; ?>() / <?php echo $slides_count; ?>) - jQuery(".wds_slideshow_filmstrip_thumbnail_<?php echo $wds; ?>").<?php echo $width_or_height; ?>() / 2;
	var imagesContainerLeft = Math.min(0, Math.max(filmStripWidth - jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").<?php echo $width_or_height; ?>(), selectedImagePos + filmStripWidth / 2));
	jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").animate({
		<?php echo $left_or_top; ?>: imagesContainerLeft
	  }, {
		duration: 500,
		complete: function () { wds_filmstrip_arrows_<?php echo $wds; ?>(); }
	  });
	}
	function wds_move_filmstrip_<?php echo $wds; ?>() {
	var image_left = jQuery(".wds_slideshow_thumb_active_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?>;
	var image_right = jQuery(".wds_slideshow_thumb_active_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?> + jQuery(".wds_slideshow_thumb_active_<?php echo $wds; ?>").<?php echo $outerWidth_or_outerHeight; ?>(true);
	var wds_filmstrip_width = jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").<?php echo $outerWidth_or_outerHeight; ?>(true);
	var wds_filmstrip_thumbnails_width = jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").<?php echo $outerWidth_or_outerHeight; ?>(true);
	var long_filmstrip_cont_left = jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?>;
	var long_filmstrip_cont_right = Math.abs(jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?>) + wds_filmstrip_width;
	if (wds_filmstrip_width > wds_filmstrip_thumbnails_width) {
	  return;
	}
	if (image_left < Math.abs(long_filmstrip_cont_left)) {
	  jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").animate({
		<?php echo $left_or_top; ?>: -image_left
	  }, {
		duration: 500,
		complete: function () { wds_filmstrip_arrows_<?php echo $wds; ?>(); }
	  });
	}
	else if (image_right > long_filmstrip_cont_right) {
	  jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").animate({
		<?php echo $left_or_top; ?>: -(image_right - wds_filmstrip_width)
	  }, {
		duration: 500,
		complete: function () { wds_filmstrip_arrows_<?php echo $wds; ?>(); }
	  });
	}
	}
	function wds_move_dots_<?php echo $wds; ?>() {
	var image_left = jQuery(".wds_slideshow_dots_active_<?php echo $wds; ?>").position().left;
	var image_right = jQuery(".wds_slideshow_dots_active_<?php echo $wds; ?>").position().left + jQuery(".wds_slideshow_dots_active_<?php echo $wds; ?>").outerWidth(true);
	var wds_dots_width = jQuery(".wds_slideshow_dots_container_<?php echo $wds; ?>").outerWidth(true);
	var wds_dots_thumbnails_width = jQuery(".wds_slideshow_dots_thumbnails_<?php echo $wds; ?>").outerWidth(true);
	var long_filmstrip_cont_left = jQuery(".wds_slideshow_dots_thumbnails_<?php echo $wds; ?>").position().left;
	var long_filmstrip_cont_right = Math.abs(jQuery(".wds_slideshow_dots_thumbnails_<?php echo $wds; ?>").position().left) + wds_dots_width;
	<?php if ( !$carousel ) { ?>
	  if(wds_dots_width > wds_dots_thumbnails_width) {
		return;
	  }
	<?php } ?>
	if (image_left < Math.abs(long_filmstrip_cont_left)) {
	  jQuery(".wds_slideshow_dots_thumbnails_<?php echo $wds; ?>").animate({
		left: -image_left
	  }, {
		duration: 500
	  });
	}
	else if (image_right > long_filmstrip_cont_right) {
	  jQuery(".wds_slideshow_dots_thumbnails_<?php echo $wds; ?>").animate({
		left: -(image_right - wds_dots_width)
	  }, {
		duration: 500
	  });
	}
	}
	/* Show/hide filmstrip arrows.*/
	function wds_filmstrip_arrows_<?php echo $wds; ?>() {
	if (jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").<?php echo $width_or_height; ?>() < jQuery(".wds_slideshow_filmstrip_<?php echo $wds; ?>").<?php echo $width_or_height; ?>()) {
	  jQuery(".wds_slideshow_filmstrip_left_<?php echo $wds; ?>").hide();
	  jQuery(".wds_slideshow_filmstrip_right_<?php echo $wds; ?>").hide();
	}
	else {
	  jQuery(".wds_slideshow_filmstrip_left_<?php echo $wds; ?>").show();
	  jQuery(".wds_slideshow_filmstrip_right_<?php echo $wds; ?>").show();
	}
	}
	function wds_testBrowser_cssTransitions_<?php echo $wds; ?>() {
	return wds_testDom_<?php echo $wds; ?>('Transition');
	}
	function wds_testBrowser_cssTransforms3d_<?php echo $wds; ?>() {
	return wds_testDom_<?php echo $wds; ?>('Perspective');
	}
	function wds_testDom_<?php echo $wds; ?>(prop) {
	/* Browser vendor DOM prefixes.*/
	var domPrefixes = ['', 'Webkit', 'Moz', 'ms', 'O', 'Khtml'];
	var i = domPrefixes.length;
	while (i--) {
	  if (typeof document.body.style[domPrefixes[i] + prop] !== 'undefined') {
		return true;
	  }
	}
	return false;
	}
	function wds_set_dots_class_<?php echo $wds; ?>() {
	jQuery(".wds_slideshow_dots_<?php echo $wds; ?>").removeClass("wds_slideshow_dots_active_<?php echo $wds; ?>").addClass("wds_slideshow_dots_deactive_<?php echo $wds; ?>");
	jQuery("#wds_dots_" + wds_current_key_<?php echo $wds; ?> + "_<?php echo $wds; ?>").removeClass("wds_slideshow_dots_deactive_<?php echo $wds; ?>").addClass("wds_slideshow_dots_active_<?php echo $wds; ?>");
	<?php if ($slider->bull_butt_img_or_not == 'style') { ?>
	jQuery(".wds_slideshow_dots_<?php echo $wds; ?>").removeClass("<?php echo $bull_style_active; ?>").addClass("<?php echo $bull_style_deactive; ?>");
	jQuery("#wds_dots_" + wds_current_key_<?php echo $wds; ?> + "_<?php echo $wds; ?>").removeClass("<?php echo $bull_style_deactive; ?>").addClass("<?php echo $bull_style_active; ?>");
	<?php } ?>
	}
	function wds_set_filmstrip_class_<?php echo $wds; ?>() {
	jQuery('.wds_slideshow_filmstrip_thumbnail_<?php echo $wds; ?>').removeClass('wds_slideshow_thumb_active_<?php echo $wds; ?>').addClass('wds_slideshow_thumb_deactive_<?php echo $wds; ?>');
	jQuery('#wds_filmstrip_thumbnail_' + wds_current_key_<?php echo $wds; ?> + '_<?php echo $wds; ?>').removeClass('wds_slideshow_thumb_deactive_<?php echo $wds; ?>').addClass('wds_slideshow_thumb_active_<?php echo $wds; ?>');
	}
	function wds_grid3d_<?php echo $wds; ?>(cols, rows, tz, wrx, wry, nty, ntx, nry, nrx, current_image_class, next_image_class, direction, random, easing) {
	/* If browser does not support CSS transitions.*/
	if (!wds_testBrowser_cssTransitions_<?php echo $wds; ?>()) {
	  return wds_fallback_<?php echo $wds; ?>(current_image_class, next_image_class, direction);
	}
	wds_trans_in_progress_<?php echo $wds; ?> = true;
	/* Set active thumbnail.*/
	wds_set_filmstrip_class_<?php echo $wds; ?>();
	wds_set_dots_class_<?php echo $wds; ?>();
	/* The time (in ms) added to/subtracted from the delay total for each new gridlet.*/
	var count = (wds_transition_duration_<?php echo $wds; ?>) / (cols + rows);
	/* Gridlet creator (divisions of the image grid, positioned with background-images to replicate the look of an entire slide image when assembled)*/
	function wds_gridlet(width, height, top, img_top, left, img_left, src, src2, imgWidth, imgHeight, c, r) {
	  var delay = random ? Math.floor((cols + rows) * count * Math.random()) : (c + r) * count;

	  /* Return a gridlet elem with styles for specific transition.*/
	  var grid_div = jQuery('<span class="wds_gridlet_<?php echo $wds; ?>" />').css({
		display: "block",
		width : "100%",
		height : "100%",
		transform : 'translateZ(' + tz + 'px)',
		backfaceVisibility : 'hidden',
		overflow: 'hidden'
	  }).append(jQuery('<span class="wds_gridlet_<?php echo $wds; ?>" />').css({
		display: "block",
		width : jQuery(".wds_slideshow_image_spun_<?php echo $wds; ?>").width() + "px",
		height : jQuery(".wds_slideshow_image_spun_<?php echo $wds; ?>").height() + "px",
		top : -top,
		left : -left,
		backgroundImage : src,
		backgroundSize: jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css("background-size"),
		backgroundPosition: jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css("background-position"),
		backgroundRepeat: 'no-repeat',
	  }));
	  var grid_div2 = jQuery('<span class="wds_gridlet_<?php echo $wds; ?>" />').css({
		display: "block",
		width : "100%",
		height : "100%",
		backfaceVisibility : 'hidden',
		transform : 'translateY(' + nty + 'px) translateX(' + ntx + 'px) rotateY('+ nry +'deg) rotateX('+ nrx +'deg)',
		overflow: 'hidden'
	  }).append(jQuery('<span class="wds_gridlet_<?php echo $wds; ?>" />').css({
		display: "block",
		width : jQuery(".wds_slideshow_image_spun_<?php echo $wds; ?>").width() + "px",
		height : jQuery(".wds_slideshow_image_spun_<?php echo $wds; ?>").height() + "px",
		top : -top,
		left : -left,
		backgroundImage : src2,
		backgroundSize: jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css("background-size"),
		backgroundPosition: jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css("background-position"),
		backgroundRepeat: 'no-repeat',
	  }));
	  return jQuery('<span class="wds_gridlet_<?php echo $wds; ?>" />').css({
		display: "block",
		width : width,
		height : height,
		top : top,
		left : left,
		transition : 'all ' + wds_transition_duration_<?php echo $wds; ?> + 'ms ' + easing + ' ' + delay + 'ms',
		transform: 'translateZ(-' + tz + 'px)',
		transformStyle: 'preserve-3d',
	  }).append(grid_div).append(grid_div2);
	}
	/* Get the current slide's image.*/
	var cur_img = jQuery(current_image_class).find('span[data-img-id^="wds_slideshow_image"]');
	var next_img = jQuery(next_image_class).find('span[data-img-id^="wds_slideshow_image"]');
	/* Create a grid to hold the gridlets.*/
	var grid = jQuery('<span style="display: block;" />').addClass('wds_grid_<?php echo $wds; ?>').css('perspective', 1000);
	/* Prepend the grid to the next slide (i.e. so it's above the slide image).*/
	jQuery(current_image_class).prepend(grid);
	/* vars to calculate positioning/size of gridlets*/
	var cont = jQuery(".wds_slide_bg_<?php echo $wds; ?>");
	var imgWidth = cur_img.width();
	var imgHeight = cur_img.height();
	var contWidth = cont.width(),
		contHeight = cont.height(),
		imgSrc = cur_img.css('background-image'),
		imgSrcNext = next_img.css('background-image'),
		colWidth = Math.floor(contWidth / cols),
		rowHeight = Math.floor(contHeight / rows),
		colRemainder = contWidth - (cols * colWidth),
		colAdd = Math.ceil(colRemainder / cols),
		rowRemainder = contHeight - (rows * rowHeight),
		rowAdd = Math.ceil(rowRemainder / rows),
		leftDist = 0,
		img_leftDist = (jQuery(".wds_slide_bg_<?php echo $wds; ?>").width() - cur_img.width()) / 2;
	/* Loop through cols*/
	for (var i = 0; i < cols; i++) {
	  var topDist = 0,
		  img_topDst = (jQuery(".wds_slide_bg_<?php echo $wds; ?>").height() - cur_img.height()) / 2,
		  newColWidth = colWidth;
	  /* If imgWidth (px) does not divide cleanly into the specified number of cols, adjust individual col widths to create correct total.*/
	  if (colRemainder > 0) {
		var add = colRemainder >= colAdd ? colAdd : colRemainder;
		newColWidth += add;
		colRemainder -= add;
	  }
	  /* Nested loop to create row gridlets for each col.*/
	  for (var j = 0; j < rows; j++)  {
		var newRowHeight = rowHeight,
			newRowRemainder = rowRemainder;
		/* If contHeight (px) does not divide cleanly into the specified number of rows, adjust individual row heights to create correct total.*/
		if (newRowRemainder > 0) {
		  add = newRowRemainder >= rowAdd ? rowAdd : rowRemainder;
		  newRowHeight += add;
		  newRowRemainder -= add;
		}
		/* Create & append gridlet to grid.*/
		grid.append(wds_gridlet(newColWidth, newRowHeight, topDist, img_topDst, leftDist, img_leftDist, imgSrc, imgSrcNext, imgWidth, imgHeight, i, j));
		topDist += newRowHeight;
		img_topDst -= newRowHeight;
	  }
	  img_leftDist -= newColWidth;
	  leftDist += newColWidth;
	}
	/* Show grid & hide the image it replaces.*/
	grid.show();
	cur_img.css('opacity', 0);
	/* Execution steps.*/
	setTimeout(function () {
	  grid.children().css({
		transform: 'translateZ(-' + tz + 'px) rotateX('+ wrx +'deg) rotateY('+ wry +'deg)'
	  });
	}, 1);
	/* After transition.*/
	 var cccount = 0;
	 var obshicccount = cols * rows;
	 grid.children().one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(wds_after_trans_each));
	 function wds_after_trans_each() {
	   if (++cccount == obshicccount) {
		 wds_after_trans();
	   }
	 }
	function wds_after_trans() {
	  jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
	  jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
	  cur_img.css('opacity', 1);
	  grid.remove();
	  wds_trans_in_progress_<?php echo $wds; ?> = false;
	  if (typeof wds_event_stack_<?php echo $wds; ?> !== 'undefined') {
		if (wds_event_stack_<?php echo $wds; ?>.length > 0) {
		  key = wds_event_stack_<?php echo $wds; ?>[0].split("-");
		  wds_event_stack_<?php echo $wds; ?>.shift();
		  wds_change_image_<?php echo $wds; ?>(key[0], key[1], wds_data_<?php echo $wds; ?>, true, direction);
		}
	  }
	  <?php if(isset($callback_items["onSliderCE"])) echo $callback_items["onSliderCE"]; ?>
	}
	}
	function wds_slic3DH_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	var dimension = jQuery(current_image_class).width() / 2;
	if (direction == 'right') {
	  wds_grid3d_<?php echo $wds; ?>(1, 5, dimension, 0, -90, 0, dimension, 90, 0, current_image_class, next_image_class, direction, 0, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	}
	else if (direction == 'left') {
	  wds_grid3d_<?php echo $wds; ?>(1, 5, dimension, 0, 90, 0, -dimension, -90, 0, current_image_class, next_image_class, direction, 0, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	}
	}
	function wds_slic3DV_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	var dimension = jQuery(current_image_class).height() / 2;
	if (direction == 'right') {
	  wds_grid3d_<?php echo $wds; ?>(10, 1, dimension, -90, 0, -dimension, 0, 0, 90, current_image_class, next_image_class, direction, 0, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	}
	else if (direction == 'left') {
	  wds_grid3d_<?php echo $wds; ?>(10, 1, dimension, 90, 0, dimension, 0, 0, -90, current_image_class, next_image_class, direction, 0, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	}
	}
	function wds_slicR3DH_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	var dimension = jQuery(current_image_class).width() / 2;
	if (direction == 'right') {
	  wds_grid3d_<?php echo $wds; ?>(1, 5, dimension, 0, -90, 0, dimension, 90, 0, current_image_class, next_image_class, direction, 1, 'ease-in-out');
	}
	else if (direction == 'left') {
	  wds_grid3d_<?php echo $wds; ?>(1, 5, dimension, 0, 90, 0, -dimension, -90, 0, current_image_class, next_image_class, direction, 1, 'ease-in-out');
	}
	}
	function wds_slicR3DV_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	var dimension = jQuery(current_image_class).height() / 2;
	if (direction == 'right') {
	  wds_grid3d_<?php echo $wds; ?>(10, 1, dimension, -90, 0, -dimension, 0, 0, 90, current_image_class, next_image_class, direction, 1, 'ease-in-out');
	}
	else if (direction == 'left') {
	  wds_grid3d_<?php echo $wds; ?>(10, 1, dimension, 90, 0, dimension, 0, 0, -90, current_image_class, next_image_class, direction, 1, 'ease-in-out');
	}
	}
	function wds_parallelSlide_<?php echo $wds; ?>(ni_left, ni_top, tx, ty, current_image_class, next_image_class, direction, easing) {
	/* If browser does not support 3d transforms/CSS transitions.*/
	if (!wds_testBrowser_cssTransitions_<?php echo $wds; ?>()) {
	  return wds_fallback_<?php echo $wds; ?>(current_image_class, next_image_class, direction);
	}
	if (!wds_testBrowser_cssTransforms3d_<?php echo $wds; ?>()) {
	  return wds_fallback3d_<?php echo $wds; ?>(current_image_class, next_image_class, direction);
	}
	wds_trans_in_progress_<?php echo $wds; ?> = true;
	/* Set active thumbnail.*/
	wds_set_filmstrip_class_<?php echo $wds; ?>();
	wds_set_dots_class_<?php echo $wds; ?>();
	jQuery(current_image_class).css({
	  position : 'absolute',
	  top : '0px',
	  left : '0px',
	  position : 'absolute',
	});
	jQuery(next_image_class).css({
	  position : 'absolute',
	  top : ni_top + 'px',
	  left : ni_left + 'px',
	  'opacity' : 1,
	  filter : 'Alpha(opacity=100)',
	  position : 'absolute',
	});
	jQuery(".wds_slider_<?php echo $wds; ?>").css({
	  position : 'relative',
	  'backface-visibility': 'hidden'
	});
	jQuery(".wds_slide_bg_<?php echo $wds; ?>").css({
	  overflow : 'hidden',
	});
	/* Execution steps.*/
	setTimeout(function () {
	  jQuery('.wds_slider_<?php echo $wds; ?>').css({
		transition : 'all ' + wds_transition_duration_<?php echo $wds; ?> + 'ms ' + easing,
		transform : 'translateX(' + tx + 'px) translateY(' + ty + 'px)',
	  });
	}, 1);
	/* After transition.*/
	jQuery('.wds_slider_<?php echo $wds; ?>').one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(wds_after_trans));
	function wds_after_trans() {
	  jQuery(current_image_class).removeAttr('style');
	  jQuery(next_image_class).removeAttr('style');
	  jQuery(".wds_slider_<?php echo $wds; ?>").removeAttr('style');
	  jQuery(".wds_slide_bg_<?php echo $wds; ?>").removeAttr('style');
	  jQuery(current_image_class).css({'opacity' : 0, filter: 'Alpha(opacity=0)', 'z-index': 1});
	  jQuery(next_image_class).css({'opacity' : 1, filter: 'Alpha(opacity=100)', 'z-index' : 2});
	  wds_trans_in_progress_<?php echo $wds; ?> = false;
	  if (typeof wds_event_stack_<?php echo $wds; ?> !== 'undefined') {
		if (wds_event_stack_<?php echo $wds; ?>.length > 0) {
		  key = wds_event_stack_<?php echo $wds; ?>[0].split("-");
		  wds_event_stack_<?php echo $wds; ?>.shift();
		  wds_change_image_<?php echo $wds; ?>(key[0], key[1], wds_data_<?php echo $wds; ?>, true, direction);
		}
	  }
	  <?php if(isset($callback_items["onSliderCE"])) echo $callback_items["onSliderCE"]; ?>
	}
	}
	function wds_parallelSlideH_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	var width = jQuery(current_image_class).width();
	var height = jQuery(current_image_class).height();
	if (direction == 'right') {
	  wds_parallelSlide_<?php echo $wds; ?>(width, 0, -width, 0, current_image_class, next_image_class, direction, 'ease-in-out');
	}
	else if (direction == 'left') {
	  wds_parallelSlide_<?php echo $wds; ?>(-width, 0, width, 0, current_image_class, next_image_class, direction, 'ease-in-out');
	}
	}
	function wds_parallelSlideV_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	var width = jQuery(current_image_class).width();
	var height = jQuery(current_image_class).height();
	if (direction == 'right') {
	  wds_parallelSlide_<?php echo $wds; ?>(0, height, 0, -height, current_image_class, next_image_class, direction, 'ease-in-out');
	}
	else if (direction == 'left') {
	  wds_parallelSlide_<?php echo $wds; ?>(0, -height, 0, height, current_image_class, next_image_class, direction, 'ease-in-out');
	}
	}
	function wds_cube_<?php echo $wds; ?>(tz, ntx, nty, nrx, nry, wrx, wry, current_image_class, next_image_class, direction, easing) {
	/* If browser does not support 3d transforms/CSS transitions.*/
	if (!wds_testBrowser_cssTransitions_<?php echo $wds; ?>()) {
	  return wds_fallback_<?php echo $wds; ?>(current_image_class, next_image_class, direction);
	}
	if (!wds_testBrowser_cssTransforms3d_<?php echo $wds; ?>()) {
	  return wds_fallback3d_<?php echo $wds; ?>(current_image_class, next_image_class, direction);
	}
	wds_trans_in_progress_<?php echo $wds; ?> = true;
	/* Set active thumbnail.*/
	wds_set_filmstrip_class_<?php echo $wds; ?>();
	wds_set_dots_class_<?php echo $wds; ?>();
	jQuery(".wds_slide_container_<?php echo $wds; ?>").css('overflow', 'visible');
	jQuery(".wds_slideshow_image_spun2_<?php echo $wds; ?>").css('overflow', 'visible');
	jQuery(".wds_slideshow_image_wrap_<?php echo $wds; ?>").css('overflow', 'visible');
	var filmstrip_position = '<?php echo $filmstrip_position; ?>';
	if (filmstrip_position == 'none') {
	  jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css('border-radius', jQuery(".wds_slideshow_image_wrap_<?php echo $wds; ?>").css('border-radius'));
	}
	else {
	  jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css('border-radius', '<?php echo $slider->glb_border_radius; ?>');
	  jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").css('border-radius', '<?php echo $slider->glb_border_radius; ?>');
	  if (filmstrip_position == 'top') {
		jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css('border-top-left-radius', 0);
		jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css('border-top-right-radius', 0);
		jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").css('border-bottom-left-radius', 0);
		jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").css('border-bottom-right-radius', 0);
	  }
	  else if (filmstrip_position == 'bottom') {
		jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css('border-bottom-left-radius', 0);
		jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css('border-bottom-right-radius', 0);
		jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").css('border-top-left-radius', 0);
		jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").css('border-top-right-radius', 0);
	  }
	  else if (filmstrip_position == 'right') {
		jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css('border-bottom-right-radius', 0);
		jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css('border-top-right-radius', 0);
		jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").css('border-bottom-left-radius', 0);
		jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").css('border-top-left-radius', 0);
	  }
	  else if (filmstrip_position == 'left') {
		jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css('border-bottom-left-radius', 0);
		jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css('border-top-left-radius', 0);
		jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").css('border-bottom-right-radius', 0);
		jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").css('border-top-right-radius', 0);
	  }
	}
	jQuery(".wds_slide_bg_<?php echo $wds; ?>").css('perspective', 1000);
	jQuery(current_image_class).css({
	  transform : 'translateZ(' + tz + 'px)',
	  backfaceVisibility : 'hidden'
	});
	jQuery(next_image_class).css({
	  opacity : 1,
	  filter: 'Alpha(opacity=100)',
	  zIndex: 2,
	  backfaceVisibility : 'hidden',
	  transform : 'translateY(' + nty + 'px) translateX(' + ntx + 'px) rotateY('+ nry +'deg) rotateX('+ nrx +'deg)'
	});
	jQuery(".wds_slider_<?php echo $wds; ?>").css({
	  transform: 'translateZ(-' + tz + 'px)',
	  transformStyle: 'preserve-3d',
	  position: 'absolute'
	});
	/* Execution steps.*/
	setTimeout(function () {
	  jQuery(".wds_slider_<?php echo $wds; ?>").css({
		transition: 'all ' + wds_transition_duration_<?php echo $wds; ?> + 'ms ' + easing,
		transform: 'translateZ(-' + tz + 'px) rotateX('+ wrx +'deg) rotateY('+ wry +'deg)'
	  });
	}, 20);
	/* After transition.*/
	jQuery(".wds_slider_<?php echo $wds; ?>").one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(wds_after_trans));
	function wds_after_trans() {
	  jQuery(current_image_class).removeAttr('style');
	  jQuery(next_image_class).removeAttr('style');
	  jQuery(".wds_slider_<?php echo $wds; ?>").removeAttr('style');
	  jQuery(current_image_class).css({'opacity' : 0, filter: 'Alpha(opacity=0)', 'z-index': 1});
	  jQuery(next_image_class).css({'opacity' : 1, filter: 'Alpha(opacity=100)', 'z-index' : 2});
	  wds_trans_in_progress_<?php echo $wds; ?> = false;
	  if (typeof wds_event_stack_<?php echo $wds; ?> !== 'undefined') {
		if (wds_event_stack_<?php echo $wds; ?>.length > 0) {
		  key = wds_event_stack_<?php echo $wds; ?>[0].split("-");
		  wds_event_stack_<?php echo $wds; ?>.shift();
		  wds_change_image_<?php echo $wds; ?>(key[0], key[1], wds_data_<?php echo $wds; ?>, true, direction);
		}
	  }
	  jQuery(".wds_slide_container_<?php echo $wds; ?>").css('overflow', 'hidden');
	  jQuery(".wds_slideshow_image_spun2_<?php echo $wds; ?>").css('overflow', 'hidden');
	  jQuery(".wds_slideshow_image_wrap_<?php echo $wds; ?>").css('overflow', 'hidden');
	  jQuery(".wds_slide_bg_<?php echo $wds; ?>").css('perspective', 'none');
	  <?php if(isset($callback_items["onSliderCE"])) echo $callback_items["onSliderCE"]; ?>
	}
	}
	function wds_cubeR_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	var random_direction = Math.floor(Math.random() * 2);
	var dimension = random_direction ? jQuery(current_image_class).height() / 2 : jQuery(current_image_class).width() / 2;
	if (direction == 'right') {
	 if (random_direction) {
	   wds_cube_<?php echo $wds; ?>(dimension, 0, -dimension, 90, 0, -90, 0, current_image_class, next_image_class, direction, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	 }
	 else {
	   wds_cube_<?php echo $wds; ?>(dimension, dimension, 0, 0, 90, 0, -90, current_image_class, next_image_class, direction, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	 }
	}
	else if (direction == 'left') {
	 if (random_direction) {
	   wds_cube_<?php echo $wds; ?>(dimension, 0, dimension, -90, 0, 90, 0, current_image_class, next_image_class, direction, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	 }
	 else {
	   wds_cube_<?php echo $wds; ?>(dimension, -dimension, 0, 0, -90, 0, 90, current_image_class, next_image_class, direction, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	 }
	}
	}
	function wds_cubeH_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	/* Set to half of image width.*/
	var dimension = jQuery(current_image_class).width() / 2;
	if (direction == 'right') {
	  wds_cube_<?php echo $wds; ?>(dimension, dimension, 0, 0, 90, 0, -90, current_image_class, next_image_class, direction, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	}
	else if (direction == 'left') {
	  wds_cube_<?php echo $wds; ?>(dimension, -dimension, 0, 0, -90, 0, 90, current_image_class, next_image_class, direction, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	}
	}
	function wds_cubeV_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	/* Set to half of image height.*/
	var dimension = jQuery(current_image_class).height() / 2;
	/* If next slide.*/
	if (direction == 'right') {
	  wds_cube_<?php echo $wds; ?>(dimension, 0, -dimension, 90, 0, -90, 0, current_image_class, next_image_class, direction, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	}
	else if (direction == 'left') {
	  wds_cube_<?php echo $wds; ?>(dimension, 0, dimension, -90, 0, 90, 0, current_image_class, next_image_class, direction, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	}
	}
	/* For browsers that does not support transitions.*/
	function wds_fallback_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_fade_<?php echo $wds; ?>(current_image_class, next_image_class, direction);
	}
	/* For browsers that support transitions, but not 3d transforms (only used if primary transition makes use of 3d-transforms).*/
	function wds_fallback3d_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_sliceV_<?php echo $wds; ?>(current_image_class, next_image_class, direction);
	}
	function wds_none_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
	jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
	/* Set active thumbnail.*/
	wds_set_filmstrip_class_<?php echo $wds; ?>();
	wds_set_dots_class_<?php echo $wds; ?>();
	}
	function wds_fade_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	/* Set active thumbnail.*/
	wds_set_filmstrip_class_<?php echo $wds; ?>();
	wds_set_dots_class_<?php echo $wds; ?>();
	if (wds_testBrowser_cssTransitions_<?php echo $wds; ?>()) {
	  jQuery(next_image_class).css('transition', 'opacity ' + wds_transition_duration_<?php echo $wds; ?> + 'ms linear');
	  jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
	  jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
	}
	else {
	  jQuery(current_image_class).animate({'opacity' : 0, 'z-index' : 1}, wds_transition_duration_<?php echo $wds; ?>);
	  jQuery(next_image_class).animate({
		  'opacity' : 1,
		  'z-index': 2
		}, {
		  duration: wds_transition_duration_<?php echo $wds; ?>,
		  complete: function () {}
		});
	  /* For IE.*/
	  jQuery(current_image_class).fadeTo(wds_transition_duration_<?php echo $wds; ?>, 0);
	  jQuery(next_image_class).fadeTo(wds_transition_duration_<?php echo $wds; ?>, 1);
	}
	<?php if(isset($callback_items["onSliderCE"])) echo $callback_items["onSliderCE"]; ?>
	}
	function wds_grid_<?php echo $wds; ?>(cols, rows, ro, tx, ty, sc, op, current_image_class, next_image_class, direction, random, roy, easing) {
	/* If browser does not support CSS transitions.*/
	if (!wds_testBrowser_cssTransitions_<?php echo $wds; ?>()) {
	  return wds_fallback_<?php echo $wds; ?>(current_image_class, next_image_class, direction);
	}
	wds_trans_in_progress_<?php echo $wds; ?> = true;
	/* Set active thumbnail.*/
	wds_set_filmstrip_class_<?php echo $wds; ?>();
	wds_set_dots_class_<?php echo $wds; ?>();
	/* The time (in ms) added to/subtracted from the delay total for each new gridlet.*/
	var count = (wds_transition_duration_<?php echo $wds; ?>) / (cols + rows);
	/* Gridlet creator (divisions of the image grid, positioned with background-images to replicate the look of an entire slide image when assembled)*/
	function wds_gridlet(width, height, top, img_top, left, img_left, src, imgWidth, imgHeight, c, r) {
	  var delay = random ? Math.floor((cols + rows) * count * Math.random()) : (c + r) * count;
	  /* Return a gridlet elem with styles for specific transition.*/
	  var grid_div = jQuery('<span class="wds_gridlet_<?php echo $wds; ?>" />').css({
		display: "block",
		width : imgWidth,/*"100%"*/
		height : jQuery(".wds_slideshow_image_spun_<?php echo $wds; ?>").height() + "px",
		top : -top,
		left : -left,
		backgroundImage : src,
		backgroundSize: jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css("background-size"),
		backgroundPosition: jQuery(".wds_slideshow_image_<?php echo $wds; ?>").css("background-position"),
		backgroundRepeat: 'no-repeat'
	  });
	  return jQuery('<span class="wds_gridlet_<?php echo $wds; ?>" />').css({
		display: "block",
		width : width,/*"100%"*/
		height : height,
		top : top,
		left : left,
		backgroundSize : imgWidth + 'px ' + imgHeight + 'px',
		backgroundPosition : img_left + 'px ' + img_top + 'px',
		backgroundRepeat: 'no-repeat',
		overflow: "hidden",
		transition : 'all ' + wds_transition_duration_<?php echo $wds; ?> + 'ms ' + easing + ' ' + delay + 'ms',
		transform : 'none'
	  }).append(grid_div);
	}
	/* Get the current slide's image.*/
	var cur_img = jQuery(current_image_class).find('span[data-img-id^="wds_slideshow_image"]');
	/* Create a grid to hold the gridlets.*/
	var grid = jQuery('<span style="display: block;" />').addClass('wds_grid_<?php echo $wds; ?>');
	/* Prepend the grid to the next slide (i.e. so it's above the slide image).*/
	jQuery(current_image_class).prepend(grid);
	/* vars to calculate positioning/size of gridlets*/
	var cont = jQuery(".wds_slide_bg_<?php echo $wds; ?>");
	var imgWidth = cur_img.width();
	var imgHeight = cur_img.height();
	var contWidth = cont.width(),
		contHeight = cont.height(),
		imgSrc = cur_img.css('background-image'),/*.replace('/thumb', ''),*/
		colWidth = Math.floor(contWidth / cols),
		rowHeight = Math.floor(contHeight / rows),
		colRemainder = contWidth - (cols * colWidth),
		colAdd = Math.ceil(colRemainder / cols),
		rowRemainder = contHeight - (rows * rowHeight),
		rowAdd = Math.ceil(rowRemainder / rows),
		leftDist = 0,
		img_leftDist = (jQuery(".wds_slide_bg_<?php echo $wds; ?>").width() - cur_img.width()) / 2;
	/* tx/ty args can be passed as 'auto'/'min-auto' (meaning use slide width/height or negative slide width/height).*/
	tx = tx === 'auto' ? contWidth : tx;
	tx = tx === 'min-auto' ? - contWidth : tx;
	ty = ty === 'auto' ? contHeight : ty;
	ty = ty === 'min-auto' ? - contHeight : ty;
	/* Loop through cols*/
	for (var i = 0; i < cols; i++) {
	  var topDist = 0,
		  img_topDst = (jQuery(".wds_slide_bg_<?php echo $wds; ?>").height() - cur_img.height()) / 2,
		  newColWidth = colWidth;
	  /* If imgWidth (px) does not divide cleanly into the specified number of cols, adjust individual col widths to create correct total.*/
	  if (colRemainder > 0) {
		var add = colRemainder >= colAdd ? colAdd : colRemainder;
		newColWidth += add;
		colRemainder -= add;
	  }
	  /* Nested loop to create row gridlets for each col.*/
	  for (var j = 0; j < rows; j++)  {
		var newRowHeight = rowHeight,
			newRowRemainder = rowRemainder;
		/* If contHeight (px) does not divide cleanly into the specified number of rows, adjust individual row heights to create correct total.*/
		if (newRowRemainder > 0) {
		  add = newRowRemainder >= rowAdd ? rowAdd : rowRemainder;
		  newRowHeight += add;
		  newRowRemainder -= add;
		}
		/* Create & append gridlet to grid.*/
		grid.append(wds_gridlet(newColWidth, newRowHeight, topDist, img_topDst, leftDist, img_leftDist, imgSrc, imgWidth, imgHeight, i, j));
		topDist += newRowHeight;
		img_topDst -= newRowHeight;
	  }
	  img_leftDist -= newColWidth;
	  leftDist += newColWidth;
	}
	/* Show grid & hide the image it replaces.*/
	grid.show();
	cur_img.css('opacity', 0);
	/* Add identifying classes to corner gridlets (useful if applying border radius).*/
	grid.children().first().addClass('rs-top-left');
	grid.children().last().addClass('rs-bottom-right');
	grid.children().eq(rows - 1).addClass('rs-bottom-left');
	grid.children().eq(- rows).addClass('rs-top-right');
	/* Execution steps.*/
	setTimeout(function () {
	  grid.children().css({
		opacity: op,
		transform: 'rotate('+ ro +'deg) rotateY('+ roy +'deg) translateX('+ tx +'px) translateY('+ ty +'px) scale('+ sc +')'
	  });
	}, 1);
	jQuery(next_image_class).css('opacity', 1);
	/* After transition.*/
	var cccount = 0;
	var obshicccount = cols * rows;
	grid.children().one('webkitTransitionEnd transitionend otransitionend oTransitionEnd mstransitionend', jQuery.proxy(wds_after_trans_each));
	function wds_after_trans_each() {
	 if (++cccount == obshicccount) {
	   wds_after_trans();
	 }
	}
	function wds_after_trans() {
	  jQuery(current_image_class).css({'opacity' : 0, 'z-index': 1});
	  jQuery(next_image_class).css({'opacity' : 1, 'z-index' : 2});
	  cur_img.css('opacity', 1);
	  grid.remove();
	  wds_trans_in_progress_<?php echo $wds; ?> = false;
	  if (typeof wds_event_stack_<?php echo $wds; ?> !== 'undefined') {
		if (wds_event_stack_<?php echo $wds; ?>.length > 0) {
		  key = wds_event_stack_<?php echo $wds; ?>[0].split("-");
		  wds_event_stack_<?php echo $wds; ?>.shift();
		  wds_change_image_<?php echo $wds; ?>(key[0], key[1], wds_data_<?php echo $wds; ?>, true, direction);
		}
	  }
	  <?php if(isset($callback_items["onSliderCE"])) echo $callback_items["onSliderCE"]; ?>
	}
	}
	function wds_sliceH_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	if (direction == 'right') {
	  var translateX = 'min-auto';
	}
	else if (direction == 'left') {
	  var translateX = 'auto';
	}
	wds_grid_<?php echo $wds; ?>(1, 8, 0, translateX, 0, 1, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
	}
	function wds_sliceV_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	if (direction == 'right') {
	  var translateY = 'min-auto';
	}
	else if (direction == 'left') {
	  var translateY = 'auto';
	}
	wds_grid_<?php echo $wds; ?>(10, 1, 0, 0, translateY, 1, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
	}
	function wds_slideV_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	if (direction == 'right') {
	  var translateY = 'auto';
	}
	else if (direction == 'left') {
	  var translateY = 'min-auto';
	}
	wds_grid_<?php echo $wds; ?>(1, 1, 0, 0, translateY, 1, 1, current_image_class, next_image_class, direction, 0, 0, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	}
	function wds_slideH_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	if (direction == 'right') {
	  var translateX = 'min-auto';
	}
	else if (direction == 'left') {
	  var translateX = 'auto';
	}
	wds_grid_<?php echo $wds; ?>(1, 1, 0, translateX, 0, 1, 1, current_image_class, next_image_class, direction, 0, 0, 'cubic-bezier(0.785, 0.135, 0.150, 0.860)');
	}
	function wds_scaleOut_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_grid_<?php echo $wds; ?>(1, 1, 0, 0, 0, 1.5, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
	}
	function wds_scaleIn_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_grid_<?php echo $wds; ?>(1, 1, 0, 0, 0, 0.5, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
	}
	function wds_blockScale_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_grid_<?php echo $wds; ?>(8, 6, 0, 0, 0, 0.6, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
	}
	function wds_blockScaleR_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_grid_<?php echo $wds; ?>(8, 6, 0, 0, 0, 0.6, 0, current_image_class, next_image_class, direction, 1, 0, 'ease-in-out');
	}
	function wds_blindR_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_grid_<?php echo $wds; ?>(8, 1, 0, 0, 0, 1, 1, current_image_class, next_image_class, direction, 1, 90, 'ease-in-out');
	}
	function wds_tilesR_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_grid_<?php echo $wds; ?>(8, 8, 0, 0, 0, 1, 1, current_image_class, next_image_class, direction, 1, 90, 'ease-in-out');
	}
	function wds_kaleidoscope_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_grid_<?php echo $wds; ?>(10, 8, 0, 0, 0, 1, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
	}
	function wds_fan_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	if (direction == 'right') {
	  var rotate = 45;
	  var translateX = 100;
	}
	else if (direction == 'left') {
	  var rotate = -45;
	  var translateX = -100;
	}
	wds_grid_<?php echo $wds; ?>(1, 10, rotate, translateX, 0, 1, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
	}
	function wds_blindV_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_grid_<?php echo $wds; ?>(1, 8, 0, 0, 0, .7, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
	}
	function wds_blindH_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	wds_grid_<?php echo $wds; ?>(10, 1, 0, 0, 0, .7, 0, current_image_class, next_image_class, direction, 0, 0, 'ease-in-out');
	}
	function wds_random_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	var anims = ['sliceH', 'sliceV', 'slideH', 'slideV', 'scaleOut', 'scaleIn', 'blockScale', 'kaleidoscope', 'fan', 'blindH', 'blindV', 'parallelSlideH', 'parallelSlideV'];
	/* Pick a random transition from the anims array.*/
	this["wds_" + anims[Math.floor(Math.random() * anims.length)] + "_<?php echo $wds; ?>"](current_image_class, next_image_class, direction);
	}
	function wds_3Drandom_<?php echo $wds; ?>(current_image_class, next_image_class, direction) {
	var anims = ['cubeH', 'cubeV', 'cubeR', 'slic3DH', 'slic3DV', 'slicR3DH', 'slicR3DV'];
	/* Pick a random transition from the anims array.*/
	this["wds_" + anims[Math.floor(Math.random() * anims.length)] + "_<?php echo $wds; ?>"](current_image_class, next_image_class, direction);
	}
	function wds_iterator_<?php echo $wds; ?>() {
	var iterator = 1;
	if (<?php echo $enable_slideshow_shuffle; ?>) {
	  iterator = Math.floor((wds_data_<?php echo $wds; ?>.length - 1) * Math.random() + 1);
	}
	else if (<?php echo $twoway_slideshow; ?>) {
	  if (wds_global_btn_<?php echo $wds; ?> == "left") {
		iterator = -1;
	  }
	  if ('<?php echo $slider_loop; ?>' == 0) {
		if (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) == 0) {
		  iterator = 1;
		}
	  }
	}
	return iterator;
	}
	function wds_change_image_<?php echo $wds; ?>(current_key, key, wds_data_<?php echo $wds; ?>, from_effect, btn) {
	if (typeof btn == "undefined") {
	  var btn = "";
	}
	if (!('<?php echo $carousel; ?>' != 0 || wds_data_<?php echo $wds; ?>[key]["is_video"] != 'image')) {
	  jQuery('<img />').attr("src", wds_data_<?php echo $wds; ?>[key]["image_url"])
	  .on('load', function() {
		jQuery(this).remove();
		wds_change_image_when_loaded_<?php echo $wds; ?>(current_key, key, wds_data_<?php echo $wds; ?>, from_effect, btn);
	  })
	  .on('error', function() {
		jQuery(this).remove();
		wds_change_image_when_loaded_<?php echo $wds; ?>(current_key, key, wds_data_<?php echo $wds; ?>, from_effect, btn);
	  });
	}
	else {
	  wds_change_image_when_loaded_<?php echo $wds; ?>(current_key, key, wds_data_<?php echo $wds; ?>, from_effect, btn);
	}
	}
	function wds_change_image_when_loaded_<?php echo $wds; ?>(current_key, key, wds_data_<?php echo $wds; ?>, from_effect, btn) {
	<?php if ( $carousel ) { ?>
	  if (wds_currentlyMoving<?php echo $wds; ?>) {
		return;
	  }
	<?php } ?>
	/* Pause videos.*/
	jQuery("#wds_slideshow_image_container_<?php echo $wds; ?>").find("iframe").each(function () {
	  if (typeof jQuery(this)[0].contentWindow != "undefined") {
		if (jQuery(this).attr('data-type') == 'youtube') {
		  player = youtube_iframes_ids_<?php echo $wds; ?>.indexOf(this.id);
		  if (typeof youtube_iframes_<?php echo $wds; ?>[player] != "undefined") {
			youtube_iframes_<?php echo $wds; ?>[player].stopVideo();
		  }
		}
		else if (jQuery(this).attr('type') == 'vimeo') {
		  jQuery(this)[0].contentWindow.postMessage('{ "method": "pause" }', "*");
		}
		else {
		  jQuery(this)[0].contentWindow.postMessage('stop', '*');
		}
	  }
	});
	jQuery("#wds_slideshow_image_container_<?php echo $wds; ?>").find("video").each(function () {
	  jQuery(this).trigger('pause');
	  jQuery('.wds_bigplay_<?php echo $wds; ?>').show();
	});
	/* Pause layer videos.*/
	jQuery(".wds_video_layer_frame_<?php echo $wds; ?>").each(function () {
	  if (typeof jQuery(this)[0].contentWindow != "undefined") {
		if (jQuery(this).attr('data-type') == 'youtube') {
		  player = youtube_iframes_ids_<?php echo $wds; ?>.indexOf(this.id);
		  if (typeof youtube_iframes_<?php echo $wds; ?>[player] != "undefined") {
			youtube_iframes_<?php echo $wds; ?>[player].stopVideo();
		  }
		}
		else if (jQuery(this).attr('type') == 'vimeo') {
		  jQuery(this)[0].contentWindow.postMessage('{ "method": "pause" }', "*");
		}
		else {
		  jQuery(this)[0].contentWindow.postMessage('stop', '*');
		}
	  }
	});

	if (wds_data_<?php echo $wds; ?>[key]) {
	  if (jQuery('.wds_ctrl_btn_<?php echo $wds; ?>').hasClass('fa-pause') || ('<?php echo $autoplay; ?>')) {
		play_<?php echo $wds; ?>();
	  }
	  if (!from_effect) {
		/* Change image key.*/
		jQuery("#wds_current_image_key_<?php echo $wds; ?>").val(key);
		if (current_key == '-1') { /* Filmstrip.*/
		  current_key = jQuery(".wds_slideshow_thumb_active_<?php echo $wds; ?>").children("img").attr("data-image-key");
		}
		else if (current_key == '-2') { /* Dots.*/
		  currId = jQuery(".wds_slideshow_dots_active_<?php echo $wds; ?>").attr("id");
		  current_key = currId.replace('wds_dots_', '').replace('_<?php echo $wds; ?>', '');
		}
	  }
	  if (wds_trans_in_progress_<?php echo $wds; ?>) {
		wds_event_stack_<?php echo $wds; ?>.push(current_key + '-' + key);
		return;
	  }
	  if (btn == "") {
		var direction = "right";
		var int_curr_key = parseInt(wds_current_key_<?php echo $wds; ?>);
		var int_key = parseInt(key);
		var last_pos = wds_data_<?php echo $wds; ?>.length - 1;

		if (int_curr_key > int_key) {
		  direction = 'left';
		}
		else if (int_curr_key == int_key) {
		  return;
		}
		/* From last slide to first.*/
		if (int_key == 0) {
		  if (int_curr_key == last_pos) {
			direction = 'right';
		  }
		}
		/* From first slide to last if there are more than two slides in the slider.*/
		if (int_key == last_pos) {
		  if (int_curr_key == 0) {
			if (last_pos > 1) {
			  direction = 'left';
			}
		  }
		}
	  }
	  else {
		direction = btn;
	  }
	  if (<?php echo $enable_slideshow_autoplay; ?>) {
		if (<?php echo $twoway_slideshow; ?>) {
		  wds_global_btn_<?php echo $wds; ?> = direction;
		}
	  }
	  /* Set active thumbnail position.*/
	  wds_current_filmstrip_pos_<?php echo $wds; ?> = key * (jQuery(".wds_slideshow_filmstrip_thumbnail_<?php echo $wds; ?>").<?php echo $width_or_height; ?>() + 2 + 2 * 0);
	  wds_current_key_<?php echo $wds; ?> = key;
	  /* Change image id.*/
	  jQuery("div[data-img-id=wds_slideshow_image_<?php echo $wds; ?>]").attr('data-image-id', wds_data_<?php echo $wds; ?>[key]["id"]);
	  var current_image_class = "#wds_image_id_<?php echo $wds; ?>_" + wds_data_<?php echo $wds; ?>[current_key]["id"];
	  var next_image_class = "#wds_image_id_<?php echo $wds; ?>_" + wds_data_<?php echo $wds; ?>[key]["id"];
	  var next_image_type = wds_data_<?php echo $wds; ?>[key]["is_video"];
	  if (next_image_type == 'video' || next_image_type.indexOf('EMBED') >= 0){
		jQuery('.wds_pp_btn_cont').hide();
	  }
	  else {
		jQuery('.wds_pp_btn_cont').show();
	  }
	  if (wds_data_<?php echo $wds; ?>[key]["target_attr_slide"] == 1 ) {
    if ( !wds_object.is_free ) {
		wds_embed_slide_autoplay(next_image_class, <?php echo $wds; ?>);
    }
	  }
	  <?php if ($preload_images && !$carousel) { ?>
	  if (wds_data_<?php echo $wds; ?>[key]["is_video"] == 'image') {
		jQuery(next_image_class).find(".wds_slideshow_image_<?php echo $wds; ?>").css("background-image", 'url("' + wds_data_<?php echo $wds; ?>[key]["image_url"] + '")');
	  }
	  else if (wds_data_<?php echo $wds; ?>[key]["is_video"] == 'EMBED_OEMBED_INSTAGRAM_IMAGE') {
		jQuery(next_image_class).find(".wds_slideshow_image_<?php echo $wds; ?>").css("background-image", 'url("//instagram.com/p/' + wds_data_<?php echo $wds; ?>[key]["image_url"] + '/media/?size=l")');
	  }
	  <?php } ?>
    if ( !wds_object.is_free ) {
    wds_video_dimenstion(<?php echo $wds; ?>, key);
    }
	  var current_slide_layers_count = wds_data_<?php echo $wds; ?>[current_key]["slide_layers_count"];
	  var next_slide_layers_count = wds_data_<?php echo $wds; ?>[key]["slide_layers_count"];
	  /* Clear layers before image change.*/
	  function set_layer_effect_out_before_change(m) {
		wds_clear_layers_effects_out_before_change_<?php echo $wds; ?>[current_key][m] = setTimeout(function() {
		  if (wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_type"] != 'social') {
			if (jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]).prev().attr('id') != 'wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"] + '_round_effect') {
			  jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]).css('-webkit-animation-duration' , 0.6 + 's').css('animation-duration' , 0.6 + 's');
			  jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]).removeClass().addClass( wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_layer_effect_out"] + ' wds_animated');
			  jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]).addClass(jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]).data("class"));
			}
			else {
			  jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]+"_div").css('-webkit-animation-duration' , 0.6 + 's').css('animation-duration' , 0.6 + 's');
			  jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]+"_div").removeClass().addClass( wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_layer_effect_out"] + ' wds_animated');
			}
		  }
		  else {
			jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]).css('-webkit-animation-duration' , 0.6 + 's').css('animation-duration' , 0.6 + 's');
			jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]).removeClass().addClass( wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_layer_effect_out"] + ' fa fa-' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_social_button"] + ' wds_animated');
		  }
		}, 10);
	  }
	<?php if ( $slider->layer_out_next ) { ?>
		for (var m = 0; m < current_slide_layers_count; m++) {
		  if (jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]).prev().attr('id') != 'wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + i + "_id"] + '_round_effect') {
			if (jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]).css('opacity') != 0) {
			  set_layer_effect_out_before_change(m);
			}
		  }
		  else {
			if (jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + m + "_id"]+"_div").css('opacity') != 0) {
			  set_layer_effect_out_before_change(m);
			}
		  }
		}
	<?php } ?>
	  /* Loop through current slide layers for clear effects.*/
	  setTimeout(function() {
		for (var k = 0; k < current_slide_layers_count; k++) {
		  clearTimeout(wds_clear_layers_effects_in_<?php echo $wds; ?>[current_key][k]);
		  clearTimeout(wds_clear_layers_effects_out_<?php echo $wds; ?>[current_key][k]);
		  if (wds_data_<?php echo $wds; ?>[current_key]["layer_" + k + "_type"] != 'social') {
			jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + k + "_id"]).removeClass().addClass('wds_layer_'+ wds_data_<?php echo $wds; ?>[current_key]["layer_" + k + "_id"]);
		  }
		  else {
			jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[current_key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + k + "_id"]).removeClass().addClass('fa fa-' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + k + "_social_button"] + ' wds_layer_' + wds_data_<?php echo $wds; ?>[current_key]["layer_" + k + "_id"]);
		  }
		}
	  }, wds_duration_for_clear_effects_<?php echo $wds; ?>);
	  /* Loop through layers in.*/
	  for (var j = 0; j < next_slide_layers_count; j++) {
		wds_set_layer_effect_in_<?php echo $wds; ?>(j, key);
	  }
	  /* Loop through layers out if pause button not pressed.*/
	  for (var i = 0; i < next_slide_layers_count; i++) {
		wds_set_layer_effect_out_<?php echo $wds; ?>(i, key);
	  }
	  setTimeout(function() {
		if (typeof jQuery().finish !== 'undefined') {
		  if (jQuery.isFunction(jQuery().finish)) {
			jQuery(".wds_line_timer_<?php echo $wds; ?>").finish();
		  }
		}
		jQuery(".wds_line_timer_<?php echo $wds; ?>").css({width: 0});
		<?php
		if (!$carousel) {
		  ?>
		if (typeof wds_<?php echo $slideshow_effect; ?>_<?php echo $wds; ?> == "function") {
		  wds_<?php echo $slideshow_effect; ?>_<?php echo $wds; ?>(current_image_class, next_image_class, direction);
		}
		else {
		  wds_none_<?php echo $wds; ?>(current_image_class, next_image_class, direction);
		}
		  <?php
		}
		?>
		if ('<?php echo $slider->timer_bar_type; ?>' != 'none') {
		  if (<?php echo $enable_slideshow_autoplay; ?> || jQuery('.wds_ctrl_btn_<?php echo $wds; ?>').hasClass('fa-pause')) {
			if ('<?php echo $slider->timer_bar_type; ?>' == 'top' || '<?php echo $slider->timer_bar_type; ?>' == 'bottom') {
			  if (!jQuery(".wds_ctrl_btn_<?php echo $wds; ?>").hasClass("fa-play")) {
				jQuery(".wds_line_timer_<?php echo $wds; ?>").animate({
				  width: "100%"
				}, {
				  duration: <?php echo $slideshow_interval * 1000; ?>,
				  specialEasing: {width: "linear"}
				});
			  }
			}
			else if ('<?php echo $slider->timer_bar_type; ?>' != 'none') {
			  if (typeof circle_timer_animate_<?php echo $wds; ?> !== 'undefined') {
				circle_timer_animate_<?php echo $wds; ?>.stop();
			  }
			  jQuery('#top_right_<?php echo $wds; ?>').css({
				'-moz-transform':'rotate(0deg)',
				'-webkit-transform':'rotate(0deg)',
				'-o-transform':'rotate(0deg)',
				'-ms-transform':'rotate(0deg)',
				'transform':'rotate(0deg)',
				'-webkit-transform-origin': 'left bottom',
				'-ms-transform-origin': 'left bottom',
				'-moz-transform-origin': 'left bottom',
				'transform-origin': 'left bottom'
			  });
			  jQuery('#bottom_right_<?php echo $wds; ?>').css({
				'-moz-transform':'rotate(0deg)',
				'-webkit-transform':'rotate(0deg)',
				'-o-transform':'rotate(0deg)',
				'-ms-transform':'rotate(0deg)',
				'transform':'rotate(0deg)',
				'-webkit-transform-origin': 'left top',
				'-ms-transform-origin': 'left top',
				'-moz-transform-origin': 'left top',
				'transform-origin': 'left top'
			  });
			  jQuery('#bottom_left_<?php echo $wds; ?>').css({
				'-moz-transform':'rotate(0deg)',
				'-webkit-transform':'rotate(0deg)',
				'-o-transform':'rotate(0deg)',
				'-ms-transform':'rotate(0deg)',
				'transform':'rotate(0deg)',
				'-webkit-transform-origin': 'right top',
				'-ms-transform-origin': 'right top',
				'-moz-transform-origin': 'right top',
				'transform-origin': 'right top'
			  });
			  jQuery('#top_left_<?php echo $wds; ?>').css({
				'-moz-transform':'rotate(0deg)',
				'-webkit-transform':'rotate(0deg)',
				'-o-transform':'rotate(0deg)',
				'-ms-transform':'rotate(0deg)',
				'transform':'rotate(0deg)',
				'-webkit-transform-origin': 'right bottom',
				'-ms-transform-origin': 'right bottom',
				'-moz-transform-origin': 'right bottom',
				'transform-origin': 'right bottom'
			  });
			  if (!jQuery(".wds_ctrl_btn_<?php echo $wds; ?>").hasClass("fa-play")) {
				/* Begin circle timer on next.*/
				circle_timer_<?php echo $wds; ?>(0);
			  }
			  else {
				curent_time_deggree_<?php echo $wds; ?> = 0;
			  }
			}
		  }
		}
		<?php
		if ($filmstrip_position != 'none' && $slides_count > 1) {
		  ?>
		  wds_move_filmstrip_<?php echo $wds; ?>();
		  <?php
		}
		if ($bull_position != 'none' && $slides_count > 1) {
		  ?>
		  wds_move_dots_<?php echo $wds; ?>();
		  <?php
		}
		?>
		if (wds_data_<?php echo $wds; ?>[key]["is_video"] != 'image') {
		  jQuery("#wds_slideshow_play_pause_<?php echo $wds; ?>").css({display: 'none'});
		}
		else {
		  jQuery("#wds_slideshow_play_pause_<?php echo $wds; ?>").css({display: ''});
		}
	  }, wds_duration_for_change_<?php echo $wds; ?>);
	}
	if (<?php echo $parallax_effect ?>) {
	  wds_parallax(<?php echo $wds; ?>);
	}
	<?php
	if ($slider->effect == 'zoomFade') {
	  ?>
	  wds_genBgPos_<?php echo $wds; ?>(next_image_class);
	  <?php
	}
	?>
	wds_window_fixed_size<?php echo $wds; ?>(next_image_class);
	<?php if(isset($callback_items["onSliderCS"])) echo $callback_items["onSliderCS"]; ?>
	}
	function wds_resize_instagram_post_<?php echo $wds; ?>() {
	if (jQuery('.inner_instagram_iframe_wds_video_frame_<?php echo $wds?>').length) {
	  var post_width = jQuery('.wds_slideshow_video_<?php echo $wds?>').width();
	  var post_height = jQuery('.wds_slideshow_video_<?php echo $wds?>').height();
	  var parent_height = post_height;
	  jQuery('.inner_instagram_iframe_wds_video_frame_<?php echo $wds?>').each(function() {
		var parent_container = jQuery(this).parent();
		if (post_height < post_width + 88) {
		  post_width = post_height - 88;
		}
		else {
		  post_height = post_width + 88;
		}
		parent_container.height(post_height);
		parent_container.width(post_width);
		parent_container.css({top: 0.5 * (parent_height - post_height)});
	  });
	}
	}
	function wds_resize_slider_<?php echo $wds; ?>() {
	var full_width = (jQuery(window).width() <= parseInt(<?php echo $slider->full_width_for_mobile; ?>) || <?php echo $slider->full_width; ?>) ? 1 : 0;
	wds_glb_margin_<?php echo $wds; ?> = parseInt('<?php echo $slider->glb_margin; ?>');
	if ('<?php echo $slider->bull_butt_img_or_not; ?>' == 'text') {
	  wds_set_text_dots_cont(<?php echo $wds; ?>);
	}
	var slide_orig_width = <?php echo $image_width + ($filmstrip_direction == 'horizontal' ? 0 : $filmstrip_width); ?>;
	var slide_orig_height = <?php echo $image_height + ($filmstrip_direction == 'horizontal' ? $filmstrip_height : 0); ?>;
	var slide_width = wds_get_overall_parent(jQuery("#wds_container1_<?php echo $wds; ?>"));
	var ratio;
	<?php if (!$carousel) { ?>
	if (slide_width > slide_orig_width) {
	  slide_width = slide_orig_width;
	}
	ratio = slide_width / (slide_orig_width + 2 * wds_glb_margin_<?php echo $wds; ?>);
	<?php } ?>
	if (full_width) {
	<?php if ( !$carousel ) { ?>
		ratio = jQuery(window).width() / slide_orig_width;
	<?php  } else { ?>
		ratio = jQuery(window).width() / slide_orig_width;
	<?php  } ?>
	  slide_orig_width = jQuery(window).width();
	  slide_orig_height = <?php echo $image_height + $filmstrip_height; ?> * slide_orig_width / <?php echo $image_width; ?>;
	  slide_width = jQuery(window).width();
	  wds_full_width_<?php echo $wds; ?>();
	}
	else if (parseInt(<?php echo $slider->full_width_for_mobile ?>)) {
	  jQuery(".wds_slideshow_image_wrap_<?php echo $wds; ?>").removeAttr("style");
	}
	<?php if ($carousel) { ?>
	  ratio = 1;
	  if (slide_width < <?php echo $carousel_width; ?>) {
		ratio = slide_width / <?php echo $carousel_width; ?>;
	  }
	<?php } ?>
	wds_glb_margin_<?php echo $wds; ?> = parseInt('<?php echo $slider->glb_margin; ?>');
	wds_glb_margin_<?php echo $wds; ?> *= ratio;
	if (!full_width) {
	  slide_orig_height -= wds_glb_margin_<?php echo $wds; ?>;
	}
	jQuery("#wds_container2_<?php echo $wds; ?>").css("margin", wds_glb_margin_<?php echo $wds; ?> + "px " + (full_width ? 0 : '') + "");
	var slide_height = slide_orig_height;
	if (slide_orig_width > slide_width) {
	  slide_height = Math.floor(slide_width * slide_orig_height / slide_orig_width);
	}
	jQuery(".wds_slideshow_image_wrap_<?php echo $wds; ?>, #wds_container2_<?php echo $wds; ?>").height(slide_height);
	<?php if (!$carousel) { ?>
		jQuery(".wds_slideshow_image_<?php echo $wds; ?>").height(slide_height - parseInt(<?php echo ($filmstrip_direction == 'horizontal' ? $filmstrip_height : 0); ?>));
		jQuery(".wds_slideshow_video_<?php echo $wds; ?>").height(slide_height - parseInt(<?php echo ($filmstrip_direction == 'horizontal' ? $filmstrip_height : 0); ?>));
	<?php } else { ?>
		jQuery(".wds_slideshow_image_<?php echo $wds; ?>").height("100%");
		jQuery(".wds_slideshow_video_<?php echo $wds; ?>").height("100%");
	<?php  } ?>
	jQuery(".wds_slideshow_image_<?php echo $wds; ?> img").each(function () {
	  var wds_theImage = new Image();
	  wds_theImage.src = jQuery(this).attr("src");
	  var wds_origWidth = wds_theImage.width;
	  var wds_origHeight = wds_theImage.height;
	  if (typeof wds_theImage.remove != 'undefined') {
		wds_theImage.remove();
	  }
	  var wds_imageWidth = jQuery(this).attr("data-wds-image-width");
	  var wds_imageHeight = jQuery(this).attr("data-wds-image-height");
	  var wds_width = wds_imageWidth;
	  if (wds_imageWidth > wds_origWidth) {
		wds_width = wds_origWidth;
	  }
	  var wds_height = wds_imageHeight;
	  if (wds_imageHeight > wds_origHeight) {
		wds_height = wds_origHeight;
	  }
	  jQuery(this).css({
		maxWidth: (parseFloat(wds_imageWidth) * ratio) + "px",
		maxHeight: (parseFloat(wds_imageHeight) * ratio) + "px",
	  });
	  if (jQuery(this).attr("data-wds-scale") != "on") {
		jQuery(this).css({
		  width: (parseFloat(wds_imageWidth) * ratio) + "px",
		  height: (parseFloat(wds_imageHeight) * ratio) + "px"
		});
	  }
	  else if (wds_imageWidth > wds_origWidth || wds_imageHeight > wds_origHeight) {
		if (wds_origWidth / wds_imageWidth > wds_origHeight / wds_imageHeight) {
		  jQuery(this).css({
			width: (parseFloat(wds_imageWidth) * ratio) + "px"
		  });
		}
		else {
		  jQuery(this).css({
			height: (parseFloat(wds_imageHeight) * ratio) + "px"
		  });
		}
	  }
	});
	jQuery(".wds_slideshow_image_<?php echo $wds; ?> [data-type='hotspot']").each(function () {
	  jQuery(this).children().each(function () {
		var width = jQuery(this).attr("data-width");
		if (jQuery(this).attr("data-type") == "hotspot_text") {
		  var height = jQuery(this).attr("data-height");
		  if (width != 0) {
			jQuery(this).width(ratio * width);
		  }
		  if (height != 0) {
			jQuery(this).height(ratio * height);
		  }
		  var min_font_size;
		  var font_size;
		  min_font_size = jQuery(this).attr("data-fmin-size");
		  font_size = ratio * jQuery(this).attr("data-fsize");
		  if (min_font_size > font_size) {
			font_size = min_font_size;
		  }
		  jQuery(this).css({fontSize: font_size + "px"});
		}
		else {
		  if (width != 0) {
			jQuery(this).width(ratio * width);
			jQuery(this).height(ratio * width);
			jQuery(this).parent().width(ratio * width);
			jQuery(this).parent().height(ratio * width);
		  }
		  jQuery(this).css({
			borderWidth: ratio * jQuery(this).attr("data-border-width")
		  });
		}
	  });
	});

	jQuery(".wds_slideshow_image_<?php echo $wds; ?> span, .wds_slideshow_image_<?php echo $wds; ?> i").each(function () {
	  var font_size;
	  var ratio_new;
	  var font_size_new;
	  var min_font_size;
	  font_size = parseFloat(jQuery(this).attr("data-wds-fsize")) * ratio;
	  font_size_new = font_size;
	  ratio_new = ratio;
	  if (jQuery(this).attr('data-type') == 'wds_text_parent') {
		min_font_size = jQuery(this).attr("data-wds-fmin-size");
		if (min_font_size > font_size) {
		  font_size_new = min_font_size;
		  ratio_new = ratio * font_size_new / font_size;
		}
	  }
	  jQuery(this).css({
		fontSize: (font_size_new) + "px",
		lineHeight: "1.25em",
		paddingLeft: (parseFloat(jQuery(this).attr("data-wds-fpaddingl")) * ratio_new) + "px",
		paddingRight: (parseFloat(jQuery(this).attr("data-wds-fpaddingr")) * ratio_new) + "px",
		paddingTop: (parseFloat(jQuery(this).attr("data-wds-fpaddingt")) * ratio_new) + "px",
		paddingBottom: (parseFloat(jQuery(this).attr("data-wds-fpaddingb")) * ratio_new) + "px",
	  });
	});

  if ( !wds_object.is_free ) {
    wds_display_hotspot();
	  wds_hotspot_position("", ratio);
  }
	if (<?php echo $parallax_effect ?>) {
	  wds_parallax(<?php echo $wds; ?>);
	}
	jQuery(".wds_slideshow_image_<?php echo $wds; ?> [data-type='wds_text_parent']").each(function () {
	  var id = jQuery(this).attr("id");
		if (wds_data_<?php echo $wds; ?>[jQuery("#" + id).data("row-key")]["layer_"+ jQuery("#" + id).data("layer-key") +"_align_layer"] == 1) {
		  var slider_width = jQuery(".wds_slider_" + <?php echo $wds; ?>).outerWidth(); 
		  var left;
		  if ((jQuery("#" +  id).offset().left - jQuery(".wds_slideshow_image_<?php echo $wds; ?>").offset().left) > (slider_width / 2 + jQuery(this).outerWidth() / 2)) {
			left = slider_width - jQuery(this).outerWidth();
		  }
		  else if ((jQuery("#" +  id).offset().left - jQuery(".wds_slideshow_image_<?php echo $wds; ?>").offset().left) < (slider_width / 2 - jQuery(this).outerWidth() / 2)) {
			left = 0;
		  }
		  else {
			left = slider_width / 2 - jQuery(this).outerWidth() / 2;
		  }
		  var left_percent = (slider_width != 0) ? 100 * left / slider_width : 0;
		  jQuery("#" +  id).css({left:left_percent + "%"});
		}
	});
	wds_resize_instagram_post_<?php echo $wds; ?>();
	wds_window_fixed_size<?php echo $wds; ?>("#wds_image_id_<?php echo $wds; ?>_" + wds_data_<?php echo $wds; ?>[parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val())]["id"]);
	}
	/* Generate background position for Zoom Fade effect.*/
	function wds_genBgPos_<?php echo $wds; ?>(current_key) {
	var bgSizeArray = [0, 70];
	var bgSize = bgSizeArray[Math.floor(Math.random() * bgSizeArray.length)];
	var bgPosXArray = ['left', 'right'];
	var bgPosYArray = ['top', 'bottom'];
	var bgPosX = bgPosXArray[Math.floor(Math.random() * bgPosXArray.length)];
	var bgPosY = bgPosYArray[Math.floor(Math.random() * bgPosYArray.length)];
	jQuery(current_key + " .wds_slideshow_image_<?php echo $wds; ?>").css({
	  backgroundPosition: bgPosX + " " + bgPosY,
	  backgroundSize : (100 + bgSize) + "% " + (100 + bgSize) + "%",
	  webkitAnimation: ' wdszoom' + bgSize + ' <?php echo 1.1 * $slideshow_interval; ?>s linear 0s alternate infinite',
	  mozAnimation: ' wdszoom' + bgSize + ' <?php echo 1.1 * $slideshow_interval; ?>s linear 0s alternate infinite',
	  animation: ' wdszoom' + bgSize + ' <?php echo 1.1 * $slideshow_interval; ?>s linear 0s alternate infinite'
	});
	}
	function wds_full_width_<?php echo $wds; ?>() {
	var left = jQuery("#wds_container1_<?php echo $wds; ?>").offset().left;
	jQuery(".wds_slideshow_image_wrap_<?php echo $wds; ?>").css({
	  left: (-left) + "px",
	  width: (jQuery(window).width()) + "px",
	  maxWidth: "none"
	});
	}
	if ("<?php echo $current_image_url; ?>" != '') {
	jQuery('<img />').attr("src", "<?php echo $current_image_url; ?>").on('load', function() {
	  jQuery(this).remove();
	  wds_ready_<?php echo $wds; ?>();
	});
	}
	else {
	jQuery(document).ready(function () {
	  wds_ready_<?php echo $wds; ?>();
	});
	}
	if ('<?php echo $fixed_bg; ?>' == 1) {
	jQuery(window).scroll(function () {
	  wds_window_fixed_pos<?php echo $wds; ?>();
	});
	}
	function wds_window_fixed_size<?php echo $wds; ?>(id) {
	if ('<?php echo $fixed_bg; ?>' != 1 || wds_data_<?php echo $wds; ?>[parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val())]["is_video"] != 'image') {
	  return;
	}
	var image = new Image();
	image.src = jQuery(id + " .wds_slideshow_image_<?php echo $wds; ?>").css('background-image').replace(/url\(|\)$|"/ig, '');
	var slide_bg_width = image.width;
	var slide_bg_height = image.height;
	if (typeof image.remove != 'undefined') {
	  image.remove();
	}
	var window_height = jQuery(window).height();
	var window_width = jQuery(window).width();
	var width, height;
	if ('<?php echo $slider->bg_fit; ?>' == 'cover' || '<?php echo $slider->bg_fit; ?>' == 'contain') {
	  var scale = Math.max(window_width / slide_bg_width, window_height / slide_bg_height);
	  width = slide_bg_width * scale;
	  height = slide_bg_height * scale;
	}
	else {
	  width = window_width;
	  height = window_height;
	}
	jQuery(id + " .wds_slideshow_image_<?php echo $wds; ?>").css({"background-size": width + "px " + height + "px"});
	wds_window_fixed_pos<?php echo $wds; ?>(id);
	}
	function wds_window_fixed_pos<?php echo $wds; ?>(id) {
	var cont = (typeof id == "undefined") ? "" : id + " ";
	var offset = jQuery(cont + ".wds_slideshow_image_<?php echo $wds; ?>").offset().top;
	var scrtop = jQuery(document).scrollTop();
	var sliderheight = jQuery(cont + ".wds_slideshow_image_<?php echo $wds; ?>").height();
	var window_height = jQuery(window).height();
	var fixed_pos;
	if ('<?php echo ($smart_crop == '1' && ($slider->bg_fit == 'cover' || $slider->bg_fit == 'contain')) ?>' ) {
	  if ('<?php echo $crop_image_position; ?>' == 'right bottom'
		|| '<?php echo $crop_image_position; ?>' == 'center bottom'
		|| '<?php echo $crop_image_position; ?>' == 'left bottom') {
		pos_retion_height = "100%";
	  }
	  else if ('<?php echo $crop_image_position; ?>' == 'left center'
		|| '<?php echo $crop_image_position; ?>' == 'center center'
		|| '<?php echo $crop_image_position; ?>' == 'right center') {
		pos_retion_height = "50%";
	  }
	  else if ('<?php echo $crop_image_position; ?>' == 'left top'
		|| '<?php echo $crop_image_position; ?>' == 'center top'
		|| '<?php echo $crop_image_position; ?>' == 'right top') {
		pos_retion_height = "0%";
	  }
	}
	fixed_pos = offset - scrtop - window_height / 2 + sliderheight / 2;
	jQuery(cont + ".wds_slideshow_image_<?php echo $wds; ?>").css({"background-position": "50% " + "calc(50% - " + fixed_pos + "px)"});
	if (scrtop < offset + sliderheight) {
	  if ('<?php echo $smart_crop == '1' && ($slider->bg_fit == 'contain' || $slider->bg_fit == 'cover') ?>' == true) {
		jQuery(cont + ".wds_slideshow_image_<?php echo $wds; ?>").css({"background-position": "" + pos_retion_height + " " + "calc(50% - " + fixed_pos + "px)"});
	  }
	}
	}
	function wds_ready_<?php echo $wds; ?>() {
	<?php
	if (isset($callback_items["onSliderI"])) {
	  echo $callback_items["onSliderI"];
	}
	if ($enable_slideshow_autoplay && $slider->stop_animation) {
	  ?>
	jQuery("#wds_container1_<?php echo $wds; ?>").mouseover(function(e) {
	  wds_stop_animation_<?php echo $wds; ?>();
	});
	jQuery("#wds_container1_<?php echo $wds; ?>").mouseout(function(e) {
	  if (!e) {
		var e = window.event;
	  }
	  var reltg = (e.relatedTarget) ? e.relatedTarget : e.toElement;
	  if (typeof reltg != "undefined") {
		if (reltg != null) {
		  if (typeof reltg.tagName != "undefined") {
			while (reltg.tagName != 'BODY') {
			  if (reltg.id == this.id){
				return;
			  }
			  reltg = reltg.parentNode;
			}
		  }
		}
	  }
	  wds_play_animation_<?php echo $wds; ?>();
	});
	  <?php
	}
	?>
	if ('<?php echo $slider->bull_butt_img_or_not; ?>' == 'text') {
	  wds_set_text_dots_cont(<?php echo $wds; ?>);
	}
	jQuery(".wds_slideshow_image_<?php echo $wds; ?> span, .wds_slideshow_image_<?php echo $wds; ?> i").each(function () {
	  jQuery(this).attr("data-wds-fpaddingl", jQuery(this).css("paddingLeft"));
	  jQuery(this).attr("data-wds-fpaddingr", jQuery(this).css("paddingRight"));
	  jQuery(this).attr("data-wds-fpaddingt", jQuery(this).css("paddingTop"));
	  jQuery(this).attr("data-wds-fpaddingb", jQuery(this).css("paddingBottom"));
	});
	if (<?php echo $navigation; ?>) {
	  jQuery("#wds_container2_<?php echo $wds; ?>").hover(function () {
		jQuery(".wds_right-ico_<?php echo $wds; ?>").animate({left: 0}, 700, "swing");
		jQuery(".wds_left-ico_<?php echo $wds; ?>").animate({left: 0}, 700, "swing");
		jQuery("#wds_slideshow_play_pause_<?php echo $wds; ?>").animate({opacity: 1, filter: "Alpha(opacity=100)"}, 700, "swing");
	  }, function () {
		jQuery(".wds_right-ico_<?php echo $wds; ?>").css({left: 4000});
		jQuery(".wds_left-ico_<?php echo $wds; ?>").css({left: -4000});
		jQuery("#wds_slideshow_play_pause_<?php echo $wds; ?>").css({opacity: 0, filter: "Alpha(opacity=0)"});
	  });
	}
	if (!<?php echo $bull_hover; ?>) {
	  jQuery("#wds_container2_<?php echo $wds; ?>").hover(function () {
		jQuery(".wds_slideshow_dots_container_<?php echo $wds; ?>").animate({opacity: 1, filter: "Alpha(opacity=100)"}, 700, "swing");
	  }, function () {
		jQuery(".wds_slideshow_dots_container_<?php echo $wds; ?>").css({opacity: 0, filter: "Alpha(opacity=0)"});
	  });
	}
	wds_resize_slider_<?php echo $wds; ?>();
	<?php if (!$carousel) { ?>
		jQuery("#wds_container2_<?php echo $wds; ?>").css({visibility: 'visible'});
		jQuery(".wds_loading").hide();
	<?php } ?>
	function wds_filmstrip_move_left() {
	  if (typeof jQuery().stop !== 'undefined') {
		if (jQuery.isFunction(jQuery().stop)) {
		  jQuery( ".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>" ).stop(true, false);
		}
	  }
	  if (jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?> < 0) {
		jQuery(".wds_slideshow_filmstrip_right_<?php echo $wds; ?>").css({opacity: 1, filter: "Alpha(opacity=100)"});
		if (jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?> > - <?php echo $filmstrip_thumb_margin_hor + $filmstrip_width; ?>) {
		  jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").animate({<?php echo $left_or_top; ?>: 0}, 100, 'linear');
		}
		else {
		  jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").animate({<?php echo $left_or_top; ?>: (jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?> + <?php echo $filmstrip_thumb_margin_hor + $filmstrip_width; ?>)}, 100, 'linear');
		}
	  }
	  /* Disable left arrow.*/
	  window.setTimeout(function(){
		if (jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?> == 0) {
		  jQuery(".wds_slideshow_filmstrip_left_<?php echo $wds; ?>").css({opacity: 0.3, filter: "Alpha(opacity=30)"});
		}
	  }, 500);
	}
	function wds_filmstrip_move_right() {
	  if (typeof jQuery().stop !== 'undefined') {
		if (jQuery.isFunction(jQuery().stop)) {
		  jQuery( ".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>" ).stop(true, false);
		}
	  }
	  if (jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?> >= -(jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").<?php echo $width_or_height; ?>() - jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").<?php echo $width_or_height; ?>())) {
		jQuery(".wds_slideshow_filmstrip_left_<?php echo $wds; ?>").css({opacity: 1, filter: "Alpha(opacity=100)"});
		if (jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?> < -(jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").<?php echo $width_or_height; ?>() - jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").<?php echo $width_or_height; ?>() - <?php echo $filmstrip_thumb_margin_hor + $filmstrip_width; ?>)) {
		  jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").animate({<?php echo $left_or_top; ?>: -(jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").<?php echo $width_or_height; ?>() - jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").<?php echo $width_or_height; ?>())}, 100, 'linear');
		}
		else {
		  jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").animate({<?php echo $left_or_top; ?>: (jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?> - <?php echo $filmstrip_thumb_margin_hor + $filmstrip_width; ?>)}, 100, 'linear');
		}
	  }
	  /* Disable right arrow.*/
	  window.setTimeout(function() {
		if (jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").position().<?php echo $left_or_top; ?> == -(jQuery(".wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>").<?php echo $width_or_height; ?>() - jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").<?php echo $width_or_height; ?>())) {
		  jQuery(".wds_slideshow_filmstrip_right_<?php echo $wds; ?>").css({opacity: 0.3, filter: "Alpha(opacity=30)"});
		}
	  }, 500);
	}
	<?php
	if ($slider->effect == 'zoomFade') {
	  ?>
	  wds_genBgPos_<?php echo $wds; ?>("#wds_image_id_<?php echo $wds; ?>_" + wds_data_<?php echo $wds; ?>[parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val())]["id"]);
	  <?php
	}
	if ($image_right_click) {
	  ?>
	  /* Disable right click.*/
	  jQuery('div[id^="wds_container"]').bind("contextmenu", function () {
		return false;
	  });
	  <?php
	}
	if ($slider->effect == 'fade') {
	  ?>
	var curr_img_id = wds_data_<?php echo $wds; ?>[parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val())]["id"];
	jQuery("#wds_image_id_<?php echo $wds; ?>_" + curr_img_id).css('transition', 'opacity ' + wds_transition_duration_<?php echo $wds; ?> + 'ms linear');
	  <?php
	}
	?>
	var isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));
	if (isMobile) {
	  if (<?php echo $touch_swipe_nav; ?>) {
		wds_swipe();
	  }
	}
	else {
	  if (<?php echo $mouse_swipe_nav; ?>) {
		wds_swipe();
	  }
	}
	function wds_swipe() {
	  if (typeof jQuery().swiperight !== 'undefined') {
		if (jQuery.isFunction(jQuery().swiperight)) {
		  jQuery('.wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>').swiperight(function () {
			wds_filmstrip_move_left();
			return false;
		  });
		  jQuery('#wds_container1_<?php echo $wds; ?>').swiperight(function () {
			wds_change_image_<?php echo $wds; ?>(parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()), (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) - wds_iterator_<?php echo $wds; ?>()) >= 0 ? (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) - wds_iterator_<?php echo $wds; ?>()) % wds_data_<?php echo $wds; ?>.length : wds_data_<?php echo $wds; ?>.length - 1, wds_data_<?php echo $wds; ?>, false, "left");
			<?php  if ( $carousel ) { ?>
				wds_carousel<?php echo $wds; ?>.prev();
			<?php } ?>
			<?php if(isset($callback_items["onSwipeS"])) echo $callback_items["onSwipeS"]; ?>
			return false;
		  });
		 }
	  }
	  if (typeof jQuery().swipeleft !== 'undefined') {
		if (jQuery.isFunction(jQuery().swipeleft)) {
		  jQuery('.wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?>').swipeleft(function () {
			wds_filmstrip_move_right();
			return false;
		  });
		  jQuery('#wds_container1_<?php echo $wds; ?>').swipeleft(function () {
			wds_change_image_<?php echo $wds; ?>(parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()), (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) + wds_iterator_<?php echo $wds; ?>()) % wds_data_<?php echo $wds; ?>.length, wds_data_<?php echo $wds; ?>, false, "right");
			<?php if ( $carousel ) { ?>
				wds_carousel<?php echo $wds; ?>.next();
			<?php } ?>
			<?php if(isset($callback_items["onSwipeS"])) echo $callback_items["onSwipeS"]; ?>
			return false;
		  });
		}
	  }
	}
	var wds_click = isMobile ? 'touchend' : 'click';
	var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel"; /* FF doesn't recognize mousewheel as of FF3.x */
	jQuery('.wds_slideshow_filmstrip_<?php echo $wds; ?>').bind(mousewheelevt, function(e) {
	  var evt = window.event || e; /* Equalize event object.*/
	  evt = evt.originalEvent ? evt.originalEvent : evt; /* Convert to originalEvent if possible.*/
	  var delta = evt.detail ? evt.detail*(-40) : evt.wheelDelta; /* Check for detail first, because it is used by Opera and FF.*/
	  if (delta > 0) {
		/* Scroll up.*/
		jQuery(".wds_slideshow_filmstrip_left_<?php echo $wds; ?>").trigger("click");
	  }
	  else {
		/* Scroll down.*/
		jQuery(".wds_slideshow_filmstrip_right_<?php echo $wds; ?>").trigger("click");
	  }
	  return false;
	});
	jQuery(".wds_slideshow_filmstrip_right_<?php echo $wds; ?>").on(wds_click, function () {
	  wds_filmstrip_move_right();
	});
	jQuery(".wds_slideshow_filmstrip_left_<?php echo $wds; ?>").on(wds_click, function () {
	  wds_filmstrip_move_left();
	});
	/* Set filmstrip initial position.*/
	wds_set_filmstrip_pos_<?php echo $wds; ?>(jQuery(".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").<?php echo $width_or_height; ?>());

	function wds_message_listener_<?php echo $wds; ?>(e) {
	  try {
		var data = JSON.parse(e.data);
		if (data.method == "paused") {
		  iframe_message_received_<?php echo $wds; ?> = iframe_message_received_<?php echo $wds; ?> + 1;
		  if (data.value == false) {
			video_is_playing_<?php echo $wds; ?> = true;
		  }
		}
	  } catch (e) {
		  return false;
	  }
	}
	if (window.addEventListener){
	  window.addEventListener('message', wds_message_listener_<?php echo $wds; ?>, false);
	}
	else {
	  window.attachEvent('onmessage', wds_message_listener_<?php echo $wds; ?>, false);
	}
	/* Mouswheel navigation.*/
	if (<?php echo $mouse_wheel_nav; ?>) {
	  jQuery('.wds_slide_container_<?php echo $wds; ?>').bind(mousewheelevt, function(e) {
		var evt = window.event || e; /* Equalize event object.*/
		evt = evt.originalEvent ? evt.originalEvent : evt; /* Convert to originalEvent if possible.*/
		var delta = evt.detail ? evt.detail*(-40) : evt.wheelDelta; /* Check for detail first, because it is used by Opera and FF.*/
		if (delta > 0) {
		  /* Scroll up.*/
		  wds_change_image_<?php echo $wds; ?>(parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()), (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) - wds_iterator_<?php echo $wds; ?>()) >= 0 ? (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) - wds_iterator_<?php echo $wds; ?>()) % wds_data_<?php echo $wds; ?>.length : wds_data_<?php echo $wds; ?>.length - 1, wds_data_<?php echo $wds; ?>, false, "left");
		}
		else {
		  /* Scroll down.*/
		  wds_change_image_<?php echo $wds; ?>(parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()), (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) + wds_iterator_<?php echo $wds; ?>()) % wds_data_<?php echo $wds; ?>.length, wds_data_<?php echo $wds; ?>, false, "right");
		}
		return false;
	  });
	}
	/* Keyboard navigation.*/
	if (<?php echo $keyboard_nav; ?>) {
	  jQuery(document).on('keydown', function (e) {
		if (e.keyCode === 39 || e.keyCode === 38) { /* Right arrow.*/
		  wds_change_image_<?php echo $wds; ?>(parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()), (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) + wds_iterator_<?php echo $wds; ?>()) % wds_data_<?php echo $wds; ?>.length, wds_data_<?php echo $wds; ?>, false, "right");
		}
		else if (e.keyCode === 37 || e.keyCode === 40) { /* Left arrow.*/
		  wds_change_image_<?php echo $wds; ?>(parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()), (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) - wds_iterator_<?php echo $wds; ?>()) >= 0 ? (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) - wds_iterator_<?php echo $wds; ?>()) % wds_data_<?php echo $wds; ?>.length : wds_data_<?php echo $wds; ?>.length - 1, wds_data_<?php echo $wds; ?>, false, "left");  
		}
		else if (e.keyCode === 32) { /* Space.*/
		  wds_play_pause_<?php echo $wds; ?>();
		}
	  });
	}
	/* Play/pause.*/
	jQuery("#wds_slideshow_play_pause_<?php echo $wds; ?>").on(wds_click, function () {
	   wds_play_pause_<?php echo $wds; ?>();
	});
	if (<?php echo $enable_slideshow_autoplay; ?>) {
	  play_<?php echo $wds; ?>();

	  jQuery(".wds_slideshow_play_pause_<?php echo $wds; ?>").attr("title", "<?php echo __('Pause', 'wds'); ?>");
	  jQuery(".wds_slideshow_play_pause_<?php echo $wds; ?>").attr("class", "wds_ctrl_btn_<?php echo $wds; ?> wds_slideshow_play_pause_<?php echo $wds; ?> fa fa-pause");
	  if (<?php echo $enable_slideshow_music ?>) {
		if ('<?php echo $slideshow_music_url; ?>' != '') {
		  document.getElementById("wds_audio_<?php echo $wds; ?>").play();
		}
	  }
	  if ('<?php echo $slider->timer_bar_type; ?>' != 'none') {
		if ('<?php echo $slider->timer_bar_type; ?>' != 'top') {
		  if ('<?php echo $slider->timer_bar_type; ?>' != 'bottom') {
			circle_timer_<?php echo $wds; ?>(0);
		  }
		}
	  }
	}
	<?php if ($preload_images) { ?>
	function wds_preload_<?php echo $wds; ?>(preload_key) {
	  if (wds_data_<?php echo $wds; ?>[preload_key]["is_video"] == 'image') {
	  jQuery('<img />')
		.on('load', function() {
		  jQuery(this).remove();
		  if (preload_key < wds_data_<?php echo $wds; ?>.length - 1) wds_preload_<?php echo $wds; ?>(preload_key + 1);
		})
		.on('error', function() {
		  jQuery(this).remove();
		  if (preload_key < wds_data_<?php echo $wds; ?>.length - 1) wds_preload_<?php echo $wds; ?>(preload_key + 1);
		})
		.attr("src", wds_data_<?php echo $wds; ?>[preload_key]["image_url"]);
	  }
	  else {
		if (preload_key < wds_data_<?php echo $wds; ?>.length - 1) wds_preload_<?php echo $wds; ?>(preload_key + 1);
	  }
	}
	wds_preload_<?php echo $wds; ?>(0);
	<?php } ?>
	var first_slide_layers_count_<?php echo $wds; ?> = wds_data_<?php echo $wds; ?>[<?php echo $start_slide_num; ?>]["slide_layers_count"];
	if (first_slide_layers_count_<?php echo $wds; ?>) {
	  /* Loop through layers in.*/
	  for (var j = 0; j < first_slide_layers_count_<?php echo $wds; ?>; j++) {
		wds_set_layer_effect_in_<?php echo $wds; ?>(j, <?php echo $start_slide_num; ?>);
	  }
	  /* Loop through layers out.*/
	  for (var i = 0; i < first_slide_layers_count_<?php echo $wds; ?>; i++) {
		wds_set_layer_effect_out_<?php echo $wds; ?>(i, <?php echo $start_slide_num; ?>);
	  }
	}
    if ( !wds_object.is_free ) {
	wds_video_dimenstion(<?php echo $wds; ?>, jQuery("#wds_current_image_key_<?php echo $wds; ?>").val());
    }
	if ('<?php echo $fixed_bg; ?>' == 1) {
	  wds_window_fixed_pos<?php echo $wds; ?>();
	}
	jQuery(".wds_slideshow_filmstrip_<?php echo $wds; ?>").hover(function() {
	  jQuery(".wds_slideshow_filmstrip_left_<?php echo $wds; ?> i, .wds_slideshow_filmstrip_right_<?php echo $wds; ?> i").animate({opacity: 1, filter: "Alpha(opacity=100)"}, 700, "swing");
	}, function () {
	  jQuery(".wds_slideshow_filmstrip_left_<?php echo $wds; ?> i, .wds_slideshow_filmstrip_right_<?php echo $wds; ?> i").animate({opacity: 0, filter: "Alpha(opacity=0)"}, 700, "swing");
	});
	jQuery("#wds_container1_<?php echo $wds; ?>").hover(function() {
	   <?php if(isset($callback_items["onSliderHover"])) echo $callback_items["onSliderHover"]; ?>
	}, function () {
	  <?php if(isset($callback_items["onSliderBlur"])) echo $callback_items["onSliderBlur"]; ?>
	});
	jQuery("#wds_slideshow_play_pause_<?php echo $wds; ?>").on("click", ".fa-play", function() {
		<?php if(isset($callback_items["onSliderPlay"])) echo $callback_items["onSliderPlay"]; ?>
	});
	jQuery("#wds_slideshow_play_pause_<?php echo $wds; ?>").on("click", ".fa-pause", function() {
		<?php if(isset($callback_items["onSliderPause"])) echo $callback_items["onSliderPause"]; ?>
	});
	}
	var wds_play_pause_state_<?php echo $wds; ?> = 0;
	function wds_play_<?php echo $wds; ?>() {
	wds_play_pause_state_<?php echo $wds; ?> = 0;
	/* Play.*/
	jQuery(".wds_slideshow_play_pause_<?php echo $wds; ?>").attr("title", "<?php echo __('Pause', 'wds'); ?>");
	jQuery(".wds_slideshow_play_pause_<?php echo $wds; ?>").attr("class", "wds_ctrl_btn_<?php echo $wds; ?> wds_slideshow_play_pause_<?php echo $wds; ?> fa fa-pause");
	/* Finish current animation and begin the other.*/
	if (<?php echo $enable_slideshow_autoplay; ?>) {
	  if ('<?php echo $slider->timer_bar_type; ?>' != 'top') {
		if ('<?php echo $slider->timer_bar_type; ?>' != 'bottom') {
		  if (typeof circle_timer_animate_<?php echo $wds; ?> !== 'undefined') {
			circle_timer_animate_<?php echo $wds; ?>.stop();
			<?php if ( $carousel ) { ?>
			  wds_carousel<?php echo $wds; ?>.pause();
			<?php } ?>
		  }
		  circle_timer_<?php echo $wds; ?>(curent_time_deggree_<?php echo $wds; ?>);
		}
	  }
	}
	play_<?php echo $wds; ?>();
	if (<?php echo $enable_slideshow_music ?>) {
	  if ('<?php echo $slideshow_music_url; ?>' != '') {
		document.getElementById("wds_audio_<?php echo $wds; ?>").play();
	  }
	}
	<?php if ( $carousel ) { ?>
	  wds_carousel<?php echo $wds; ?>.start();
	<?php } ?>
	}
	function wds_pause_<?php echo $wds; ?>() {
	/* Pause.*/
	/* Pause layers out effect.*/
	wds_play_pause_state_<?php echo $wds; ?> = 1;
	var current_key = jQuery('#wds_current_image_key_<?php echo $wds; ?>').val();
	var current_slide_layers_count = wds_data_<?php echo $wds; ?>[current_key]["slide_layers_count"];
	setTimeout(function() {
	  for (var k = 0; k < current_slide_layers_count; k++) {
		clearTimeout(wds_clear_layers_effects_out_<?php echo $wds; ?>[current_key][k]);
	  }
	}, wds_duration_for_clear_effects_<?php echo $wds; ?>);
	window.clearInterval(wds_playInterval_<?php echo $wds; ?>);
	jQuery(".wds_slideshow_play_pause_<?php echo $wds; ?>").attr("title", "<?php echo __('Play', 'wds'); ?>");
	jQuery(".wds_slideshow_play_pause_<?php echo $wds; ?>").attr("class", "wds_ctrl_btn_<?php echo $wds; ?> wds_slideshow_play_pause_<?php echo $wds; ?> fa fa-play");
	if (<?php echo $enable_slideshow_music ?>) {
	  document.getElementById("wds_audio_<?php echo $wds; ?>").pause();
	}
	if (typeof jQuery().stop !== 'undefined') {
	  if (jQuery.isFunction(jQuery().stop)) {
		<?php
		if ($slider->timer_bar_type == 'top' ||  $slider->timer_bar_type == 'bottom') {
		  ?>
		  jQuery(".wds_line_timer_<?php echo $wds; ?>").stop();
		  <?php
		}
		elseif ($slider->timer_bar_type != 'none') {
		  ?>
		  /* Pause circle timer.*/
		  if (typeof circle_timer_animate_<?php echo $wds; ?>.stop !== 'undefined') {
			circle_timer_animate_<?php echo $wds; ?>.stop();
			<?php if ( $carousel ) { ?>
			  wds_carousel<?php echo $wds; ?>.pause();
			<?php } ?>
		  }
		  <?php
		}
		?>
	  }
	}
	<?php if ( $carousel ) { ?>
	  wds_carousel<?php echo $wds; ?>.pause();
	<?php } ?>
	}
	function wds_play_pause_<?php echo $wds; ?>(play_pause) {
	if (typeof play_pause == "undefined") {
	  var play_pause = "";
	}
	if (play_pause == "") {
	  if (jQuery(".wds_ctrl_btn_<?php echo $wds; ?>").hasClass("fa-play") || wds_play_pause_state_<?php echo $wds; ?>) {
		wds_play_<?php echo $wds; ?>();
	  }
	  else {
		wds_pause_<?php echo $wds; ?>();
	  }
	}
	else if (play_pause == "play") {
	  wds_play_<?php echo $wds; ?>();
	}
	else if (play_pause == "pause") {
	  wds_pause_<?php echo $wds; ?>();
	}
	}
	function wds_stop_animation_<?php echo $wds; ?>() {
	window.clearInterval(wds_playInterval_<?php echo $wds; ?>);
	/* Pause layers out effect.*/
	var current_key = jQuery('#wds_current_image_key_<?php echo $wds; ?>').val();
	var current_slide_layers_count = wds_data_<?php echo $wds; ?>[current_key]["slide_layers_count"];

	setTimeout(function() {
	  for (var k = 0; k < current_slide_layers_count; k++) {
		clearTimeout(wds_clear_layers_effects_out_<?php echo $wds; ?>[current_key][k]);
	  }
	}, wds_duration_for_clear_effects_<?php echo $wds; ?>);
	if (<?php echo $enable_slideshow_music ?>) {
	  document.getElementById("wds_audio_<?php echo $wds; ?>").pause();
	}
	if (typeof jQuery().stop !== 'undefined') {
	  if (jQuery.isFunction(jQuery().stop)) {
		if ('<?php echo $slider->timer_bar_type; ?>' == 'top' || '<?php echo $slider->timer_bar_type; ?>' == 'bottom') {
		  jQuery(".wds_line_timer_<?php echo $wds; ?>").stop();
		  <?php if ( $carousel ) { ?>
			wds_carousel<?php echo $wds; ?>.pause();
		  <?php } ?>
		}
		else if ('<?php echo $slider->timer_bar_type; ?>' != 'none') {
		  circle_timer_animate_<?php echo $wds; ?>.stop();
		  <?php if ( $carousel ) { ?>
			wds_carousel<?php echo $wds; ?>.pause();
		  <?php } ?>
		}
	  }
	}
	}
	function wds_play_animation_<?php echo $wds; ?>() {
	if (jQuery(".wds_ctrl_btn_<?php echo $wds; ?>").hasClass("fa-play")) {
	  return;
	}
	play_<?php echo $wds; ?>();
	<?php if ( $carousel ) { ?>
	  wds_carousel<?php echo $wds; ?>.start();
	<?php } ?>
	if ('<?php echo $slider->timer_bar_type; ?>' != 'none') {
	  if ('<?php echo $slider->timer_bar_type; ?>' != 'bottom') {
		if ('<?php echo $slider->timer_bar_type; ?>' != 'top') {
		  if (typeof circle_timer_animate_<?php echo $wds; ?> !== 'undefined') {
			circle_timer_animate_<?php echo $wds; ?>.stop();
			<?php if ( $carousel ) { ?>
				wds_carousel<?php echo $wds; ?>.pause();
			<?php } ?>
		  }
		  circle_timer_<?php echo $wds; ?>(curent_time_deggree_<?php echo $wds; ?>);
		}
	  }
	}
	if (<?php echo $enable_slideshow_music ?>) {
	  if ('<?php echo $slideshow_music_url; ?>' != '') {
		document.getElementById("wds_audio_<?php echo $wds; ?>").play();
	  }
	}
	var next_slide_layers_count = wds_data_<?php echo $wds; ?>[wds_current_key_<?php echo $wds; ?>]["slide_layers_count"];
	for (var i = 0; i < next_slide_layers_count; i++) {
	  wds_set_layer_effect_out_<?php echo $wds; ?>(i, wds_current_key_<?php echo $wds; ?>);
	}
	}
	/* Effects in part.*/
	function wds_set_layer_effect_in_<?php echo $wds; ?>(j, key) {
	var cout;
		wds_clear_layers_effects_in_<?php echo $wds; ?>[key][j] = setTimeout(function() {
	  cout = jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_id"]);
	  if (wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_type"] != 'social') {
			if (jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_id"]).prev().attr('id') != 'wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_id"] + '_round_effect') {
		  cout.css('-webkit-animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's').css('animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's');
		  jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_id"]).removeClass().addClass( wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_layer_effect_in"] + ' wds_animated');
		  cout.addClass(jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_id"]).data("class"));
		}
		else {
		  cout = jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_id"]+'_div');
		  cout.css('-webkit-animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's').css('animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's');
		  cout.removeClass().addClass('hotspot_container ' + wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_layer_effect_in"] + ' wds_animated');
		}
		  }
	  else {
		cout.css('-webkit-animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's').css('animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_duration_eff_in"] / 1000 + 's');	
		cout.removeClass().addClass( wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_layer_effect_in"] + ' fa fa-' + wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_social_button"] + ' wds_animated');
	  }
	  /* Play video on layer in.*/
	  if (wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_type"] == "video") {
		if (wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_video_autoplay"] == "on") {


		  cout.find("iframe").each(function () {
			if (jQuery(this).attr('data-type') == 'youtube') {
			  player = youtube_iframes_ids_<?php echo $wds; ?>.indexOf(this.id);
			  if (typeof youtube_iframes_<?php echo $wds; ?>[player] != "undefined") {
    if ( !wds_object.is_free ) {
				wds_playVideo(youtube_iframes_<?php echo $wds; ?>[player]);
    }
			  }
			}
			else if (jQuery(this).attr('type') == 'vimeo') {
			  jQuery(this)[0].contentWindow.postMessage('{ "method": "play" }', "*");
			}
			else {
			  jQuery(this)[0].contentWindow.postMessage('play', '*');
			}
		  });
		}
	  }
    if ( !wds_object.is_free ) {
	  wds_upvideo_layer_dimenstion(<?php echo $wds; ?>, key, j);
    }
	  var iteration_count = wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_infinite_in"] == 0 ? 'infinite' : wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_infinite_in"];
	  cout.css(
		'-webkit-animation-iteration-count', iteration_count
	  ).css(
		'animation-iteration-count', iteration_count
	  );
		}, wds_data_<?php echo $wds; ?>[key]["layer_" + j + "_start"]);
	  }
	/* Effects out part.*/
	function wds_set_layer_effect_out_<?php echo $wds; ?>(i, key) {
	var cout;
		wds_clear_layers_effects_out_<?php echo $wds; ?>[key][i] = setTimeout(function() {
	  cout = jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_id"]);  
	  if (wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_layer_effect_out"] != 'none') {
		if (wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_type"] != 'social') {
		  if (jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_id"]).prev().attr('id') != 'wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_id"] + '_round_effect') {
			cout.css('-webkit-animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's').css('animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's');
			cout.removeClass().addClass( wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_layer_effect_out"] + ' wds_animated');
		  }
		  else {
			cout = jQuery('#wds_<?php echo $wds; ?>_slide' + wds_data_<?php echo $wds; ?>[key]["id"] + '_layer' + wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_id"]+'_div');
			cout.css('-webkit-animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's').css('animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's');
			cout.removeClass().addClass( wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_layer_effect_out"] + ' wds_animated');
		  }
		}
		else {
		  cout.css('-webkit-animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's').css('animation-duration' , wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_duration_eff_out"] / 1000 + 's');
		  cout.removeClass().addClass( wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_layer_effect_out"] + ' fa fa-' + wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_social_button"] + ' wds_animated');
		}
		var iteration_count = wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_infinite_out"] == 0 ? 'infinite' : wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_infinite_out"];
		cout.css(
		  '-webkit-animation-iteration-count', iteration_count
		).css(
		  'animation-iteration-count', iteration_count
		);
	  }
		}, wds_data_<?php echo $wds; ?>[key]["layer_" + i + "_end"]);
	  }
	function play_<?php echo $wds; ?>() {
	if ('<?php echo $slider->timer_bar_type; ?>' != 'none') {
	  if (<?php echo $enable_slideshow_autoplay; ?> || jQuery('.wds_ctrl_btn_<?php echo $wds; ?>').hasClass('fa-pause')) {
		jQuery(".wds_line_timer_<?php echo $wds; ?>").animate({
		  width: "100%"
		}, {
		  duration: <?php echo $slideshow_interval * 1000; ?>,
		  specialEasing: {width: "linear"}
		});
	  }
	}
	window.clearInterval(wds_playInterval_<?php echo $wds; ?>);
	/* Play.*/
	wds_playInterval_<?php echo $wds; ?> = setInterval(function () {
	  var curr_img_index = parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val());
	  if ('<?php echo $slider_loop; ?>' == 0) {
		if (<?php echo $twoway_slideshow; ?>) {
		  if (wds_global_btn_<?php echo $wds; ?> == "left") {
			if (curr_img_index == 0) {
			  return false;
			}
		  }
		  else {
			if (curr_img_index == <?php echo $slides_count - 1; ?>) {
			  return false;
			}
		  }
		}
		else {
		  if (curr_img_index == <?php echo $slides_count - 1; ?>) {
			return false;
		  }
		}
	  }
	  var curr_img_id = wds_data_<?php echo $wds; ?>[parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val())]["id"];
	  video_is_playing_<?php echo $wds; ?> = false;
	  jQuery("#wds_image_id_<?php echo $wds; ?>_" + curr_img_id).find("video").each(function() {
		if (!this.paused) {
		  video_is_playing_<?php echo $wds; ?> = true;
		}
	  });
	  jQuery("#wds_image_id_<?php echo $wds; ?>_" + curr_img_id).find("iframe[type='youtube']").each(function() {
		player = youtube_iframes_ids_<?php echo $wds; ?>.indexOf(this.id);
		if (typeof youtube_iframes_<?php echo $wds; ?>[player] != "undefined") {
		  if (typeof youtube_iframes_<?php echo $wds; ?>[player].getPlayerState == "function") {
			if (youtube_iframes_<?php echo $wds; ?>[player].getPlayerState() == 1) {
			  video_is_playing_<?php echo $wds; ?> = true;
			}
		  }
		}
	  });
	  iframe_message_sent_<?php echo $wds; ?> = 0;
	  iframe_message_received_<?php echo $wds; ?> = 0;
	  jQuery("#wds_image_id_<?php echo $wds; ?>_" + curr_img_id).find("iframe[type='vimeo']").each(function() {
		jQuery(this)[0].contentWindow.postMessage('{ "method": "paused" }', "*");
		iframe_message_sent_<?php echo $wds; ?> = iframe_message_sent_<?php echo $wds; ?> + 1;
	  });
	  function wds_call_change() {
		if (!video_is_playing_<?php echo $wds; ?>) {
		  var iterator = 1;
		  var img_index = (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) + iterator) % wds_data_<?php echo $wds; ?>.length;
		  if (<?php echo $enable_slideshow_shuffle; ?>) {
			 iterator = Math.floor((wds_data_<?php echo $wds; ?>.length - 1) * Math.random() + 1);
		  }
		  else if (<?php echo $twoway_slideshow; ?>) {
			if (wds_global_btn_<?php echo $wds; ?> == "left") {
			  iterator = -1;
			  img_index = (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) + iterator) >= 0 ? (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) + iterator) % wds_data_<?php echo $wds; ?>.length : wds_data_<?php echo $wds; ?>.length - 1;
			}
		  }
		  wds_change_image_<?php echo $wds; ?>(parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()), img_index, wds_data_<?php echo $wds; ?>);
		  <?php if ( $carousel ) { ?>
			wds_carousel<?php echo $wds; ?>.next();
		  <?php } ?>
		}
	  }
	  function wds_check_message_received() {
		return iframe_message_sent_<?php echo $wds; ?> == iframe_message_received_<?php echo $wds; ?> ? true : false;
	  }
	  function wds_call(wds_condition, wds_callback) {
		if (wds_condition()) {
		  wds_callback();
		}
		else {
		  setTimeout(function () {
			wds_call(wds_condition, wds_callback);
		  }, 10);
		}
	  }
		wds_call(wds_check_message_received, wds_call_change);
		}, parseInt('<?php echo ($slideshow_interval * 1000); ?>') + wds_duration_for_change_<?php echo $wds; ?>);
	}
	function wds_callbackItems(callbackList, slide_id) {
		var key = jQuery(".wds_slideshow_image_<?php echo $wds; ?>[data-image-id='" + slide_id + "']").attr('data-image-key');
		switch (callbackList) {
		  case 'SlidePlay':
				wds_play_pause_<?php echo $wds; ?>('play');
			break;
			case 'SlidePause':
				wds_play_pause_<?php echo $wds; ?>('pause');
			break;
			case 'SlidePlayPause':
				wds_play_pause_<?php echo $wds; ?>();
			break;
			case 'SlideNext':
				wds_change_image_<?php echo $wds; ?>(parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()), (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) + wds_iterator_<?php echo $wds; ?>()) % wds_data_<?php echo $wds; ?>.length, wds_data_<?php echo $wds; ?>, false, "right"); 
				<?php if ( $carousel == 1) { ?>
					wds_carousel<?php echo $wds; ?>.next();
				<?php } ?>
				return false;
			break;
			case 'SlidePrevious':
				wds_change_image_<?php echo $wds; ?>(parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()), (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) - wds_iterator_<?php echo $wds; ?>()) >= 0 ? (parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()) - wds_iterator_<?php echo $wds; ?>()) % wds_data_<?php echo $wds; ?>.length : wds_data_<?php echo $wds; ?>.length - 1, wds_data_<?php echo $wds; ?>, false, "left"); 
				<?php if ( $carousel == 1 ) { ?>
					wds_carousel<?php echo $wds; ?>.prev();
				<?php } ?>
				return false;
			break;
			case 'SlideLink':
				wds_change_image_<?php echo $wds; ?>(parseInt(jQuery('#wds_current_image_key_<?php echo $wds; ?>').val()), parseInt(key), wds_data_<?php echo $wds; ?>); 
				<?php if ( $carousel == 1) { ?>
					wds_carousel<?php echo $wds; ?>.shift(jQuery('.wds_slider_car_image<?php echo $wds; ?>[data-image-id=' + slide_id + ']'));
				<?php } ?>
				return false;
			break;
			case 'PlayMusic':
				document.getElementById("wds_audio_<?php echo $wds; ?>").play();
			break;
		}
	}

	jQuery(window).focus(function() {
		if (!jQuery(".wds_ctrl_btn_<?php echo $wds; ?>").hasClass("fa-play")) {
		  if (<?php echo $enable_slideshow_autoplay; ?>) {
			play_<?php echo $wds; ?>();
			<?php if ( $carousel ) { ?>
				wds_carousel<?php echo $wds; ?>.start();
			<?php } ?>
			if ('<?php echo $slider->timer_bar_type; ?>' != 'none') {
			  if ('<?php echo $slider->timer_bar_type; ?>' != 'top') {
				if ('<?php echo $slider->timer_bar_type; ?>' != 'bottom') {
				  if (typeof circle_timer_animate_<?php echo $wds; ?> !== 'undefined') {
					circle_timer_animate_<?php echo $wds; ?>.stop();
				  }
				  circle_timer_<?php echo $wds; ?>(curent_time_deggree_<?php echo $wds; ?>);
				}
			  }
			}
		  }
		}
		<?php if ( !$carousel ) { ?>
		  var i_<?php echo $wds; ?> = 0;
		  jQuery(".wds_slider_<?php echo $wds; ?>").children("span").each(function () {
			if (jQuery(this).css('opacity') == 1) {
			  jQuery("#wds_current_image_key_<?php echo $wds; ?>").val(i_<?php echo $wds; ?>);
			}
			i_<?php echo $wds; ?>++;
		  });
		<?php } ?>
	});
	jQuery(window).blur(function() {
		wds_event_stack_<?php echo $wds; ?> = [];
		window.clearInterval(wds_playInterval_<?php echo $wds; ?>);
		if (typeof jQuery().stop !== 'undefined') {
		  if (jQuery.isFunction(jQuery().stop)) {
			if ('<?php echo $slider->timer_bar_type; ?>' == 'top' || '<?php echo $slider->timer_bar_type; ?>' == 'bottom') {
			  jQuery(".wds_line_timer_<?php echo $wds; ?>").stop();
			  <?php if ( $carousel ) { ?>
				wds_carousel<?php echo $wds; ?>.pause();
			  <?php } ?>
			}
			else if ('<?php echo $slider->timer_bar_type; ?>' != 'none') {
			  circle_timer_animate_<?php echo $wds; ?>.stop();
			  <?php if ( $carousel ) { ?>
				wds_carousel<?php echo $wds; ?>.pause();
			  <?php } ?>
			}
		  }
		}
	});
	jQuery(window).resize(function () {
		wds_resize_slider_<?php echo $wds; ?>();
		<?php if(isset($callback_items["onSliderR"])) echo $callback_items["onSliderR"]; ?>
	});

	<?php if ( $carousel ) { ?>
	var wds_currentlyMoving<?php echo $wds; ?>;
	var wds_currentCenterNum<?php echo $wds; ?>;
	var wds_carousel<?php echo $wds; ?>;
	function wds_carousel_params<?php echo $wds; ?>() {
		var width, height;
		var slide_orig_width = <?php echo $image_width; ?>;
		var slide_orig_height = <?php echo $image_height; ?>;
		var slide_width = wds_get_overall_parent(jQuery("#wds_container1_<?php echo $wds; ?>"));
		var par = 1, par1 = 1;
		var ratio = slide_width / slide_orig_width;
		var full_width = (jQuery(window).width() <= parseInt(<?php echo $slider->full_width_for_mobile; ?>) || <?php echo $slider->full_width; ?>) ? 1 : 0;
		if (full_width) {
			ratio = jQuery(window).width() / slide_orig_width;
			slide_orig_width = jQuery(window).width() - (2 * wds_glb_margin_<?php echo $wds; ?>);
			slide_orig_height = <?php echo $image_height; ?> * slide_orig_width / <?php echo $image_width; ?>;
			slide_width = jQuery(window).width() - (2 * wds_glb_margin_<?php echo $wds; ?>);
			wds_full_width_<?php echo $wds; ?>();
		}
		else if (parseInt(<?php echo $slider->full_width_for_mobile ?>)) {
			jQuery(".wds_slideshow_image_wrap_<?php echo $wds; ?>").removeAttr("style");
		}
		var slide_height = slide_orig_height;
		if (slide_orig_width > slide_width) {
			slide_height = Math.floor(slide_width * slide_orig_height / slide_orig_width);
		}
		width = slide_width;
		height = slide_height;
		var larg_width,img_height,parF=1;
		if (width < <?php echo $carousel_width; ?>) {
			par = width / <?php echo $carousel_width; ?>;
		}
		par1 = <?php echo $image_height; ?> * par / height;
		if (width < <?php echo $carousel_width; ?>) {
			jQuery(".wds_slideshow_image_wrap_<?php echo $wds; ?>, #wds_container2_<?php echo $wds; ?>").height(height *  par1+ <?php echo ($filmstrip_direction == 'horizontal' ? $filmstrip_height : 0); ?>);
			jQuery(".wds_slideshow_image_container_<?php echo $wds; ?>").height(height * par1);
			jQuery(".wds_btn_cont wds_contTableCell<?php echo $wds; ?>").height(height * par1  );
			jQuery(".wds_slide_container_<?php echo $wds; ?>").height(height * par1);
		}
		if (full_width) {
			var parF = parseFloat("<?php echo $carousel_image_parameters; ?>");
			parF = isNaN( parF ) ? 1 : parF;
			parF *= <?php echo $image_width; ?>;
			jQuery(".wds_slideshow_image_wrap_<?php echo $wds; ?>, #wds_container2_<?php echo $wds; ?>").height(height *par1+<?php echo ($filmstrip_direction == 'horizontal' ? $filmstrip_height : 0); ?>);
			jQuery(".wds_slideshow_image_container_<?php echo $wds; ?>").height(height * par1);
			jQuery(".wds_btn_cont wds_contTableCell<?php echo $wds; ?>").height(height* par1);
			jQuery(".wds_slide_container_<?php echo $wds; ?>").height(height * par1);
		}
		<?php
			if ($carousel_image_counts  >  $slides_count ) {
			  $carousel_image_counts = $slides_count;
			}
			if ($carousel_image_parameters > 1) {
			  $carousel_image_parameters = 1;
			}
			$interval = 0;
			if ( $enable_slideshow_autoplay == TRUE ) {
			  $interval = $slideshow_interval;
			}
		?>
		var slideshow_filmstrip_container_width = '<?php echo $filmstrip_direction; ?>' == 'horizontal' ? 0 : jQuery( ".wds_slideshow_filmstrip_container_<?php echo $wds; ?>").width();
		jQuery(".wds_slideshow_dots_container_<?php echo $wds; ?>").css({width: (<?php echo $image_width; ?> * par),left:(width -<?php echo $image_width; ?> * par - slideshow_filmstrip_container_width) / 2}); 
		var orig_width = <?php echo $image_width; ?>;
		var img_width =  Math.min(larg_width, orig_width);
		wds_carousel<?php echo $wds; ?> = jQuery(".wds_slide_container_<?php echo $wds; ?>").featureCarouselslider({
			containerWidth:       width,
			containerHeight:      height,
			largeFeatureWidth:    <?php echo $image_width; ?> * par,
			largeFeatureHeight:   <?php echo $image_height; ?> * par,
			fit_containerWidth:   <?php echo $carousel_fit_containerWidth; ?>,
			smallFeaturePar:      <?php echo $carousel_image_parameters; ?>,
			featuresArray:        [],
			timeoutVar:           null,
			rotationsRemaining:   0,
			parametr:             par,
			parf:                 parF,
			data:                 wds_data_<?php echo $wds; ?>,
			autoPlay:             <?php echo $interval * 1000; ?>,
			interval:             <?php echo $slideshow_interval * 1000; ?>,
			imagecount:           <?php echo $carousel_image_counts; ?>,
			wds_number:           <?php echo $wds; ?>,
			startingFeature:      wds_currentCenterNum<?php echo $wds; ?>,
			carouselSpeed:        wds_transition_duration_<?php echo $wds; ?>,
			carousel_degree:       <?php echo $carousel_degree ?>,
			carousel_grayscale:    <?php echo $carousel_grayscale ?>,
			carousel_transparency: <?php echo $carousel_transparency ?>,
			borderWidth:		      0
		});
	}
	jQuery(document).ready(function() {
		wds_currentlyMoving<?php echo $wds; ?> = false;
		wds_currentCenterNum<?php echo $wds; ?> = <?php echo $slider->start_slide_num; ?>;
		jQuery(".wds_left-ico_<?php echo $wds; ?>").click(function () {
		  wds_carousel<?php echo $wds; ?>.prev();
		});
		jQuery(".wds_right-ico_<?php echo $wds; ?>").click(function () {
		  wds_carousel<?php echo $wds; ?>.next();
		});
	});
	jQuery(window).resize(function() {
      if ( !wds_object.is_free ) {
      wds_carousel_params<?php echo $wds; ?>();
      wds_carousel<?php echo $wds; ?>.pause();
      if (!jQuery(".wds_ctrl_btn_<?php echo $wds; ?>").hasClass("fa-play")) {
      wds_carousel<?php echo $wds; ?>.start();
      }
      }
	});
	jQuery(window).on('load', function() {
      if ( !wds_object.is_free ) {
      wds_carousel_params<?php echo $wds; ?>();
      wds_display_hotspot();
      wds_hotspot_position();
      }
	});
	<?php } ?>
	<?php
		$js_content = ob_get_clean();
		clearstatcache();
		return $js_content;
	}

  /**
   * @param $id
   * @param $slider_row
   * @param $slide_rows
   * @param $wds
   * @return string
   */
  public static function create_css( $id, $slider_row, $slide_rows, $layers_rows, $wds ) {
    $wds_global_options = get_option("wds_global_options", 0);
    $global_options = json_decode($wds_global_options);
    $loading_gif = isset($global_options->loading_gif) ? $global_options->loading_gif : 0;

    $resolutions = array(320, 480, 640, 768, 800, 1024, 1366, 1824, 3000);
    $bull_hover = isset($slider_row->bull_hover) ? $slider_row->bull_hover : 1;
    $bull_position = $slider_row->bull_position;

    $image_width = $slider_row->width;
    $image_height = $slider_row->height;

    $slides_count = count($slide_rows);

    $circle_timer_size = (2 * $slider_row->timer_bar_size - 2) * 2;

    $enable_slideshow_shuffle = $slider_row->shuffle;
    $mouse_swipe_nav = isset($slider_row->mouse_swipe_nav) ? $slider_row->mouse_swipe_nav : 0;
    $thumb_size = isset($slider_row->thumb_size) ? $slider_row->thumb_size : '0.3';
    if ($slider_row->navigation == 'always') {
      $navigation = 0;
      $pp_btn_opacity = 1;
    }
    else {
      $navigation = 4000;
      $pp_btn_opacity = 0;
    }
    $filmstrip_direction = ($slider_row->film_pos == 'right' || $slider_row->film_pos == 'left') ? 'vertical' : 'horizontal';
    $filmstrip_position = $slider_row->film_pos;
    if ($filmstrip_position != 'none') {
      if ($filmstrip_direction == 'horizontal') {
        $filmstrip_width = $slider_row->film_thumb_width;
        $filmstrip_height = $slider_row->film_thumb_height;
        $filmstrip_width_in_percent = 100 / count($slide_rows);
        $filmstrip_height_in_percent = 100 * $filmstrip_height / ($image_height + $filmstrip_height);
        $filmstrip_container_width_in_percent = 100 * $filmstrip_width / $image_width * count($slide_rows);
        $filmstrip_container_height_in_percent = 100;
      }
      else {
        $filmstrip_width = $slider_row->film_thumb_width;
        $filmstrip_height = $slider_row->film_thumb_height;
        $filmstrip_width_in_percent = 100 * $filmstrip_width / ($image_width + $filmstrip_width);
        $filmstrip_height_in_percent = 100 / count($slide_rows);
        $filmstrip_container_width_in_percent = 100;
        $filmstrip_container_height_in_percent = 100 * $filmstrip_height / $image_height * count($slide_rows);
      }
    }
    else {
      $filmstrip_width_in_percent = 0;
      $filmstrip_height_in_percent = 0;
      $filmstrip_container_width_in_percent = 0;
      $filmstrip_container_height_in_percent = 0;
    }
    $left_or_top = 'left';
    $width_or_height = 'width';
    if (!($filmstrip_direction == 'horizontal')) {
      $left_or_top = 'top';
      $width_or_height = 'height';
    }

    $carousel = isset($slider_row->carousel) ? $slider_row->carousel : FALSE;
    $smart_crop = isset($slider_row->smart_crop) ? $slider_row->smart_crop : 0;
    $crop_image_position = isset($slider_row->crop_image_position) ? $slider_row->crop_image_position : 'center center';
    $hide_on_mobile = (isset($slider_row->hide_on_mobile) ? $slider_row->hide_on_mobile : 0);
    $full_width_for_mobile = isset($slider_row->full_width_for_mobile) ? (int) $slider_row->full_width_for_mobile : 0;
      ob_start();
      ?>
      .wds_slider_<?php echo $wds; ?> video::-webkit-media-controls-panel {
        display: none!important;
        -webkit-appearance: none;
      }
      .wds_slider_<?php echo $wds; ?> video::--webkit-media-controls-play-button {
        display: none!important;
        -webkit-appearance: none;
      }
      .wds_slider_<?php echo $wds; ?> video::-webkit-media-controls-start-playback-button {
        display: none!important;
        -webkit-appearance: none;
      }
      .wds_bigplay_<?php echo $wds; ?>,
      .wds_slideshow_image_<?php echo $wds; ?>,
      .wds_slideshow_video_<?php echo $wds; ?> {
        display: block;
      }
      .wds_bulframe_<?php echo $wds; ?> {
        display: none;
        background-image: url('');
        margin: 0px;
        position: absolute;
        z-index: 3;
        -webkit-transition: left 1s, right 1s;
        transition: left 1s, right 1s;
        width: <?php echo 100 * $thumb_size ?>%;
        height: <?php echo 100 * $thumb_size ?>%;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> {
        text-align: <?php echo $slider_row->align; ?>;
        margin: <?php echo $slider_row->glb_margin; ?>px <?php echo $slider_row->full_width ? 0 : ''; ?>;
        visibility: hidden;
      <?php echo $slider_row->full_width ? 'position: relative;' : ''; ?>
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_wrap_<?php echo $wds; ?>,
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_wrap_<?php echo $wds; ?> * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_wrap_<?php echo $wds; ?> {
        background-color: <?php echo WDW_S_Library::spider_hex2rgba($slider_row->background_color, (100 - $slider_row->background_transparent) / 100); ?>;
        border-width: <?php echo $slider_row->glb_border_width; ?>px;
        border-style: <?php echo $slider_row->glb_border_style; ?>;
        border-color: #<?php echo $slider_row->glb_border_color; ?>;
        border-radius: <?php echo $slider_row->glb_border_radius; ?>;
        border-collapse: collapse;
        display: inline-block;
        position: <?php echo $slider_row->full_width ? 'absolute' : 'relative'; ?>;
        text-align: center;
        width: 100%;
      <?php
      if (!$carousel) {
        ?>
        max-width: <?php echo $image_width; ?>px;
      <?php
    }
    ?>
        box-shadow: <?php echo $slider_row->glb_box_shadow; ?>;
        overflow: hidden;
        z-index: 0;
      }

      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_<?php echo $wds; ?> {
        padding: 0 !important;
        margin: 0 !important;
        float: none !important;
        vertical-align: middle;
        background-position: <?php echo ($smart_crop == '1' && ($slider_row->bg_fit == 'cover' || $slider_row->bg_fit == 'contain')) ? $crop_image_position : 'center center'; ?>;
        background-repeat: no-repeat;
        background-size: <?php echo $slider_row->bg_fit; ?>;
        width: 100%;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_<?php echo $wds; ?> video {
        padding: 0 !important;
        margin: 0 !important;
        vertical-align: middle;
        background-position: center center;
        background-repeat: no-repeat;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_<?php echo $wds; ?>>video {
        background-size: <?php echo $slider_row->bg_fit; ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_container_<?php echo $wds; ?> {
        display: /*table*/block;
        position: absolute;
        text-align: center;
      <?php echo $filmstrip_position; ?>: <?php echo ($filmstrip_direction == 'horizontal' ? $filmstrip_height_in_percent . '%' : $filmstrip_width_in_percent . '%'); ?>;
        vertical-align: middle;
        width: <?php echo 100 - ($filmstrip_direction == 'vertical' ? $filmstrip_width_in_percent : 0); ?>%;
        height: <?php echo 100 - ($filmstrip_direction == 'horizontal' ? $filmstrip_height_in_percent : 0); ?>%;
      }

      <?php
      foreach ($resolutions as $key => $resolution) {
        if ($key) {
          $prev_resolution = $resolutions[$key - 1] + 1;
        }
        else {
          $prev_resolution = 0;
        }

        $media_slide_height = ($image_width > $resolution) ? ($image_height * $resolution) / $image_width : $image_height;
        $media_bull_size = ((int) ($resolution / 26) > $slider_row->bull_size) ? $slider_row->bull_size : (int) ($resolution / 26);
        $media_bull_margin = ($slider_row->bull_margin > 2 && $resolution < 481) ? 2 : $slider_row->bull_margin;
        $media_bull_size_cont = $media_bull_size + $media_bull_margin * ($slider_row->bull_butt_img_or_not == 'text' ? 4 : 2);
        $media_pp_butt_size = ((int) ($resolution / 16) > $slider_row->pp_butt_size) ? $slider_row->pp_butt_size : (int) ($resolution / 16);
        $media_rl_butt_size = ((int) ($resolution / 16) > $slider_row->rl_butt_size) ? $slider_row->rl_butt_size : (int) ($resolution / 16);
        ?>
      @media only screen and (min-width: <?php echo $prev_resolution; ?>px) and (max-width: <?php echo $resolution; ?>px) {
        .wds_bigplay_<?php echo $wds; ?>,
        .wds_bigplay_layer {
          position: absolute;
          width: <?php echo $media_pp_butt_size; ?>px;
          height: <?php echo $media_pp_butt_size; ?>px;
          background-image: url('<?php echo addslashes(htmlspecialchars_decode ($slider_row->play_butt_url, ENT_QUOTES)); ?>');
          background-position: center center;
          background-repeat: no-repeat;
          background-size: cover;
          transition: background-image 0.2s ease-out;
          -ms-transition: background-image 0.2s ease-out;
          -moz-transition: background-image 0.2s ease-out;
          -webkit-transition: background-image 0.2s ease-out;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          margin: auto
        }
        .wds_bigplay_<?php echo $wds; ?>:hover,
        .wds_bigplay_layer:hover {
          background: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->play_butt_hov_url, ENT_QUOTES)); ?>' ) no-repeat;
          width: <?php echo $media_pp_butt_size; ?>px;
          height: <?php echo $media_pp_butt_size; ?>px;
          background-position: center center;
          background-repeat: no-repeat;
          background-size: cover;
        }
        #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_dots_thumbnails_<?php echo $wds; ?> {
          height: <?php echo $media_bull_size_cont; ?>px;
          width: <?php echo $media_bull_size_cont * $slides_count; ?>px;
        }
        #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_dots_<?php echo $wds; ?> {
          font-size: <?php echo $media_bull_size; ?>px;
          margin: <?php echo $media_bull_margin; ?>px;
        <?php
        if ($slider_row->bull_butt_img_or_not != 'text') {
          ?>
          width: <?php echo $media_bull_size; ?>px;
          height: <?php echo $media_bull_size; ?>px;
        <?php
      }
      else {
        ?>
          padding: <?php echo $media_bull_margin; ?>px;
          height: <?php echo $media_bull_size + 2 * $media_bull_margin; ?>px;
        <?php
      }
      ?>
        }
        #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_pp_btn_cont {
          font-size: <?php echo $media_pp_butt_size; ?>px;
          height: <?php echo $media_pp_butt_size; ?>px;
          width: <?php echo $media_pp_butt_size; ?>px;
        }
        #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_left_btn_cont,
        #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_right_btn_cont {
          height: <?php echo $media_rl_butt_size; ?>px;
          font-size: <?php echo $media_rl_butt_size; ?>px;
          width: <?php echo $media_rl_butt_size; ?>px;
        }
      }
      <?php
    }
    ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_video_<?php echo $wds; ?> {
        padding: 0 !important;
        margin: 0 !important;
        float: none !important;
        width: 100%;
        vertical-align: middle;
        display: inline-block;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #wds_slideshow_play_pause_<?php echo $wds; ?> {
        color: #<?php echo $slider_row->butts_color; ?>;
        cursor: pointer;
        position: relative;
        z-index: 13;
        width: inherit;
        height: inherit;
        font-size: inherit;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #wds_slideshow_play_pause_<?php echo $wds; ?>:hover {
        color: #<?php echo $slider_row->hover_color; ?>;
        cursor: pointer;
      }
      <?php
      if ($slider_row->play_paus_butt_img_or_not != 'style') {
        ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_play_pause_<?php echo $wds; ?>.fa-pause:before,
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_play_pause_<?php echo $wds; ?>.fa-play:before {
        content: "";
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #wds_slideshow_play_pause_<?php echo $wds; ?>.fa-play {
        background-image: url('<?php echo addslashes(htmlspecialchars_decode ($slider_row->play_butt_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-out;
        -ms-transition: background-image 0.2s ease-out;
        -moz-transition: background-image 0.2s ease-out;
        -webkit-transition: background-image 0.2s ease-out;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #wds_slideshow_play_pause_<?php echo $wds; ?>.fa-play:before {
        content: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->play_butt_hov_url, ENT_QUOTES)); ?>');
        width: 0;
        height: 0;
        visibility: hidden;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #wds_slideshow_play_pause_<?php echo $wds; ?>.fa-play:hover {
        background-image: url('<?php echo addslashes(htmlspecialchars_decode ($slider_row->play_butt_hov_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #wds_slideshow_play_pause_<?php echo $wds; ?>.fa-pause{
        background-image: url('<?php echo addslashes(htmlspecialchars_decode ($slider_row->paus_butt_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-out;
        -ms-transition: background-image 0.2s ease-out;
        -moz-transition: background-image 0.2s ease-out;
        -webkit-transition: background-image 0.2s ease-out;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #wds_slideshow_play_pause_<?php echo $wds; ?>.fa-pause:before {
        content: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->paus_butt_hov_url, ENT_QUOTES)); ?>');
        width: 0;
        height: 0;
        visibility: hidden;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #wds_slideshow_play_pause_<?php echo $wds; ?>.fa-pause:hover {
        background-image: url('<?php echo addslashes(htmlspecialchars_decode ($slider_row->paus_butt_hov_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
      }
      <?php
    }
    ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_left-ico_<?php echo $wds; ?>,
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_right-ico_<?php echo $wds; ?> {
        background-color: <?php echo WDW_S_Library::spider_hex2rgba($slider_row->nav_bg_color, (100 - $slider_row->butts_transparent) / 100); ?>;
        border-radius: <?php echo $slider_row->nav_border_radius; ?>;
        border: <?php echo $slider_row->nav_border_width; ?>px <?php echo $slider_row->nav_border_style; ?> #<?php echo $slider_row->nav_border_color; ?>;
        border-collapse: separate;
        color: #<?php echo $slider_row->butts_color; ?>;
        left: 0;
        top: 0;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
        cursor: pointer;
        line-height: 0;
        width: inherit;
        height: inherit;
        font-size: inherit;
        position: absolute;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_left-ico_<?php echo $wds; ?> {
        left: -<?php echo $navigation; ?>px;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_right-ico_<?php echo $wds; ?> {
        left: <?php echo $navigation; ?>px;
      }
      <?php
      if ($slider_row->rl_butt_img_or_not != 'style') {
        ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_left-ico_<?php echo $wds; ?> {
        left: -<?php echo $navigation; ?>px;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->left_butt_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-out;
        -ms-transition: background-image 0.2s ease-out;
        -moz-transition: background-image 0.2s ease-out;
        -webkit-transition: background-image 0.2s ease-out;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_left-ico_<?php echo $wds; ?>:before {
        content: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->left_butt_hov_url, ENT_QUOTES)); ?>');
        width: 0;
        height: 0;
        visibility: hidden;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_left-ico_<?php echo $wds; ?>:hover {
        left: -<?php echo $navigation; ?>px;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->left_butt_hov_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_right-ico_<?php echo $wds; ?> {
        left: <?php echo $navigation; ?>px;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->right_butt_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-out;
        -ms-transition: background-image 0.2s ease-out;
        -moz-transition: background-image 0.2s ease-out;
        -webkit-transition: background-image 0.2s ease-out;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_right-ico_<?php echo $wds; ?>:before {
        content: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->right_butt_hov_url, ENT_QUOTES)); ?>');
        width: 0;
        height: 0;
        visibility: hidden;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_right-ico_<?php echo $wds; ?>:hover {
        left: <?php echo $navigation; ?>px;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->right_butt_hov_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
      }
      <?php
    }
    ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #wds_slideshow_play_pause_<?php echo $wds; ?> {
        opacity: <?php echo $pp_btn_opacity; ?>;
        filter: "Alpha(opacity=<?php echo $pp_btn_opacity * 100; ?>)";
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_left-ico_<?php echo $wds; ?>:hover,
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_right-ico_<?php echo $wds; ?>:hover {
        color: #<?php echo $slider_row->hover_color; ?>;
        cursor: pointer;
      }

      /* Filmstrip*/
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_container_<?php echo $wds; ?> {
        background-color: #<?php echo $slider_row->film_bg_color; ?> !important;
        display: block;
        height: <?php echo ($filmstrip_direction == 'horizontal' ? $filmstrip_height_in_percent . '%' : '100%'); ?>;
        position: absolute;
        width: <?php echo ($filmstrip_direction == 'horizontal' ? '100%' : $filmstrip_width_in_percent . '%'); ?>;
        z-index: 10105;
      <?php echo $filmstrip_position; ?>: 0;
        overflow: hidden;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_<?php echo $wds; ?> {
        overflow: hidden;
        <?php if ($slider_row->film_pos == 'left') {
          ?>padding-right: <?php echo $slider_row->film_tmb_margin; ?>px;<?php
        }
        elseif ($slider_row->film_pos == 'right') {
          ?>padding-left: <?php echo $slider_row->film_tmb_margin; ?>px;<?php
        }
        elseif ($slider_row->film_pos == 'top') {
          ?>padding-bottom: <?php echo $slider_row->film_tmb_margin; ?>px;<?php
        }
        elseif ($slider_row->film_pos == 'bottom') {
          ?>padding-top: <?php echo $slider_row->film_tmb_margin; ?>px;<?php
        }
        ?>
        position: absolute;
        height: <?php echo ($filmstrip_direction == 'horizontal' ? '100%' : $filmstrip_container_height_in_percent . '%'); ?>;
        width: <?php echo ($filmstrip_direction == 'horizontal' ? $filmstrip_container_width_in_percent . '%' : '100%'); ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_thumbnails_<?php echo $wds; ?> {
        height: 100%;
      <?php echo $left_or_top; ?>: 0px;
        margin: 0 auto;
        overflow: hidden;
        position: relative;
        width: 100%;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_thumbnail_<?php echo $wds; ?> {
        position: relative;
        background: none;
        float: left;
        height: <?php echo $filmstrip_direction == 'horizontal' ? '100%' : $filmstrip_height_in_percent . '%'; ?>;
        padding: <?php echo $filmstrip_direction == 'horizontal' ? '0 0 0 ' . $slider_row->film_tmb_margin . 'px' : $slider_row->film_tmb_margin . 'px 0 0'; ?>;
        width: <?php echo ($filmstrip_direction == 'horizontal' ? $filmstrip_width_in_percent . '%' : '100%'); ?>;
        overflow: hidden;
      <?php
      if ($mouse_swipe_nav) {
      ?>
        cursor: -moz-grab;
        cursor: -webkit-grab;
        cursor: grab;
      <?php
      }
      else {
      ?>
        cursor: pointer;
      <?php
      }
      ?>
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_thumbnail_<?php echo $wds; ?> :active{
      <?php
      if ($mouse_swipe_nav) {
      ?>
        cursor: -moz-grab;
        cursor: -webkit-grab;
        cursor: grab;
      <?php
      }
      else {
      ?>
        cursor: inherit;
      <?php
      }
      ?>
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #wds_filmstrip_thumbnail_0_<?php echo $wds; ?> {
      <?php echo $filmstrip_direction == 'horizontal' ? 'margin-left: 0' : 'margin-top: 0'; ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_thumb_active_<?php echo $wds; ?> div {
        opacity: 1;
        filter: Alpha(opacity=100);
        border: <?php echo $slider_row->film_act_border_width; ?>px <?php echo $slider_row->film_act_border_style; ?> #<?php echo $slider_row->film_act_border_color; ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_thumb_deactive_<?php echo $wds; ?> {
        opacity: <?php echo number_format((100 - $slider_row->film_dac_transparent) / 100, 2, ".", ""); ?>;
        filter: Alpha(opacity=<?php echo 100 - $slider_row->film_dac_transparent; ?>);
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_thumbnail_img_<?php echo $wds; ?> {
        display: block;
        opacity: 1;
        filter: Alpha(opacity=100);
        padding: 0 !important;
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        width: 100%;
        height: 100%;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_left_<?php echo $wds; ?>,
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_right_<?php echo $wds; ?> {
        background-color: rgba(0, 0, 0, 0);
        cursor: pointer;
        display: table;
        vertical-align: middle;
      <?php echo $width_or_height; ?>: 20px;
        z-index: 10000;
        position: absolute;
      <?php echo ($filmstrip_direction == 'horizontal' ? 'height: 100%' : 'width: 100%') ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_left_<?php echo $wds; ?> {
      <?php echo $left_or_top; ?>: 0;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_right_<?php echo $wds; ?> {
      <?php echo($filmstrip_direction == 'horizontal' ? 'right' : 'bottom') ?>: 0;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_left_<?php echo $wds; ?> i,
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_filmstrip_right_<?php echo $wds; ?> i {
        color: #<?php echo $slider_row->film_bg_color; ?>;
        display: table-cell;
        font-size: 20px;
        vertical-align: middle;
        opacity: 0;
        filter: Alpha(opacity=0);
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_none_selectable_<?php echo $wds; ?> {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slide_container_<?php echo $wds; ?> {
        display: table-cell;
        margin: 0 auto;
        position: absolute;
        vertical-align: middle;
        width: 100%;
        height: 100%;
        overflow: hidden;
        cursor: <?php echo $mouse_swipe_nav ? '-moz-grab' : 'inherit'; ?>;
        cursor: <?php echo $mouse_swipe_nav ? '-webkit-grab' : 'inherit'; ?>;
        cursor: <?php echo $mouse_swipe_nav ? 'grab' : 'inherit'; ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slide_container_<?php echo $wds; ?>:active {
        cursor: <?php echo $mouse_swipe_nav ? '-moz-grabbing' : 'inherit'; ?>;
        cursor: <?php echo $mouse_swipe_nav ? '-webkit-grabbing' : 'inherit'; ?>;
        cursor: <?php echo $mouse_swipe_nav ? 'grabbing' : 'inherit'; ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slide_bg_<?php echo $wds; ?> {
        margin: 0 auto;
        width: /*inherit*/100%;
        height: /*inherit*/100%;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slider_<?php echo $wds; ?> {
        height: /*inherit*/100%;
        width: /*inherit*/100%;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_spun_<?php echo $wds; ?> {
        width: /*inherit*/100%;
        height: /*inherit*/100%;
        display: table-cell;
        filter: Alpha(opacity=100);
        opacity: 1;
        position: absolute;
        vertical-align: middle;
        z-index: 2;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_second_spun_<?php echo $wds; ?> {
        width: /*inherit*/100%;
        height: /*inherit*/100%;
        display: table-cell;
        filter: Alpha(opacity=0);
        opacity: 0;
        position: absolute;
        vertical-align: middle;
        z-index: 1;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_grid_<?php echo $wds; ?> {
        display: none;
        height: 100%;
        overflow: hidden;
        position: absolute;
        width: 100%;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_gridlet_<?php echo $wds; ?> {
        opacity: 1;
        filter: Alpha(opacity=100);
        position: absolute;
      }
      /* Dots.*/
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_dots_container_<?php echo $wds; ?> {
        opacity: <?php echo $bull_hover; ?>;
        filter: "Alpha(opacity=<?php echo $bull_hover * 100; ?>)";
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_dots_container_<?php echo $wds; ?> {
        display: block;
        overflow: hidden;
        position: absolute;
        width: 100%;
      <?php echo $bull_position; ?>: 0;
        /*z-index: 17;*/
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_dots_thumbnails_<?php echo $wds; ?> {
        left: 0px;
        font-size: 0;
        margin: 0 auto;
        position: relative;
        z-index: 999;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_dots_<?php echo $wds; ?> {
        display: inline-block;
        position: relative;
        color: #<?php echo $slider_row->bull_color; ?>;
        cursor: pointer;
        z-index: 17;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_dots_active_<?php echo $wds; ?> {
        color: #<?php echo $slider_row->bull_act_color; ?>;
        opacity: 1;
        filter: Alpha(opacity=100);
      <?php
      if ($slider_row->bull_butt_img_or_not != 'style' && $slider_row->bull_butt_img_or_not != 'text') {
        ?>
        display: inline-block;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->bullets_img_main_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
      <?php
    }
    else if ($slider_row->bull_butt_img_or_not == 'text') {
      ?>
        background-color: #<?php echo $slider_row->bull_back_act_color; ?>;
        border-radius: <?php echo $slider_row->bull_radius; ?>;
      <?php
    }
    ?>
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_dots_deactive_<?php echo $wds; ?> {
      <?php
      if ($slider_row->bull_butt_img_or_not != 'style' && $slider_row->bull_butt_img_or_not != 'text') {
        ?>
        display: inline-block;
        background-image: url('<?php echo addslashes(htmlspecialchars_decode($slider_row->bullets_img_hov_url, ENT_QUOTES)); ?>');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        transition: background-image 0.2s ease-in;
        -ms-transition: background-image 0.2s ease-in;
        -moz-transition: background-image 0.2s ease-in;
        -webkit-transition: background-image 0.2s ease-in;
      <?php
    }
    else if ($slider_row->bull_butt_img_or_not == 'text') {
      ?>
        background-color: #<?php echo $slider_row->bull_back_color; ?>;
        border-radius: <?php echo $slider_row->bull_radius; ?>;
      <?php
    }
    ?>
      }
      <?php
      if ($slider_row->timer_bar_type == 'top' || $slider_row->timer_bar_type == 'bottom') {
        ?>
      /* Line timer.*/
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_line_timer_container_<?php echo $wds; ?> {
        display: block;
        position: absolute;
        overflow: hidden;
      <?php echo $slider_row->timer_bar_type; ?>: 0;
        z-index: 16;
        width: 100%;
        height: <?php echo $slider_row->timer_bar_size; ?>px;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_line_timer_<?php echo $wds; ?> {
        z-index: 17;
        width: 0;
        height: <?php echo $slider_row->timer_bar_size; ?>px;
        background: #<?php echo $slider_row->timer_bar_color; ?>;
        opacity: <?php echo number_format((100 - $slider_row->timer_bar_transparent) / 100, 2, ".", ""); ?>;
        filter: alpha(opacity=<?php echo 100 - $slider_row->timer_bar_transparent; ?>);
      }
      <?php
    }
    elseif ($slider_row->timer_bar_type != 'none') {
      ?>
      /* Circle timer.*/
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_line_timer_container_<?php echo $wds; ?> {
        display: block;
        position: absolute;
        overflow: hidden;
      <?php echo $slider_row->timer_bar_type; ?>: 0;
        z-index: 16;
        width: 100%;
        height: <?php echo $circle_timer_size; ?>px;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_circle_timer_container_<?php echo $wds; ?> {
        display: block;
        position: absolute;
        overflow: hidden;
        z-index: 16;
        width: 100%;
      <?php switch ($slider_row->timer_bar_type) {
      case 'circle_top_right': echo 'top: 0px; text-align:right;'; break;
      case 'circle_top_left': echo 'top: 0px; text-align:left;'; break;
      case 'circle_bot_right': echo 'bottom: 0px; text-align:right;'; break;
      case 'circle_bot_left': echo 'bottom: 0px; text-align:left;'; break;
      default: 'top: 0px; text-align:right;';
       } ?>
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_circle_timer_container_<?php echo $wds; ?> .wds_circle_timer_<?php echo $wds; ?> {
        display: inline-block;
        width: <?php echo $circle_timer_size; ?>px;
        height: <?php echo $circle_timer_size; ?>px;
        position: relative;
        opacity: <?php echo number_format((100 - $slider_row->timer_bar_transparent) / 100, 2, ".", ""); ?>;
        filter: alpha(opacity=<?php echo 100 - $slider_row->timer_bar_transparent; ?>);
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_circle_timer_container_<?php echo $wds; ?> .wds_circle_timer_<?php echo $wds; ?> .wds_circle_timer_parts_<?php echo $wds; ?> {
        display: table;
        width: 100%;
        height: 100%;
        border-radius: 100%;
        position: relative;
      }
      .wds_circle_timer_part_<?php echo $wds; ?> {
        display: table-cell;
        width: 50%;
        height: 100%;
        overflow: hidden !important;
      }
      .wds_circle_timer_small_parts_<?php echo $wds; ?> {
        display: block;
        width: 100%;
        height: 50%;
        background: #<?php echo $slider_row->timer_bar_color; ?>;
        position: relative;
      }
      .wds_circle_timer_center_cont_<?php echo $wds; ?> {
        display: table;
        width: <?php echo $circle_timer_size; ?>px;
        height: <?php echo $circle_timer_size; ?>px;
        position: absolute;
        text-align: center;
        top:0px;
        vertical-align:middle;
      }
      .wds_circle_timer_center_<?php echo $wds; ?> {
        display: table-cell;
        width: 100%;
        height: 100%;
        text-align: center;
        line-height: 0px !important;
        vertical-align: middle;
      }
      .wds_circle_timer_center_<?php echo $wds; ?> div {
        display: inline-block;
        width: <?php echo $circle_timer_size / 2 - 2; ?>px;
        height: <?php echo $circle_timer_size / 2 - 2; ?>px;
        background-color: #FFFFFF;
        border-radius: 100%;
        z-index: 300;
        position: relative;
      }

      <?php
    }
    ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slide_container_<?php echo $wds; ?> {
        height: /*inherit*/100%;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_spun1_<?php echo $wds; ?> {
        display: table;
        width: <?php echo $carousel ? "100%" : "/*inherit*/100%"; ?>;
        height: <?php echo $carousel ? "100%" : "/*inherit*/100%"; ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_spun2_<?php echo $wds; ?> {
        display: table-cell;
        vertical-align: middle;
        text-align: center;
        overflow: hidden;
        height: /*inherit*/100%;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_video_layer_frame_<?php echo $wds; ?> {
        max-height: 100%;
        max-width: 100%;
        width: 100%;
        height: 100%;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_video_hide<?php echo $wds; ?> {
        width: 100%;
        height: 100%;
        position:absolute;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slider_car_image<?php echo $wds; ?> {
        overflow: hidden;
      }
      #wds_container1_<?php echo $wds; ?> .wds_loading_img {
        background-image: url('<?php echo WD_S_URL ?>/images/loading/<?php echo $loading_gif; ?>.gif');
      }
      <?php
      if ($hide_on_mobile) {
        ?>
      @media screen and (max-width: <?php echo $hide_on_mobile; ?>px){
        #wds_container1_<?php echo $wds; ?> {
          display: none;
        }
      }
      <?php
    }
    if ($full_width_for_mobile) {
      ?>
      @media screen and (max-width: <?php echo $full_width_for_mobile; ?>px) {
        #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> {
          margin:<?php echo $slider_row->glb_margin; ?>px 0;
          position: relative;
        }
        #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_slideshow_image_wrap_<?php echo $wds; ?> {
          position: absolute;
        }
      }
      <?php
    }
    echo $slider_row->css;
    foreach ($slide_rows as $key => $slide_row) {
      if (isset($layers_rows[$slide_row->id]) && !empty($layers_rows[$slide_row->id])) {
        foreach ($layers_rows[$slide_row->id] as $key => $layer) {
          if ($layer->published) {
            $prefix = 'wds_' . $wds . '_slide' . $slide_row->id . '_layer' . $layer->id;
            switch ($layer->type) {
              case 'text': {
                ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #<?php echo $prefix; ?> {
        font-size: <?php echo $layer->size; ?>px;
        line-height: 1.25em;
        padding: <?php echo $layer->padding; ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_layer_<?php echo $layer->id; ?>{
        opacity: <?php echo ($layer->layer_effect_in != 'none') ? '0 !important' : '1'; ?>;
        filter: "Alpha(opacity=<?php echo ($layer->layer_effect_in != 'none') ? '0' : '100'; ?>)" !important;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #<?php echo $prefix; ?>:hover {
                                                                                 color: #<?php echo $layer->hover_color_text; ?> !important;
                                                                               }
      <?php
      break;
    }
    case 'image': {
      ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_layer_<?php echo $layer->id; ?>{
        opacity: <?php echo ($layer->layer_effect_in != 'none') ? '0 !important' : '1'; ?>;
        filter: "Alpha(opacity=<?php echo ($layer->layer_effect_in != 'none') ? '0' : '100'; ?>)" !important;
      }
      <?php
      break;
    }
    case 'video': {
      ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_layer_<?php echo $layer->id; ?> {
        opacity: <?php echo ($layer->layer_effect_in != 'none') ? '0 !important' : '1'; ?>;
        filter: "Alpha(opacity=<?php echo ($layer->layer_effect_in != 'none') ? '0' : '100'; ?>)" !important;
      }
      <?php
      break;
    }
    case 'upvideo': {
      ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_layer_<?php echo $layer->id; ?> {
        opacity: <?php echo ($layer->layer_effect_in != 'none') ? '0 !important' : '1'; ?>;
        filter: "Alpha(opacity=<?php echo ($layer->layer_effect_in != 'none') ? '0' : '100'; ?>)" !important;
      }
      <?php
      break;
    }
    case 'social': {
      ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #<?php echo $prefix; ?> {
        font-size: <?php echo $layer->size; ?>px;
        padding: <?php echo $layer->padding; ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_layer_<?php echo $layer->id; ?> {
        opacity: <?php echo ($layer->layer_effect_in != 'none') ? '0 !important' : '1'; ?>;
        filter: "Alpha(opacity=<?php echo ($layer->layer_effect_in != 'none') ? '0' : '100'; ?>)" !important;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #<?php echo $prefix; ?>:hover {
                                                                                 color: #<?php echo $layer->hover_color; ?> !important;
                                                                               }
      <?php
      break;
    }
    case 'hotspots': {
      ?>
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> #<?php echo $prefix; ?> {
        font-size: <?php echo $layer->size; ?>px;
        line-height: 1.25em;
        padding: <?php echo $layer->padding; ?>;
      }
      #wds_container1_<?php echo $wds; ?> #wds_container2_<?php echo $wds; ?> .wds_layer_<?php echo $layer->id; ?>_div{
        opacity: <?php echo ($layer->layer_effect_in != 'none') ? '0 !important' : '1'; ?>;
        filter: "Alpha(opacity=<?php echo ($layer->layer_effect_in != 'none') ? '0' : '100'; ?>)" !important;
      }
      <?php
      break;
    }
    default:
      break;
  }
}
}
}
}
    $css_content = ob_get_clean();
    clearstatcache();
    return $css_content;
  }
}
