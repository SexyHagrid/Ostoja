<?php

  class Breadcrumbs {
    public static function showBreadcrumbs($currentPage) {
      if (!isset($_SESSION['breadcrumbs'])) {
        $_SESSION['breadcrumbs'] = [];
        $_SESSION['breadcrumbs'][] = array('page' => $currentPage['page'], 'address' => $currentPage['address']);
      }

      if (in_array($currentPage, $_SESSION['breadcrumbs'])) {
        while($_SESSION['breadcrumbs'][count($_SESSION['breadcrumbs'])-1]['address'] != $currentPage['address']) {
          array_pop($_SESSION['breadcrumbs']);
        }
      }

      if (count($_SESSION['breadcrumbs']) > 0 && $_SESSION['breadcrumbs'][count($_SESSION['breadcrumbs'])-1]['address'] !== $currentPage['address']) {
        $_SESSION['breadcrumbs'][] = array('page' => $currentPage['page'], 'address' => $currentPage['address']);
      }

      foreach($_SESSION['breadcrumbs'] as $breadcrumb) {
        $page = $breadcrumb['page'];
        $address = $breadcrumb['address'];
        if ($address === $currentPage['address']) {
          echo "<li class='breadcrumb-item active' aria-current='page'>$page</li>";
          break;
        }

        echo "<li class='breadcrumb-item'><a href='$address'>$page</a></li>";
      }
    }
  }

?>