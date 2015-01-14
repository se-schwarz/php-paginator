<?php

/**
 * Class Page
 */
class Page
{
  public $number = null;
  public $label = null;
  public $active = false;
  public $url = null;

  public function __construct($number, $label, $url, $active=false)
  {
    $this->number = $number;
    $this->label = $label;
    $this->url = $url;
    $this->active = $active;
  }
}


/**
 * Class Paginator
 */
class Paginator {
  function __construct($current_page, $overall, $per_page, $paginator_edge=3, $paginator_slice=5) {
    $this->paginator_edge = $paginator_edge;
    $this->paginator_slice = $paginator_slice;
    $this->current_page = $current_page;
    $this->overall = $overall;
    $this->per_page = $per_page;
    $this->page_count = intval(ceil($overall/$per_page));
    $this->init();
  }

  public function init()
  {
    $pages = max($this->page_count,1);
    $page = $this->current_page;
    $page_slices = array();
    $start_slice_lower = 1;
    $start_slice_upper = min($this->paginator_edge, $pages);
    $middle_slice_lower = max(intval($page) - intval($this->paginator_slice / 2), 1);
    $middle_slice_upper = min($middle_slice_lower-1 + $this->paginator_slice, $pages);
    $end_slice_lower = max($pages - $this->paginator_edge+1, 1);
    $end_slice_upper = $pages;

    if ($start_slice_upper + 1 >= $middle_slice_lower)
    {
      if ($middle_slice_upper +1 >= $end_slice_lower)
      {
        $tmp_pages = array();
        foreach(range($start_slice_lower, $end_slice_upper) as $i)
        {
          $active = ($i == $this->current_page) ? true: false;
          $tmp_pages[] = new Page($i, $i, $this->create_url($i), $active);
        }
        $page_slices[] = $tmp_pages;
      }
      else
      {
        $tmp_pages = array();
        foreach(range($start_slice_lower, $middle_slice_upper) as $i)
        {
          $active = ($i == $this->current_page) ? true: false;
          $tmp_pages[] = new Page($i, $i, $this->create_url($i), $active);
        }
        $page_slices[] = $tmp_pages;
        $tmp_pages = array();
        foreach(range($end_slice_lower, $end_slice_upper) as $i)
        {
          $active = ($i == $this->current_page) ? true: false;
          $tmp_pages[] = new Page($i, $i, $this->create_url($i), $active);
        }
        $page_slices[] = $tmp_pages;
      }
    }
    elseif ($middle_slice_upper+1 >= $end_slice_lower)
    {
      $tmp_pages = array();
      foreach(range($start_slice_lower, $start_slice_upper) as $i)
      {
        $active = ($i == $this->current_page) ? true: false;
        $tmp_pages[] = new Page($i, $i, $this->create_url($i), $active);
      }
      $page_slices[] = $tmp_pages;
      $tmp_pages = array();
      foreach(range($middle_slice_lower, $end_slice_upper) as $i)
      {
        $active = ($i == $this->current_page) ? true: false;
        $tmp_pages[] = new Page($i, $i, $this->create_url($i), $active);
      }
      $page_slices[] = $tmp_pages;
    }
    else
    {
      $tmp_pages = array();
      foreach(range($start_slice_lower, $start_slice_upper) as $i)
      {
        $active = ($i == $this->current_page) ? true: false;
        $tmp_pages[] = new Page($i, $i, $this->create_url($i), $active);
      }
      $page_slices[] = $tmp_pages;
      $tmp_pages = array();
      foreach(range($middle_slice_lower, $middle_slice_upper) as $i)
      {
        $active = ($i == $this->current_page) ? true: false;
        $tmp_pages[] = new Page($i, $i, $this->create_url($i), $active);
      }
      $page_slices[] = $tmp_pages;
      $tmp_pages = array();
      foreach(range($end_slice_lower, $end_slice_upper) as $i)
      {
        $active = ($i == $this->current_page) ? true: false;
        $tmp_pages[] = new Page($i, $i, $this->create_url($i), $active);
      }
      $page_slices[] = $tmp_pages;
    }
    $this->slices = $page_slices;
  }

  /**
   * This is a simpel function that takes the current request uri and adds the page parameter.
   * @param $page
   * @return mixed
   */
  public function create_url($page, $param_name='page')
  {
    $path = $_SERVER['REQUEST_URI'];
    $get = $_GET;
    $get[$param_name] = $page;
    return $path.'?'.http_build_query($get);
  }
}