<?php

/**
 * This functions shows how a paginator could be created
 * @param $overall
 * @param int $per_page
 * @return Paginator
 */
function get_paginator($overall, $per_page=10) {
  $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
  return new Paginator($current_page, $overall, $per_page);
}

