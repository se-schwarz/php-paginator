<?php
/**
 * This code show a possible use of the paginator output
 */
?>

<div class="paginator">
  <ul class="page-list">
    <?php
    $j = 0;
    foreach($paginator->slices as $slice) {
      $i = 0;
      if ($j != 0) {
        ?>
        <li class="page seperator">...</li>
      <?php
      }
      foreach ($slice as $page) {
        $is_first = ($j == 0 && $i == 0) ? true : false;
        $is_last = ($i == count($slice)-1 && $j == count($paginator->slices)-1) ? true: false;
        ?>

        <li
          class="page page-<?php echo htmlspecialchars($page->number); ?> <?php if ($is_first): ?>first <?php endif; if($is_last): ?>last <?php endif; ?> <?php if($page->active): ?>active <?php endif; ?>">
          <a
            href="<?php echo htmlspecialchars($page->url); ?>"
            title="<?php echo htmlspecialchars($page->number); ?>"
            class="paginator-page-link"
            >
            <?php echo htmlspecialchars($page->label); ?>
          </a>
        </li>
        <?php
        $i++;
      }
      $j++;
    }
    ?>
  </ul>
</div>